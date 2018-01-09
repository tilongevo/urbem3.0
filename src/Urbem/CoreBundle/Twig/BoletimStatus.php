<?php

namespace Urbem\CoreBundle\Twig;

use Doctrine\ORM\EntityManagerInterface;

class BoletimStatus extends \Twig_Extension
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
            new \Twig_SimpleFilter('statusFilter', array($this, 'statusFilter')),
        );
    }

    public function statusFilter($boletim)
    {
        $repository = $this->em->getRepository('CoreBundle:Tesouraria\Boletim');
        $status = $repository->verificarStatusBoletim([$boletim->getCodBoletim(), $boletim->getExercicio(), $boletim->getCodEntidade()]);
        if(!empty($status)){
            return $status['situacao'];
        }
    }

    public function getName()
    {
        return 'boletim_status_extension';
    }
}
