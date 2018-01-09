<?php

namespace Urbem\CoreBundle\Model\Arrecadacao;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Arrecadacao\Desconto;
use Urbem\CoreBundle\Entity\Arrecadacao\GrupoVencimento;

class DescontoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * DescontoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Desconto::class);
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
    public function saveDesconto($params)
    {
        $dataVencimento = \DateTime::createFromFormat('d/m/Y', $params['dataVencimento']);

        /** @var GrupoVencimento $grupoVencimento */
        $grupoVencimento = $params['grupoVencimento'];
        $paramsDesconto = array(
            'cod_grupo' => $grupoVencimento->getCodGrupo(),
            'cod_vencimento' => $grupoVencimento->getCodVencimento(),
            'ano_exercicio' => $grupoVencimento->getAnoExercicio()
        );

        $codDesconto = $this->getNextVal($paramsDesconto);

        $percentual = $params['formaDesconto'] == 'per' ? true : false;

        $desconto = new Desconto();
        $desconto->setCodDesconto($codDesconto);
        $desconto->setDataVencimento($dataVencimento);
        $desconto->setValor($params['valor']);
        $desconto->setPercentual((boolean) $percentual);
        $desconto->setFkArrecadacaoGrupoVencimento($grupoVencimento);

        $this->entityManager->persist($desconto);
        $this->entityManager->flush();
    }
}
