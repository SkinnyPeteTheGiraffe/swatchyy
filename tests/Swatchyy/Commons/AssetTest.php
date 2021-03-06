<?php

namespace Matik\Swatchyy\Tests\Swatchyy\Commons;

use Mockery;
use Matik\Swatchyy\Tests\SwatchyyTestCase;
use Matik\Swatchyy\Commons\Asset;
use Brain\Monkey\Functions;
use phpmock\phpunit\PHPMock;
use Matik\Swatchyy\Core\Config;
use Matik\Swatchyy\Exceptions\FileNotFoundException;

class AssetTest extends SwatchyyTestCase
{
    use PHPMock;
    /**
     * @test
     */
    public function test_file_setter_and_getter()
    {
        $config = $this->getConfig();
        $asset = $this->getAsset($config, 'js/example.js');
        $this->assertEquals($asset->getFile(), 'js/example.js');
    }
    /**
     * @test
     */
    public function test_relative_path_getter()
    {
        $config = $this->getConfig();
        $asset = $this->getAsset($config, 'js/example.js');
        $this->assertEquals($asset->getRelativePath(), 'public/js/example.js');
    }
    /**
     * @test
     */
    public function test_public_path_getter()
    {
        $config = $this->getConfig();
        $asset = $this->getAsset($config, 'js/example.js');
        $this->assertEquals($asset->getPublicPath(), 'abs/path/public/js/example.js');
    }
    /**
     * @test
     */
    public function test_public_uri_getter()
    {
        $config = $this->getConfig();
        $asset = $this->getAsset($config, 'js/example.js');
        $this->assertEquals($asset->getPublicUri(), 'uri/path/public/js/example.js');
    }

    /**
     * @test
     * @throws FileNotFoundException
     */
//    public function test_uri_getter()
//    {
//        $config = $this->getConfig();
//        $asset = $this->getAsset($config, 'js/example.js');
//        $exists = $this->getFunctionMock(__NAMESPACE__, "file_exists");
//        $exists->expects($this->once())->willReturn(true);
//        $this->assertEquals($asset->getUri(), 'uri/path/public/js/example.js');
//    }
//
//    /**
//     * @test
//     * @throws FileNotFoundException
//     */
//    public function test_path_getter()
//    {
//        $config = $this->getConfig();
//        $asset = $this->getAsset($config, 'js/example.js');
//        $exists = $this->getFunctionMock(__NAMESPACE__, "file_exists");
//        $exists->expects($this->once())->willReturn(true);
//        $this->assertEquals($asset->getPath(), 'abs/path/public/js/example.js');
//    }
//
//    /**
//     * @test
//     * @throws FileNotFoundException
//     */
//    public function it_should_throw_on_getting_file_uri_if_file_is_missing()
//    {
//        $config = $this->getConfig();
//        $asset = $this->getAsset($config, 'js/example.js');
//        $this->expectException(FileNotFoundException::class);
//        $asset->getUri();
//    }

    /**
     * @test
     * @throws FileNotFoundException
     */
    public function it_should_throw_on_getting_file_path_if_file_is_missing()
    {
        $config = $this->getConfig();
        $asset = $this->getAsset($config, 'js/example.js');
        $this->expectException(FileNotFoundException::class);
        $asset->getPath();
    }
    public function getConfig()
    {
        return new Config([
            'paths' => [
                'uri' => 'uri/path',
                'directory' => 'abs/path',
            ],
            'directories' => [
                'assets' => 'resources/assets',
                'public' => 'public',
            ]
        ]);
    }
    public function getAsset($config, $name)
    {
        return (new Asset($config))->setFile($name);
    }
}