<?php
/**
 * Created by PhpStorm.
 * User: dwendlandt
 * Date: 03/02/16
 * Time: 19:28
 */

namespace Dawen\Bundle\ConfigToJsBundle\Component;

use Symfony\Component\Filesystem\Filesystem;

final class ConfigDumper implements ConfigDumperInterface
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $outputPath;

    /**
     * @var array
     */
    private $config = [];

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var array
     */
    private $renderers = [];

    /**
     * ConfigDumper constructor.
     *
     * @param string $type
     * @param string $outputPath
     * @param array $config
     * @param Filesystem $filesystem
     */
    public function __construct($type, $outputPath, array $config, Filesystem $filesystem)
    {
        $this->type = $type;
        $this->outputPath = $outputPath;
        $this->config = $config;
        $this->filesystem = $filesystem;
    }

    /**
     * @inheritdoc
     */
    public function dump()
    {
        if (!isset($this->renderers[$this->type])) {
            throw new ConfigDumperException('A renderer with the name "' . $this->type . '" is not registered');
        }

        if (empty($this->config)) {
            throw new ConfigDumperException('It does not make sense to dump an empty config');
        }

        /** @var RendererInterface $renderer */
        $renderer = $this->renderers[$this->type];

        $this->filesystem->dumpFile($this->outputPath, $renderer->render($this->config));
    }

    /**
     * @inheritdoc
     */
    public function getOutputPath()
    {
        return $this->outputPath;
    }

    /**
     * @inheritdoc
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return $this->getType();
    }

    /**
     * @inheritdoc
     */
    public function setOutputPath($filePath)
    {
        $this->outputPath = $filePath;
    }

    /**
     * @inheritdoc
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    /**
     * @inheritdoc
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @inheritdoc
     */
    public function registerRenderer(RendererInterface $renderer)
    {
        $name = $renderer->getName();
        if (isset($this->renderers[$name])) {
            throw new ConfigDumperException('A renderer with the name "' . $name . '" is already registered');
        }

        $this->renderers[$name] = $renderer;
    }

    /**
     * @inheritdoc
     */
    public function getFilesystem()
    {
        return $this->filesystem;
    }

    /**
     * @inheritdoc
     */
    public function setFilesystem(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }
}