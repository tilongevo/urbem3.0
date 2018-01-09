<?php

namespace Urbem\CoreBundle\Model\Concurso;

use Doctrine\ORM;

class EditalModel
{
    private $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Concurso\\Edital");
    }

    public function listarConcursoPorExercicio($exercicio = '')
    {
        return $this->repository->listarConcursoPorExercicio($exercicio);
    }

    public function listarExercicio()
    {
        return $this->repository->listarExercicio();
    }

    /**
     * @return array
     */
    public function getEditaisJaCadastrados()
    {
        $editais = $this->entityManager->getRepository('CoreBundle:Concurso\Edital')
            ->findAll();

        $editaisLista = array();
        foreach ($editais as $excluidoKey => $excluidoValue) {
            $editaisLista[] = $excluidoValue->getCodEdital();
        }

        return $editaisLista;
    }
}
