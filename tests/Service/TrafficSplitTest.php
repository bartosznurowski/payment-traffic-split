<?php

namespace App\Tests\Service;

use App\Entity\Payment;
use App\Service\Gateway\FakeGateway;
use App\Service\TrafficSplit;
use PHPUnit\Framework\TestCase;

class TrafficSplitTest extends TestCase
{
    public function testWeightedDistribution()
    {
        $g1 = new FakeGateway('G1');
        $g2 = new FakeGateway('G2');
        $g3 = new FakeGateway('G3');

        $splitter = new TrafficSplit([
            ['gateway' => $g1, 'weight' => 75],
            ['gateway' => $g2, 'weight' => 10],
            ['gateway' => $g3, 'weight' => 15]
        ]);

        $runs = 1000;

        for ($i = 0; $i < $runs; $i++) {
            $splitter->handlePayment(new Payment());
        }

        echo "Weighted distribution: " . PHP_EOL;
        echo "G1 load: " . $g1->getTrafficLoad() . PHP_EOL;
        echo "G2 load: " . $g2->getTrafficLoad() . PHP_EOL;
        echo "G3 load: " . $g3->getTrafficLoad() . PHP_EOL;

        $total = $g1->getTrafficLoad() + $g2->getTrafficLoad() + $g3->getTrafficLoad();
        
        $this->assertGreaterThan(700, $g1->getTrafficLoad()); 
        $this->assertGreaterThan(50, $g2->getTrafficLoad());  
        $this->assertGreaterThan(100, $g3->getTrafficLoad());
        $this->assertEquals($runs, $total);
    }

    public function testEqualDistribution()
    {
        $g1 = new FakeGateway('G1');
        $g2 = new FakeGateway('G2');
        $g3 = new FakeGateway('G3');
        $g4 = new FakeGateway('G4');

        $splitter = new TrafficSplit([
            ['gateway' => $g1, 'weight' => 25],
            ['gateway' => $g2, 'weight' => 25],
            ['gateway' => $g3, 'weight' => 25],
            ['gateway' => $g4, 'weight' => 25]
        ]);

        $runs = 1000;

        for ($i = 0; $i < $runs; $i++) {
            $splitter->handlePayment(new Payment());
        }

        echo PHP_EOL . "Equal distribution: " . PHP_EOL;
        echo "G1 load: " . $g1->getTrafficLoad() . PHP_EOL;
        echo "G2 load: " . $g2->getTrafficLoad() . PHP_EOL;
        echo "G3 load: " . $g3->getTrafficLoad() . PHP_EOL;
        echo "G4 load: " . $g4->getTrafficLoad() . PHP_EOL;

        $total = $g1->getTrafficLoad() + $g2->getTrafficLoad() + $g3->getTrafficLoad() + $g4->getTrafficLoad();

        $this->assertGreaterThan(200, $g1->getTrafficLoad());
        $this->assertGreaterThan(200, $g2->getTrafficLoad());
        $this->assertGreaterThan(200, $g3->getTrafficLoad());
        $this->assertGreaterThan(200, $g4->getTrafficLoad());
        $this->assertEquals($runs, $total);
    }

}
