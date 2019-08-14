<?php


namespace LendInvest\Entity;


class Wallet
{
    /**
     * @var float
     */
    private $amount = 2000;

    /**
     * @param float $value
     * @return float
     */
    public function addMoney(float $value): float
    {
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
        $currentAmount = $this->amount - $value;
        if ($currentAmount < 0) {
            throw new \Exception('Insufficient funds');
        }
        $this->amount = $currentAmount;
        return $value;
    }
}