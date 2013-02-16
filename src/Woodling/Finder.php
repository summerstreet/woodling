<?php namespace Woodling;

class Finder
{

    /**
     * @var array Default search paths (last node serves as both file and folder name)
     */
    public $searchPaths = array(
        'applications/tests/blueprints',
        'app/tests/blueprints',
        'tests/blueprints'
    );

    /**
     * @param string|array $paths String or array of paths to expand search with
     */
    public function addPaths($paths)
    {
        if (is_string($paths))
        {
            $paths = array($paths);
        }

        foreach($paths as $path)
        {
            $this->searchPaths[] = $path;
        }
    }

}
