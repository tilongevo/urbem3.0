<?php

namespace Urbem\CoreBundle\Model\Ponto;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Ponto;

class ConfiguracaoRelogioPontoModel
{
    private $entityManager = null;
    private $configuracaoRelogioPontoRepository = null;
    private $configuracaoParametrosGeraisRepository = null;
    private $configuracaoHorasExtras2Repository = null;
    private $configuracaoBancoHorasRepository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->configuracaoRelogioPontoRepository = $this->entityManager
        ->getRepository("CoreBundle:Ponto\\ConfiguracaoRelogioPonto");
        $this->configuracaoParametrosGeraisRepository = $this->entityManager
        ->getRepository("CoreBundle:Ponto\\ConfiguracaoParametrosGerais");
        $this->configuracaoHorasExtras2Repository = $this->entityManager
        ->getRepository("CoreBundle:Ponto\\ConfiguracaoHorasExtras2");
        $this->configuracaoBancoHorasRepository = $this->entityManager
        ->getRepository("CoreBundle:Ponto\\ConfiguracaoBancoHoras");
    }

    public function getConfiguracaoParametrosGeraisByCodConfiguracao($codConfiguracao)
    {
        return $this->configuracaoParametrosGeraisRepository->findOneByCodConfiguracao($codConfiguracao);
    }

    public function getConfiguracaoHorasExtras2ByCodConfiguracao($codConfiguracao)
    {
        return $this->configuracaoHorasExtras2Repository->findOneByCodConfiguracao($codConfiguracao);
    }

    public function getConfiguracaoBancoHorasByCodConfiguracao($codConfiguracao)
    {
        return $this->configuracaoBancoHorasRepository->findOneByCodConfiguracao($codConfiguracao);
    }

    public function save($ponto)
    {
        // Saving ConfiguracaoRelogioPonto
        $this->entityManager->getConnection()->beginTransaction();
        try {
            $this->entityManager->persist($ponto);
            $this->entityManager->flush();
            $this->entityManager->getConnection()->commit();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        /*
        // Saving ConfiguracaoParametrosGerais
        $this->entityManager->getConnection()->beginTransaction();
        try {
            $ponto->getConfiguracaoParametrosGerais()->setCodConfiguracao($ponto);
            $this->entityManager->persist($ponto->getConfiguracaoParametrosGerais());
            $this->entityManager->flush();
            $this->entityManager->getConnection()->commit();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        // Saving ConfiguracaoHorasExtras2
        $this->entityManager->getConnection()->beginTransaction();
        try {
            $ponto->getConfiguracaoHorasExtras2()->setCodConfiguracao($ponto);
            $this->entityManager->persist($ponto->getConfiguracaoHorasExtras2());
            $this->entityManager->flush();
            $this->entityManager->getConnection()->commit();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        // Saving ConfiguracaoBancoHoras
        $this->entityManager->getConnection()->beginTransaction();
        try {
            $ponto->getConfiguracaoBancoHoras()->setCodConfiguracao($ponto);
            $this->entityManager->persist($ponto->getConfiguracaoBancoHoras());
            $this->entityManager->flush();
            $this->entityManager->getConnection()->commit();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }*/

        return $ponto;
    }

    public function update($ponto)
    {
        // Saving ConfiguracaoRelogioPonto
        $this->entityManager->getConnection()->beginTransaction();
        try {
            $this->entityManager->persist($ponto);
            $this->entityManager->flush();
            $this->entityManager->getConnection()->commit();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        /*
        // Saving ConfiguracaoParametrosGerais
        $this->entityManager->getConnection()->beginTransaction();
        try {
            $configuracaoParametrosGeraisExists = $this->configuracaoParametrosGeraisRepository
            ->findOneByCodConfiguracao($ponto->getCodConfiguracao());
            $ponto->getConfiguracaoParametrosGerais()->setCodConfiguracao($ponto);

            // var_dump($ponto->getConfiguracaoParametrosGerais());
            // die();
            $this->entityManager->persist($ponto->getConfiguracaoParametrosGerais());
            $this->entityManager->flush();
            $this->entityManager->getConnection()->commit();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        die();

        // Saving ConfiguracaoHorasExtras2
        $this->entityManager->getConnection()->beginTransaction();
        try {
            $ponto->getConfiguracaoHorasExtras2()->setCodConfiguracao($ponto);
            $this->entityManager->persist($ponto->getConfiguracaoHorasExtras2());
            $this->entityManager->flush();
            $this->entityManager->getConnection()->commit();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        // Saving ConfiguracaoBancoHoras
        $this->entityManager->getConnection()->beginTransaction();
        try {
            $ponto->getConfiguracaoBancoHoras()->setCodConfiguracao($ponto);
            $this->entityManager->persist($ponto->getConfiguracaoBancoHoras());
            $this->entityManager->flush();
            $this->entityManager->getConnection()->commit();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }*/

        return $ponto;
    }
}
