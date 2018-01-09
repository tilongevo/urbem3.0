<?php

namespace Urbem\CoreBundle\Twig;

use Doctrine\ORM\EntityManagerInterface;
use Urbem\CoreBundle\Entity\Monetario\Agencia;
use Urbem\CoreBundle\Entity\Monetario\Banco;
use Urbem\CoreBundle\Entity\Tesouraria\Cheque;

class ChequeTipoEmissao extends \Twig_Extension
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
            new \Twig_SimpleFilter('chequeTipoEmissao', array($this, 'chequeTipoEmissao')),
        );
    }

    public function chequeTipoEmissao($cheque)
    {
        $repository = $this->em->getRepository(Cheque::class);

        $repositoryAgencia = $this->em->getRepository(Agencia::class);
        $agencia = $repositoryAgencia->findOneBy(['codAgencia' => $cheque->getCodAgencia()]);

        $repositoryBanco = $this->em->getRepository(Banco::class);
        $banco = $repositoryBanco->findOneBy(['codBanco' => $cheque->getCodBanco()]);

        $dadosCheque = $repository->dadosCheque($banco->getNumBanco(), $agencia->getNumAgencia(), $cheque->getFkMonetarioContaCorrente()->getNumContaCorrente(), $cheque->getNumCheque());

        $tipoEmissao = "";
        if (!empty($dadosCheque['data_emissao'])) {
            switch ($dadosCheque['tipo_emissao']) {
                case 'despesa_extra':
                    $tipoEmissao = "Despesa extra";
                    break;
                case 'ordem_pagamento':
                    $tipoEmissao = "Ordem pagamento";
                    break;
                case 'transferencia':
                    $tipoEmissao = "Transfêrencia";
                    break;
            }
        }

        return $tipoEmissao;
    }

    public function getName()
    {
        return 'cheque_tipo_emissao_extension';
    }
}
