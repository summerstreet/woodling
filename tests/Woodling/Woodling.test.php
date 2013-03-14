<?php

use Woodling\Core;
use Woodling\Woodling;

class TestWoodlingWoodling extends PHPUnit_Framework_TestCase
{

    /**
     * Should set a new instance of Woodling\Core on Woodling\Woodling
     */
    public function testStaticInit()
    {
        $file = 'tests/blueprints.php';
        $class = 'WoodlingTestStaticInitHelper_'.md5(microtime());
        $content = '<?php class '.$class.'{}';
        @file_put_contents($file, $content);

        $woodling = Woodling::init();
        $this->assertInstanceOf('Woodling\Core', Woodling::getCore());
        $this->assertSame($woodling, Woodling::getCore());
        $this->assertTrue(class_exists($class));

        @unlink($file);
    }

    public function testClass()
    {
        $this->assertClassHasStaticAttribute('core', 'Woodling\Woodling');
    }

    /**
     * Should return whatever's in Woodling::$core
     */
    public function testStaticSetAndGetCore()
    {
        $oldCore = Woodling::getCore();
        $newCore = new Core();
        Woodling::setCore($newCore);
        $this->assertSame($newCore, Woodling::getCore());
        Woodling::setCore($oldCore);
    }

    public function testStaticSeed()
    {
        $name = 'User';
        $closure = function() {};
        $coreMock = $this->getMock('Woodling\Core', array('seed'));
        $coreMock->expects($this->once())
            ->method('seed')
            ->with($this->equalTo($name), $this->isInstanceOf('Closure'));
        Woodling::setCore($coreMock);
        Woodling::seed($name, $closure);
    }

    public function testStaticRetrieve()
    {
        $name = 'User';
        $returnValue = 'Object';
        $coreMock = $this->getMock('Woodling\Core', array('retrieve'));
        $coreMock->expects($this->once())
            ->method('retrieve')
            ->with($this->equalTo($name))
            ->will($this->returnValue($returnValue));
        Woodling::setCore($coreMock);
        $this->assertEquals($returnValue, Woodling::retrieve($name));
    }

    public function testStaticRetrieveWithOverrides()
    {
        $name = 'User';
        $overrides = array('name' => 'Mindaugas Bujanauskas');
        $returnValue = 'Object';
        $coreMock = $this->getMock('Woodling\Core', array('retrieve'));
        $coreMock->expects($this->once())
            ->method('retrieve')
            ->with($this->equalTo($name), $this->arrayHasKey('name'))
            ->will($this->returnValue($returnValue));
        Woodling::setCore($coreMock);
        Woodling::retrieve($name, $overrides);
    }

    public function testStaticSaved()
    {
        $name = 'User';
        $returnValue = 'Object';
        $coreMock = $this->getMock('Woodling\Core', array('saved'));
        $coreMock->expects($this->once())
            ->method('saved')
            ->with($this->equalTo($name))
            ->will($this->returnValue($returnValue));
        Woodling::setCore($coreMock);
        $this->assertEquals($returnValue, Woodling::saved($name));
    }

    public function testStaticSavedWithOverrides()
    {
        $name = 'User';
        $overrides = array('name' => 'Mindaugas Bujanauskas');
        $returnValue = 'Object';
        $coreMock = $this->getMock('Woodling\Core', array('saved'));
        $coreMock->expects($this->once())
            ->method('saved')
            ->with($this->equalTo($name), $this->arrayHasKey('name'))
            ->will($this->returnValue($returnValue));
        Woodling::setCore($coreMock);
        Woodling::saved($name, $overrides);
    }

    public function testStaticRetrieveList()
    {
        $name = 'stdClass';
        $count = 3;
        $returnValue = array(new $name());

        $coreMock = $this->getMock('Woodling\Core', array('retrieveList'));
        $coreMock->expects($this->once())
            ->method('retrieveList')
            ->with($this->equalTo($name), $this->equalTo($count), $this->equalTo(array()))
            ->will($this->returnValue($returnValue));

        Woodling::setCore($coreMock);

        $list = Woodling::retrieveList($name, $count);
        $this->assertEquals($returnValue, $list);
    }

    public function testStaticRetrieveListWithOverrides()
    {
        $name = 'stdClass';
        $count = 3;
        $overrides = array('name' => 'Mindaugas Bujanauskas');
        $returnValue = array(new $name());

        $coreMock = $this->getMock('Woodling\Core', array('retrieveList'));
        $coreMock->expects($this->once())
            ->method('retrieveList')
            ->with($this->equalTo($name), $this->equalTo($count), $this->equalTo($overrides))
            ->will($this->returnValue($returnValue));

        Woodling::setCore($coreMock);

        $list = Woodling::retrieveList($name, $count, $overrides);
        $this->assertEquals($returnValue, $list);
    }

    public function testStaticSavedList()
    {
        $name = 'stdClass';
        $count = 3;
        $returnValue = new $name();

        $coreMock = $this->getMock('Woodling\Core', array('savedList'));
        $coreMock->expects($this->once())
            ->method('savedList')
            ->with($this->equalTo($name), $this->equalTo($count), $this->equalTo(array()))
            ->will($this->returnValue($returnValue));

        Woodling::setCore($coreMock);

        $list = Woodling::savedList($name, $count);
        $this->assertEquals($returnValue, $list);
    }

    public function testStaticSavedListWithOverrides()
    {
        $name = 'stdClass';
        $count = 3;
        $overrides = array('name' => 'Mindaugas Bujanauskas');
        $returnValue = new $name();

        $coreMock = $this->getMock('Woodling\Core', array('savedList'));
        $coreMock->expects($this->once())
            ->method('savedList')
            ->with($this->equalTo($name), $this->equalTo($count), $this->equalTo($overrides))
            ->will($this->returnValue($returnValue));

        Woodling::setCore($coreMock);

        $list = Woodling::savedList($name, $count, $overrides);
        $this->assertEquals($returnValue, $list);
    }

}
