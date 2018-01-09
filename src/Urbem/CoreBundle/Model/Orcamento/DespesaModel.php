<?php

namespace Urbem\CoreBundle\Model\Orcamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Repository;

class DespesaModel extends AbstractModel
{
    protected $entityManager = null;

    /** @var Repository\Orcamento\DespesaRepository */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Orcamento\\Despesa");
    }

    public function getPAO($exercicio)
    {
        return $this->repository->getPAO($exercicio);
    }

    public function recuperaSaldoDotacao($exercicio, $cod_despesa)
    {
        return $this->repository->recuperaSaldoDotacao($exercicio, $cod_despesa);
    }

    /**
     * @param string|int $exercicio
     * @param int        $codDespesa
     * @param int        $codEntidade
     * @param string     $dataEmpenho
     * @param string     $tipoEmissao
     *
     * @return array
     */
    public function recuperaSaldoDotacaoDataEmpenho($exercicio, $codDespesa, $codEntidade, $dataEmpenho = '', $tipoEmissao = 'R')
    {
        return $this->repository->recuperaSaldoDotacaoDataEmpenho($exercicio, $codDespesa, $codEntidade, $dataEmpenho, $tipoEmissao);
    }

    public function recuperaCodEstrutural($exercicio, $cod_despesa)
    {
        return $this->repository->recuperaCodEstrutural($exercicio, $cod_despesa);
    }

    public function recuperaCodEstruturalUnico($exercicio, $cod_despesa)
    {
        return $this->repository->recuperaCodEstruturalUnico($exercicio, $cod_despesa);
    }

    public function getOneDespesa($codDespesa)
    {
        return $this->repository->findOneBy([
            'codDespesa' => $codDespesa,
        ]);
    }

    public function getDespesaLiquidacaoEmpenho($exercicio, $codDespesa)
    {
        return $this->repository->getDespesaLiquidacaoEmpenho($exercicio, $codDespesa);
    }

    /**
     * @param $codDespesa
     * @param $exercicio
     * @param $codEntidade
     * @return null|object
     */
    public function getOneDespesaByCodDespesaAndExercicioAndCodEntidade($codDespesa, $exercicio, $codEntidade)
    {
        return $this->repository->findOneBy([
            'codDespesa' => $codDespesa,
            'exercicio' => $exercicio,
            'codEntidade' => $codEntidade
        ]);
    }

    /**
     * @param $codDespesa
     * @param $exercicio
     * @return null|object
     */
    public function getOneDespesaByCodDespesaAndExercicio($codDespesa, $exercicio)
    {
        return $this->repository->findOneBy([
            'codDespesa' => $codDespesa,
            'exercicio' => $exercicio
        ]);
    }
    
    /**
     * @param int $codDespesa
     * @param int $ano
     * @return mixed
     */
    public function getPrevisoesDespesa($codDespesa, $ano)
    {
        return $this->repository->getPrevisoesDespesa($codDespesa, $ano);
    }
    
    /**
     * @param int $exercicio
     * @param string $filtro
     * @param array $delimitadores
     * @param string $contrDetelhado
     * @param int $orgao
     * @param int $unidade
     * @param string $vCreateDropTable
     * @return mixed
     */
    public function getBalanceteDespesa($exercicio, $filtro = '', Array $delimitadores = [], $contrDetalhado = '', $orgao, $unidade, $vCreateDropTable)
    {
        return $this->repository->getBalanceteDespesa(
            $exercicio,
            $filtro,
            $delimitadores,
            $contrDetalhado, 
            $orgao, 
            $unidade,
            $vCreateDropTable
        );
    }
    
    /**
     * @param int $exercicio
     * @return mixed
     */
    public function getClassificacoesDespesa($exercicio)
    {
        return $this->repository->getClassificacoesDespesa($exercicio);
    }
}
