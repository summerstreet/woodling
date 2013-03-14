<?php namespace Woodling;

/**
 * Woodling facade
 */

class Woodling
{

    /**
     * @var Core
     */
    protected static $core;

    /**
     * @return Core
     */
    public static function init()
    {
        $core = new Core();
        static::setCore($core);
        $core->finder->findBlueprints();
        return $core;
    }

    /**
     * @return Core
     */
    public static function getCore()
    {
        return static::$core;
    }

    /**
     * @param Core $core
     */
    public static function setCore(Core $core)
    {
        static::$core = $core;
    }

    /**
     * @param string $className
     * @param callable|array $params
     */
    public static function seed($className, $params)
    {
        static::getCore()->seed($className, $params);
    }

    /**
     * @param string $className
     * @param array $attributeOverrides
     * @return object
     */
    public static function retrieve($className, $attributeOverrides = array())
    {
        return static::getCore()->retrieve($className, $attributeOverrides);
    }

    /**
     * @param string $className
     * @param array $attributeOverrides
     * @return object
     */
    public static function saved($className, $attributeOverrides = array())
    {
        return static::getCore()->saved($className, $attributeOverrides);
    }

    /**
     * @param string $className
     * @param int $count
     * @param array $attributeOverrides
     * @return array
     */
    public static function retrieveList($className, $count, $attributeOverrides = array())
    {
        return static::getCore()->retrieveList($className, $count, $attributeOverrides);
    }

    /**
     * @param string $className
     * @param int $count
     * @param array $attributeOverrides
     * @return array
     */
    public static function savedList($className, $count, $attributeOverrides = array())
    {
        return static::getCore()->savedList($className, $count, $attributeOverrides);
    }

}
