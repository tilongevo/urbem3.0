<?php

namespace Urbem\PrestacaoContasBundle\Service;

use DateTime;
use DateInterval;
use DirectoryIterator;
use SimpleXMLElement;

use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;

use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Entity\TransparenciaExportacao;
use Urbem\CoreBundle\Helper\StringHelper;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\TransparenciaExportacaoModel;

use Urbem\PrestacaoContasBundle\Service\Report\AbstractReport;
use ZipArchive;

/**
 * Class ExportTransparencia
 *
 * @package Urbem\PrestacaoContasBundle\Service\Report
 */
class ExportTransparencia
{
    const FILE_EXTENSION = '.zip';

    /** @var Filesystem */
    private $filesystem;

    /** @var ContainerInterface */
    private $container;

    /** @var SimpleXMLElement */
    private $xmlFile;

    private $fileFolderPath;

    private $fileName;

    /** @var DateTime */
    protected $dataInicial;

    /** @var DateTime */
    protected $dataFinal;

    /** @var DateTime */
    private $today;

    /** @var string|integer */
    protected $exercicio;

    /** @var TransparenciaExportacaoModel */
    protected $transparenciaExportacaoModel;

    /** @var TransparenciaExportacao */
    protected $transparenciaExportacao;

    /** @var ConsoleOutput */
    protected $outputConsole;

    /**
     * ReportGenerator constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->filesystem = $container->get('filesystem');

        $prestacaoContasBundleFolder = $container->getParameter('prestacaocontasbundle');
        $this->fileFolderPath = $prestacaoContasBundleFolder['report'];

        $this->container = $container;

        $this->initialize();
    }

    /**
     * @return mixed
     */
    public function getFileFolderPath()
    {
        return $this->fileFolderPath;
    }

