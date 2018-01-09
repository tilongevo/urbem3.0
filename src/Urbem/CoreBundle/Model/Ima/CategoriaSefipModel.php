<?php

namespace Urbem\CoreBundle\Model\Ima;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel as Model;
use Urbem\CoreBundle\Entity\Ima;
use Urbem\CoreBundle\Entity\Pessoal\Categoria;
use Urbem\CoreBundle\Repository\RecursosHumanos\Ima\CategoriaSefipRepository;

class CategoriaSefipModel extends Model
{
    protected $entityManager = null;
    /** @var CategoriaSefipRepository|null */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Ima\CategoriaSefip::class);
    }

    public function removeCategoriaSefip()
    {
        $this->repository->removeCategoriaSefip();
    }

    /**
     * @param Ima\ModalidadeRecolhimento $modalidade
     * @param Categoria                  $categoria
     *
     * @return Ima\CategoriaSefip
     */
    public function createCategoriaSefip(Ima\ModalidadeRecolhimento $modalidade, Categoria $categoria)
    {
        /** @var Ima\CategoriaSefip $categoriaSefip */
        $categoriaSefip = new Ima\CategoriaSefip();
        $categoriaSefip->setFkImaModalidadeRecolhimento($modalidade);
        $categoriaSefip->setFkPessoalCategoria($categoria);

        $this->entityManager->persist($categoriaSefip);
    }

    /**
     * @return array
     */
    public function recuperaModalidades()
    {
        return $this->repository->recuperaModalidades();
    }
}
