<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Almoxarifado;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial;
use Urbem\CoreBundle\Entity\Almoxarifado\SaidaDiversa;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Helper\ArrayHelper;
use Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado\SaidaDiversaRepository;

/**
 * Class SaidaDiversaModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Almoxarifado
 */
class SaidaDiversaModel extends AbstractModel
{
    protected $entityManager = null;

    /** @var EntityRepository|SaidaDiversaRepository $repository */
    protected $repository = null;

    /**
     * SaidaDiversaModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(SaidaDiversa::class);
    }

    /**
     * @param LancamentoMaterial $lancamentoMaterial
     * @param SwCgm              $swCgm
     * @param string             $observacao
     * @return SaidaDiversa
     */
    public function create(LancamentoMaterial $lancamentoMaterial, SwCgm $swCgm, $observacao = "")
    {
        $saidaDiversa = new SaidaDiversa();
        $saidaDiversa->setFkAlmoxarifadoLancamentoMaterial($lancamentoMaterial);
        $saidaDiversa->setFkSwCgm($swCgm);
        $saidaDiversa->setObservacao(substr($observacao, 0, 160));

        $this->save($saidaDiversa);

        return $saidaDiversa;
    }

    /**
     * @param array $params
     * @return array
     * @throws \Exception
     */
    public function performContabilidadeAlmoxarifadoLancamento(array $params)
    {
        $mandatoryKeys = [
            'exercicio',
            'cod_conta_despesa',
            'valor',
            'complemento',
            'tipo_lote',
            'nom_lote',
            'dt_lote',
            'cod_entidade'
        ];

        if (!ArrayHelper::arrayMultiKeysExists($mandatoryKeys, $params)) {
            throw new \Exception(sprintf(
                'Some mandatory parameters are missing ("%s")',
                implode('", "', $mandatoryKeys)
            ));
        }

        return $this->repository->performContabilidadeAlmoxarifadoLancamento($params);
    }
}