    /**
     * Inicializaçao do serviço.
     */
    protected function initialize()
    {
        $this->today = new DateTime();

        $this->dataFinal = new DateTime();
        $this->dataFinal->sub(new DateInterval('P1D'));

        $this->exercicio = (int) $this->dataFinal->format('Y');

        $this->dataInicial = new DateTime();
        $this->dataInicial->setDate($this->exercicio, 1, 1);

        $this->fileName = $this->today->format('YmdHis');

        $this->transparenciaExportacaoModel =
            new TransparenciaExportacaoModel($this->container->get('doctrine.orm.entity_manager'));

        $this->transparenciaExportacao = $this->transparenciaExportacaoModel
            ->getTransparenciaExportacaoByDate($this->today);

        try {
            if (is_null($this->transparenciaExportacao)) {
                $this->transparenciaExportacao = $this->transparenciaExportacaoModel
                    ->buildOne($this->today, $this->getFileName(), TransparenciaExportacao::STATUS_GERANDO);
            }

            $this->checkDependencies();
        } catch (\Exception $exception) {
            $this->transparenciaExportacaoModel
                ->setStatus($this->transparenciaExportacao, $exception->getCode(), $exception->getMessage());

            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * @return string
     */
    protected function getUsername()
    {
        $token = $this->container->get('security.token_storage')->getToken();
        if (!is_null($token)) {
            /** @var Usuario $usuario */
            $usuario = $token->getUser();

            return $usuario->getUsername();
        }

        return 'terminal';
    }

    /**
     * @return array|int|string
     */
    protected function getHash()
    {
        $entityManager = $this->container->get('doctrine.orm.entity_manager');

        return (new ConfiguracaoModel($entityManager))
            ->getConfiguracao('hash_identificador', Modulo::MODULO_TRANSPARENCIA, true, $this->exercicio);
    }

    /**
     * @return string
     */
    protected function getTransparenciaUploadFolder()
    {
        return $this->getTransparenciaFolder() . DIRECTORY_SEPARATOR . 'uploads/remessas/';
    }

    /**
     * @return string
     */
    protected function getTransparenciaFolder()
    {
        $portalTransparenciaRootpath = $this->container->getParameter('portal_transparencia_rootpath');

        return $portalTransparenciaRootpath;
    }

    /**
     * Retorna o caminho do arquivo.
     *
     * @return string
     */
    protected function getFilePath()
    {
        return $this->fileFolderPath . DIRECTORY_SEPARATOR . $this->transparenciaExportacao->getArquivo();
    }

    /**
     * @return string
     */
    protected function getTransparenciaScript()
    {
        $transparenciaFolder = $this->getTransparenciaFolder();

        return sprintf('%s/scripts/importacao.php', $transparenciaFolder);
    }

    /**
     * Verifica se o arquivo existe.
     *
     * @return bool
     */
    protected function isFileExists()
    {
        $arquivo = $this->getFilePath();

        return $this->filesystem->exists($arquivo);
    }

    /**
     * @return bool
     */
    protected function isTransparenciaFolderExists()
    {
        return $this->filesystem->exists($this->getTransparenciaUploadFolder());
    }

    /**
     * @return bool
     */
    public function isAlreadyDoneToday()
    {
        if (false == is_null($this->transparenciaExportacao)
            && true == $this->isFileExists()) {
            return true;
        }

        return false;
    }

    /**
     * @throws \Exception
     */
    protected function checkDependencies()
    {
        $throwMessage = '';
        if (!$this->isTransparenciaFolderExists()) {
            $throwMessage = sprintf('Diretório %s não existe!', $this->getTransparenciaUploadFolder());
            $this->transparenciaExportacaoModel
                ->setStatus($this->transparenciaExportacao, TransparenciaExportacao::STATUS_FALHA_GERADO, $throwMessage);

            throw new \Exception($throwMessage);
        }

        if (!$this->filesystem->exists($this->getTransparenciaScript())) {
            $throwMessage = sprintf('Script de importação do relatório, nao existe! %s', $this->getTransparenciaScript());
            $this->transparenciaExportacaoModel
                ->setStatus($this->transparenciaExportacao, TransparenciaExportacao::STATUS_FALHA_GERADO, $throwMessage);

            throw new \Exception($throwMessage, TransparenciaExportacao::STATUS_FALHA_GERADO);
        }
    }

    /**
     * @param $message
     */
    protected function showMessage($message)
    {
        if ($this->outputConsole instanceof ConsoleOutput) {
            $this->outputConsole->write($message . PHP_EOL);
        }
    }

    /**
     * Executa a copia do arquivo para o portal da transparencia.
     * @throws \Exception
     */
    public function execute(OutputInterface $output = null)
    {
        $this->outputConsole = $output;

        if ($this->isAlreadyDoneToday()) {
            return;
        }

        try {
            $this->generate();
            $this->copy();

            $this->transparenciaExportacaoModel
                ->setStatus($this->transparenciaExportacao, TransparenciaExportacao::STATUS_IMPORTADO, null);
        } catch (\Exception $exception) {
            $this->transparenciaExportacaoModel
                ->setStatus($this->transparenciaExportacao, TransparenciaExportacao::STATUS_FALHA_GERADO, $exception->getMessage());

            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * Copia o arquivo gerado para o portal da transparencia.
     * @throws \Exception
     * @deprecated
     */
    public function copy()
    {
        try {
            $fileTo = $this->getTransparenciaUploadFolder() . $this->getFileName();

            $this->showMessage(sprintf("Disponibilizando aquivo em '%s'", $fileTo));
            $this->filesystem->copy($this->getFilePath(), $fileTo);
        } catch (\Exception $exception) {
            $this->transparenciaExportacaoModel
                ->setStatus($this->transparenciaExportacao, TransparenciaExportacao::STATUS_FALHA_GERADO, $exception->getMessage());

            throw new \Exception($exception->getMessage());
        }

        $this->transparenciaExportacaoModel
            ->setStatus($this->transparenciaExportacao, TransparenciaExportacao::STATUS_TRANSFERIDO, null);
    }

    /**
     * @return bool
     * @throws \Exception
     * @deprecated
     */
    protected function executeScriptOnPortalTransparencia()
    {
        $scriptImport = $this->getTransparenciaScript();
        $this->showMessage(sprintf("Executando importação: '%s'", $scriptImport));
        $resultShell = shell_exec(sprintf("php %s", $scriptImport));

        if (true != (bool) $resultShell) {
            $throwMessage = sprintf('Ocorreu um erro durante a importaçao de Informaçoes no Portal da Transparencia: %s', $resultShell);
            $this->transparenciaExportacaoModel
                ->setStatus($this->transparenciaExportacao, TransparenciaExportacao::STATUS_FALHA_GERADO, $throwMessage);

            throw new \Exception($throwMessage);
        }

        return true;
    }

    /**
     * @return void
     */
    protected function generateConfigFile()
    {
        $this->xmlFile = new SimpleXMLElement('<config/>');
        $this->xmlFile->addChild('timestamp_geracao', $this->today->format('Y-m-d H:i:s'));
        $this->xmlFile->addChild('data_limite_dado', $this->dataFinal->format('Y-m-d'));
        $this->xmlFile->addChild('usuario', $this->getUsername());
        $this->xmlFile->addChild('exercicio', $this->exercicio);
        $this->xmlFile->addChild('hash', $this->getHash());
    }

    /**
     * Gera um arquivo .zip com os relatorios no formato .TXT
     *
     * @return string
     * @throws \Exception
     */
    public function generate()
    {
        $this->transparenciaExportacaoModel
            ->updateOne($this->transparenciaExportacao, $this->getFileName(), TransparenciaExportacao::STATUS_GERANDO);

        try {
            if (!$this->filesystem->exists($this->fileFolderPath)) {
                $this->filesystem->mkdir($this->fileFolderPath, 0777);
            }

            $zipArchive = new ZipArchive();
            $zipArchive->open($this->getFilePath(), ZipArchive::CREATE);

            $this->generateConfigFile();
            $xmlTagArquivos = $this->xmlFile->addChild('arquivos');

            $reports = $this->container->getParameter('transparencia');
            $totalArquivos = count($reports);

            $this->showMessage(sprintf("%s arquivos necessarios para o pacote Transparência", $totalArquivos));
            $item = 1;
            foreach ($reports as $reportItem) {
                $transparenciaReportName = 'transparencia.' . StringHelper::convertToSnakeCase($reportItem) . '_report';
                $transparenciaReportFileName = strtoupper($reportItem) . '.TXT';

                $this->showMessage(sprintf("Arquivo %s de %s - %s", $item, $totalArquivos, $transparenciaReportFileName));

                $fileContent = "";
                if ($this->container->has($transparenciaReportName)) {
                    /** @var AbstractReport $transparenciaReport */
                    $transparenciaReport = $this->container->get($transparenciaReportName);
                    $fileContent = implode("\r\n", $transparenciaReport->generateAsString('', $this->dataInicial, $this->dataFinal, $this->exercicio));
                }

                $zipArchive->addFromString($transparenciaReportFileName, $fileContent);
                $xmlTagArquivos->addChild('arquivo', $transparenciaReportFileName);
                $item++;
            }

            $zipArchive->addFromString('config.xml', $this->xmlFile->asXML());
            $zipArchive->close();

            $this->removeOldFiles();
        } catch (\Exception $exception) {
            $this->transparenciaExportacaoModel
                ->setStatus($this->transparenciaExportacao, TransparenciaExportacao::STATUS_FALHA_GERADO, $exception->getMessage());

            throw new \Exception($exception->getMessage());
        }

        $this->transparenciaExportacaoModel
            ->setStatus($this->transparenciaExportacao, TransparenciaExportacao::STATUS_GERADO);
    }

    /**
     * Remove os arquivos anteriores.
     */
    public function removeOldFiles($all = false)
    {
        $directoryIterator = new DirectoryIterator($this->fileFolderPath);

        $files = [];
        foreach ($directoryIterator as $directory) {
            /** Verifica se é um arquivo e não um diretorio. */
            if ($directory->isFile()) {
                /** Adiciona em um novo array, usando a data de criação como chave desse array. */
                $files[$directory->getMTime()] = $directory->getFilename();
            }
        }

        if ($all == false) {
            /** Reorderna o array de forma ascendente (Arquivos mais recentes primeiros). */
            krsort($files);

            /** @var array $files Remove o primeiro item do array (Arquivos mais recentes). */
            $files = array_slice($files, 1);
        }

        /** @var DirectoryIterator $file */
        foreach ($files as $file) {
            /** Remove os arquivos restantes. */
            $this->filesystem->remove($this->fileFolderPath . DIRECTORY_SEPARATOR . $file);
        }
    }

    /**
     * @return mixed
     */
    public function getFileName()
    {
        if (!is_null($this->transparenciaExportacao)) {
            return $this->transparenciaExportacao->getArquivo();
        }

        return $this->fileName . self::FILE_EXTENSION;
    }

    /**
     * @param mixed $fileName
     *
     * @return $this
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDataInicial()
    {
        return $this->dataInicial;
    }

    /**
     * @param DateTime $dataInicial
     *
     * @return $this
     */
    public function setDataInicial($dataInicial)
    {
        $this->dataInicial = $dataInicial;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDataFinal()
    {
        return $this->dataFinal;
    }

    /**
     * @param DateTime $dataFinal
     *
     * @return $this
     */
    public function setDataFinal($dataFinal)
    {
        $this->dataFinal = $dataFinal;

        return $this;
    }

    /**
     * @return int|string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * @param int|string $exercicio
     *
     * @return $this
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;

        return $this;
    }
}
