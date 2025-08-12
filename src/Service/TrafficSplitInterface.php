<?php
namespace App\Service;

use App\Entity\Payment;

interface TrafficSplitInterface
{
    public function handlePayment(Payment $payment): void;
}
