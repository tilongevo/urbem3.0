<?php

namespace Urbem\CoreBundle\Command;

use Doctrine\Bundle\DoctrineBundle\Command\DoctrineCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class ImportDataSetupUrbemCommand extends DoctrineCommand
{
    const KEY_PARAMETER_IMPORT = "import_data_urbem";
    const ALERT_ALL_DATA = "Begin import all data to your database\r\n";
    const ALERT_ONLY_INITIAL_DATA = "Begin import only initial data to your database\r\n";
    const DEFAULT_FILE_LOCKED = "import.locked";
    const URL_DUMPDB = "https://www.dropbox.com/s/5arq40vzp6zx45m/urbem-database.sql.zip?dl=0";

    protected $envImport = '';
    protected $env = '';
    protected $dirImport;

    protected function configure()
    {
        $this
            ->setName('doctrine:fixtures:import-urbem')
            ->setDescription('Load data initial URBEM to your database.')
            ->addOption('rotas-grupos', null, InputOption::VALUE_NONE, 'Importa as rotas após importação da massa de dados')
            ->addOption('force', null, InputOption::VALUE_NONE, 'Force import all data')
            ->setHelp(<<<EOT
The <info>doctrine:fixtures:import-urbem</info> command loads all data from your bundles:

  <info>./bin/console doctrine:fixtures:import-urbem</info>

If your import is the only initial data can use the <info>--rotas-grupos</info> option:

  <info>./bin/console doctrine:fixtures:import-urbem --rotas-grupos</info>
EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $message = self::ALERT_ALL_DATA;
        if ($input->getOption('rotas-grupos')) {
//            $message = self::ALERT_ONLY_INITIAL_DATA;
            $this->executeImport($input, $checkFailure = true);

            echo $message;
            exit;
        }

        if ($input->getOption('env') && $input->getOption('env') == "homolog") {
            $this->envImport = "homolog_";
        }

        if ($input->getOption('env')) {
            $this->env = $input->getOption('env');
        }

        $this->checkIsPermission();

        if ($input->getOption('force')) {
            @unlink($this->dirImport . "/" . self::DEFAULT_FILE_LOCKED);
        }

        $this->checkIsLockedExists();
        $this->downloadDumpDB();
        $this->dropSchemas();
        $this->createDatabase($checkFailure = false);
        $this->createFunctions();
        $this->executeMigrations($checkFailure = false);

        // Agora execute a importação do banco manualmente, se necessário exxecute mais de uma vez até finalizar com sucesso
        // psql -h <host> -p <port> -d <database> -U <user> < var/import-urbem/urbem-database.sql

        // Após a conclusão da importação execute...


        echo "\r\n\r\nAGORA EXECUTE A IMPORTACAO DA MASSA DE DADOS MANUALMENTE, SE NECESSARIO EXECUTE MAIS DE UMA VEZ ATE FINALIZAR COM SUCESSO\r\n";
        echo "psql -h <host> -p <port> -d <database> -U <user> < var/import-urbem/urbem-database.sql\r\n\r\n";


        echo "\r\n\r\nAPOS A IMPORTACAO DOS DADOS SEU BANCO ESTARA COM +- 1900MB, E ENTAO EXECUTE:\r\n\r\n";
        echo "php bin/console doctrine:fixtures:import-urbem --rotas-grupos \r\n\r\n";


        echo "\r\n\r\nPOR FIM, EXECUTE AS MIGRATIONS:\r\n\r\n";
        echo "php bin/console doc:mi:mi \r\n\r\n";
        // Importa banco gigante
//        $this->executeCommandPsql(" < {$this->dirImport}/urbem-database.sql", $checkFailure = false);

        // Importa somente nossos dados
//        $this->executeImport($input, $checkFailure = true);



//        $this->dropSchemas();
//        $this->createDatabase($checkFailure = true);
//        $this->createFunctions();
//
//        echo $message;
        //Executar migrations
        //Importar SQL antigo
        //Importar dados novos... (somente alguns arquivos)
//        $this->executeImport($input, $checkFailure = true);
    }

    protected function downloadDumpDB()
    {
        $nameDumpFile = $this->dirImport . "/urbem-database";

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            throw new \Exception("Para desenvolvedores que utilizam o Windows, faça o download do arquivo:\r\n" . self::URL_DUMPDB . "\r\n\r\nDescompacte o arquivo em <project>/var/import-urbem");
        }

        if (!file_exists($nameDumpFile . ".sql")) {
            // VERIFICAR SE EH LINUX / MAC
            print "Aguarde, estamos fazendo download do DUMP do banco de dados\r\n";
            shell_exec("wget " . self::URL_DUMPDB . " --output-document=" . $nameDumpFile . ".zip");

            print "Descompactando banco de dados\r\n";
            shell_exec("unzip " . $nameDumpFile . ".zip -d " . $this->dirImport);
            unlink($nameDumpFile . ".zip");
        }
    }

    protected function checkIsPermission()
    {
        $dir = $this->currentPathProject() . "var";
        if (!is_writable(dirname($dir))) {
            throw new \Exception("Precisamos de permissão de escrita na pasta VAR do projeto, execute: chmod 777 -R var");
        }

        $this->dirImport = $dir . "/import-urbem";
        $this->createPathTemp($this->dirImport);
        return true;
    }

    protected function createPathTemp($dir)
    {
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
    }

    protected function createLock()
    {
        return file_put_contents($this->dirImport . "/" . self::DEFAULT_FILE_LOCKED, "true");
    }

    protected function checkIsLockedExists()
    {
        if(file_exists($this->dirImport . "/" . self::DEFAULT_FILE_LOCKED)) {
            throw new \Exception("Olá, a importação do URBEM já foi executada, deste ponto em diante execute: php bin/console doc:mi:mi");
        }

        return false;
    }

    protected function currentPathProject()
    {
        return $this->getContainer()->get('kernel')->getRootDir() . "/../";
    }

    protected function executeMigrations($checkFailure)
    {
        //$this->executeDoctrine("doctrine:schema:create" . (!empty($this->envImport) ? " --env=" . $this->env : ""), $checkFailure);
        // $this->executeDoctrine("doc:mi:mi --no-interaction" . (!empty($this->envImport) ? " --env=" . $this->env : ""), $checkFailure);
    }

    protected function createDatabase($checkFailure)
    {
        $this->executeDoctrine("doctrine:schema:create" . (!empty($this->envImport) ? " --env=" . $this->env : ""), $checkFailure);
//        $this->executeDoctrine("doc:mi:mi --no-interaction" . (!empty($this->envImport) ? " --env=" . $this->env : ""), $checkFailure);
    }

    protected function dropSchemas()
    {
        $file = $this->getContainer()->get('kernel')->getRootDir() . "/../scripts/drop_schemas.sql";
        $this->executeCommandPsql(" < $file");
    }

    protected function executeDoctrine($commandDoctrine, $checkFailure = false)
    {
        $command = "php {$this->currentPathProject()}bin/console {$commandDoctrine} 2>&1";
        echo $command . "\r\n";
        $res = shell_exec($command);

        print_r($res);
        $this->checkIsError($res, $commandDoctrine, $checkFailure);
    }

    protected function createFunctions()
    {
        $functions = $this->loadParameters()['functions'];
        $views = $this->loadParameters()['views'];
        $user           = $this->getContainer()->getParameter("database_{$this->envImport}user");
        $programSed     = $this->getContainer()->getParameter('program_sed');

        /**
         * @todo Nossa missão é zerar o arquivo functions_v1.sql e separar em arquivos
         */
        $file = $this->getContainer()->get('kernel')->getRootDir() . "/../scripts/functions_v1.sql";
        $sanitizeFileFunction = "{$programSed} -i \"s/postgres/{$user}/g\" " . $file;
        echo $sanitizeFileFunction . "\r\n";
        $res = shell_exec($sanitizeFileFunction);
        print_r($res);

        $this->executeCommandPsql(" < $file");

        shell_exec("git checkout -- {$file}");

        foreach($functions as $table => $file) {
            echo $file . "\r\n";
            echo "****************************************************************************\r\n";
            $file = $this->getContainer()->get('kernel')->getRootDir() . "/../scripts/functions/{$file}";

            $this->executeCommandPsql(" < $file", $checkFailure = true);
        }

        foreach($views as $table => $file) {
            echo $file . "\r\n";
            echo "****************************************************************************\r\n";
            $file = $this->getContainer()->get('kernel')->getRootDir() . "/../scripts/views/{$file}";

            $this->executeCommandPsql(" < $file", $checkFailure = true);
        }
    }

    protected function executeCommandPsql($commandPsql, $checkFailure = false)
    {
        $host           = $this->getContainer()->getParameter("database_{$this->envImport}host");
        $port           = $this->getContainer()->getParameter("database_{$this->envImport}port");
        $database       = $this->getContainer()->getParameter("database_{$this->envImport}name");
        $programPsql    = $this->getContainer()->getParameter("program_psql");
        $user           = $this->getContainer()->getParameter("database_{$this->envImport}user");
        $password       = $this->getContainer()->getParameter("database_{$this->envImport}password");

        $res = shell_exec("PGPASSWORD='".$password."' $programPsql -h $host -p $port -U $user $database {$commandPsql} 2>&1");
        print_r($res);

        $this->checkIsError($res, $commandPsql, $checkFailure);
    }

    protected function checkIsError($result, $commandPsql, $checkFailure = false)
    {
        $needle = ['FEHLER', 'ERRO', 'ERROR', 'PDOException', 'DriverException'];
        if ($checkFailure && $this->errorExists($result, $needle)) {
            throw new \Exception($this->messageErrorImport($commandPsql));
        }
    }

    protected function executeImport(InputInterface $input, $checkFailure = false)
    {
        $tables         = $this->loadTablesToImport($input);

        foreach($tables as $table => $file) {
            echo $file . "\r\n";
            echo "****************************************************************************\r\n";
            $file = $this->getContainer()->get('kernel')->getRootDir() . "/../scripts/initial/{$file}";

            $this->executeCommandPsql(" < $file", $checkFailure);
        }

        echo "\r\nSuccessfully imported data!!!\r\n";
    }

    protected function loadParameters()
    {
        return $recipient = $this->getContainer()->getParameter(self::KEY_PARAMETER_IMPORT);
    }

    protected function loadTablesToImport(InputInterface $input)
    {
        $groups = $this->loadParameters();
        unset($groups['functions']);
        unset($groups['views']);

        $allTables = [];

        foreach($groups as $group => $data) {
//            if ($group == "custom" && $input->getOption('only-initial-data')) {
//                continue;
//            }

            $allTables = array_merge($allTables, $data);
        }

        return $allTables;
    }

    protected function errorExists($haystack, $needle)
    {
        $haystack = strtolower($haystack);
        if(!is_array($needle)) { $needle = array($needle);
        }

        foreach($needle as $what) {
            $what = strtolower($what);
//            dump($haystack, $what, strpos($haystack, $what));
            if(($pos = strpos($haystack, $what))!==false) { return true;
            }
        }
        return false;
    }

    protected function messageErrorImport($commandPsql = null)
    {
        //begin of HTML message
        return <<<MESSAGE
\r\n
 ________                                                                __                                                __                                             
/        |                                                              /  |                                              /  |                                            
$$$$$$$$/   ______    ______    ______         _______    ______        $$/  _____  ____    ______    ______    ______   _$$ |_     ______    _______   ______    ______  
$$ |__     /      \  /      \  /      \       /       \  /      \       /  |/     \/    \  /      \  /      \  /      \ / $$   |   /      \  /       | /      \  /      \ 
$$    |   /$$$$$$  |/$$$$$$  |/$$$$$$  |      $$$$$$$  | $$$$$$  |      $$ |$$$$$$ $$$$  |/$$$$$$  |/$$$$$$  |/$$$$$$  |$$$$$$/    $$$$$$  |/$$$$$$$/  $$$$$$  |/$$$$$$  |
$$$$$/    $$ |  $$/ $$ |  $$/ $$ |  $$ |      $$ |  $$ | /    $$ |      $$ |$$ | $$ | $$ |$$ |  $$ |$$ |  $$ |$$ |  $$/   $$ | __  /    $$ |$$ |       /    $$ |$$ |  $$ |
$$ |_____ $$ |      $$ |      $$ \__$$ |      $$ |  $$ |/$$$$$$$ |      $$ |$$ | $$ | $$ |$$ |__$$ |$$ \__$$ |$$ |        $$ |/  |/$$$$$$$ |$$ \_____ /$$$$$$$ |$$ \__$$ |
$$       |$$ |      $$ |      $$    $$/       $$ |  $$ |$$    $$ |      $$ |$$ | $$ | $$ |$$    $$/ $$    $$/ $$ |        $$  $$/ $$    $$ |$$       |$$    $$ |$$    $$/ 
$$$$$$$$/ $$/       $$/        $$$$$$/        $$/   $$/  $$$$$$$/       $$/ $$/  $$/  $$/ $$$$$$$/   $$$$$$/  $$/          $$$$/   $$$$$$$/  $$$$$$$/  $$$$$$$/  $$$$$$/  
                                                                                          $$ |                                                                            
                                                                                          $$ |                                                                            
                                                                                          $$/                                                                             
 
\r\n
$commandPsql
\r\n
MESSAGE;
    }
}
