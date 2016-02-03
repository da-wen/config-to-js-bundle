<?php
/**
 * Created by PhpStorm.
 * User: dwendlandt
 * Date: 03/02/16
 * Time: 19:36
 */

namespace Dawen\Bundle\ConfigToJsBundle\Component;

interface RendererInterface
{
    /**
     * Gets the name of the renderer
     *
     * @return string
     */
    public function getName();

    /**
     * Generates valid javascript of configuration.
     *
     * @param array $config
     *
     * @return string
     */
    public function render(array $config);
}