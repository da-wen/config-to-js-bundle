<?php
/**
 * Created by PhpStorm.
 * User: dwendlandt
 * Date: 03/02/16
 * Time: 23:28
 */

namespace Dawen\Bundle\ConfigToJsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class JsConfigDumpCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('config:js:dump')
            ->setDescription('Dumps defined config to js file');
    }

    /**
     * @see Command
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dumper = $this->getContainer()->get('config_to_js.dumper');

        $dumper->dump();

        $output->writeln('Dumped config to ' . $dumper->getOutputPath());
    }
}