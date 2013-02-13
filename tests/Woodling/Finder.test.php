<?php

use Woodling\Finder;

class TestWoodlingFinder extends PHPUnit_Framework_TestCase
{

    /**
     * @var Woodling\Finder
     */
    public $finder;

    public function setUp()
    {
        $this->finder = new Finder();
        $this->finder->setPaths(array('application/tests/', 'app/tests/', 'tests/'));
    }

    public function testInstantiation()
    {
        $this->assertInstanceOf('Woodling\Finder', $this->finder);
        $this->assertNotEmpty($this->finder->getPaths());
        $this->assertNotEmpty($this->finder->getFilename());
    }

    public function testSetAndGetPaths()
    {
        $paths = array('path1/', 'path2/');
        $this->finder->setPaths($paths);
        $this->assertEquals($paths, $this->finder->getPaths());
    }

    public function testGetFilename()
    {
        $this->assertNotEmpty($this->finder->getFilename());
    }

    public function testAddPathsWithString()
    {
        $path = 'my/blueprints/';
        $this->finder->addPaths($path);
        $this->assertTrue(in_array($path, $this->finder->getPaths()));
    }

    public function testAddPathsWithArray()
    {
        $paths = array('my/path/1', 'my/path/2');
        $this->finder->addPaths($paths);
        $this->assertTrue(in_array($paths[0], $this->finder->getPaths()));
        $this->assertTrue(in_array($paths[1], $this->finder->getPaths()));
    }

    public function testIsDir()
    {
        $path = __DIR__;
        $exists = '/tmp1';
        $notExists = '/not';
        @mkdir($path.$exists, 0777, true);
        $this->assertTrue($this->finder->isDir($path.$exists));
        $this->assertFalse($this->finder->isDir($path.$notExists));
        @rmdir(__DIR__.$exists);
    }

    public function testFileExists()
    {
        $path = __DIR__;
        $exists = $path.'/tmp.txt';
        $notExists = $path.'/not.php';
        @file_put_contents($exists, '');
        $this->assertTrue($this->finder->fileExists($exists));
        $this->assertFalse($this->finder->fileExists($notExists));
        @unlink($exists);
    }

    public function testLoadFile()
    {
        $path = __DIR__.'/';
        $file = 'blueprints.php';
        @file_put_contents($path.$file, "<?php\n");
        $this->assertEquals(1, $this->finder->loadFile($path.$file));
        @unlink($path.$file);
    }

    public function testLoadByFilename()
    {
        $path = 'some/path/';
        $finderMock = $this->getMock('Woodling\Finder', array('loadFile', 'fileExists'));
        $finderMock->expects($this->once())
            ->method('loadFile')
            ->with($this->equalTo($path.$finderMock->getFilename()));
        $finderMock->expects($this->once())
            ->method('fileExists')
            ->with($this->equalTo($path.$finderMock->getFilename()))
            ->will($this->returnValue(true));
        $finderMock->loadByFilename($path);
    }

    public function testLoadInPath()
    {
        $dir1 = __DIR__ . '/tmp2/';
        $dir2 = __DIR__ . '/tmp2/tmp/';
        $filePhp = $dir1.'tmp.php';
        $fileTxt = $dir1.'tmp.txt';

        @mkdir($dir2, 0777, true);
        @file_put_contents($filePhp, "<?php\n");
        @file_put_contents($fileTxt, '');

        $finderMock = $this->getMock('Woodling\Finder', array('loadFile'));
        $finderMock->expects($this->once())
            ->method('loadFile')
            ->with($this->equalTo($filePhp));

        $finderMock->loadInPath($dir1);
        $finderMock->loadInPath($dir2);

        @unlink($fileTxt);
        @unlink($filePhp);
        @rmdir($dir2);
        @rmdir($dir1);
    }

    public function testFindBlueprintsDirExists()
    {
        $finderMock = $this->getMock('Woodling\Finder', array('loadByFilename', 'loadInPath', 'isDir'));
        $finderMock->expects($this->exactly(3))
            ->method('isDir')
            ->with($this->stringEndsWith('tests/'))
            ->will($this->returnValue(true));
        $finderMock->expects($this->exactly(3))
            ->method('loadByFilename')
            ->with($this->stringEndsWith('tests/'));
        $finderMock->expects($this->exactly(3))
            ->method('loadInPath')
            ->with($this->stringEndsWith('tests/'));
        $finderMock->findBlueprints();
    }

    public function testFindBlueprintsDirNotExists()
    {
        $finderMock = $this->getMock('Woodling\Finder', array('loadByFilename', 'loadInPath', 'isDir'));
        $finderMock->expects($this->exactly(3))
            ->method('isDir')
            ->with($this->stringEndsWith('tests/'))
            ->will($this->returnValue(false));
        $finderMock->expects($this->never())
            ->method('loadByFilename');
        $finderMock->expects($this->never())
            ->method('loadInPath');
        $finderMock->findBlueprints();
    }

}
