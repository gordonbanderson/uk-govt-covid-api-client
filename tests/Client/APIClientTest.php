<?php declare(strict_types = 1);

namespace Suilven\CovidAPIClient\Tests\Client;

use PHPUnit\Framework\TestCase;
use Suilven\CovidAPIClient\Client\APIClient;
use Suilven\CovidAPIClient\Factory\AreaTypeFactory;
use Suilven\CovidAPIClient\Filter\AreaType;
use Suilven\CovidAPIClient\Filter\Filter;
use Suilven\CovidAPIClient\Model\SingleEntry;

class APIClientTest extends TestCase
{
    /**
     * @vcr test_area_type_nation
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

        $this->assertEquals($result->getFirstLink(), $result->getLastLink());
        $this->assertEquals($result->getFirstLink(), $result->getCurrentLink());
    }


    /**
     * @vcr textExplore
     */
    public function testExplore()
    {
        $factory = new AreaTypeFactory();
        $areaType = $factory->getAreaType(AreaType::LOWER_TIER);

        $client = new APIClient();
        $filter = new Filter();
        $filter->setAreaType($areaType);
        $filter->setDate('2020-09-21');
        $result = $client->getData([$filter]);
        print_r($result);
    }

        /**
     * @vcr testRegionByName
     */
    public function testRegionByName()
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

        $this->assertEquals(264, $result->getNumberOfResults());

        /** @var SingleEntry $firstRecord */
        $firstRecord = $result->getRecords()[0];

        print_r($firstRecord);

        // this is recorded by PHP VCR so the values should not change
        $this->assertEquals(189, $firstRecord->getNewCasesByPublishDate());
        $this->assertEquals(29422, $firstRecord->getCumCasesByPublishDate());
        $this->assertEquals('E12000006', $firstRecord->getAreaCode());
        $this->assertEquals('East of England', $firstRecord->getAreaName());
        $this->assertEquals('2020-09-22', $firstRecord->getDate());
    }


    /**
     * @vcr test_area

    public function testUpperTierByAreaCode(): void
    {
        $factory = new AreaTypeFactory();
        $areaType = $factory->getAreaType(AreaType::UPPER_TIER);

        $client = new APIClient();
        $filter = new Filter();
        $filter->setAreaType($areaType);
        $filter->setAreaCode('E92000001');
        $result = $client->getData([$filter]);
        echo '---- JSON ----';
        \print_r($result);
    }
     * **/
}
