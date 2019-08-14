<?php
declare(strict_types=1);


namespace LendInvest\Entity;


class Transaction
{
    /**
     * @var Investor
     */
    private $investor;

    /**
     * @var Tranche
     */
    private $tranche;

    /**
     * @var Loan
     */
    private $loan;

    /**
     * @var \DateTimeImmutable
     */
    private $date;

    /**
     * @var float
     */
    private $amount;

    /**
     * Transaction constructor.
     * @param Investor $investor
     * @param Tranche $tranche
     * @param Loan $loan
     * @param \DateTimeImmutable $date
     * @param float $amount
     */
    public function __construct(
        Investor $investor,
        Tranche $tranche,
        Loan $loan,
        \DateTimeImmutable $date,
        float $amount
    )
    {
        $this->investor = $investor;
        $this->tranche = $tranche;
        $this->loan = $loan;
        $this->date = $date;
        $this->amount = $amount;
    }

    /**
     * @return Investor
     */
    public function getInvestor(): Investor
    {
        return $this->investor;
    }

    /**
     * @return Tranche
     */
    public function getTranche(): Tranche
    {
        return $this->tranche;
    }

    /**
     * @return Loan
     */
    public function getLoan(): Loan
    {
        return $this->loan;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }
}