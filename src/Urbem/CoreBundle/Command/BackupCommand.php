<?php

namespace Urbem\CoreBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Urbem\CoreBundle\Helper\StringHelper;
use Urbem\CoreBundle\Model\ServerModel;

/**
 * Class BackupCommand
 * @package Urbem\CoreBundle\Command
 */
class BackupCommand extends ContainerAwareCommand
{
    /**
     * Configure
     */
    protected function configure()
    {
        parent::configure();
        $this
            ->setName('server:urbem:backup')
            ->setDescription('Backup all data Urbem')
            ->setHelp('');
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @return mixed
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $env = $this->getContainer()->hasParameter("env") ? $this->getContainer()->getParameter("env") : $container->get('kernel')->getEnvironment();
        $backupServerEnabled = $this->getContainer()->hasParameter("server_backup_enabled") ? $this->getContainer()->getParameter("server_backup_enabled") : false;
        $storage = $container->get('urbem_storage');
        $storage->setBucket("urbem-{$env}");

        // Dados da prefeitura
        $info = $container->get('prefeitura.info');

        if (!$info->hasBackupExecution() || !$backupServerEnabled) {
            $output->writeln("Backup não configurado");
            return;
        }

        $uf = $info->getUf();
        $municipio = str_replace(" ", "-", $info->getMunicipio());
        $cnpj = preg_replace('/\D/', '', $info->getCnpj());

        $this->executeBackup($uf, $municipio, $cnpj, $storage, $output);
    }

    /**
     * @param $uf
     * @param $municipio
     * @param $cnpj
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    private function executeBackup($uf, $municipio, $cnpj, $storage, OutputInterface $output)
    {
        $serverModel = new ServerModel($this->getContainer());
        $instanceId = $serverModel->executeEc2("--instance-id");

        // Filename
        $fileName = sprintf("%s.zip", StringHelper::removeExcessSpace(
            StringHelper::removeSpecialCharacter(
                strtolower(
                    sprintf("%s-%s-%s-%s", $uf, $municipio, $instanceId, $cnpj)
                )
            )
        ));

        // Zip
        $toCompactedFile = __DIR__ . "/../../../../var/{$fileName}";
        if ($this->processStorageFiles($toCompactedFile) && $storage->uploadFile($toCompactedFile, "proj-{$cnpj}/{$fileName}")) {
            $output->writeln("Backup realizado com sucesso -> proj-{$cnpj}/{$fileName}");
        }
    }

    /**
     * @param $zipFileName
     * @return bool
     */
    private function processStorageFiles($zipFileName)
    {
        // Get real path for our folder
        $rootPath = realpath($this->getContainer()->getParameter("file_storage") . "/../");

        // Initialize archive object
        $zip = new \ZipArchive();
        $zip->open($zipFileName, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        // Create recursive directory iterator
        /** @var SplFileInfo[] $files */
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($rootPath),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $name => $file) {
            // Skip directories (they would be added automatically)
            if (!$file->isDir()) {
                // Get real and relative path for current file
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($rootPath) + 1);

                // Add current file to archive
                $zip->addFile($filePath, $relativePath);
            }
        }

        // Zip archive will be created only after closing object
        $zip->close();

        return true;
    }
}
