<?php

namespace Urbem\CoreBundle\Model\Organograma;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Entity\Organograma\Organograma;
use Urbem\CoreBundle\Entity\Organograma\OrgaoNivel;
use Urbem\CoreBundle\Model\InterfaceModel;
use Urbem\CoreBundle\Repository\Organograma\OrganogramaRepository;

/**
 * Class OrganogramaModel
 *
 * @package Urbem\CoreBundle\Model\Organograma
 */
class OrganogramaModel extends AbstractModel implements InterfaceModel
{
    /** @var ORM\EntityManager */
    protected $entityManager = null;

    /** @var OrganogramaRepository */
    protected $repository = null;

    const VALOR_INICIAL = 1;

    public function __construct(ORM\EntityManager $entityManager)
    {
        /** @var ORM\EntityManager entityManager */
        $this->entityManager = $entityManager;
        /** @var OrganogramaRepository repository */
        $this->repository = $this->entityManager->getRepository("CoreBundle:Organograma\\Organograma");
    }

    /**
     * @param Organograma $organograma
     *
     * @return bool
     */
    public function canRemove($organograma)
    {
        if ($organograma->getAtivo()) {
            return false;
        }

        $orgaoNiveis = $this->entityManager->getRepository(OrgaoNivel::class)
            ->findBy([
                'codOrganograma' => $organograma->getCodOrganograma()
            ]);

        if (count($orgaoNiveis) > 0) {
            return false;
        }

        return true;
    }

    public function getOrganogramaVigentePorTimestamp()
    {
        $query = $this->entityManager->getConnection()->prepare(
            "SELECT pessoalOrganogramaVigentePorTimestamp('',now()::varchar) AS cod_organograma,
                (coalesce( (SELECT max(cod_periodo_movimentacao) FROM folhapagamento.periodo_movimentacao_situacao
                WHERE timestamp <= now()), 0)) AS cod_periodo_movimentacao, (coalesce((    SELECT periodo_movimentacao.dt_final::varchar
              FROM folhapagamento.periodo_movimentacao
              INNER JOIN folhapagamento.periodo_movimentacao_situacao
                ON periodo_movimentacao.cod_periodo_movimentacao = periodo_movimentacao_situacao.cod_periodo_movimentacao
              WHERE periodo_movimentacao_situacao.timestamp <= now()
              ORDER BY periodo_movimentacao.cod_periodo_movimentacao desc LIMIT 0) ,'1900-01-01'::varchar)) AS dt_final"
        );

        $query->execute();
        return $query->fetch();
    }

    public function getOrganograma($codOrganograma, $dataFinal)
    {
        $query = $this->entityManager->getConnection()->prepare(
            sprintf(
                "SELECT orgao_nivel.cod_estrutural
                     , recuperaDescricaoOrgao(orgao.cod_orgao,'%s') as descricao
                     , orgao.cod_orgao
                  FROM organograma.orgao
            INNER JOIN (SELECT orgao_nivel.*
                             , organograma.fn_consulta_orgao(orgao_nivel.cod_organograma, orgao_nivel.cod_orgao) AS cod_estrutural
                          FROM organograma.orgao_nivel) AS orgao_nivel
                    ON orgao_nivel.cod_orgao = orgao.cod_orgao
                   AND orgao_nivel.cod_nivel = publico.fn_nivel(cod_estrutural)
                 WHERE (orgao.inativacao > '%s' OR orgao.inativacao IS NULL)
             AND orgao_nivel.cod_organograma = %s ORDER BY cod_estrutural",
                $dataFinal,
                $dataFinal,
                $codOrganograma
            )
        );

        $query->execute();
        return $query->fetchAll();
    }

    public function getOneOrganograma($codOrganograma, $dataFinal)
    {
        $resultado = $this->getOrganograma($codOrganograma, $dataFinal);
        return array_shift($resultado);
    }

    public function getOrgaosOrganogramaByCodOrganograma($codOrganograma)
    {
        return $this->repository->getOrgaosOrganogramaByCodOrganograma($codOrganograma);
    }

    public function getOrganogramaByCodOrganograma($codOrganograma)
    {
        return $this->repository->getOrganogramaByCodOrganograma($codOrganograma);
    }


    public function getProximoCodOrganograma()
    {
        $repository = $this->repository;
        $organograma = $repository->findOneBy([], ['codOrganograma' => 'DESC']);
        $codOrganograma = self::VALOR_INICIAL;
        if ($organograma) {
            $codOrganograma = $organograma->getCodOrganograma() + 1;
        }
        return $codOrganograma;
    }

    /**
     * @param $codOrganograma
     * @param bool|false $codOrgao
     * @param bool|false $codNivel
     * @return mixed
     */
    public function listarOrgaosRelacionadosDescricaoComponente($codOrganograma, $codNivel = false, $codOrgao = false)
    {
        return $this->repository->listarOrgaosRelacionadosDescricaoComponente($codOrganograma, $codNivel, $codOrgao);
    }

    /**
     * @param $codOrganograma
     * @param $codOrgao
     * @return mixed
     */
    public function consultaOrgao($codOrganograma, $codOrgao)
    {
        return $this->repository->consultaOrgao($codOrganograma, $codOrgao);
    }

    /**
     * @param \DateTime $dateTime
     *
     * @return array
     */
    public function getOrganogramaAtivo(\DateTime $dateTime)
    {
        $queryBuilder = $this->repository->createQueryBuilder('o');
        $queryBuilder
            ->where('o.implantacao < :date')
            ->setParameter(':date', $dateTime)
            ->orderBy('o.implantacao')
        ;

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @return bool|false
     */
    public function canMigracaoOrganograma()
    {
        $finalizado = $this->repository->findCanMigraOrganograma();

        return !empty($finalizado) ? $finalizado['finalizado'] : false;
    }

    /**
     * Prepara informações de configuração para executar a migração do organograma
     *
     * @param $exercicio
     *
     * @return bool|false
     */
    protected function prepareMigrationOrganograma($exercicio)
    {
        return $this->repository->findAtributeMigrationOrganograma($exercicio);
    }

    /**
     * Executa migração do organograma
     *
     * @param Organograma $organogramaNovo
     * @param Usuario     $currentUser
     * @param             $exercicio
     *
     * @return bool|false
     */
    public function executeMigrationOrganograma(Organograma $organogramaNovo, Usuario $currentUser, $exercicio)
    {
        if ($this->prepareMigrationOrganograma($exercicio)) {
            return $this->repository->executeMigrationOrganograma($organogramaNovo, $currentUser);
        }

        return false;
    }
}
