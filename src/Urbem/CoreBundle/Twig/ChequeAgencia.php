<?php

namespace Urbem\CoreBundle\Twig;

use Doctrine\ORM\EntityManagerInterface;

class ChequeAgencia extends \Twig_Extension
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
            new \Twig_SimpleFilter('chequeAgencia', array($this, 'chequeAgencia')),
        );
    }

    public function chequeAgencia($codAgencia)
    {
        $repository = $this->em->getRepository('CoreBundle:Monetario\Agencia');
        $agencia = $repository->findOneBy(['codAgencia' => $codAgencia]);
        return $agencia->getNumAgencia() . ' - ' . $agencia->getNomAgencia();
    }

    public function getName()
    {
        return 'cheque_agencia_extension';
    }
}
