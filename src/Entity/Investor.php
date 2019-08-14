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
     * @var Wallet
     */
    private $wallet;

    /**
     * Investor constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->wallet = new Wallet();
    }

    /**
     * @param Tranche $tranche
     * @param $amount
     * @return Transaction
     * @throws \Exception
     */
    public function invest(Tranche $tranche, $amount): Transaction
    {
        $value = $this->wallet->takeMoney($amount);
        return $tranche->investmentProcessing($value, $this);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}