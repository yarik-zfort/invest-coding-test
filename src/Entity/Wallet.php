<?php
declare(strict_types=1);

namespace LendInvest\Entity;


use LendInvest\Helper\AmountValidator;

class Wallet
{
    /**
     * @var float
     */
    private $amount = 2000;

    /**
     * @param float $value
     * @return float
     * @throws \Exception
     */
    public function addMoney(float $value): float
    {
        AmountValidator::positiveValueValidate($value);
        $this->amount += $value;
        return $this->amount;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $value
     * @return float
     * @throws \Exception
     */
    public function takeMoney(float $value): float
    {
        AmountValidator::positiveValueValidate($value);
        $currentAmount = $this->amount - $value;
        if ($currentAmount < 0) {
            throw new \Exception('Insufficient funds');
        }
        $this->amount = $currentAmount;
        return $value;
    }
}