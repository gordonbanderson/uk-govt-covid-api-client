<?php declare(strict_types = 1);

namespace Suilven\CovidAPIClient\Filter;

use Suilven\CovidAPIClient\Factory\AreaTypeFactory;

/**
 * Class Filter
 *
 * @package Suilven\CovidAPIClient\Filter
 */
class Filter
{
    /** @var \Suilven\CovidAPIClient\Filter\AreaType */
    private $areaType;

    /** @var string|null */
    private $areaName;

    /** @var string|null */
    private $areaCode;

    /** @var string|null */
    private $date;

    public function __construct()
    {
        // initialise area type as this is mandatory
        $factory = new AreaTypeFactory();
        $this->areaType = $factory->getAreaType(AreaType::NATION);
    }


    public function getAreaType(): AreaType
    {
        return $this->areaType;
    }


    public function setAreaType(AreaType $areaType): void
    {
        $this->areaType = $areaType;
    }


    public function getAreaName(): ?string
    {
        return $this->areaName;
    }


    public function setAreaName(string $areaName): void
    {
        $this->areaName = $areaName;
    }


    public function getAreaCode(): ?string
    {
        return $this->areaCode;
    }


    public function setAreaCode(string $areaCode): void
    {
        $this->areaCode = $areaCode;
    }


    public function getDate(): ?string
    {
        return $this->date;
    }


    public function setDate(string $date): void
    {
        $this->date = $date;
    }
}
