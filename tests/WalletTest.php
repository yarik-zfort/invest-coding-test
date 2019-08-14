<?php


use LendInvest\Entity\Investor;
use LendInvest\Entity\Loan;
use LendInvest\Entity\Tranche;

class WalletTest extends \PHPUnit\Framework\TestCase
{
    public function testTakeMoney()
    {
        $this->expectExceptionMessage('Insufficient funds');
        $loan = new Loan('2019-08-01', '2019-10-01');
        $tranceA = new Tranche($loan, 1000, 3, 'A');
        $investor1 = new Investor('Investor1');
        $transaction1 = $investor1->invest($tranceA, 3000);
    }
}