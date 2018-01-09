<?php

namespace Urbem\CoreBundle\Model\Organograma;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Entity\Organograma\Organograma;

class DeParaOrgaoModel
{
    private $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Organograma\\DeParaOrgao");
    }

    public function canRemove($object)
    {
    }

    /**
     * @param Organograma $organogramaAtual
     * @param Organograma $organogramaNovo
     *
     * @return bool
     */
    public function copiarOrgaosParaNovoOrganograma(Organograma $organogramaAtual, Organograma $organogramaNovo)
    {
        // EntityManager
        $em = $this->entityManager;

        // Repositórios necessários para consultas em cascata
        $vwOrgaoNivelViewRepository = $em->getRepository('CoreBundle:Organograma\VwOrgaoNivelView');
        $orgaoRepository = $em->getRepository('CoreBundle:Organograma\Orgao');
        $deParaOrgaoRepository = $em->getRepository('CoreBundle:Organograma\DeParaOrgao');

        // Recupera todos os órgãos do organograma atual
        $orgaosAtuais = $vwOrgaoNivelViewRepository->findByCodOrganograma($organogramaAtual->getCodOrganograma());

        // Cadastra no "De Para"
        foreach ($orgaosAtuais as $orgao) {
            $currentOrgao = $orgaoRepository->findOneByCodOrgao($orgao->getCodOrgao());

            if (!$deParaOrgaoRepository->findOneBy(['codOrgao' => $currentOrgao->getCodOrgao(), 'codOrganograma' => $organogramaAtual->getCodOrganograma()])) {
                $deParaOrgao = new Entity\Organograma\DeParaOrgao();
                $deParaOrgao->setFkOrganogramaOrgao($currentOrgao);
                $deParaOrgao->setFkOrganogramaOrganograma($organogramaAtual);
                $deParaOrgao->setFkOrganogramaOrgao1(null);

                $em->persist($deParaOrgao);
                $em->flush($deParaOrgao);
            }
        }

        return true;
    }

    public function verificaMigracaoAtual()
    {
        $em = $this->entityManager;
        $organogramaAtual = $em->getRepository('CoreBundle:Organograma\Organograma')->findOneByAtivo(true);

        $deParaOrgao = $em->getRepository('CoreBundle:Organograma\DeParaOrgao')->findOneByCodOrganograma(
            $organogramaAtual->getCodOrganograma()
        );

        $organogramaNovo = null;
        if ($deParaOrgao && !empty($deParaOrgao->getCodOrgaoNew())) {
            $orgaoNew = $deParaOrgao->getFkOrganogramaOrgao1();
            $orgaoNiveis = $orgaoNew->getFkOrganogramaOrgaoNiveis();
            foreach ($orgaoNiveis as $orgaoNivel) {
                $organogramaNovo = $orgaoNivel->getFkOrganogramaNivel()->getFkOrganogramaOrganograma();
                break;
            }
        }

        return $organogramaNovo;
    }

    public function getOrganogramaByCodOrganograma($codOrganograma)
    {
        return $this->repository->getOrganogramaByCodOrganograma($codOrganograma);
    }
}
