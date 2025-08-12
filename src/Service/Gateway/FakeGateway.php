<?php

namespace App\Service\Gateway;

use App\Entity\Payment;

class FakeGateway implements PaymentGatewayInterface
{
    private string $name;
    private int $traffic = 0;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function process(Payment $payment): void
    {
        $this->traffic++;
    }

    public function getTrafficLoad(): int
    {
        return $this->traffic;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
