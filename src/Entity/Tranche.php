<?php
declare(strict_types=1);


namespace LendInvest\Entity;


use LendInvest\Helper\AmountValidator;

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
        if (AmountValidator::positiveValueValidate($maxAmount, 'The amount')) {
            $this->maxAmount = $maxAmount;
        }
        if (AmountValidator::positiveValueValidate($monthlyRate, 'The monthly rate')) {
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
     * @param string|null $date
     * @return Transaction
     * @throws \Exception
     */
    public function investmentProcessing(
        float $amount,
        Investor $investor,
        string $date = null
    ): Transaction
    {
        AmountValidator::positiveValueValidate($amount, 'The amount');
        if ($date) {
            $currentDate = new \DateTimeImmutable($date);
        } else {
            $currentDate = new \DateTimeImmutable();
        }
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
}