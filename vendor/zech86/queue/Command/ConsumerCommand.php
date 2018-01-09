<?php

namespace Zechim\QueueBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ConsumerCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('queue:consume');
        $this->setDescription('Consume a message from a queue');
        $this->setHelp(
<<<EOT
    The <info>%command.name%</info> command consumes a message from AMQ
EOT
        );

        $this->setDefinition(
            new InputDefinition(array(
                new InputOption('body', 'b', InputOption::VALUE_REQUIRED, 'Message BODY'),
            ))
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $body = json_decode($input->getOption('body'), true);

            if (JSON_ERROR_NONE !== json_last_error()) {
                throw new \Exception();
            }

        } catch (\Exception $e) {
            throw new \InvalidArgumentException(sprintf(
                'body parameter expected a valid json. The following error' .
                'was found during json_decode: %s',
                json_last_error_msg()
            ));

        }

        if (true === array_key_exists('command', $body)) {
            $command = $this->getApplication()->find($body['command']);
            $command->run(new ArrayInput($body['options']), $output);
        }
    }
}
