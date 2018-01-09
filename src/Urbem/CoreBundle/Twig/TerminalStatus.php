<?php

namespace Urbem\CoreBundle\Twig;

use Doctrine\ORM\EntityManagerInterface;

class TerminalStatus extends \Twig_Extension
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
            new \Twig_SimpleFilter('terminalStatusFilter', array($this, 'terminalStatusFilter')),
        );
    }

    public function terminalStatusFilter($terminal)
    {
        $repository = $this->em->getRepository('CoreBundle:Tesouraria\Terminal');
        $situacao = $repository->statusTerminal($terminal->getCodTerminal());
        $status = null;
        if($situacao['situacao'] == "Ativo") {
            if (!empty($terminal->getFkTesourariaAberturas()->count())) {
                foreach ($terminal->getFkTesourariaAberturas() as $abertura) {
                    $retorno = $repository->statusTerminalPorTerminalExercicioEntidade($abertura->getCodTerminal(), $abertura->getExercicioBoletim(), $abertura->getCodEntidade());
                    if (empty($retorno)) {
                        $status = "reaberto";
                    } else {
                        $status = $retorno['situacao'];
                    }
                }
            }
        }else{
            $status = $situacao['situacao'];
        }

        return $status;
    }

    public function getName()
    {
        return 'terminal_status_extension';
    }
}
