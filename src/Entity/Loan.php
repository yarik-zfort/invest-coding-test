<?php
declare(strict_types=1);

namespace LendInvest\Entity;


use LendInvest\Helper\DateValidator;


class Loan
{
    /**
     * @var \DateTimeImmutable
     */
    private $startDate;

    /**
     * @var \DateTimeImmutable
     */
    private $endDate;

    /**
     * @var \SplObjectStorage
     */
    public $tranches;

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
        $start = new \DateTimeImmutable($startDate);
        $end = new \DateTimeImmutable($endDate);
        if ($start > $end) {
            throw new \Exception('Start date must be earlier than end date');
        }
        $this->startDate = $start;
        $this->endDate = $end;
        $this->tranches = new \SplObjectStorage();
    }

    public function isOpen(): bool
    {
        $today = new \DateTimeImmutable();
        return $this->endDate > $today;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getStartDate(): \DateTimeImmutable
    {
        return $this->startDate;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getEndDate(): \DateTimeImmutable
    {
        return $this->endDate;
    }

    public function addTranche(Tranche $tranche): void
    {
        if (!$this->tranches->contains($tranche)) {
            $this->tranches->attach($tranche);
        }
    }
}