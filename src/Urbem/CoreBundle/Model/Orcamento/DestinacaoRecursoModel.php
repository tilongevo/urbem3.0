<?php

namespace Urbem\CoreBundle\Model\Orcamento;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity;

class DestinacaoRecursoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;
    const CREATE = 'create';
    const EDIT = 'edit';
    const CREATE_ACTION = 'createAction';

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Orcamento\\DestinacaoRecurso");
    }

    /**
     * Metodo para salvar/editar DestinacaoRecurso, a partir das datas de um ppa
     * @param $object
     * @param $action
     */
    public function salvarProximosAnos($object, $action)
    {
        $ppaExercicio = $this->entityManager->getRepository(Entity\Ppa\Ppa::class)->getPpaExercicio($object->getExercicio());
        $exercicio = (int) $object->getExercicio();
        $anoFinal = (int) $ppaExercicio->getAnoFinal();

        $destinacaoRecursoCollection = new ArrayCollection();
        for ($exercicio; $exercicio <= $anoFinal; $exercicio++) {
            if ($exercicio == $object->getExercicio()) {
                continue;
            }

            $destinacaoRecurso = null;
            switch ($action) {
                case self::CREATE:
                    $destinacaoRecurso = new Entity\Orcamento\DestinacaoRecurso();
                    $destinacaoRecurso->setExercicio($exercicio);
                    $destinacaoRecurso->setCodDestinacao($object->getCodDestinacao());
                    break;
                case self::EDIT:
                    $destinacaoRecurso = $this->repository->findOneBy(['codDestinacao' => $object->getCodDestinacao(), 'exercicio' => $exercicio]);
                    break;
            }
            $destinacaoRecurso->setDescricao($object->getDescricao());
            $destinacaoRecursoCollection->add($destinacaoRecurso);
        }

        array_map([$this, 'save'], $destinacaoRecursoCollection->toArray());
    }
}
