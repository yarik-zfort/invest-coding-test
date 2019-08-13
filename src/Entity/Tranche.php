<?php
declare(strict_types=1);

namespace LendInvest\Entity;


class Tranche
{
    /**
     * @var Loan
     */
    private $loan;

    private $maxAmount;

    private $monthlyRate;

    private $totalAmount = 0;

    private $name;

    private $transactions;

    public function __construct(
        Loan $loan,
        float $maxAmount,
        float $monthlyRate,
        string $name = ''
    )
    {
        if ($this->isMaxAmountValid($maxAmount)) {
            $this->maxAmount = $maxAmount;
        }
        if ($this->isMonthlyRateValid($monthlyRate)) {
            $this->monthlyRate = $monthlyRate;
        }
        $this->transactions = new \SplObjectStorage();
        $this->loan = $loan;
        $this->loan->addTranche($this);
    }

    public function investmentProcessing(float $amount, Investor $investor): Transaction
    {
        if (!$this->loan->isOpen()) {
            throw new \Exception('Loan closed');
        }

        $currentAmount = $this->totalAmount + $amount;
        if ($currentAmount > $this->maxAmount) {
            throw new \Exception('MAX AMOUNT');
        }

        $transaction = new Transaction(
            $investor,
            $this,
            $this->loan,
            new \DateTimeImmutable(),
            $amount
        );
        $this->transactions->attach($transaction);
        $this->totalAmount += $amount;
        return $transaction;
    }

    private function isMaxAmountValid(float $maxAmount): bool
    {
        if ($maxAmount < 0) {
            throw new \LogicException('The amount must be greater than zero');
        }
        return true;
    }

    private function isMonthlyRateValid(float $monthlyRate): bool
    {
        if ($monthlyRate < 0) {
            throw new \LogicException('The monthly rate must be greater than zero');
        }
        return true;
    }

    /**
     * @return Loan
     */
    public function getLoan(): Loan
    {
        return $this->loan;
    }

    /**
     * @return float
     */
    public function getMaxAmount(): float
    {
        return $this->maxAmount;
    }

    /**
     * @return float
     */
    public function getMonthlyRate(): float
    {
        return $this->monthlyRate;
    }

    /**
     * @return \SplObjectStorage
     */
    public function getTransactions(): \SplObjectStorage
    {
        return $this->transactions;
    }
}