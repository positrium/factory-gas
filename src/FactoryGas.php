<?php

namespace imasami\FactoryGas;

use Fuel\Core\DB;

class FactoryGas
{
    private static $instance;

    protected static $factories = [];

    private function __construct()
    {
    }

    private static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new FactoryGas();

            $suffix = '_factory.php';
            if (!defined('APPPATH')) {
                define('APPPATH', './');
            }
            $dir = APPPATH . 'tests/factories/';
            $len = strlen($suffix);
            foreach (scandir($dir) as $file) {
                if (substr($file, strlen($file) - $len, $len) !== $suffix) {
                    continue;
                }
                require_once $dir . $file;
            }
        }
        return self::$instance;
    }

    /**
     * define factory.
     *
     * @param $name
     * @param array $kvs
     */
    public static function define($table, $name, array $kvs)
    {
        self::getInstance();

        self::$factories[$name] = [
            'table' => $table,
            'param' => $kvs,
        ];
    }

    /**
     * create array in memory.
     *
     * @param $name
     *
     * @return mixed
     */
    public static function build($name)
    {
        self::getInstance();

        return self::$factories[$name]['param'];
    }

    /**
     * create db record.
     *
     * @param $name
     *
     * @return object
     */
    public static function create($name)
    {
        self::getInstance();

			  DB::set_charset('utf8');
        DB::insert(self::$factories[$name]['table'])->set(self::$factories[$name]['param'])->execute();
        return DB::select()->from(self::$factories[$name]['table'])->where(self::$factories[$name]['param'])->execute()->current();
    }

    /**
     * @return array
     */
    public static function getFactories()
    {
        self::getInstance();

        return self::$factories;
    }

    /**
     * truncate db table.
     *
     * @param $name
     */
    public static function truncate($name = "all")
    {
        self::getInstance();

        if ($name == "all") {
            foreach (self::$factories as $factory) {
                \DBUtil::truncate_table($factory['table']);
            }
        } else {
            \DBUtil::truncate_table(self::$factories[$name]['table']);
        }
    }
}
