<?php

namespace Urbem\CoreBundle\Model\Empenho;

use Doctrine\ORM;
use Urbem\CoreBundle\Model;

class EmpenhoAssinaturaModel
{
    private $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Empenho\EmpenhoAssinatura");
    }
    
    public function getCgmAssinatura($exercicio, $codEntidade)
    {
        $assinantes = $this->repository->getCgmAssinatura($exercicio, $codEntidade);
        
        $assinantesList = array();
        foreach ($assinantes as $assinante) {
            $choiceLabel = $assinante->numcgm . " - " . $assinante->nom_cgm;
            $assinantesList[$choiceLabel] = $assinante->numcgm;
        }
        
        return $assinantesList;
    }
}
