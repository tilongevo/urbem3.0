<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Monetario\Agencia;
use Urbem\CoreBundle\Entity\Pessoal\Pensao;
use Urbem\CoreBundle\Entity\Pessoal\PensaoBanco;

class PensaoBancoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Pessoal\Pensao");
    }

    /**
     * @param Agencia $agencia
     * @param Pensao $pensao
     * @param string $conta
     * @return PensaoBanco
     */
    public function savaPensaoBanco(Agencia $agencia, Pensao $pensao, $conta)
    {
        $pensaoBanco = new PensaoBanco();
        $pensaoBanco
            ->setFkPessoalPensao($pensao)
            ->setFkMonetarioAgencia($agencia)
            ->setContaCorrente($conta);

        $this->save($pensaoBanco);

        return $pensaoBanco;
    }
}
