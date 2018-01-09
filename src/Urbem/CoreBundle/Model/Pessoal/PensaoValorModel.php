<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Pessoal\Pensao;
use Urbem\CoreBundle\Entity\Pessoal\PensaoValor;

class PensaoValorModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Pessoal\PensaoValor");
    }

    /**
     * @param Pensao $pensao
     * @param $valor
     * @return PensaoValor
     */
    public function savePensaoValor(Pensao $pensao, $valor)
    {
        $pensaoValor = new PensaoValor();
        $pensaoValor
            ->setFkPessoalPensao($pensao)
            ->setValor($valor);

        $this->save($pensaoValor);

        return $pensaoValor;
    }
}
