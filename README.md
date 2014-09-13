runkit
======

####Runkit Function

You can add, modify, delete functions in realtime

```php

use Runkit\RunkitFunction;

function HeloWorld() {
  echo 'Hello';
}

$function = new RunkitFunction('HelloWorld');
$function->setCode('echo "Hello World!";');
$function->redefine();

HeloWorld();

// or you can use object of RunkitFunction class as a function

$function();

```
