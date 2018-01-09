<?php

namespace Urbem\CoreBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Urbem\CoreBundle\Entity\Administracao\Modulo;

class CreateConfigurationFromPreviousExerciseCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('create:configuration:previous-exercise')
            ->setDescription('Recupera diferenca de registros de configuracoes do exercicio anterior')
            ->setHelp('');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $exercicioAtual = date("Y");
        $exercicioAanterior = $exercicioAtual - 1;

        $this->executeSQL("insert into administracao.configuracao (exercicio, cod_modulo, parametro, valor)
	              (select '{$exercicioAtual}' exercicio, cod_modulo, parametro, valor from administracao.configuracao where exercicio = '{$exercicioAanterior}' and 
	                  parametro not in (select parametro from administracao.configuracao where exercicio = '$exercicioAtual'));
        ");

        $this->executeSQL($this->getStringParametersIfExists($exercicioAtual, Modulo::MODULO_ADMINISTRATIVO, 'site', ''));
        $this->executeSQL($this->getStringParametersIfExists($exercicioAtual, Modulo::MODULO_ADMINISTRATIVO, 'CGMPrefeito', ''));
    }

    private function executeSQL($stringSQL) {
        $container = $this->getApplication()->getKernel()->getContainer();
        $conn = $container->get('doctrine.orm.entity_manager')->getConnection();
        $sth = $conn->prepare($stringSQL);
        $sth->execute();
    }

    private function getStringParametersIfExists($exercicio, $codModulo, $parametro, $valor) {
        return "insert into administracao.configuracao (exercicio, cod_modulo, parametro, valor)
                  select '{$exercicio}', {$codModulo}, '{$parametro}', '{$valor}'
                    WHERE NOT EXISTS (SELECT exercicio, cod_modulo, parametro, valor from administracao.configuracao WHERE 
                        exercicio='{$exercicio}' and cod_modulo ={$codModulo} and parametro = '{$parametro}')";
    }
}