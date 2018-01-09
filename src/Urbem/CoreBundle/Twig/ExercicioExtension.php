<?php

namespace Urbem\CoreBundle\Twig;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Class ExercicioExtension
 */
class ExercicioExtension extends \Twig_Extension
{
    /** @var EntityManagerInterface */
    private $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct($em)
    {
        $this->em = $em;
    }
    
    /**
     * @return array
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('exercicioLista', array($this, 'exercicioLista')),
        );
    }
    
    /**
     * Retorna a dropdown de exercício
     * @param  string $timestamp
     * @return array
     */
    public function exercicioLista($timestamp)
    {
        $ano = date("Y", strtotime($timestamp));
        
        return range($ano + 1, $ano - 4);
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'exercicio_extension';
    }
}
