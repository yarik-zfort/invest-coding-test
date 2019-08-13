<?php


use LendInvest\Entity\Loan;
use LendInvest\Entity\Tranche;

class TrancheTest extends \PHPUnit\Framework\TestCase
{
    public function testTrancheCreateWithNegativeAmount()
    {
        $this->expectExceptionMessage('The amount must be greater than zero');
        $loan = new Loan('2019-08-01', '2019-10-01');
        $tranceA = new Tranche($loan, -1000, 3, 'A');
    }

    public function testTrancheCreateWithNegativeMonthyRate()
    {
        $this->expectExceptionMessage('The monthly rate must be greater than zero');
        $loan = new Loan('2019-08-01', '2019-10-01');
        $tranceA = new Tranche($loan, 1000, -3, 'A');
    }
}