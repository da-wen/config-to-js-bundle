<?php
/**
 * Created by PhpStorm.
 * User: dwendlandt
 * Date: 04/02/16
 * Time: 09:27
 */

namespace Dawen\Bundle\ConfigToJsBundle\Tests\Component\Renderer;

use Dawen\Bundle\ConfigToJsBundle\Component\Renderer\ModuleRenderer;

class ModuleRendererTest extends \PHPUnit_Framework_TestCase
{
    public function testGetName()
    {
        $renderer = new ModuleRenderer();
        $this->assertSame('module', $renderer->getName());
    }

    public function testRender()
    {
        $config = ['my' => 'value', 'second' => 'thing'];
        $expected = 'export default ' . json_encode($config) . ';';

        $renderer = new ModuleRenderer();

        $this->assertSame($expected, $renderer->render($config));
    }
}