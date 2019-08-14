<?php
declare(strict_types=1);

use LendInvest\Entity\Investor;
use LendInvest\Entity\Loan;
use LendInvest\Entity\Tranche;

class InterestCalculationTest extends \PHPUnit\Framework\TestCase
{
    public function testCalculate()
    {
        $loan = new Loan('2015-10-01', '2015-11-15');

        $tranceA = new Tranche($loan, 1000, 3, 'A');
        $tranceB = new Tranche($loan, 1000, 6, 'B');

        $investor1 = new Investor('Investor1');
        $transaction1 = $investor1->invest($tranceA, 1000, '2015-10-03');

        $investor3 = new Investor('Investor3');
        $transaction3 = $investor3->invest($tranceB, 500, '2015-10-10');

        $result = $loan->interestMonthCalculation('2015-11-01');
        $this->assertArrayHasKey('Investor1', $result);
        $this->assertArrayHasKey('Investor3', $result);

        $this->assertEquals($result['Investor1'], 28.06);
        $this->assertEquals($result['Investor3'], 21.29);
    }
}