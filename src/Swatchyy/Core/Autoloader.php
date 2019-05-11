<?php

namespace Matik\Swatchyy\Core;

use Matik\Swatchyy\Config\Configuration;
use Matik\Swatchyy\Exceptions\FileNotFoundException;

class Autoloader
{
    /**
     * Theme config instance.
     *
     * @var Configuration
     */
    protected $config;

    /**
     * Construct autoloader.
     *
     * @param Configuration $config
     */
    public function __construct(Configuration $config)
    {
        $this->config = $config;
    }

    /**
     * Autoload registered files.
     *
     * @return void
     * @throws FileNotFoundException
     *
     * @throws FileNotFoundException
     */
    public function register()
    {
        do_action('matik/swatchyy/autoloader/before_load');

        $this->load();

        do_action('matik/swatchyy/autoloader/after_load');
    }

    /**
     * Localize and autoloads files.
     *
     * @return void
     * @throws FileNotFoundException
     */
    public function load()
    {
        foreach ($this->config['autoload'] as $file) {
            if ( ! locate_template($this->getRelativePath($file), true, true)) {
                throw new FileNotFoundException("Bootstrapped file [{$this->getPath($file)}] cannot be found. Please, check your bootstrap entries in `config/app.php` file.");
            }
        }
    }

    /**
     * Gets absolute file path.
     *
     * @param  string $file
     *
     * @return string
     */
    public function getPath($file)
    {
        $file = $this->getRelativePath($file);

        return $this->config['paths']['directory'] . '/' . $file;
    }

    /**
     * Gets file path within `theme` directory.
     *
     * @param  string $file
     *
     * @return string
     */
    public function getRelativePath($file)
    {
        return $this->config['directories']['app'] . '/' . $file;
    }
}
