<?php declare(strict_types = 1);

namespace Suilven\CovidAPIClient\Client;

use Suilven\CovidAPIClient\Transport\Http;

class APIClient
{
    /** @var \Suilven\CovidAPIClient\Transport\Http|null */
    private $http;

    public function __construct()
    {
        $this->http = new Http();
    }


    public function getData($filters)
    {
        $encodedFilters = $this->getFiltersForURL($filters);
        $structure = $this->getStructure();
        $url = Http::ENDPOINT . '?filters=' . $encodedFilters;
        $url .= '&structure=' . $structure;

        error_log('URL: ' . $url);

        $gzipped = $this->http->request($url);
        return gzdecode($gzipped);
    }


    private function getStructure()
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
        return json_encode($structure);
    }


    /** @param array<\Suilven\CovidAPIClient\Filter\Filter> $filters */
    public function getFiltersForURL(array $filters): string
    {
        $encodedFilters = [];
        /** @var \Suilven\CovidAPIClient\Filter\Filter $filter */
        foreach ($filters as $filter) {
            //filters=[metricName1]=[string];[metricName2]=[string];[metricName3]=[string]
            if (!\is_null($filter->getAreaType())) {
                $encodedFilters[] = 'areaType=' . $filter->getAreaType()->getName();
            }

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
}
