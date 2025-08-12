<?php

namespace App\Service;

use App\Entity\Payment;
use App\Service\Gateway\PaymentGatewayInterface;

class TrafficSplit implements TrafficSplitInterface
{

    private array $gateways = [];

    public function __construct(array $gatewaysWithWeights)
    {
        $this->initializeGateways($gatewaysWithWeights);
    }

    private function initializeGateways(array $gatewaysWithWeights): void
    {
        foreach ($gatewaysWithWeights as $item) {

            $gateway = $item['gateway'];
            $weight = $item['weight'];

            if (!$gateway instanceof PaymentGatewayInterface) {
                throw new \InvalidArgumentException('Gateway must implement PaymentGatewayInterface.');
            }
            
            if ($weight <= 0) {
                continue;
            }
            
            for ($i = 0; $i < $weight; $i++) {
                $this->gateways[] = $gateway;
            }
            
        }
    }

    public function handlePayment(Payment $payment): void
    {
        if (empty($this->gateways)) {
            throw new \RuntimeException('No payment gateways configured.');
        }

        $randomIndex = random_int(0, count($this->gateways) - 1);
        
        $gateway = $this->gateways[$randomIndex];
        $gateway->process($payment);
    }
}
