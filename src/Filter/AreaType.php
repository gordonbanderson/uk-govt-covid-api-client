<?php declare(strict_types = 1);

namespace Suilven\CovidAPIClient\Filter;

class AreaType
{

    public const OVERVIEW = 'overview';
    public const NATION = 'nation';
    public const REGION = 'region';
    public const NHS_REGION = 'nhsRegion';
    public const UPPER_TIER = 'utla';
    public const LOWER_TIER = 'ltla';

    /** @var string - this is immutable */
    private $name;


    public function __construct($name)
    {
        $this->name = $name;
    }


    public function getName(): string
    {
        return $this->name;
    }
}
