<?php

namespace Urbem\CoreBundle\Model\Organograma;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Organograma\Orgao;
use Urbem\CoreBundle\Repository\Organograma\OrgaoRepository;

class OrgaoModel extends AbstractModel
{
    const VALOR_INICIAL = 1;

    /** @var OrgaoRepository $repository */
    protected $repository;

    /**
     * OrgaoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Orgao::class);
    }

    /**
     * @TODO Precisa de refactor, pois está removendo os usuários também =/
     * @param $object
     * @return bool
     */
    public function canRemove($object)
    {
        $info = $this->repository->getFilhoByCodOrgaoCanRemove($object->getCodOrgao());

        $remove = false;
        if (!$info) {
            $remove = true;
        }
        return false;
    }

    public function getProximoValorByCodOrgao($codOrganograma, $codOrgao, $codNivel)
    {
        return $this->repository->getProximoValorByCodOrgao($codOrganograma, $codOrgao, $codNivel);
    }

    public function getInfoByCodOrgao($codOrgao)
    {
        return $this->repository->getInfoByCodOrgao($codOrgao);
    }

    public function getFilhoByCodOrgao($codOrgao)
    {
        return $this->repository->getFilhoByCodOrgao($codOrgao);
    }

    public function getOrgaosByCodNivel($codOrganograma, $codNivel, $codOrgao = null)
    {
        return $this->repository->getOrgaosByCodNivel($codOrganograma, $codNivel, $codOrgao);
    }

    public function getOrgaoSuperiorByCodNivel($codOrganograma, $codNivel)
    {
        return $this->repository->getOrgaoSuperiorByCodNivel($codOrganograma, $codNivel);
    }

    public function getOneOrgaoByCodOrgao($codOrgao)
    {
        return $this->repository->findOneByCodOrgao($codOrgao);
    }

    public function getCgmPessoaJuridica($parameter)
    {
        $em = $this->entityManager;

        $repository = $em->getRepository('CoreBundle:SwCgmPessoaJuridica');
        $qb = $repository->createQueryBuilder('cgmpj');
        $qb->join('CoreBundle:SwCgm', 'cgm', 'WITH', 'cgmpj.numcgm = cgm.numcgm');
        $qb->Where('LOWER(cgm.nomCgm) LIKE :nomCgm');
        $qb->setParameter('nomCgm', sprintf('%%%s%%', strtolower($parameter)));
        $qb = $qb->getQuery();
        $rlt = $qb->getResult();
        return $rlt;
    }

    public function getProximoCodOrgao()
    {
        $repository = $this->repository;
        $orgao = $repository->findOneBy([], ['codOrgao' => 'DESC']);
        $codOrgao = self::VALOR_INICIAL;
        if ($orgao) {
            $codOrgao = $orgao->getCodOrgao() + 1;
        }
        return $codOrgao;
    }

    /**
     * @param Orgao $orgao
     * @return string
     */
    public function getOrgaoReduzido(Orgao $orgao)
    {
        $params = [
            "cod_orgao = {$orgao->getCodOrgao()}"
        ];
        $vw_orgao = $this->repository->findOneOrgao($params);
        return $vw_orgao->orgao_reduzido;
    }

    /**
     * @param $vigencia
     * @param $codOrganograma
     * @return array
     */
    public function montaRecuperaOrgaos($vigencia, $codOrganograma)
    {
        return $this->repository->montaRecuperaOrgaos($vigencia, $codOrganograma);
    }
}
