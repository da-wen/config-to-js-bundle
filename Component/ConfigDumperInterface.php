<?php
/**
 * Created by PhpStorm.
 * User: dwendlandt
 * Date: 03/02/16
 * Time: 19:28
 */

namespace Dawen\Bundle\ConfigToJsBundle\Component;

use Symfony\Component\Filesystem\Filesystem;

interface ConfigDumperInterface
{
    /**
     * Dumps a file by given type
     *
     * @throws ConfigDumperException
     */
    public function dump();

    /**
     * Getter for output file path
     *
     * @return string
     */
    public function getOutputPath();

    /**
     * Getter for config that should be dumped
     *
     * @return array
     */
    public function getConfig();

    /**
     * Getter for type
     *
     * @return string
     */
    public function getType();

    /**
     * Getter for filesystem
     *
     * @return Filesystem
     */
    public function getFilesystem();

    /**
     * Setter for filesystem
     *
     * @param Filesystem $filesystem
     *
     * @return Filesystem
     */
    public function setFilesystem(Filesystem $filesystem);

    /**
     * Setter for output filepath
     *
     * @param string $filePath
     *
     * @return string
     */
    public function setOutputPath($filePath);

    /**
     * Setter for config
     *
     * @param array $config
     *
     * @return array
     */
    public function setConfig(array $config);

    /**
     * Setter for type
     *
     * @param string $type
     *
     * @return string
     */
    public function setType($type);

    /**
     * Registers a renderer
     *
     * @param RendererInterface $renderer
     * @throws ConfigDumperException
     */
    public function registerRenderer(RendererInterface $renderer);
}