<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Protocolo;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

use Sonata\AdminBundle\Form\FormMapper;

use Symfony\Component\HttpFoundation\Request;

use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Model\SwCgmModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

/**
 * Class SwProcessoInteressadoAdmin
 *
 * @package Urbem\AdministrativoBundle\Resources\config\Sonata\Protocolo
 */
class SwProcessoInteressadoAdmin extends AbstractAdmin
{
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $formMapper
            ->add('fkSwCgm', 'autocomplete', [
                'attr'                 => ['class' => 'select2-parameters '],
                'class'                => SwCgm::class,
                'label'                => 'label.cgm',
                'json_from_admin_code' => $this->code,
                'json_query_builder'   =>
                    function (EntityRepository $repository, $term, Request $request) use ($entityManager) {
                        $swCgmQueryBuilder = (new SwCgmModel($entityManager))->findLikeQuery(['nomCgm'], $term);

                        return $swCgmQueryBuilder;
                    },
                'placeholder'          => $this->trans('label.selecione'),
                'required'             => true,

            ]);
    }
}
