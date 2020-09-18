<?php declare(strict_types = 1);

namespace Suilven\CovidAPIClient\Factory;

use splitbrain\phpcli\Exception;
use Suilven\CovidAPIClient\Filter\AreaType;

class AreaTypeFactory
{
    private const VALID_AREA_TYPES = [
        AreaType::OVERVIEW,
        AreaType::NATION,
        AreaType::REGION,
        AreaType::NHS_REGION,
        AreaType::LOWER_TIER,
        AreaType::UPPER_TIER,
    ];

    public function getAreaType(string $name): AreaType
    {
        if (!\in_array($name, self::VALID_AREA_TYPES, true)) {
            throw new Exception('Area type ' . $name . ' is not valid');
        }

        /*
         * Offset 'ltla'|'nation'|'nhsRegion'|'overview'|'region'|'utla' does
         not exist on array('overview', 'nation', 'region', 'nhsRegion',
         'ltla', 'utla').
         */
        return new AreaType($name);
    }
}
