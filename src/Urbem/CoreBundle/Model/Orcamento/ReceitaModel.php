<?php

namespace Urbem\CoreBundle\Model\Orcamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Orcamento\ContaReceita;
use Urbem\CoreBundle\Entity\Orcamento\Receita;

class ReceitaModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Orcamento\\Receita");
    }

    public function getLancamentosCreditosReceber($params)
    {
        return $this->repository->getLancamentosCreditosReceber($params);
    }

    /**
     * @param $exercicio
     * @param $descricao
     * @return mixed
     */
    public function getClassificacaoReceita($exercicio, $descricao)
    {
        return $this->repository->getReceitaByExercicioAndDescricao($exercicio, $descricao);
    }

    /**
     * @param $exercicio
     * @param $codConta
     * @return mixed
     */
    public function getContaReceita($exercicio, $codConta)
    {
        return $this->repository->getContaReceitaByCodConta($exercicio, $codConta);
    }

    /**
     * @param $exercicio
     * @param $codConta
     * @return null|object
     */
    public function getReceita($exercicio, $codConta)
    {
        return $this->repository->findOneBy([
            'exercicio' => $exercicio,
            'codConta' => $codConta
        ]);
    }

    /**
     * Filtra para a busca, codigo estrutural ou descricao
     * @param $filtro
     * @return mixed|string
     */
    public function getCodEstruturalOrDescricao($filtro)
    {
        $filter = str_replace('.', '', trim($filtro));
        if (is_numeric($filter)) {
            $primeiraParte = implode('.', str_split(substr($filter, 0, 4)));
            $segundaParte = implode('.', str_split(substr($filter, 4), 2));
            $filter = $primeiraParte . '.' . $segundaParte;
        }
        return $filter;
    }

    /**
     * @param Receita $receita
     * @return array
     */
    public function getLancamentosReceita($receita)
    {
        $valorArrecadado = array();
        $con = 0;
        for ($periodo = 1; $periodo <= 6; $periodo++) {
            $dtInicial = new \DateTime(sprintf('%s-%s-%s', $receita->getExercicio(), str_pad((($periodo == 1) ? $periodo : $periodo + $con ), 2, '0', STR_PAD_LEFT), '01'));
            $dtTermino = clone $dtInicial;
            $dtTermino->modify('+1 month')->modify('last day of this month');

            $valorArrecadado[$periodo] = $this->repository->getValorArrecadadoReceitaPorPeriodo($receita->getCodEntidade(), $receita->getExercicio(), $receita->getFkOrcamentoContaReceita()->getCodEstrutural(), $dtInicial->format('d/m/Y'), $dtTermino->format('d/m/Y'));
            $con++;
        }
        return $valorArrecadado;
    }
}
