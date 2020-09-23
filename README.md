# PHP Client to UK Govt Covid API
[![Build Status](https://travis-ci.org/gordonbanderson/uk-govt-covid-api-client.svg?branch=master)](https://travis-ci.org/gordonbanderson/uk-govt-covid-api-client)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/gordonbanderson/uk-govt-covid-api-client/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/gordonbanderson/uk-govt-covid-api-client/?branch=master)
[![codecov.io](https://codecov.io/github/gordonbanderson/uk-govt-covid-api-client/coverage.svg?branch=master)](https://codecov.io/github/gordonbanderson/uk-govt-covid-api-client?branch=master)


[![Latest Stable Version](https://poser.pugx.org/suilven/uk-covid-govt-api-client/version)](https://packagist.org/packages/suilven/uk-covid-govt-api-client)
[![Latest Unstable Version](https://poser.pugx.org/suilven/uk-covid-govt-api-client/v/unstable)](//packagist.org/packages/suilven/uk-covid-govt-api-client)
[![Total Downloads](https://poser.pugx.org/suilven/uk-covid-govt-api-client/downloads)](https://packagist.org/packages/suilven/uk-covid-govt-api-client)
[![License](https://poser.pugx.org/suilven/uk-covid-govt-api-client/license)](https://packagist.org/packages/suilven/uk-covid-govt-api-client)
[![Monthly Downloads](https://poser.pugx.org/suilven/uk-covid-govt-api-client/d/monthly)](https://packagist.org/packages/suilven/uk-covid-govt-api-client)
[![Daily Downloads](https://poser.pugx.org/suilven/uk-covid-govt-api-client/d/daily)](https://packagist.org/packages/suilven/uk-covid-govt-api-client)
[![composer.lock](https://poser.pugx.org/suilven/uk-covid-govt-api-client/composerlock)](https://packagist.org/packages/suilven/uk-covid-govt-api-client)

[![GitHub Code Size](https://img.shields.io/github/languages/code-size/gordonbanderson/uk-govt-covid-api-client)](https://github.com/gordonbanderson/uk-govt-covid-api-client)
[![GitHub Repo Size](https://img.shields.io/github/repo-size/gordonbanderson/uk-govt-covid-api-client)](https://github.com/gordonbanderson/uk-govt-covid-api-client)
[![GitHub Last Commit](https://img.shields.io/github/last-commit/gordonbanderson/uk-govt-covid-api-client)](https://github.com/gordonbanderson/uk-govt-covid-api-client)
[![GitHub Activity](https://img.shields.io/github/commit-activity/m/gordonbanderson/uk-govt-covid-api-client)](https://github.com/gordonbanderson/uk-govt-covid-api-client)
[![GitHub Issues](https://img.shields.io/github/issues/gordonbanderson/uk-govt-covid-api-client)](https://github.com/gordonbanderson/uk-govt-covid-api-client/issues)

![codecov.io](https://codecov.io/github/gordonbanderson/uk-govt-covid-api-client/branch.svg?branch=master)

# Background
The UK Government has provided an API for accessing COVID data.  The documentation is poor, see 
https://coronavirus.data.gov.uk/developers-guide , and if the structure parameter is missing the API call redirects to
the documentation above (!).  

I am not sure about how often and indeed how soon the data is updated, but hopefully it proves of use to the PHP
community.

# Installation
## Existing PHP Environment
If you have an existing PHP environment, install as follows:
```
composer require suilven/uk-covid-govt-api-client
```
## Docker
A Docker environment is provided for, primarily to run unit tests
```
sudo docker-compose up -d phpcli
sudo docker-compose exec /bin/bash
composer install
```

# Usage
## Get An Area Type
An area type is mandatory, but defaults to a level of nation.  This can be set as follows:

```
use Suilven\CovidAPIClient\Factory\AreaTypeFactory;
use Suilven\CovidAPIClient\Filter\AreaType;

$factory = new AreaTypeFactory();
$areaType = $factory->getAreaType(AreaType::NATION);
```

    public const OVERVIEW = 'overview';
    public const NATION = 'nation';
    public const REGION = 'region';
    public const NHS_REGION = 'nhsRegion';
    public const UPPER_TIER = 'utla';
    public const LOWER_TIER = 'ltla';
    
Valid values for AreaType are as follows:
* `AreaType::OVERVIEW`
* `AreaType::NATION`
* `AreaType::REGION`
* `AreaType::NHS_REGION`
* `AreaType::UPPER_TIER`
* `AreaType::LOWER_TIER`

Valid values for upper and lower tier area names can be found in the docs directory.

## Add a Filter
```
$factory = new AreaTypeFactory();
$areaType = $factory->getAreaType(AreaType::UPPER_TIER);
$client = new APIClient();
$filter = new Filter();
$filter->setAreaType($areaType);
$filter->setAreaName('Blackburn with Darwen');
$result = $client->getData([$filter]);
```

One can set a date, an area code or area name as above.


## Get Results
Each recodr (of an array) is a `Suilven\CovidAPIClient\Model<SingleEntry` object.
```
$record = $result->getRecords();
```

### Get Data For An Individual Result
```
$record->getNewCasesByPublishDate();
$record->getNewDeaths28DaysByDeathDate();
$record->getCumCasesByPublishDate();
$record->getCumDeaths28DaysByDeathDate();
$record->getCumCasesByPublishDate();
$this->assertEquals('S12000027', $record->getAreaCode();
$this->assertEquals('Shetland Islands', $record->getAreaName();
$this->assertEquals('2020-09-21', $record->getDate())
```


# COMMENTS
This is a functional but rough implementation, although well tested.
  
I still do not fully understand how the data behind the API is updated, this is a bit of a black box.
