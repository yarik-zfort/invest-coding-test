<?php
declare(strict_types=1);

use LendInvest\Entity\Loan;

class LoanTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider wrongDateProvider
     */
    public function testLoanCreateWithWrongStartDate($startDate)
    {
        $this->expectExceptionMessage('Start loan date must be a valid date in (Y-m-d) format');
        $loan = new Loan($startDate, date('Y-m-d'));
    }

    /**
     * @dataProvider wrongDateProvider
     */
    public function testLoanCreateWithWrongEndDate($endDate)
    {
        $this->expectExceptionMessage('End loan date must be a valid date in (Y-m-d) format');
        $loan = new Loan(date('Y-m-d'), $endDate);
    }

    public function testLoanCreateWithWrongDateRange()
    {
        $this->expectExceptionMessage('Start date must be earlier than end date');
        $loan = new Loan('2019-08-13', '2019-08-10');
    }

    public function testIsOpen()
    {
        $loan1 = new Loan('2019-08-01', '2019-10-01');
        $this->assertTrue($loan1->isOpen(new DateTimeImmutable()));

        $loan2 = new Loan('2019-06-01', '2019-08-01');
        $this->assertFalse($loan2->isOpen(new DateTimeImmutable()));
    }

    public function wrongDateProvider()
    {
        return [
            '1' => ['2010-20-20'],
            '2' => ['20-10-2010'],
            '3' => ['01-01-2020'],
            '4' => ['01/01/2020'],
        ];
    }
}