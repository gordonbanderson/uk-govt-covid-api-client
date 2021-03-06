<?php declare(strict_types = 1);

namespace Suilven\CovidAPIClient\Client;

use Suilven\CovidAPIClient\Model\Results;
use Suilven\CovidAPIClient\Transport\Http;

class APIClient
{
    /** @var \Suilven\CovidAPIClient\Transport\Http */
    private $http;

    public function __construct()
    {
        $this->http = new Http();
    }


    /**
     * @param array<\Suilven\CovidAPIClient\Filter\Filter> $filters
     * @throws \Exception
     */
    public function getData(array $filters): Results
    {
        $encodedFilters = $this->getFiltersForURL($filters);
        $structure = $this->getStructure();
        $url = Http::ENDPOINT . '?filters=' . $encodedFilters;
        $url .= '&structure=' . $structure;

        // if no string is returned, due to HTTP errors, an exception will have been trhown
        /** @var string $gzipped */
        $gzipped = $this->http->request($url);

        /** @var string $gunzipped */
        $gunzipped = \gzdecode($gzipped);

        return new Results($gunzipped);
    }


    /** @param array<\Suilven\CovidAPIClient\Filter\Filter> $filters */
    public function getFiltersForURL(array $filters): string
    {
        $encodedFilters = [];
        /** @var \Suilven\CovidAPIClient\Filter\Filter $filter */
        foreach ($filters as $filter) {
            $encodedFilters[] = 'areaType=' . $filter->getAreaType()->getName();

            if (!\is_null($filter->getAreaCode())) {
                $encodedFilters[] = 'areaCode=' . $filter->getAreaCode();
            }

            if (!\is_null($filter->getAreaName())) {
                $encodedFilters[] = 'areaName=' . $filter->getAreaName();
            }

            if (\is_null($filter->getDate())) {
                continue;
            }

            $encodedFilters[] = 'date=' . $filter->getDate();
        }

        return \implode(';', $encodedFilters);
    }


    private function getStructure(): string
    {
        $structure = [
            'date' => 'date',
            'areaName' => 'areaName',
            'areaCode' => 'areaCode',
            'newCasesByPublishDate' => 'newCasesByPublishDate',
            'cumCasesByPublishDate' => 'cumCasesByPublishDate',
            'newDeaths28DaysByDeathDate' => 'newDeaths28DaysByDeathDate',
            'cumDeaths28DaysByDeathDate' => 'cumDeaths28DaysByDeathDate',
        ];

        // this value will always be set
        return (string) \json_encode($structure);
    }
}
