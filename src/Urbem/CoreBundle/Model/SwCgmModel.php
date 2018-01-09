<?php

namespace Urbem\CoreBundle\Model;

use Doctrine\ORM;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacao;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\SwCgmPessoaFisica;
use Urbem\CoreBundle\Entity\SwCgmPessoaJuridica;
use Urbem\CoreBundle\Model\InterfaceModel;
use Urbem\CoreBundle\AbstractModel as Model;
use Urbem\CoreBundle\Model\Administracao\SwCgmLogradouroModel;
use Urbem\CoreBundle\Repository\SwCgmRepository;

class SwCgmModel extends Model implements InterfaceModel
{
    /** @var ORM\EntityManager $entityManager */
    protected $entityManager = null;

    /** @var ORM\EntityRepository|SwCgmRepository $repository */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(SwCgm::class);
    }

    /**
     * @param SwCgm $swCgm
     *
     * @return bool
     */
    public function canRemove($swCgm)
    {
        return $this->canRemoveWithAssociation($swCgm);
    }

    public function getDisponiveis($id)
    {
        return $this->repository->getDisponiveis($id);
    }

    public function consultaDadosCgmPessoaFisica($id)
    {
        return $this->repository->consultaDadosCgmPessoaFisica($id);
    }

    public function findOneByCgmJoinedToCgmPessoaFisica($id)
    {
        return $this->repository->consultaDadosCgmPessoaFisica($id);
    }

    public function getCgm(SwCgm $cgm)
    {
        $cgms = $this->entityManager
            ->getRepository("CoreBundle:SwCgm")
            ->findBy(array('numcgm' => $cgm));

        return $cgms;
    }

    /**
     * @param $paramsWhere
     * @return array
     */
    public function getSwCgmsJson($paramsWhere)
    {
        return $this->repository->getSwCgmsJson($paramsWhere);
    }

    /**
     * @param $paramsWhere
     * @return array
     */
    public function getSwCgmsPessoaJuridicaJson($paramsWhere)
    {
        return $this->repository->getSwCgmsPessoaJuridicaJson($paramsWhere);
    }

    /**
     * @param $q
     * @return ORM\QueryBuilder
     */
    public function carregaParticipanteCertificacaoQuery($q)
    {
        $subquery = $this->repository->createQueryBuilder('cgm');
        $subquery
            ->select('participanteCertificacao.cgmFornecedor')
            ->from(ParticipanteCertificacao::class, 'participanteCertificacao');

        $queryBuilder = $this->recuperaApenasPessoasFisicasEJuridicas();
        $queryBuilder
            ->andWhere(
                $queryBuilder->expr()->in("{$queryBuilder->getRootAlias()}.numcgm", $subquery->getDQL())
            );

        if (is_numeric($q)) {
            $queryBuilder->andWhere("{$queryBuilder->getRootAlias()}.numcgm = {$q}");
        } else {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->like(
                    $queryBuilder->expr()->lower(
                        "{$queryBuilder->getRootAlias()}.nomCgm"
                    ),
                    $queryBuilder->expr()->literal(
                        sprintf('%%%s%%', $q)
                    )
                )
            );
        }

        return $queryBuilder;
    }

    /**
     * @param string|int $search - Parâmetro de pequisa, pode ser (int) cgm.numcgm  ou (string) cgm.nomFantasia
     * @return ORM\QueryBuilder
     */
    public function carregaSwCgmPessoaJuridicaQuery($search)
    {
        $queryBuilder = $this->repository->createQueryBuilder('cgm');
        $queryBuilder
            ->join('cgm.fkSwCgmPessoaJuridica', 'swCgmPessoaJuridica')
            ->where("{$queryBuilder->getRootAlias()}.numcgm <> 0");

        if (is_numeric($search)) {
            $queryBuilder->andWhere("{$queryBuilder->getRootAlias()}.numcgm = {$search}");
        } else {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->like(
                    $queryBuilder->expr()->lower(
                        "{$queryBuilder->getRootAlias()}.nomCgm"
                    ),
                    $queryBuilder->expr()->literal(
                        '%'. trim($search) .'%'
                    )
                )
            );
        }

        return $queryBuilder;
    }

    /**
     * @param string|int $search - Parâmetro de pequisa, pode ser (int) cgm.numcgm  ou (string) cgm.nomCgm
     * @return ORM\QueryBuilder
     */
    public function carregaSwCgmQuery($search)
    {
        $queryBuilder = $this->repository->createQueryBuilder('cgm');
        $queryBuilder
            ->where("{$queryBuilder->getRootAlias()}.numcgm <> 0");

        if (is_numeric($search)) {
            $queryBuilder->andWhere("{$queryBuilder->getRootAlias()}.numcgm = {$search}");
        } else {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->like(
                    $queryBuilder->expr()->lower(
                        "{$queryBuilder->getRootAlias()}.nomCgm"
                    ),
                    $queryBuilder->expr()->literal(
                        sprintf('%%%s%%', $search)
                    )
                )
            );
        }

        return $queryBuilder;
    }

    public function recuperaRelacionamentoVinculado($stTabelaVinculo, $stCampoVinculo, $filtroVinculo, $stcondicao)
    {
        return $this->repository->recuperaRelacionamentoVinculado($stTabelaVinculo, $stCampoVinculo, $filtroVinculo, $stcondicao);
    }

    public function getCgmImprensa()
    {
        return $this->repository->getCgmImprensa();
    }

    public function findOneByNumcgm($numcgm)
    {
        return $this->repository->findOneByNumcgm($numcgm);
    }

    public function recuperaExcetoFornecedores(ProxyQuery $query = null)
    {
        $subQuery = $this->entityManager->createQueryBuilder();
        $subQuery
            ->select('Fornecedor')
            ->from('CoreBundle:Compras\Fornecedor', 'Fornecedor');

        if (is_null($query)) {
            $query = $this->entityManager->createQueryBuilder();
            $query
                ->select('SwCgm')
                ->from('CoreBundle:SwCgm', 'SwCgm')
            ;
        }

        $query
            ->leftJoin('CoreBundle:SwCgmPessoaFisica', 'PF', 'WITH', "{$query->getRootAliases()[0]}.numcgm = PF.numcgm")
            ->leftJoin('CoreBundle:SwCgmPessoaJuridica', 'PJ', 'WITH', "{$query->getRootAliases()[0]}.numcgm = PJ.numcgm")
            ->where("{$query->getRootAliases()[0]}.numcgm <> 0")
            ->andWhere($query->expr()->notIn("{$query->getRootAliases()[0]}.numcgm", $subQuery->getDQL()))
        ;

        return $query;
    }

    public function recuperaApenasPessoasFisicasEJuridicas(ProxyQuery $query = null)
    {
        if (is_null($query)) {
            $query = $this->repository->createQueryBuilder('swCgm');
        }

        $query
            ->leftJoin(SwCgmPessoaFisica::class, 'swCgmPessoaFisica', 'WITH', "{$query->getRootAlias()}.numcgm = swCgmPessoaFisica.numcgm")
            ->leftJoin(SwCgmPessoaJuridica::class, 'swCgmPessoaJuridica', 'WITH', "{$query->getRootAlias()}.numcgm = swCgmPessoaJuridica.numcgm")
            ->where("{$query->getRootAlias()}.numcgm <> 0")
        ;

        return $query;
    }

    public function getEntidadesConfiguracaoEmpenhoList($codModulo, $exercicio)
    {
        return $this->repository->getEntidadesConfiguracaoEmpenhoList($codModulo, $exercicio);
    }

    /**
     * @param array $columns
     * @param string $q
     * @return ORM\QueryBuilder
     */
    public function findLikeQuery(array $columns, $q)
    {
        $queryBuilder = $this->repository->createQueryBuilder('cgm');

        foreach ($columns as $key => $column) {
            $whereClause = $key == 0 ? "andWhere" : "orWhere" ;
            $queryBuilder->{$whereClause}("LOWER(cgm.{$column}) LIKE LOWER(:q)");
        }

        $queryBuilder->setParameter("q", "%{$q}%");

        return $queryBuilder;
    }

    /**
     * @param array $columns
     * @param string $q
     * @return array
     */
    public function findLike(array $columns, $q)
    {
        return $this->findLikeQuery($columns, $q)->getQuery()->getResult();
    }

    /**
     * @param SwCgm $swCgm
     * @param bool  $flush
     */
    public function remove($swCgm, $flush = true)
    {
        $swCgmAtributoValorModel = new SwCgmAtributoValorModel($this->entityManager);
        $swCgmLogradouroModel = new SwCgmLogradouroModel($this->entityManager);

        $swCgmAtributoValorModel->remove($swCgm, false);
        $swCgmLogradouroModel->remove($swCgm, false);

        parent::remove($swCgm, $flush);
    }

    /**
     * @param $term
     * @return ORM\QueryBuilder
     */
    public function getCgmPessoaFisicaByNumcgmAndNomCgm($term)
    {
        return $this->repository->getCgmPessoaFisicaByNumcgmAndNomCgm($term);
    }

    /**
     * @param SwCgm $swCgm
     */
    public function setNumcgm(SwCgm $swCgm)
    {
        $swCgm->setNumcgm($this->repository->nextNumCgm());
    }
}
