<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Frota;

use Doctrine\DBAL\DBALException;
use Doctrine\ORM;
use Symfony\Component\Form\Form;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Repository;
use Symfony\Component\Validator\Validator;

use Urbem\CoreBundle\Entity\Frota;

/**
 * Class VeiculoDocumentoEmpenhoModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Frota
 */
class VeiculoDocumentoEmpenhoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * VeiculoDocumentoEmpenhoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        /** @var ORM\EntityManager entityManager */
        $this->entityManager = $entityManager;
        /** @var ORM\EntityRepository repository */
        $this->repository = $this->entityManager->getRepository("CoreBundle:Frota\VeiculoDocumentoEmpenho");
    }

    /**
     * @param Frota\VeiculoDocumento $object
     * @param Form $form
     * @return Frota\VeiculoDocumentoEmpenho $veiculoDocumentoEmpenho
     */
    public function setVeiculoDocumentoEmpenho($object, $form)
    {
        $em = $this->entityManager;

        $veiculoDocumentoEmpenho = new Frota\VeiculoDocumentoEmpenho();
        $veiculoDocumentoEmpenho->setFkFrotaVeiculoDocumento($object);
        $veiculoDocumentoEmpenho->setCodEmpenho($form->get('codEmpenho')->getData());
        $veiculoDocumentoEmpenho->setCodEntidade($form->get('codEntidade')->getData()->getCodEntidade());
        $veiculoDocumentoEmpenho->setExercicioEmpenho($form->get('exercicioEmpenho')->getData());

        return $veiculoDocumentoEmpenho;
    }
}
