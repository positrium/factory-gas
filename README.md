# factory-gas

![](https://img.shields.io/badge/FuelPHP-1.8.*-blue.svg)
[![Build Status](https://travis-ci.org/imasami/factory-gas.svg?branch=master)](https://travis-ci.org/imasami/factory-gas)

## composer

```
"require-dev": {
	"imasami/factory-gas": "dev-master"
},
```

## setup

copy `vendor/imasami/factory-gas/tests/factories/foo_factory.php.dist` to below.
`_factory.php` is suffix.

```
app
 `--- tests
       `--- factories
             `--- brabra_success_factory.php
             `--- brabra_fail_factory.php
```

define factories to `brabra_success_factory.php`

```php
<?php

use imasami\FactoryGas\FactoryGas;

// ---------------------------------------------------------------------------

FactoryGas::define('users', 'Controller_Users_Test_success', [
  'name' => 'Alan',
  'age' => 25
]);
```

define factories to `brabra_fail_factory.php`

```php
<?php

use imasami\FactoryGas\FactoryGas;

// ---------------------------------------------------------------------------

FactoryGas::define('users', 'Controller_Users_Test_fail', [
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
  protected function setUp()
  {
    $model = FactoryGas::build('Controller_Users_Test_success');
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
  protected function setUp()
  {
    $model = FactoryGas::create('Controller_Users_Test_success');
    print($model['id']);
    // 11
    FactoryGas::create('Controller_Users_Test_fail');
  }
```

### truncate

```php
<?php

use imasami\FactoryGas\FactoryGas;

class Controller_Users_Test extends \PHPUnit_Framework_TestCase
{
  protected function tearDown()
  {
    FactoryGas::truncate('Controller_Users_Test_success');
  }
```
