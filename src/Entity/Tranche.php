<?php
declare(strict_types=1);


namespace LendInvest\Entity;


class Tranche
{
    /**
     * @var Loan
     */
    private $loan;

    /**
     * @var float
     */
    private $maxAmount;

    /**
     * @var float
     */
    private $monthlyRate;

    /**
     * @var int
     */
    private $totalAmount = 0;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \SplObjectStorage
     */
    private $transactions;

    /**
     * Tranche constructor.
     * @param Loan $loan
     * @param float $maxAmount
     * @param float $monthlyRate
     * @param string $name
     * @throws \Exception
     */
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
        $this->name = $name;
    }

    /**
     * @param float $amount
     * @param Investor $investor
     * @return Transaction
     * @throws \Exception
     */
    public function investmentProcessing(float $amount, Investor $investor): Transaction
    {
        $currentDate = $this->getCurrentDate();
        if (!$this->loan->isOpen($currentDate)) {
            throw new \Exception('Loan closed');
        }

        $currentAmount = $this->totalAmount + $amount;
        if ($currentAmount > $this->maxAmount) {
            throw new \Exception('Maximum amount exceeded');
        }

        $transaction = new Transaction(
            $investor,
            $this,
            $this->getLoan(),
            $currentDate,
            $amount
        );
        $this->transactions->attach($transaction);
        $this->totalAmount += $amount;
        return $transaction;
    }

    /**
     * @param float $maxAmount
     * @return bool
     * @throws \Exception
     */
    private function isMaxAmountValid(float $maxAmount): bool
    {
        if ($maxAmount < 0) {
            throw new \Exception('The amount must be greater than zero');
        }
        return true;
    }

    /**
     * @param float $monthlyRate
     * @return bool
     * @throws \Exception
     */
    private function isMonthlyRateValid(float $monthlyRate): bool
    {
        if ($monthlyRate < 0) {
            throw new \Exception('The monthly rate must be greater than zero');
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return \SplObjectStorage
     */
    public function getTransactions(): \SplObjectStorage
    {
        return $this->transactions;
    }

    /**
     * @return \DateTimeImmutable
     * @throws \Exception
     */
    public function getCurrentDate(): \DateTimeImmutable
    {
        return new \DateTimeImmutable();
    }
}