<?php
declare(strict_types=1);


namespace LendInvest\Entity;


use LendInvest\Helper\AmountValidator;
use LendInvest\Helper\DateValidator;

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
     * @param string $date
     * @return Transaction
     * @throws \Exception
     */
    public function invest(Tranche $tranche, $amount, string $date = null): Transaction
    {
        AmountValidator::positiveValueValidate($amount, 'The amount');
        if ($date) {
           DateValidator::validateDateFormat($date);
        }
        $value = $this->wallet->takeMoney($amount);
        return $tranche->investmentProcessing($value, $this, $date);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}