<?php
namespace App\Service\Gateway;

use App\Entity\Payment;

interface PaymentGatewayInterface
{
    public function process(Payment $payment): void;
    public function getTrafficLoad(): int;
}
