<?php declare(strict_types = 1);

namespace Suilven\CovidAPIClient\Tests\Client;

use PHPUnit\Framework\TestCase;
use Suilven\CovidAPIClient\Client\APIClient;
use Suilven\CovidAPIClient\Factory\AreaTypeFactory;
use Suilven\CovidAPIClient\Filter\AreaType;
use Suilven\CovidAPIClient\Filter\Filter;

class APIClientTest extends TestCase
{
    /** @vcr test_area_type_nation */
    public function testAreaTypeNation(): void
    {
        $factory = new AreaTypeFactory();
        $areaType = $factory->getAreaType(AreaType::NATION);

        $client = new APIClient();
        $filter = new Filter();
        $filter->setAreaType($areaType);
        $filter->setAreaName('england');
        $result = $client->getData([$filter]);

        $this->assertEquals($result->getFirstLink(), $result->getLastLink());
        $this->assertEquals($result->getFirstLink(), $result->getCurrentLink());

        $this->assertEquals(1000, $result->getPageSize());
        $this->assertEquals(null, $result->getPrevLink());
        $this->assertEquals(null, $result->getNextLink());
    }


    /** @vcr test_lower_tier_by_date */
    public function testLowerTierByDate(): void
    {
        $factory = new AreaTypeFactory();
        $areaType = $factory->getAreaType(AreaType::LOWER_TIER);

        $client = new APIClient();
        $filter = new Filter();
        $filter->setAreaType($areaType);
        $filter->setDate('2020-09-21');
        $result = $client->getData([$filter]);

        /** @var \Suilven\CovidAPIClient\Model\SingleEntry $record */
        $record = $result->getRecords()[282];

        // this is recorded by PHP VCR so the values should not change
        $this->assertEquals(0, $record->getNewCasesByPublishDate());
        $this->assertEquals(0, $record->getNewDeaths28DaysByDeathDate());
        $this->assertEquals(60, $record->getCumCasesByPublishDate());
        $this->assertEquals(5, $record->getCumDeaths28DaysByDeathDate());
        $this->assertEquals(60, $record->getCumCasesByPublishDate());
        $this->assertEquals('S12000027', $record->getAreaCode());
        $this->assertEquals('Shetland Islands', $record->getAreaName());
        $this->assertEquals('2020-09-21', $record->getDate());
    }


    /** @vcr test_region_by_name */
    public function testRegionByName(): void
    {
        $factory = new AreaTypeFactory();
        $areaType = $factory->getAreaType(AreaType::REGION);

        $client = new APIClient();
        $filter = new Filter();
        $filter->setAreaType($areaType);
        $filter->setAreaName('East of England');
        $result = $client->getData([$filter]);

        $this->assertEquals($result->getFirstLink(), $result->getLastLink());
        $this->assertEquals($result->getFirstLink(), $result->getCurrentLink());

        $this->assertEquals(265, $result->getNumberOfResults());

        /** @var \Suilven\CovidAPIClient\Model\SingleEntry $firstRecord */
        $firstRecord = $result->getRecords()[0];

        // this is recorded by PHP VCR so the values should not change
        $this->assertEquals(238, $firstRecord->getNewCasesByPublishDate());
        $this->assertEquals(29660, $firstRecord->getCumCasesByPublishDate());
        $this->assertEquals('E12000006', $firstRecord->getAreaCode());
        $this->assertEquals('East of England', $firstRecord->getAreaName());
        $this->assertEquals('2020-09-23', $firstRecord->getDate());
    }


    /** @vcr test_area_code */
    public function testAreaCode(): void
    {
        $factory = new AreaTypeFactory();
        $areaType = $factory->getAreaType(AreaType::REGION);

        $client = new APIClient();
        $filter = new Filter();
        $filter->setAreaType($areaType);
        $filter->setAreaCode('E12000006');
        $result = $client->getData([$filter]);

        $this->assertEquals($result->getFirstLink(), $result->getLastLink());
        $this->assertEquals($result->getFirstLink(), $result->getCurrentLink());

        $this->assertEquals(265, $result->getNumberOfResults());

        /** @var \Suilven\CovidAPIClient\Model\SingleEntry $firstRecord */
        $firstRecord = $result->getRecords()[0];

        // this is recorded by PHP VCR so the values should not change
        $this->assertEquals(238, $firstRecord->getNewCasesByPublishDate());
        $this->assertEquals(29660, $firstRecord->getCumCasesByPublishDate());
        $this->assertEquals('E12000006', $firstRecord->getAreaCode());
        $this->assertEquals('East of England', $firstRecord->getAreaName());
        $this->assertEquals('2020-09-23', $firstRecord->getDate());
    }


    /** @vcr test_invalid_parameters */
    public function testInvalidParameters(): void
    {
        $this->expectException('\Exception');
        $this->expectExceptionMessage('http error returned');

        $factory = new AreaTypeFactory();
        $areaType = $factory->getAreaType(AreaType::LOWER_TIER);

        $client = new APIClient();
        $filter = new Filter();
        $filter->setAreaType($areaType);
        $filter->setDate('2020-14-20');
        $client->getData([$filter]);
    }
}
