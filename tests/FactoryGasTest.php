<?php
use imasami\FactoryGas\FactoryGas;
use PHPUnit\Framework\TestCase;

class FactoryGasTest extends TestCase
{
    protected function setUp()
    {
        FactoryGas::define('users', 'User_Test', [
            'id' => 1,
            'name' => "Bob",
            'age' => 25,
        ]);
    }

    public function testDefineFactory()
    {
        $factories = FactoryGas::getFactories();
        $this->assertNotEmpty($factories['User_Test']);
        $target = $factories['User_Test'];
        $this->assertEquals('users', $target['table']);
        $this->assertNotEmpty($target['param']);
        $param = $target['param'];
        $this->assertEquals(1, $param['id']);
        $this->assertEquals('Bob', $param['name']);
        $this->assertEquals(25, $param['age']);
    }

    public function testBuildFactory()
    {
        $param = FactoryGas::build('User_Test');
        $this->assertEquals(1, $param['id']);
        $this->assertEquals('Bob', $param['name']);
        $this->assertEquals(25, $param['age']);
    }

    public function testIncludeFactoryFile()
    {
        $param = FactoryGas::build('sample_defined_on_factory_1');
        $this->assertEquals(1, $param['COLUMN_1']);
        $this->assertEquals(9, $param['COLUMN_2']);

        $param = FactoryGas::build('sample_defined_on_factory_2');
        $this->assertEquals(255, $param['COLUMN_1']);
        $this->assertEquals(999, $param['COLUMN_2']);
    }

    protected function tearDown()
    {

    }
}
