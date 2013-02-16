<?php

use Woodling\Finder;

class TestWoodlingFinder extends PHPUnit_Framework_TestCase
{

    /**
     * @var Finder
     */
    public $finder;

    public function setUp()
    {
        $this->finder = new Finder();
    }

    public function testInstantiation()
    {
        $this->assertNotEmpty($this->finder->searchPaths);
    }

    public function testAddPaths()
    {
        $stringPath = 'my/string/path';
        $arrayPaths = array('my/array/path/1', 'my/array/path/2');

        $this->finder->addPaths($stringPath);
        $this->assertTrue(in_array($stringPath, $this->finder->searchPaths), 'String path added');

        $this->finder->addPaths($arrayPaths);
        $this->assertTrue(in_array($arrayPaths[0], $this->finder->searchPaths), 'Array path [0] added');
        $this->assertTrue(in_array($arrayPaths[1], $this->finder->searchPaths), 'Array path [1] added');
    }

}
