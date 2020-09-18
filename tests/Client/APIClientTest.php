<?php declare(strict_types = 1);

namespace Suilven\CovidAPIClient\Tests\Client;

use PHPUnit\Framework\TestCase;
use Suilven\CovidAPIClient\Client\APIClient;
use Suilven\CovidAPIClient\Factory\AreaTypeFactory;
use Suilven\CovidAPIClient\Filter\AreaType;
use Suilven\CovidAPIClient\Filter\Filter;

class APIClientTest extends TestCase
{
   /*
    * curl -i https://api.coronavirus.data.gov.uk/v1/data?filters=areaType=nation;areaName=england&structure=%7B%22name%22:%22areaName%22%7D'
    */
    public function testAreaTypeNation(): void
    {
        $factory = new AreaTypeFactory();
        $areaType = $factory->getAreaType(AreaType::NATION);

        $client = new APIClient();
        $filter = new Filter();
        $filter->setAreaType($areaType);
        $filter->setAreaName('england');
        $result = $client->getData([$filter]);
        echo '---- JSON ----';
        \print_r($result);
    }
}
