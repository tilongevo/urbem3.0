<?php

namespace Urbem\CoreBundle\Model\Ppa;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Ppa\Acao;
use Urbem\CoreBundle\Entity\Ppa\AcaoDados;

class AcaoModel extends AbstractModel
{
    /**
     * @var ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var ORM\EntityRepository
     */
    protected $repository;

    /**
     * AcaoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Ppa\\Acao");
    }

    /**
     * @param $object
     * @return bool
     */
    public function canRemove($object)
    {
        return false;
    }

    /**
     * @param $codTipo
     * @param $exercicio
     * @param $numAcao
     * @return bool
     */
    public function verificaNumAcaoByCodTipo($codTipo, $exercicio, $numAcao)
    {
        $parametros = array(
            1 => 'pao_digitos_id_projeto',
            2 => 'pao_digitos_id_atividade',
            3 => 'pao_digitos_id_oper_especiais'
        );

        if (array_key_exists($codTipo, $parametros)) {
            $em = $this->entityManager;
            $config = $em->getRepository('CoreBundle:Administracao\Configuracao')
                ->findOneBy([
                    'parametro' => $parametros[$codTipo],
                    'exercicio' => $exercicio
                ]);
            if ($config) {
                $digitos = explode(',', $config->getValor());
                if (!in_array(substr(str_pad($numAcao, 4, '0', STR_PAD_LEFT), 0, 1), $digitos)) {
                    return false;
                }
            }
        }
        return true;
    }

    public function getPpaByCodPrograma($codPrograma)
    {
        $em = $this->entityManager;
        $ppaRepository = $em->getRepository('CoreBundle:Ppa\Ppa');

        $queryBuilder = $ppaRepository->createQueryBuilder('ppa');
        $queryBuilder->innerJoin('CoreBundle:Ppa\MacroObjetivo', 'mo', 'WITH', 'ppa.codPpa = mo.codPpa');
        $queryBuilder->innerJoin('CoreBundle:Ppa\ProgramaSetorial', 'ps', 'WITH', 'ps.codMacro = mo.codMacro');
        $queryBuilder->innerJoin('CoreBundle:Ppa\Programa', 'p', 'WITH', 'p.codSetorial = ps.codSetorial');
        $queryBuilder->where('p.codPrograma = :codPrograma');
        $queryBuilder->setParameter('codPrograma', $codPrograma);
        $ppa = $queryBuilder->setMaxResults(1)->getQuery()->getOneOrNullResult();

        return $ppa;
    }

    /**
     * @param $codAcao
     * @param $codRecurso
     * @return array
     */
    public function getRecursosByCodAcaoCodRecurso($codAcao, $codRecurso)
    {
        $em = $this->entityManager;

        $acao = $em->getRepository('CoreBundle:Ppa\Acao')->find($codAcao);
        $acaoDados = $acao->getAcaoDados();
        $acaoRecursos = $acaoDados->getFkPpaAcaoRecursos()->filter(
            function ($entry) use ($codRecurso) {
                if ($entry->getCodRecurso() == $codRecurso) {
                    return $entry;
                }
            }
        );
        return $acaoRecursos;
    }

    public function verificaAcaoExistente($numAcao, $codPpa)
    {
        return $this->repository->verificaAcaoExistente($numAcao, $codPpa);
    }

    /**
     * Retorna AcaoDados, filtrado pelo field ultimoTimestampAcaoDados de Acao
     * @param Acao $acao
     * @return AcaoDados|null
     */
    public function currentAcaoDados(Acao $acao)
    {
        return $acao->getFkPpaAcaoDados()->filter(
            function ($entry) use ($acao) {
                if ($entry->getTimestampAcaoDados() == $acao->getUltimoTimestampAcaoDados()) {
                    return $entry;
                }
            }
        )->first();
    }
    
    /**
     * @param int $exercicio
     * @param int $codPpa
     * @param boolean $hmlg
     * @return array
     */
    public function getConfigAcaoDespesa($exercicio = null, $codPpa = null, $hmlg = false)
    {
        return $this->repository->getConfigAcaoDespesa($exercicio, $codPpa, $hmlg);
    }
    
    /**
     * @param int $codPpa
     * @param int $ano
     * @param array $param
     * @return array
     */
    public function getAcaoDespesas($codPpa, $ano, Array $param = [], $order = null, $count = false, $limit = 0, $offset = 0)
    {
        return $this->repository->getAcaoDespesas($codPpa, $ano, $param, $order, $count, $limit, $offset);
    }
    
    /**
     * @param int $exercicio
     * @param int $codAcao
     * @param int $ano
     * @param int $codRecurso
     * @return array
     */
    public function recuperaConfigDespesa($exercicio, $codAcao, $ano = 0, $codRecurso = 0)
    {
        return $this->repository->recuperaConfigDespesa($exercicio, $codAcao, $ano, $codRecurso);
    }
    
    /**
     * @param int $exercicio
     * @param int $codAno
     * @param int $codAcao
     * @return mixed
     */
    public function recuperaDespesaByAcao($exercicio, $codAno, $codAcao)
    {
        return $this->repository->recuperaDespesaByAcao($exercicio, $codAno, $codAcao);
    }
}
