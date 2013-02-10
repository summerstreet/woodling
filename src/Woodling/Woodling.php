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

}
