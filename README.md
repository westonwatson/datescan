# Datescan 
> Recognize and parse multiple date/time formats.

![Build Status](https://travis-ci.org/westonwatson/datescan.svg?branch=master)
![MIT License](https://img.shields.io/github/license/westonwatson/datescan.svg)
![Release](https://img.shields.io/github/release/westonwatson/datescan.svg)
![GitHub tag](https://img.shields.io/github/tag/westonwatson/datescan.svg)
![Download Count](https://img.shields.io/github/downloads/westonwatson/datescan/total.svg)
![GitHub contributors](https://img.shields.io/github/contributors/westonwatson/datescan.svg)
![GitHub issues](https://img.shields.io/github/issues/westonwatson/datescan.svg)

We needed a simple tool to help parse multiple date formats that came in over a myriad of sources into our central lead processing platform. Datescan was a way for us to recognize and parse the multitude of differing formats with a simple, consistent, and reliable tool.

We're excited to bring Datescan to the public, and hope that more developers come on board and contribute to the project.


#### Example Usage(s)
##### Basic Usage
```
<?php

namespace ExampleNamespace\ExampleCode;

use westonwatson\Datescan\Datescan;

/**
 * Class ExampleClass
 *
 * @package ExampleNamespace\ExampleCode
 */
class ExampleClass
{
    /**
     * @param string $date
     *
     * @return string
     * @throws \Exception
     */
    public function exampleFunction(string $date = '10/12/19'): string
    {
        //input date as string
        $datescan = new Datescan($date);

        //get DateTime object
        $dateTimeObject = $datescan->getRealDateTime();

        //return date string as another format
        return $dateTimeObject->format('d/m/Y');
    }
}
```

##### Custom Pattern Format
> When dealing with multiple date time formats, you may come across non-standard formats. These formats may not be included in Datescan's default pattern list. Using the `addFormatPattern` method allows you to include custom regex patterns and their associated DateTime format strings. Below is an example of using the method to include your own pattern and format.
```
<?php

namespace ExampleNamespace\ExampleCustomPattern;

use westonwatson\Datescan\Datescan;

/**
 * Class ExampleCustomPatternClass
 *
 * @package ExampleNamespace
 */
class ExampleCustomPatternClass
{
    /**
     * @param string $date
     *
     * @return string
     */
    public function exampleCustomPatternFunction(string $date = '10--12--2019'): string
    {
        //input date as string
        $datescan = new Datescan($date);

        //add custom format and pattern
        $datescan->addFormatPattern('d--m--Y', '/^(0[1-9]|[1-2][0-9]|3[0-1])--(0[1-9]|1[0-2])--[0-9]{4}$/');

        //return DateTime object
        return $datescan->getRealDateTime();
    }
}       
```

##### Custom Closest Date
> Datescan uses a simple date difference algorithm to return a single date/time when there are multiple pattern matches. It uses the current DateTime (now) for comparison. So, if there are multiple regex pattern matches, the closest date to today will be selected and returned. You can change this 'closestDate' for comparisons, giving you more flexibility when dealing with complex patterns that could possibly match multiple formats.

```
<?php

namespace ExampleNamespace\ExampleClosestDateCode;

use westonwatson\Datescan\Datescan;

/**
 * Class ExampleClosestDateClass
 *
 * @package ExampleNamespace
 */
class ExampleClosestDateClass
{
    /**
     * @param string $date
     *
     * @return string
     */
    public function exampleClosestDateFunction(string $date = '10/12/12'): string
    {
        //input date as string
        $datescan = new Datescan($date);

        //set custom closestDate
        $datescan->setClosestDate(new DateTime('2009-01-01'));

        //get DateTime object
        $dateTimeObject = $datescan->getRealDateTime();

        //return date string as another format
        return $dateTimeObject->format('d/m/Y');
    }
}
```

> In the above section, we're dealing with a date string that could match multiple patterns. In this instance, we know that the date is y/m/d not d/m/y. Setting a closestDate in the past (2009) allows Datescan to match the correct pattern/format. December 12th, 2010.

### Contributing

Please, feel free to submit a pull request or open an issue on GitHub. Any and all help is greatly appreciated. If you'd like; add your name and/or contact information to the list of contributors below. 

--Thanks 👍 

##### Contributors 
 * Weston Watson 

![GitHub stars](https://img.shields.io/github/stars/westonwatson/datescan.svg?style=social&label=Star)
![GitHub watchers](https://img.shields.io/github/watchers/westonwatson/datescan.svg?style=social&label=Watch)
![GitHub forks](https://img.shields.io/github/forks/westonwatson/datescan.svg?style=social&label=Fork)
