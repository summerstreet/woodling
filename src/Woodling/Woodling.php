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

    public static function reset()
    {
        self::$core = NULL;
    }

    /**
     * @return Core
     */
    public static function getCore()
    {
        if (static::$core === NULL)
        {
            static::init();
        }

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
     * Creates a new blueprint and stores it in repository.
     * 
     * @param string $className
     * @param \Closure|array $params
     */
    public static function seed($className, $params)
    {
        static::getCore()->seed($className, $params);
    }

    /**
     * Returns an instance of your class with attributes defined in blueprint.
     * 
     * @param string $className
     * @param array $attributeOverrides
     * @return object
     */
    public static function retrieve($className, $attributeOverrides = array())
    {
        return static::getCore()->retrieve($className, $attributeOverrides);
    }

    /**
     * Returns a saved instance of your class with attributes defined in blueprint.
     * 
     * @param string $className
     * @param array $attributeOverrides
     * @return object
     */
    public static function saved($className, $attributeOverrides = array())
    {
        return static::getCore()->saved($className, $attributeOverrides);
    }

    /**
     * Returns an array of your class instances.
     * 
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
     * Returns an array of your class' saved instances
     * 
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
