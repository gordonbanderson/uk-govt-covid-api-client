<?php declare(strict_types = 1);

namespace Suilven\CovidAPIClient\Model;

class Results
{
    private $records = [];

    private $pageSize;

    private $numberOfResults;

    private $prevLink;

    private $nextLink;

    private $firstLink;

    private $lastLink;

    private $currentLink;

    /**
     * @return mixed
     */
    public function getCurrentLink()
    {
        return $this->currentLink;
    }

    public function __construct($json)
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



    /**
     * @return mixed
     */
    public function getPageSize()
    {
        return $this->pageSize;
    }

    /**
     * @return mixed
     */
    public function getNumberOfResults()
    {
        return $this->numberOfResults;
    }

    /**
     * @return mixed
     */
    public function getPrevLink()
    {
        return $this->prevLink;
    }

    /**
     * @return mixed
     */
    public function getNextLink()
    {
        return $this->nextLink;
    }

    /**
     * @return mixed
     */
    public function getFirstLink()
    {
        return $this->firstLink;
    }

    /**
     * @return mixed
     */
    public function getLastLink()
    {
        return $this->lastLink;
    }


    public function getRecords()
    {
        return $this->records;
    }
}
