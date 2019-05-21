# Datescan
> Recognize and parse multiple date/time formats.

#### Example Usage

```
<?php

namespace ExampleNamespace/ExampleCode;

use westonwatson/datescan/Datescan;

class ExampleClass 
{
    public function exampleFunction(string $date = '10/12/19'): string
    {
        echo "\n{$date}\n";
        $dth = new Datescan($date);
        
        return $dth->getRealDateTime()->format('d/m/Y');
    }
}
```

#### Introduction


