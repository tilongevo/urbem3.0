<?php

namespace Urbem\CoreBundle\Model\Arrecadacao;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Arrecadacao\TabelaConversaoValores;

/**
 * Class TabelaConversaoValoresModel
 * @package Urbem\CoreBundle\Model\Arrecadacao
 */
class TabelaConversaoValoresModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * TabelaConversaoValoresModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(TabelaConversaoValores::class);
    }

    /**
     * @param $params
     */
    public function saveTabelaConversaoValores($params)
    {
        $tabelaConversaoValores = new TabelaConversaoValores();
        $tabelaConversaoValores->setParametro1($params['parametro1']);
        $tabelaConversaoValores->setParametro2($params['parametro2']);
        $tabelaConversaoValores->setParametro3($params['parametro3']);
        $tabelaConversaoValores->setParametro4($params['parametro4']);
        $tabelaConversaoValores->setValor($params['valor']);
        $tabelaConversaoValores->setFkArrecadacaoTabelaConversao($params['tabelaConversao']);

        $this->entityManager->persist($tabelaConversaoValores);
        $this->entityManager->flush();
    }
}
