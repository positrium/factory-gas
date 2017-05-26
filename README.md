# factory-gas

![](https://img.shields.io/badge/FuelPHP-1.8.*-blue.svg)

## composer

```
"require-dev": {
	"imasami/factory-gas": "*@dev"
},
```

## setup

copy `vendor/imasami/factory-gas/tests/factories.php.dis` to below.

```
app
 `--- tests
       `--- factories.php
```

define factories to `factories.php`

```php
<?php

use imasami\FactoryGas\FactoryGas;
$factory = FactoryGas::getInstance();

// ---------------------------------------------------------------------------

$factory->define('users', 'Controller_Users_Test_success', [
  'name' => 'Alan',
  'age' => 25
]);

$factory->define('users', 'Controller_Users_Test_fail', [
  'name' => 'Bob',
  'age' => 12
]);
```

## use

### build

build to memory.

```php
<?php

use imasami\FactoryGas\FactoryGas;

class Controller_Users_Test extends \PHPUnit_Framework_TestCase
{
  protected $factory;

  protected function setUp()
  {
    $this->factory = FactoryGas::getInstance();
    $model = $this->factory->build('Controller_Users_Test_success');
    print_r($model);
    // Array
    // (
    //  [name] => 'Alan'
    //  [age] => 25
    // )
  }
```

### create

create record to database.

```php
<?php

use imasami\FactoryGas\FactoryGas;

class Controller_Users_Test extends \PHPUnit_Framework_TestCase
{
  protected $factory;

  protected function setUp()
  {
    $this->factory = FactoryGas::getInstance();
    $model = $this->factory->create('Controller_Users_Test_success');
    print($model['id']);
    // 11
    $this->factory->create('Controller_Users_Test_fail');
  }
```


