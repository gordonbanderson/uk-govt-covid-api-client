<?php declare(strict_types = 1);

namespace Suilven\CovidAPIClient\Model;

class Results
{
    /** @var array<\Suilven\CovidAPIClient\Model\SingleEntry> */
    private $records = [];

    /** @var int */
    private $pageSize;

    /** @var int */
    private $numberOfResults;

    /** @var string|null */
    private $prevLink;

    /** @var string|null */
    private $nextLink;

    /** @var string */
    private $firstLink;

    /** @var string */
    private $lastLink;

    /** @var string */
    private $currentLink;

    /**
     * Results constructor.
     */
    public function __construct(string $json)
    {
        $decoded = \json_decode($json, true);

        // deal with the entries retrieved first
        foreach ($decoded['data'] as $entryOrig) {
            $normalizedEntry = new SingleEntry();
            $normalizedEntry->setDate($entryOrig['date']);
            $normalizedEntry->setAreaName($entryOrig['areaName']);
            $normalizedEntry->setAreaCode($entryOrig['areaCode']);
            $normalizedEntry->setNewCasesByPublishDate($entryOrig['newCasesByPublishDate']);
            $normalizedEntry->setNewDeaths28DaysByDeathDate($entryOrig['newDeaths28DaysByDeathDate']);
            $normalizedEntry->setCumCasesByPublishDate($entryOrig['cumCasesByPublishDate']);
            $normalizedEntry->setCumDeaths28DaysByDeathDate($entryOrig['cumDeaths28DaysByDeathDate']);
            $this->records[] = $normalizedEntry;
        }

        $this->pageSize = $decoded['maxPageLimit'];
        $this->numberOfResults = $decoded['length'];
        $this->nextLink = $decoded['pagination']['next'];
        $this->prevLink = $decoded['pagination']['previous'];
        $this->firstLink = $decoded['pagination']['first'];
        $this->lastLink = $decoded['pagination']['last'];
        $this->currentLink = $decoded['pagination']['current'];
    }


    public function getCurrentLink(): string
    {
        return $this->currentLink;
    }


    public function getPageSize(): int
    {
        return $this->pageSize;
    }


    public function getNumberOfResults(): int
    {
        return $this->numberOfResults;
    }


    public function getPrevLink(): ?string
    {
        return $this->prevLink;
    }


    public function getNextLink(): ?string
    {
        return $this->nextLink;
    }


    public function getFirstLink(): string
    {
        return $this->firstLink;
    }


    public function getLastLink(): string
    {
        return $this->lastLink;
    }


    /** @return array<\Suilven\CovidAPIClient\Model\SingleEntry> */
    public function getRecords(): array
    {
        return $this->records;
    }
}
