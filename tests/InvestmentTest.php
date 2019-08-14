<?php

use LendInvest\Entity\Investor;
use LendInvest\Entity\Loan;
use LendInvest\Entity\Tranche;
use LendInvest\Entity\Transaction;

class InvestmentTest extends \PHPUnit\Framework\TestCase
{
    public function testInvestmentProcessing()
    {
        $loan = new Loan('2019-08-01', '2019-10-15');
        $tranceA = new Tranche($loan, 1000, 3, 'A');
        $tranceB = new Tranche($loan, 1000, 6, 'B');

        $investor1 = new Investor('Investor1');
        $transaction1 = $investor1->invest($tranceA, 1000);
        $this->assertInstanceOf(Transaction::class, $transaction1);

        $investor2 = new Investor('Investor2');
        try {
            $transaction2 = $investor2->invest($tranceA, 1);
        }catch (Exception $e) {
            $this->assertEquals('Maximum amount exceeded', $e->getMessage());
        }

        $investor3 = new Investor('Investor3');
        $transaction3 = $investor3->invest($tranceB, 500);
        $this->assertInstanceOf(Transaction::class, $transaction1);

        $investor4 = new Investor('Investor4');
        try {
            $transaction4 = $investor4->invest($tranceB, 1100);
        }catch (Exception $e) {
            $this->assertEquals('Maximum amount exceeded', $e->getMessage());
        }
    }
}