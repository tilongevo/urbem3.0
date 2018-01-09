<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Almoxarifado;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem;
use Urbem\CoreBundle\Entity\Almoxarifado\NaturezaLancamento;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado\NaturezaLancamentoRepository;

/**
 * Class NaturezaLancamentoModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Almoxarifado
 */
class NaturezaLancamentoModel extends AbstractModel
{
    protected $entityManager = null;

    /** @var NaturezaLancamentoRepository|null  */
    protected $repository = null;

    /**
     * NaturezaLancamentoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Almoxarifado\NaturezaLancamento::class);
    }

    /**
     * @param String $exercicio
     * @return int $lastNumConvenio
     */
    public function buildNumNaturezaLancamento($exercicio)
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select(
                $queryBuilder->expr()->max("naturezaLancamento.numLancamento") . " AS numLancamento"
            )
            ->from(Almoxarifado\NaturezaLancamento::class, 'naturezaLancamento')
            ->where('naturezaLancamento.exercicioLancamento = :exercicio')
            ->setParameter('exercicio', $exercicio);

        $result = $queryBuilder->getQuery()->getSingleResult();

        $lastNumLancamento = $result["numLancamento"] + 1;

        return $lastNumLancamento;
    }

    /**
     * @param SwCgm $cgm
     * @param string $exercicio
     * @param string $tipoNatureza
     * @param integer $codNatureza
     *
     * @return Almoxarifado\NaturezaLancamento
     */
    public function buildOne(SwCgm $cgm, $exercicio, $tipoNatureza = 'E', $codNatureza = 7)
    {
        /** @var Almoxarifado\Natureza $natureza */
        $natureza = $this->entityManager->getRepository(Almoxarifado\Natureza::class)
            ->findOneBy([
                'codNatureza' => $codNatureza,
                'tipoNatureza' => $tipoNatureza
            ]);

        /** @var Almoxarifado\Almoxarife $almoxarife */
        $almoxarife = $this->entityManager->getRepository(Almoxarifado\Almoxarife::class)
            ->find($cgm->getNumcgm());

        $lastNumLancamento = $this->buildNumNaturezaLancamento($exercicio);

        $naturezaLancamento = new Almoxarifado\NaturezaLancamento();
        $naturezaLancamento->setExercicioLancamento($exercicio);
        $naturezaLancamento->setNumLancamento($lastNumLancamento);
        $naturezaLancamento->setFkAdministracaoUsuario($cgm->getFkAdministracaoUsuario());

        $naturezaLancamento->setFkAlmoxarifadoAlmoxarife($almoxarife);
        $naturezaLancamento->setFkAlmoxarifadoNatureza($natureza);

        return $naturezaLancamento;
    }

    /**
     * @param Almoxarifado\NaturezaLancamento $naturezaLancamento
     * @param SwCgm $cgm
     * @param string $exercicio
     * @param string $tipoNatureza
     * @param integer $codNatureza
     *
     * @return Almoxarifado\NaturezaLancamento
     */
    public function buildOneWithObject(Almoxarifado\NaturezaLancamento $naturezaLancamento, SwCgm $cgm, $exercicio, $tipoNatureza = 'E', $codNatureza = 7)
    {
        $natureza = $this->entityManager->getRepository(Almoxarifado\Natureza::class)
            ->findOneBy([
                'codNatureza' => $codNatureza,
                'tipoNatureza' => $tipoNatureza
            ]);

        $lastNumLancamento = $this->buildNumNaturezaLancamento($exercicio);

        $naturezaLancamento->setExercicioLancamento($exercicio);
        $naturezaLancamento->setNumLancamento($lastNumLancamento);
        $naturezaLancamento->setFkAlmoxarifadoNatureza($natureza);
        $naturezaLancamento->setNumcgmUsuario($cgm);

        return $naturezaLancamento;
    }

    /**
     * @param ProxyQueryInterface $proxyQuery
     * @param $exercicio
     * @return ProxyQueryInterface
     */
    public function getListaEntradaDoacao(ProxyQueryInterface $proxyQuery, $exercicio)
    {
        $proxyQuery
            ->andWhere('o.exercicioLancamento = :exercicioEntidade')
            ->andWhere('o.codNatureza = :codNatureza')
            ->andWhere('o.tipoNatureza = :tipoNatureza')
            ->setParameters([
                'exercicioEntidade' => $exercicio,
                'codNatureza' => 3,
                'tipoNatureza' => 'E'
            ]);

        return $proxyQuery;
    }

    /**
     * @param SwCgm $cgm
     * @param $exercicio
     * @param string $tipoNatureza
     * @param int $codNatureza
     * @return Almoxarifado\NaturezaLancamento
     */
    public function saveNaturezaLancamento(SwCgm $cgm, $exercicio, $tipoNatureza = 'E', $codNatureza = 7)
    {
        $naturezaLancamento = $this->buildOne(
            $cgm,
            $exercicio,
            $tipoNatureza,
            $codNatureza
        );

        $this->save($naturezaLancamento);

        return $naturezaLancamento;
    }

    /**
     * @param ProxyQueryInterface $proxyQuery
     * @param $exercicio
     * @return ProxyQueryInterface
     */
    public function getListaEntradaDiversos(ProxyQueryInterface $proxyQuery, $exercicio)
    {
        $proxyQuery
            ->andWhere('o.exercicioLancamento = :exercicioEntidade')
            ->andWhere('o.codNatureza = :codNatureza')
            ->andWhere('o.tipoNatureza = :tipoNatureza')
            ->setParameters([
                'exercicioEntidade' => $exercicio,
                'codNatureza' => 9,
                'tipoNatureza' => 'E'
            ]);

        return $proxyQuery;
    }

    /**
     * @param ProxyQueryInterface $proxyQuery
     * @param $exercicio
     * @return ProxyQueryInterface
     */
    public function findListaEntradasValidasEstorno(ProxyQueryInterface $proxyQuery, $exercicio)
    {
        $arrNunsLancamento = $this->repository->findListaEntradasValidasEstorno($exercicio);

        $numerosLancamento = [];
        foreach ($arrNunsLancamento as $lancamento) {
            $numerosLancamento[] = $lancamento['num_lancamento'];
        }

        $numerosLancamento = (false == empty($numerosLancamento)) ? $numerosLancamento : 0 ;

        $rootAlias = $proxyQuery->getRootAlias();
        $proxyQuery
            ->andWhere(
                $proxyQuery->expr()->in("{$rootAlias}.numLancamento", ":numerosLancamento")
            )
            ->andWhere("{$rootAlias}.exercicioLancamento = :exercicio")
            ->setParameters([
                'numerosLancamento' => $numerosLancamento,
                'exercicio' => $exercicio
            ])
        ;

        return $proxyQuery;
    }

    /**
     * @param NaturezaLancamento $naturezaLancamento
     * @return array
     */
    public function findEntradaValidaEstorno(NaturezaLancamento $naturezaLancamento)
    {
        $result = $this->repository->findListaEntradasValidasEstorno(
            $naturezaLancamento->getExercicioLancamento(),
            $naturezaLancamento->getNumLancamento()
        );

        return reset($result);
    }

    /**
     * Retorna os itens da Entrada selecionada junto a quantidade já estornada de cada item, quando houver
     *
     * @param array $params['exercicio', 'numLancamento', 'codNatureza', 'tipoNatureza'(, 'codItem')]
     * @return array
     */
    public function getItensEntrada($params)
    {
        $arrItens = $this->repository->getListaItensEntrada($params);

        foreach ($arrItens as $index => $item) {
            $arrItens[$index]['cod_almoxarifado'] =
                $this->entityManager->find(Almoxarifado\Almoxarifado::class, $arrItens[$index]['cod_almoxarifado']);

            $arrItens[$index]['cod_item'] =
                $this->entityManager->find(Almoxarifado\CatalogoItem::class, $arrItens[$index]['cod_item']);

            $arrItens[$index]['cod_marca'] =
                $this->entityManager->find(Almoxarifado\Marca::class, $arrItens[$index]['cod_marca']);

            $arrItens[$index]['cod_centro'] =
                $this->entityManager->find(Almoxarifado\CentroCusto::class, $arrItens[$index]['cod_centro']);

            $arrItens[$index]['quantidade_estornada'] = (new LancamentoMaterialEstornoModel($this->entityManager))
                ->getSaldoEstornado(
                    $arrItens[$index]['cod_item'],
                    $arrItens[$index]['cod_marca'],
                    $arrItens[$index]['cod_centro']
                );
        }

        return $arrItens;
    }

    /**
     * @param CatalogoItem          $catalogoItem
     * @param NaturezaLancamento    $naturezaLancamento
     * @return mixed|null
     */
    public function getItemEntrada(CatalogoItem $catalogoItem, NaturezaLancamento $naturezaLancamento)
    {
        $resultSearch = $this->getItensEntrada([
            'exercicio' => $naturezaLancamento->getExercicioLancamento(),
            'numLancamento' => $naturezaLancamento->getNumLancamento(),
            'codNatureza' => $naturezaLancamento->getCodNatureza(),
            'tipoNatureza' => $naturezaLancamento->getTipoNatureza()
        ]);

        foreach ($resultSearch as $result) {
            /** @var CatalogoItem $fCatalogoItem */
            $fCatalogoItem = $result['cod_item'];

            if ($fCatalogoItem->getCodItem() == $catalogoItem->getCodItem()) {
                return $result;
            }
        }

        return null;
    }

    /**
     * @param int $numLancamento
     * @param string $exercicioLancamento
     * @param string $tipoNatureza
     * @param int $codNatureza
     * @return Almoxarifado\NaturezaLancamento $naturezaLancamento
     */
    public function findOne($numLancamento, $exercicioLancamento, $tipoNatureza = 'E', $codNatureza = 7)
    {
        $naturezaLancamento = $this->repository
            ->findOneBy([
                'numLancamento' => $numLancamento,
                'exercicioLancamento' => $exercicioLancamento,
                'codNatureza' => $codNatureza,
                'tipoNatureza' => $tipoNatureza
            ]);

        return $naturezaLancamento;
    }

    /**
     * @param Almoxarifado\Natureza $natureza
     * @param Almoxarifado\Almoxarife $almoxarife
     * @param $exercicio
     * @return Almoxarifado\NaturezaLancamento
     */
    public function create(Almoxarifado\Natureza $natureza, Almoxarifado\Almoxarife $almoxarife, $exercicio)
    {
        $naturezaLancamento = $this->repository->findOneBy([
            'exercicioLancamento' => $exercicio,
            'fkAlmoxarifadoNatureza' => $natureza,
        ]);

        if (true == is_null($naturezaLancamento)) {
            $naturezaLancamento = new Almoxarifado\NaturezaLancamento();
            $numLancamento = $this->repository->getNextNumLancamento([
                'cod_natureza' => $natureza->getCodNatureza(),
                'tipo_natureza' => $natureza->getTipoNatureza(),
                'exercicio_lancamento' => $exercicio
            ]);

            $naturezaLancamento->setExercicioLancamento($exercicio);
            $naturezaLancamento->setNumLancamento($numLancamento);
            $naturezaLancamento->setFkAlmoxarifadoAlmoxarife($almoxarife);
            $naturezaLancamento->setFkAlmoxarifadoNatureza($natureza);
            $naturezaLancamento->setNumcgmUsuario($almoxarife->getCgmAlmoxarife());

            $this->save($naturezaLancamento);
        }

        return $naturezaLancamento;
    }
}
