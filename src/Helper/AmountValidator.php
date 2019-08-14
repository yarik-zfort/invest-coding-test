<?php
declare(strict_types=1);

namespace LendInvest\Helper;


class AmountValidator
{
    public static function positiveValueValidate(float $value, $propertyName = 'Value'): bool
    {
        if ($value < 0) {
            throw new \Exception("$propertyName must be greater than zero");
        }
        return true;
    }
}