<?php
declare(strict_types=1);


namespace LendInvest\Entity;


class Investor
{
    /**
     * @var string
     */
    private $name;

    /**
     * Investor constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param Tranche $tranche
     * @param $amount
     * @return Transaction
     * @throws \Exception
     */
    public function invest(Tranche $tranche, $amount): Transaction
    {
        return $tranche->investmentProcessing($amount, $this);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}