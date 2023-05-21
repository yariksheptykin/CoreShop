<?php

declare(strict_types=1);

/*
 * CoreShop
 *
 * This source file is available under two different licenses:
 *  - GNU General Public License version 3 (GPLv3)
 *  - CoreShop Commercial License (CCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @copyright  Copyright (c) CoreShop GmbH (https://www.coreshop.org)
 * @license    https://www.coreshop.org/license     GPLv3 and CCL
 *
 */

namespace CoreShop\Bundle\ClassDefinitionPatchBundle\Command;

use CoreShop\Bundle\ClassDefinitionPatchBundle\Console\ConsoleDiffer;
use CoreShop\Bundle\ClassDefinitionPatchBundle\PatcherInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class PatchCommand extends Command
{
    public function __construct(
        private PatcherInterface $patcher,
        private ConsoleDiffer $consoleDiffer,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('coreshop:patch:classes')
            ->setDescription('Execute Class Patches.')
            ->addOption('force', 'f', null, 'Force execution of all patches.')
            ->addOption('dump', 'd', null, 'Dump the diff of all patches.')
            ->setHelp(
                <<<EOT
The <info>%command.name%</info> executes all Class Patches.
EOT
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if ($input->getOption('dump')) {
            foreach ($this->patcher->getPatches() as $patch) {
                $output->writeln('<info>===================================</info>');
                $output->writeln(sprintf('Diff for Class <comment>%s</comment>', $patch->getClassName()));
                $output->writeln('<info>===================================</info>');
                $output->writeln('');
                $output->writeln(
                    $this->consoleDiffer->diff(
                        print_r($this->patcher->old($patch), true),
                        print_r($this->patcher->new($patch), true),
                    ),
                );
            }
        }

        if ($input->getOption('force')) {
            $this->patcher->patch();
        }

        return 0;
    }
}
