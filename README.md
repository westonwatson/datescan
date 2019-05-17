# Datescan
> Recognize and parse multiple date/time formats.


####Example Usage
```
<?php

namespace ExampleNamespace/ExampleCode;

use westonwatson/datescan/DateTimeHelper;

class ExampleClass 
{
    public function exampleFunction(string $date = '10/12/19'): string
    {
        echo "\n{$date}\n";
        $dth = new DateTimeHelper($date);
        
        return $dth->getRealDateTime()->format('d/m/Y');
    }
}
```
