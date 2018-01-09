<?php

namespace Urbem\CoreBundle\Twig;

use Doctrine\ORM\EntityManagerInterface;

class ChequeEmitido extends \Twig_Extension
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct($em)
    {
        $this->em = $em;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('chequeEmitido', array($this, 'chequeEmitido')),
        );
    }

    public function chequeEmitido($cheque)
    {
        $repository = $this->em->getRepository('CoreBundle:Monetario\Agencia');
        $agencia = $repository->findOneBy(['codAgencia' => $cheque->getCodAgencia()]);

        $repository = $this->em->getRepository('CoreBundle:Monetario\Banco');
        $banco = $repository->findOneBy(['codBanco' => $cheque->getCodBanco()]);

        $repository = $this->em->getRepository('CoreBundle:Tesouraria\Cheque');
        $statusCheque =  $repository->statusCheque($banco->getNumBanco(), $agencia->getNumAgencia(), $cheque->getFkMonetarioContaCorrente()->getNumContaCorrente(), $cheque->getNumCheque());
        return $statusCheque['emitido'];
    }

    public function getName()
    {
        return 'cheque_emitido_extension';
    }
}
