<?php

namespace Urbem\CoreBundle\Model\Tesouraria;

use Doctrine\ORM;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\AbstractModel;

class ArrecadacaoEstornadaModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository('CoreBundle:Tesouraria\ArrecadacaoEstornada');
    }

    /**
     * @param $codArrecadacao
     * @param $exercicio
     * @param $timestampArrecadacao
     * @param $timestampEstornada
     * @return null|object
     */
    public function getOneArrecadacao($codArrecadacao, $exercicio, $timestampArrecadacao, $timestampEstornada)
    {
        $arrecadacao = $this->repository->findOneBy([
            'codArrecadacao' => $codArrecadacao,
            'exercicio' => $exercicio,
            'timestampArrecadacao' => $timestampArrecadacao,
            'timestampEstornada' => $timestampEstornada
        ]);

        return $arrecadacao;
    }
}
