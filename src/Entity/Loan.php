<?php


namespace LendInvest\Entity;


use LendInvest\Helper\DateValidator;


class Loan
{
    private $startDate;

    private $endDate;

    public function __construct(string $startDate, string $endDate)
    {
        DateValidator::validateDateFormat(
            $startDate,
            'Y-m-d',
            'Start loan date'
        );
        DateValidator::validateDateFormat(
            $endDate,
            'Y-m-d',
            'End loan date'
        );
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }
}