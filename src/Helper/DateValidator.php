<?php
declare(strict_types=1);

namespace LendInvest\Helper;

class DateValidator
{
    /**
     * @param string $date
     * @param string $format
     * @param string $propertyName
     * @throws \Exception
     */
    public static function validateDateFormat(
        string $date,
        string $format = 'Y-m-d',
        string $propertyName = 'Date'
    ): void
    {
        $validateDate = \DateTime::createFromFormat($format, $date);
        if (!($validateDate && $validateDate->format($format) === $date)) {
            throw new \Exception("$propertyName must be a valid date in (Y-m-d) format");
        }
    }
}