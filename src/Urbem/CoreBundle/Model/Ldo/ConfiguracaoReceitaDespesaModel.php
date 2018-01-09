<?php

namespace Urbem\CoreBundle\Model\Ldo;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity;

class ConfiguracaoReceitaDespesaModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;
    const TIPO_RECEITA = 'receita';
    const TIPO_DESPESA = 'despesa';

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Ldo\\ConfiguracaoReceitaDespesa");
    }

    /**
     * Retorna as receitas do tipo R e do tipo D
     * @param array $dadosConfReceitaDespesaPorTipo
     * @return null|object
     */
    protected function getReceitasTipos(array $dadosConfReceitaDespesaPorTipo)
    {
        list($ppa, $ano, $codTipo, $exercicio, $tipo) = $dadosConfReceitaDespesaPorTipo;

        $confReceitaDespesaRepository = $this->entityManager->getRepository(Entity\Ldo\ConfiguracaoReceitaDespesa::class);
        return $confReceitaDespesaRepository->findOneBy(
            ['codPpa' => $ppa, 'ano' => $ano, 'codTipo' => $codTipo, 'tipo' => $tipo, 'exercicio' => $exercicio]
        );
    }

    /**
     * Busca o Tipo receita despesa por, codigo do tipo e pelo tipo, que pode ser D ou R
     * @param array $dadosBuscaReceitaDespesa
     * @return null|object
     */
    protected function findTipoReceitaDespesaPorTipo(array $dadosBuscaReceitaDespesa)
    {
        list($codTipo, $tipoReceitaDespesa) = $dadosBuscaReceitaDespesa;

        $tipoReceitaDespesaRepository = $this->entityManager->getRepository(Entity\Ldo\TipoReceitaDespesa::class);
        return $tipoReceitaDespesaRepository->findOneBy(['codTipo' => $codTipo, 'tipo' => $tipoReceitaDespesa]);
    }

    /**
     * Busca o Ldo por codPpa e ano
     * @param array $dadosBuscaLdo
     * @return null|object
     */
    protected function findLdoPorPpaEAno(array $dadosBuscaLdo)
    {
        list($codPpa, $ano) = $dadosBuscaLdo;

        $ldoRepository = $this->entityManager->getRepository(Entity\Ldo\Ldo::class);
        return $ldoRepository->findOneBy(['codPpa' => $codPpa, 'ano' => $ano]);
    }

    /**
     * Retorna do array pelo codTipo e pelas keys:
     * receitaArrecadado, receitaPrevisto, receitaProjetada, despesaArrecadado, despesaPrevisto, despesaProjetada
     * @param array $dataForm
     * @param $codTipo
     * @param $exercicio
     * @return float
     */
    protected function getReceitasDespesas(array $dataForm, $codTipo, $exercicio)
    {
        $retorno = (float) 0;
        if (!empty($dataForm[$codTipo]) && !empty($dataForm[$codTipo][$exercicio])){
            $retorno = $dataForm[$codTipo][$exercicio];
        }
        return $retorno;
    }

    /**
     * @param array $dataForm
     * @param $exercicio
     * @param $codTipo
     * @param $tipoReceitaDespesa
     * @param $stringReceitaDespesa
     * @return null|object|Entity\Ldo\ConfiguracaoReceitaDespesa
     */
    public function populaValoresConfiguracaoReceitaDespesa(array $dataForm, $exercicio, $codTipo, $tipoReceitaDespesa, $stringReceitaDespesa)
    {
        $ano = (($exercicio-2)%4)+1;
        if (empty($dataForm['cod_ppa'])) {
            return null;
        }

        $dadosConfReceitaDespesaPorTipo = [
            $dataForm['cod_ppa'],
            $ano,
            $codTipo,
            $exercicio,
            $tipoReceitaDespesa
        ];

        $receitaDespesa = $this->getReceitasTipos($dadosConfReceitaDespesaPorTipo);
        if (empty($receitaDespesa)) {
            $receitaDespesa = new Entity\Ldo\ConfiguracaoReceitaDespesa();
        }

        $receitaDespesa->setFkLdoLdo($this->findLdoPorPpaEAno([$dataForm['cod_ppa'], $ano]));
        $receitaDespesa->setFkLdoTipoReceitaDespesa($this->findTipoReceitaDespesaPorTipo([$codTipo, $tipoReceitaDespesa]));
        $receitaDespesa->setExercicio($exercicio);
        $receitaDespesa->setVlArrecadadoLiquidado($this->getReceitasDespesas($dataForm[$stringReceitaDespesa . 'Arrecadado'], $codTipo, $exercicio));
        $receitaDespesa->setVlPrevistoFixado($this->getReceitasDespesas($dataForm[$stringReceitaDespesa . 'Previsto'], $codTipo, $exercicio));
        $receitaDespesa->setVlProjetado($this->getReceitasDespesas($dataForm[$stringReceitaDespesa . 'Projetada'], $codTipo, $exercicio));

        return $receitaDespesa;
    }

}