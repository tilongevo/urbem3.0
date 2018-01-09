<?php

namespace Urbem\CoreBundle\Model\Arrecadacao;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Arrecadacao\GrupoVencimento;
use Urbem\CoreBundle\Entity\Arrecadacao\VencimentoParcela;

class VencimentoParcelaModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * VencimentoParcelaModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(VencimentoParcela::class);
    }

    /**
     * @return mixed
     */
    public function getNextVal($params)
    {
        return $this->repository->getNextVal($params);
    }

    /**
     * @param $params
     */
    public function saveVencimentoParcela($params)
    {
        $dataVencimento = \DateTime::createFromFormat('d/m/Y', $params['dataVencimento']);
        $dataVencimentoDesconto = \DateTime::createFromFormat('d/m/Y', $params['dataVencimentoDesconto']);

        /** @var GrupoVencimento $grupoVencimento */
        $grupoVencimento = $params['grupoVencimento'];

        $formaDesconto = $params['formaDesconto'] == 'perparc' ? true : false;

        $paramsVencimento = array(
            'cod_grupo' => $grupoVencimento->getCodGrupo(),
            'cod_vencimento' => $grupoVencimento->getCodVencimento(),
            'ano_exercicio' => $grupoVencimento->getAnoExercicio()
        );

        $codParcela = $this->getNextVal($paramsVencimento);

        $vencimentoParcela = new VencimentoParcela();
        $vencimentoParcela->setCodParcela($codParcela);
        $vencimentoParcela->setDataVencimento($dataVencimento);
        $vencimentoParcela->setValor($params['valor']);
        $vencimentoParcela->setDataVencimentoDesconto($dataVencimentoDesconto);
        $vencimentoParcela->setPercentual($formaDesconto);
        $vencimentoParcela->setFkArrecadacaoGrupoVencimento($grupoVencimento);

        $this->entityManager->persist($vencimentoParcela);
        $this->entityManager->flush();
    }
}
