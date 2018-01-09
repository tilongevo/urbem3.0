<?php

namespace Urbem\CoreBundle\Twig;

use Doctrine\ORM\EntityManagerInterface;

class ChequeBanco extends \Twig_Extension
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
            new \Twig_SimpleFilter('chequeBanco', array($this, 'chequeBanco')),
        );
    }

    public function chequeBanco($codBanco)
    {
        $repository = $this->em->getRepository('CoreBundle:Monetario\Banco');
        $banco = $repository->findOneBy(['codBanco' => $codBanco]);
        return $banco->getNumBanco() . ' - ' . $banco->getNomBanco();
    }

    public function getName()
    {
        return 'cheque_banco_extension';
    }
}
