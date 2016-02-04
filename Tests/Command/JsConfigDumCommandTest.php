<?php
/**
 * Created by PhpStorm.
 * User: dwendlandt
 * Date: 04/02/16
 * Time: 09:03
 */

namespace Dawen\Bundle\ConfigToJsBundle\Tests\Command;

use Dawen\Bundle\ConfigToJsBundle\Command\JsConfigDumpCommand;

class JsConfigDumpCommandTest extends \PHPUnit_Framework_TestCase
{

    public function testDump()
    {
        $dumper = $this->getMockBuilder('Dawen\Bundle\ConfigToJsBundle\Component\ConfigDumper')
            ->disableOriginalConstructor()
            ->getMock();

        $dic = $this->getMockBuilder('Symfony\Component\DependencyInjection\ContainerInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $input = $this->getMockBuilder('Symfony\Component\Console\Input\InputInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $output = $this->getMockBuilder('Symfony\Component\Console\Output\OutputInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $dumpCommand = new JsConfigDumpCommand();
        $dumpCommand->setContainer($dic);

        //test instance
        $this->assertInstanceOf('Dawen\Bundle\ConfigToJsBundle\Command\JsConfigDumpCommand', $dumpCommand);
        $this->assertInstanceOf('Symfony\Component\Console\Command\Command', $dumpCommand);
        $this->assertInstanceOf('Symfony\Component\DependencyInjection\ContainerAwareInterface', $dumpCommand);

        //generate expectations
        $outputPath = 'my/output/path.js';

        $dumper->expects($this->once())->method('getOutputPath')->willReturn($outputPath);
        $dumper->expects($this->once())->method('dump');
        $output->expects($this->once())->method('writeln')->with('Dumped config to ' . $outputPath);
        $dic->expects($this->once())->method('get')->with('config_to_js.dumper')->willReturn($dumper);

        $dumpCommand->run($input, $output);
    }
}