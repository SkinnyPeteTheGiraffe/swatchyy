<?php

namespace Matik\Swatchyy\Commons;

use Matik\Swatchyy\Config\Configuration;
use Matik\Swatchyy\Exceptions\FileNotFoundException;

class Asset
{
    /**
     * Theme config instance.
     *
     * @var Configuration
     */
    protected $config;
    /**
     * Asset file.
     *
     * @var string
     */
    protected $file;
    /**
     * Construct asset.
     *
     * @param Configuration $config
     */
    public function __construct(Configuration $config)
    {
        $this->config = $config;
    }

    /**
     * Get asset file URI.
     *
     * @return string
     * @throws FileNotFoundException
     */
    public function getUri()
    {
        if ($this->fileExists($file = $this->getPublicPath())) {
            return $this->getPublicUri();
        }
        throw new FileNotFoundException("Asset file [$file] cannot be located.");
    }

    /**
     * Get asset file path.
     *
     * @return string
     * @throws FileNotFoundException
     */
    public function getPath()
    {
        if ($this->fileExists($file = $this->getPublicPath())) {
            return $file;
        }
        throw new FileNotFoundException("Asset file [$file] cannot be located.");
    }
    /**
     * Gets asset uri path.
     *
     * @return string
     */
    public function getPublicUri()
    {
        $uri = $this->config['paths']['uri'];
        return $uri . '/' . $this->getRelativePath();
    }
    /**
     * Gets asset directory path.
     *
     * @return string
     */
    public function getPublicPath()
    {
        $directory = $this->config['paths']['directory'];
        return $directory . '/' . $this->getRelativePath();
    }
    /**
     * Gets asset relative path.
     *
     * @return string
     */
    public function getRelativePath()
    {
        $public = $this->config['directories']['public'];
        return $public . '/' . $this->file;
    }
    /**
     * Checks if asset file exist.
     *
     * @param  string $file
     *
     * @return boolean
     */
    public function fileExists($file)
    {
        return file_exists($file);
    }
    /**
     * Gets the Asset file.
     *
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }
    /**
     * Sets the Asset file.
     *
     * @param string $file the file
     *
     * @return self
     */
    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }
}