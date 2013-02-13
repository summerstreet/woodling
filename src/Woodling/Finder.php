<?php namespace Woodling;

class Finder
{

    /**
     * @var array Paths to check
     */
    protected $paths = array(
        'application/tests/',
        'app/tests/',
        'tests/'
    );

    /**
     * @var string Default filename
     */
    protected $filename = 'blueprints.php';

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param array $paths
     */
    public function setPaths($paths)
    {
        $this->paths = $paths;
    }

    /**
     * @return array
     */
    public function getPaths()
    {
        return $this->paths;
    }

    /**
     * @param array|string $paths
     */
    public function addPaths($paths)
    {
        if (is_string($paths))
        {
            $paths = array($paths);
        }

        foreach($paths as $path)
        {
            $this->paths[] = $path;
        }
    }

    /**
     * @param string $dir
     * @return bool
     */
    public function isDir($dir)
    {
        return is_dir($dir);
    }

    /**
     * @param string $file
     * @return bool
     */
    public function fileExists($file)
    {
        return file_exists($file);
    }

    /**
     * @param string $file
     * @return mixed
     */
    public function loadFile($file)
    {
        return require_once($file);
    }

    /**
     * @param string $path
     */
    public function loadByFilename($path)
    {
        $filepath = rtrim($path, '/').'/'.$this->filename;
        if ($this->fileExists($filepath))
        {
            $this->loadFile($filepath);
        }
    }

    /**
     * @param string $path
     */
    public function loadInPath($path)
    {
        foreach (new \DirectoryIterator($path) as $node)
        {
            $ext = strtolower(pathinfo($node->getPathName(), PATHINFO_EXTENSION));

            if ($node->isFile() && $ext === 'php')
            {
                $this->loadFile($node->getPathName());
            }
        }
    }

    public function findBlueprints()
    {
        $paths = $this->getPaths();

        foreach($paths as $path)
        {
            if ( ! $this->isDir($path)) continue;

            $this->loadByFilename($path);
            $this->loadInPath($path);
        }
    }

}
