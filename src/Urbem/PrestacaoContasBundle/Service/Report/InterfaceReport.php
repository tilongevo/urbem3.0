<?php

namespace Urbem\PrestacaoContasBundle\Service\Report;

use DateTime;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Interface Report
 *
 * @package Urbem\PrestacaoContasBundle\Service\Report
 */
interface InterfaceReport
{
    public function __construct(EntityManager $entityManager, Filesystem $filesystem);

    public function generate(DateTime $dataInicial, DateTime $dataFinal, $exercicio);

    public function generateAsString($glue, DateTime $dataInicial, DateTime $dataFinal, $exercicio);
}
