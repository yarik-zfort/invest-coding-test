<?php

use LendInvest\Entity\Investor;
use LendInvest\Entity\Loan;
use LendInvest\Entity\Tranche;

class InterestCalculationTest extends \PHPUnit\Framework\TestCase
{
    public function testCalculate()
    {
        $loan = new Loan('2015-10-01', '2015-11-15');

        $trancheA = $this->getMockBuilder(Tranche::class)
            ->setConstructorArgs([$loan, 1000, 3, 'A'])
            ->setMethods(['getCurrentDate'])
            ->getMock();

        $trancheA->expects($this->once())
            ->method('getCurrentDate')
            ->willReturn(new DateTimeImmutable('2015-10-03'));

        $investor1 = new Investor('Investor1');
        $transaction1 = $investor1->invest($trancheA, 1000);

        $trancheB = $this->getMockBuilder(Tranche::class)
            ->setConstructorArgs([$loan, 1000, 6, 'B'])
            ->setMethods(['getCurrentDate'])
            ->getMock();

        $trancheB->expects($this->once())
            ->method('getCurrentDate')
            ->willReturn(new DateTimeImmutable('2015-10-10'));

        $investor3 = new Investor('Investor3');
        $transaction3 = $investor3->invest($trancheB, 500);

        $result = $loan->interestMonthCalculation('2015-11-01');

        $this->assertArrayHasKey('Investor1', $result);
        $this->assertArrayHasKey('Investor3', $result);

        $this->assertEquals($result['Investor1'], 28.06);
        $this->assertEquals($result['Investor3'], 21.29);
    }
}