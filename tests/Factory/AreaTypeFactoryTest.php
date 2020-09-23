<?php declare(strict_types = 1);

namespace Suilven\CovidAPIClient\Tests\Factory;

use PHPUnit\Framework\TestCase;
use Suilven\CovidAPIClient\Factory\AreaTypeFactory;

class AreaTypeFactoryTest extends TestCase
{
    public function testInvalidAreaTypeName(): void
    {
        $this->expectException('\Exception');
        $this->expectExceptionMessage('Area type cul de sac is not valid');
        $factory = new AreaTypeFactory();
        $factory->getAreaType('cul de sac');
    }
}
