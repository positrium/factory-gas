<?php

namespace imasami\FactoryGas;

use Fuel\Core\DB;

class FactoryGas
{
  private static $instance;

  protected $factories = [];

  private function __construct()
  {
  }

  public static function getInstance()
  {
    if (self::$instance == null) {
      self::$instance = new FactoryGas();
    }
    return self::$instance;
  }

  /**
   * define factory.
   *
   * @param $name
   * @param array $kvs
   */
  public function define($table, $name, array $kvs)
  {
    $this->factories[$name] = [
      'table' => $table,
      'param' => $kvs
    ];
  }

  /**
   * create array in memory.
   *
   * @param $name
   *
   * @return mixed
   */
  public function build($name)
  {
    return $this->factories[$name]['param'];
  }

  /**
   * create db record.
   *
   * @param $name
   *
   * @return object
   */
  public function create($name)
  {
    DB::insert($this->factories[$name]['table'])->set($this->factories[$name]['param'])->execute();
    return DB::select()->from($this->factories[$name]['table'])->where($this->factories[$name]['param'])->execute()->current();
  }

  /**
   * @return array
   */
  public function getFactories()
  {
    return $this->factories;
  }
}

$suffix = '_factory.php';
$dir = APPPATH . 'tests/factories/';
$len = strlen($suffix);
foreach (scandir($dir) as $file) {
  if (substr($file, strlen($file) - $len, $len) !== $suffix) {
    continue;
  }
  require_once($dir . $file);
}
