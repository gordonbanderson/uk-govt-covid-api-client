<?php declare(strict_types = 1);

namespace Suilven\CovidAPIClient\Model;

class SingleEntry
{
    /** @var string $date */
    private $date;

    /** @var string */
    private $areaName;

    /** @var string */
    private $areaCode;

    /** @var int */
    private $newCasesByPublishDate;

    /** @var int */
    private $cumCasesByPublishDate;

    /** @var ?int */
    private $newDeaths28DaysByDeathDate;

    /** @var ?int */
    private $cumDeaths28DaysByDeathDate;

    public function getDate(): string
    {
        return $this->date;
    }


    public function setDate(string $date): void
    {
        $this->date = $date;
    }


    public function getAreaName(): string
    {
        return $this->areaName;
    }


    public function setAreaName(string $areaName): void
    {
        $this->areaName = $areaName;
    }


    public function getAreaCode(): string
    {
        return $this->areaCode;
    }


    public function setAreaCode(string $areaCode): void
    {
        $this->areaCode = $areaCode;
    }


    public function getNewCasesByPublishDate(): int
    {
        return $this->newCasesByPublishDate;
    }


    public function setNewCasesByPublishDate(?int $newCasesByPublishDate): void
    {
        $this->newCasesByPublishDate = $newCasesByPublishDate;
    }


    public function getCumCasesByPublishDate(): ?int
    {
        return $this->cumCasesByPublishDate;
    }


    public function setCumCasesByPublishDate(?int $cumCasesByPublishDate): void
    {
        $this->cumCasesByPublishDate = $cumCasesByPublishDate;
    }


    public function getNewDeaths28DaysByDeathDate(): ?int
    {
        return $this->newDeaths28DaysByDeathDate;
    }


    public function setNewDeaths28DaysByDeathDate(?int $newDeaths28DaysByDeathDate): void
    {
        $this->newDeaths28DaysByDeathDate = $newDeaths28DaysByDeathDate;
    }


    public function getCumDeaths28DaysByDeathDate(): ?int
    {
        return $this->cumDeaths28DaysByDeathDate;
    }


    public function setCumDeaths28DaysByDeathDate(?int $cumDeaths28DaysByDeathDate): void
    {
        $this->cumDeaths28DaysByDeathDate = $cumDeaths28DaysByDeathDate;
    }
}
