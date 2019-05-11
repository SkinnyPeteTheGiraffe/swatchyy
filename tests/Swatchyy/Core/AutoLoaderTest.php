<?php

use Brain\Monkey\Functions;
use Brain\Monkey\Actions;
use Matik\Swatchyy\Core\Autoloader;
use Matik\Swatchyy\Core\Config;
use Matik\Swatchyy\Tests\SwatchyyTestCase;
use Matik\Swatchyy\Exceptions\FileNotFoundException;

class AutoloaderTest extends SwatchyyTestCase
{
    /**
     * @test
     */
    public function test_relative_path_getter()
    {
        $config = $this->getConfig();
        $autoloader = $this->getAutoloader($config);

        $this->assertEquals($autoloader->getRelativePath('file/to/load.php'), 'app/file/to/load.php');
    }

    /**
     * @test
     */
    public function test_path_getter()
    {
        $config = $this->getConfig();
        $autoloader = $this->getAutoloader($config);

        $this->assertEquals($autoloader->getPath('file/to/load.php'), 'abs/path/app/file/to/load.php');
    }

    /**
     * @test
     * @throws FileNotFoundException
     */
    public function it_should_throw_if_no_file()
    {
        $config = $this->getConfig();
        $autoloader = $this->getAutoloader($config);

        Functions\expect('locate_template')
            ->once()
            ->with('app/file/to/load.php', true, true)
            ->andReturn(false);

        $this->expectException(FileNotFoundException::class);

        $autoloader->register();
    }

    /**
     * @test
     * @throws FileNotFoundException
     */
    public function it_should_return_true_on_successfully_autoloading()
    {
        $config = $this->getConfig();
        $this->assertNotNull($config);
        $autoloader = $this->getAutoloader($config);

        Actions\expectDone('matik/swatchyy/autoloader/before_load')->once()->withAnyArgs();
        Actions\expectDone('matik/swatchyy/autoloader/after_load')->once()->withAnyArgs();

        Functions\expect('locate_template')
            ->once()
            ->with('app/file/to/load.php', true, true)
            ->andReturn(true);

        $autoloader->register();
    }

    public function getConfig()
    {
        return new Config([
            'paths' => [
                'directory' => 'abs/path',
            ],
            'directories' => [
                'app' => 'app'
            ],
            'autoload' => [
                'file/to/load.php',
            ]
        ]);
    }

    public function getAutoloader($config)
    {
        return new Autoloader($config);
    }
}
