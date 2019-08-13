<?php
declare(strict_types=1);

namespace LendInvest\Entity;


class Investor
{
    public function invest(Tranche $tranche, $amount): Transaction
    {
        return $tranche->investmentProcessing($amount, $this);
    }

}