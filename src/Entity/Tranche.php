<?php


namespace LendInvest\Entity;


class Tranche
{
    /**
     * @var Loan
     */
    private $loan;

    private $maxAmount;

    private $monthlyRate;

    public function __construct(Loan $loan, float $maxAmount, float $monthlyRate)
    {
        $this->loan = $loan;
        if ($this->isMaxAmountValid($maxAmount)) {
            $this->maxAmount = $maxAmount;
        }
        if ($this->isMonthlyRateValid($monthlyRate)) {
            $this->monthlyRate = $monthlyRate;
        }
    }

    private function isMaxAmountValid(float $maxAmount): bool
    {
        if ($maxAmount < 0) {
            throw new \LogicException('The amount must be greater than zero');
        }
        return true;
    }

    private function isMonthlyRateValid(float $monthlyRate)
    {
        if ($monthlyRate < 0) {
            throw new \LogicException('The monthly rate must be greater than zero');
        }
        return true;
    }
}