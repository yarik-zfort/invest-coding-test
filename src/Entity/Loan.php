<?php
declare(strict_types=1);

namespace LendInvest\Entity;


use LendInvest\Helper\DateValidator;
use LendInvest\Helper\LoanValidator;


class Loan
{
    /**
     * @var \DateTimeImmutable
     */
    private $startDate;

    /**
     * @var \DateTimeImmutable
     */
    private $endDate;

    /**
     * @var Tranche []
     */
    public $tranches;

    /**
     * Loan constructor.
     * @param string $startDate
     * @param string $endDate
     * @throws \Exception
     */
    public function __construct(string $startDate, string $endDate)
    {
        DateValidator::validateDateFormat(
            $startDate,
            'Y-m-d',
            'Start loan date'
        );
        DateValidator::validateDateFormat(
            $endDate,
            'Y-m-d',
            'End loan date'
        );
        LoanValidator::periodValidate($startDate, $endDate);
        $this->startDate = new \DateTimeImmutable($startDate);
        $this->endDate = new \DateTimeImmutable($endDate);
        $this->tranches = new \SplObjectStorage();
    }

    /**
     * @param \DateTimeInterface $date
     * @return bool
     */
    public function isOpen(\DateTimeInterface $date): bool
    {
        return $this->endDate >= $date && $this->startDate <= $date;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getStartDate(): \DateTimeImmutable
    {
        return $this->startDate;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getEndDate(): \DateTimeImmutable
    {
        return $this->endDate;
    }

    /**
     * @param Tranche $tranche
     */
    public function addTranche(Tranche $tranche): void
    {
        if (!$this->tranches->contains($tranche)) {
            $this->tranches->attach($tranche);
        }
    }

    /**
     * @param string $date
     * @return array
     * @throws \Exception
     */
    public function interestMonthCalculation(string $date): array
    {
        DateValidator::validateDateFormat($date, 'Y-m-d');
        $interestDate = new \DateTimeImmutable($date);
        $firstDayOfMonth = $interestDate->modify('first day of previous month');
        $lastDayOfMonth = $interestDate->modify('last day of previous month');
        $lastDayOfMonth = $lastDayOfMonth->setTime(23, 59, 59);
        $countDaysInMonth = (int)$lastDayOfMonth->format('d');
        $result = [];
        foreach ($this->tranches as $tranche) {
            $transactions = $tranche->getTransactions();
            if ($transactions->count()) {
                foreach ($transactions as $transaction) {
                    $transactionDate = $transaction->getDate();
                    if ($transactionDate >= $firstDayOfMonth && $transactionDate <= $lastDayOfMonth) {
                        $amount = $transaction->getAmount();
                        $monthlyRate = $tranche->getMonthlyRate();
                        $allMonthInterest = ($amount / 100) * $monthlyRate;
                        $interestPerDay = $allMonthInterest / $countDaysInMonth;
                        $daysDiff = $lastDayOfMonth->diff($transactionDate);
                        $daysDiff = $daysDiff->days + 1;
                        $daysDiff = $countDaysInMonth - $daysDiff;
                        $interest = round($allMonthInterest - ($daysDiff * $interestPerDay), 2);
                        $user = $transaction->getInvestor();
                        if (!isset($result[$user->getName()])) {
                            $result[$user->getName()] = $interest;
                        } else {
                            $result[$user->getName()] += $interest;
                        }
                    }
                }
            }
        }
        return $result;
    }
}