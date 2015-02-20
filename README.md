runkit
======

##Installation

####Install runkit

For use this extension you should install php runkit extension from https://github.com/zenovich/runkit

For install it you should do (with root access):

```bash
$> cd /usr/src/
$> git clone https://github.com/zenovich/runkit.git
$> cd runkit
$> ./configure
$> make
$> make install
```

Then you need to add runkit.so to your php.ini config file and restart apache or php-fpm

####Install oncesk/runkit lib

For installation you can use git clone, composer will be soon

```bash
$> git clone https://github.com/oncesk/runkit.git
```

Or download zip archive and unpack it into some directory

If you install not with composer you can include autoload.php into your code

```php

include __DIR__ . '/runkit/src/autoload.php';

```

####Runkit Class

Will be soon

####Runkit Method

Will be soon

####Runkit Function

Will be soon

####Runkit Constant

Will be soon

####Tests

Tested with PHPUnit

```bash
$> cd tests
$> phpunit --bootstrap ../src/autoload.php  ./
```

PS: new releasses will be soon
