<?php

namespace App\Observers;

use App\Models\Payment;
use App\Models\PaymentPlan;
use Carbon\Carbon;

class PaymentPlanObserver
{
    /**
     * Handle the PaymentPlan "created" event.
     */
    public function created(PaymentPlan $paymentPlan): void
    {
        $startDate = Carbon::parse($paymentPlan->created_at);
        if (!$paymentPlan->payment_type) {
            for ($i = 0; $i < $paymentPlan->duration; $i++) {
                Payment::create([
                    'customer_id' => $paymentPlan->customer_id,
                    'payment_plan_id' => $paymentPlan->id,
                    'discount_id' => 1,
                    'amount' => $paymentPlan->amount,
                    'payment_date' => $startDate->copy()->addMonths($i),
                    'payment_method' => 'efectivo',
                    'reference' => null,
                    'status' => 'pendiente',
                ]);
            }
        } else {
            for ($i = 0; $i < $paymentPlan->duration; $i++) {
                Payment::create([
                    'customer_id' => $paymentPlan->customer_id,
                    'payment_plan_id' => $paymentPlan->id,
                    'discount_id' => 1,
                    'amount' => $paymentPlan->amount,
                    'payment_date' => $startDate->copy()->addYear($i),
                    'payment_method' => 'efectivo',
                    'reference' => null,
                    'status' => 'pendiente',
                ]);
            }
        }
    }

    /**
     * Handle the PaymentPlan "updated" event.
     */
    public function updated(PaymentPlan $paymentPlan): void
    {
        // Solo si el monto fue modificado
    if ($paymentPlan->isDirty('amount')) {
        // Solo actualizar los pagos que están pendientes
        $paymentPlan->payments()
            ->where('status', 'pendiente')
            ->update([
                'amount' => $paymentPlan->amount,
            ]);
    }
    }

    /**
     * Handle the PaymentPlan "deleted" event.
     */
    public function deleted(PaymentPlan $paymentPlan): void
    {
        //
    }

    /**
     * Handle the PaymentPlan "restored" event.
     */
    public function restored(PaymentPlan $paymentPlan): void
    {
        //
    }

    /**
     * Handle the PaymentPlan "force deleted" event.
     */
    public function forceDeleted(PaymentPlan $paymentPlan): void
    {
        //
    }
}
