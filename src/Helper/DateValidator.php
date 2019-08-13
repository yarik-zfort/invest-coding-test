<?php
declare(strict_types=1);

namespace LendInvest\Helper;

class DateValidator
{
    public static function validateDateFormat(
        string $date,
        string $format = 'Y-m-d',
        string $propertyName = 'Date'
    ): void
    {
        $validateDate = \DateTime::createFromFormat($format, $date);
        if (!($validateDate && $validateDate->format($format) === $date)) {
            throw new \LogicException("$propertyName must be a valid date in (Y-m-d) format");
        }
    }
}