<?php
/**
 * Created by PhpStorm.
 * User: dwendlandt
 * Date: 04/02/16
 * Time: 09:41
 */

namespace Dawen\Bundle\ConfigToJsBundle\Tests\Component;

use Dawen\Bundle\ConfigToJsBundle\Component\ConfigDumper;
use Dawen\Bundle\ConfigToJsBundle\Component\ConfigDumperException;
use Dawen\Bundle\ConfigToJsBundle\Component\ConfigDumperInterface;

class ConfigDumperTest extends \PHPUnit_Framework_TestCase
{
    const OUTPUT_PATH = 'my-path/file.js';
    const TYPE = 'module';

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $filesystem;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $renderer;

    /**
     * @var ConfigDumperInterface
     */
    private $dumper;

    /**
     * @var array
     */
    private $config = ['my' => 'config'];

    protected function setUp()
    {
        parent::setUp();

        $this->filesystem = $this->getMockBuilder('Symfony\Component\Filesystem\Filesystem')
            ->disableOriginalConstructor()
            ->getMock();

        $this->renderer = $this->getMockBuilder('Dawen\Bundle\ConfigToJsBundle\Component\RendererInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $this->dumper = new ConfigDumper(self::TYPE, self::OUTPUT_PATH, $this->config, $this->filesystem);
    }

    protected function tearDown()
    {
        $this->filesystem = null;
        $this->renderer = null;

        parent::tearDown();
    }

    public function testInstance()
    {
        $this->assertInstanceOf('Dawen\Bundle\ConfigToJsBundle\Component\ConfigDumperInterface', $this->dumper);
        $this->assertInstanceOf('Dawen\Bundle\ConfigToJsBundle\Component\ConfigDumper', $this->dumper);
    }

    public function testGetConfig()
    {
        $this->assertSame($this->config, $this->dumper->getConfig());
    }

    public function testSetConfig()
    {
        $config = ['new' => 'config', 'more' => 'values'];

        $this->dumper->setConfig($config);
        $this->assertSame($config, $this->dumper->getConfig());
    }

    public function testGetType()
    {
        $this->assertSame(self::TYPE, $this->dumper->getType());
    }

    public function testSetType()
    {
        $type = 'new-type';

        $this->dumper->setType($type);
        $this->assertSame($type, $this->dumper->getType());
    }

    public function testGetOutputPath()
    {
        $this->assertSame(self::OUTPUT_PATH, $this->dumper->getOutputPath());
    }

    public function testSetOutputPath()
    {
        $outputPath = 'new-output-path';

        $this->dumper->setOutputPath($outputPath);
        $this->assertSame($outputPath, $this->dumper->getOutputPath());
    }

    public function testGetFilesystem()
    {
        $this->assertSame($this->filesystem, $this->dumper->getFilesystem());
    }

    public function testSetFilesystem()
    {
        $filesystem = $this->getMockBuilder('Symfony\Component\Filesystem\Filesystem')
            ->disableOriginalConstructor()
            ->getMock();

        $this->dumper->setFilesystem($filesystem);
        $this->assertSame($filesystem, $this->dumper->getFilesystem());
    }

    public function testRegisterRendererException()
    {
        $this->renderer->expects($this->exactly(2))->method('getName')->willReturn(self::TYPE);

        $message = 'A renderer with the name "' . self::TYPE . '" is already registered';
        $this->setExpectedException(ConfigDumperException::class, $message);

        $this->dumper->registerRenderer($this->renderer);
        $this->dumper->registerRenderer($this->renderer);
    }

    public function testDumpNotExistingRendererException()
    {
        $message = 'A renderer with the name "' . self::TYPE . '" is not registered';
        $this->setExpectedException(ConfigDumperException::class, $message);

        $this->dumper->dump();
    }

    public function testDumpEmptyConfigException()
    {
        $this->renderer->expects($this->never())->method('getName')->willReturn(self::TYPE);

        $message = 'It does not make sense to dump an empty config';
        $this->setExpectedException(ConfigDumperException::class, $message);

        $this->dumper->setConfig([]);
        $this->dumper->dump();
    }

    public function testDump()
    {
        $renderedString = 'my fancy output';

        $this->renderer->expects($this->once())->method('getName')->willReturn(self::TYPE);
        $this->renderer->expects($this->once())->method('render')->with($this->config)->willReturn($renderedString);
        $this->filesystem->expects($this->once())->method('dumpFile')->with(self::OUTPUT_PATH, $renderedString);

        $this->dumper->registerRenderer($this->renderer);
        $this->dumper->dump();
    }
}