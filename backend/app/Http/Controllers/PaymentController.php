<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentInitializeRequest;
use App\Http\Requests\PaymentRefundRequest;
use App\Models\Payment;
use App\Services\PaystackService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(private PaystackService $paystackService)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $payments = Payment::query()
            ->when($request->user()->hasRole('Student'), function ($query) use ($request) {
                $query->where('user_id', $request->user()->id);
            })
            ->latest()
            ->paginate();

        return response()->json($payments);
    }

    public function initialize(PaymentInitializeRequest $request): JsonResponse
    {
        $payload = $this->paystackService->initializeTransaction($request->user(), $request->validated());

        return response()->json($payload, 201);
    }

    public function webhook(Request $request): JsonResponse
    {
        $this->paystackService->handleWebhook($request->all(), $request->header('x-paystack-signature'));

        return response()->json(status: 202);
    }

    public function refund(PaymentRefundRequest $request, Payment $payment): JsonResponse
    {
        $this->authorize('refund', $payment);

        $response = $this->paystackService->refund($payment, $request->validated('amount'));

        return response()->json($response);
    }
}
