<?php
/**
 * Created by PhpStorm.
 * User: dwendlandt
 * Date: 03/02/16
 * Time: 23:14
 */

namespace Dawen\Bundle\ConfigToJsBundle\Component\Renderer;

use Dawen\Bundle\ConfigToJsBundle\Component\RendererInterface;

class ModuleRenderer implements RendererInterface
{

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'module';
    }

    /**
     * @inheritdoc
     */
    public function render(array $config)
    {
        return 'export default ' . json_encode($config) . ';';
    }
}