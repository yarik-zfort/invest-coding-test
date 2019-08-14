<?php
declare(strict_types=1);

namespace LendInvest\Helper;


class LoanValidator
{
    /**
     * @param string $start
     * @param string $end
     * @throws \Exception
     */
    public static function periodValidate(string $start, string $end): void
    {
        $start = new \DateTimeImmutable($start);
        $end = new \DateTimeImmutable($end);
        if ($start > $end) {
            throw new \Exception('Start date must be earlier than end date');
        }
    }
}