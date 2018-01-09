<?php

namespace Urbem\CoreBundle\Resources\config\Sonata\Debug;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Administracao\Rota;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Class SwCgmPessoaFisicaAdmin
 * @package Urbem\CoreBundle\Resources\config\Sonata\Filter
 *
 * PATH: autocomplete/debug/admin/create
 * SERVICE: core.admin.autocomplete.debug
 * ROUTE: app/config/dev/routing.yml + src/Urbem/CoreBundle/Resources/config/routing.yml
 * CONTROLLER: src/Urbem/CoreBundle/Controller/AutoCompleteController.php
 */
class AutoCompleteAdmin extends AbstractAdmin
{
    protected $baseRoutePattern = 'autocomplete/debug/admin';

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('list');
        $collection->remove('batch');
        $collection->remove('edit');
        $collection->remove('delete');
        $collection->remove('show');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('id');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('numcgm')
            ->add('codCategoriaCnh');
        ;
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form->with('Sem Entidade');

        $form->add('no_entity_autocomplete', 'autocomplete', [
            'route' => [
                /* src/Urbem/CoreBundle/Controller/AutoCompleteController.php */
                /* app/config/dev/routing.yml */
                'name' => 'autocomplete_debug_without_entity',
            ],
            'label' => 'Simples',
            'data' => ['Item 1'],
            'required' => false, // debug purpose
            'mapped' => false, // debug purpose
        ]);

        $form->add('no_entity_autocomplete_multiple', 'autocomplete', [
            'route' => [
                /* src/Urbem/CoreBundle/Controller/AutoCompleteController.php */
                /* app/config/dev/routing.yml */
                'name' => 'autocomplete_debug_without_entity',
            ],
            'label' => 'Múltiplo',
            'data' => ['Item 1', 'Item 2'],
            'multiple' => true,
            'required' => false, // debug purpose
            'mapped' => false, // debug purpose
        ]);

        $form->end();

        $form->with('Com Entidade');

        $swcgm = $this->configurationPool->getContainer()->get('doctrine')->getRepository(SwCgm::class);
        $swcgm = $swcgm->createQueryBuilder('o')->setMaxResults(2)->getQuery()->getResult();

        $form->add('default_entity_autocomplete', 'autocomplete', [
            'class' => SwCgm::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repo, $term, Request $request) {
                return $repo->createQueryBuilder('o')
                            ->where('o.nomCgm LIKE :nomCgm')
                            ->setParameter('nomCgm', "%{$term}%");
            },
            'label' => 'Simples (busca por SwCgm.nomCgm)',
            'data' => reset($swcgm), // debug purpose
            'required' => false, // debug purpose
            'mapped' => false, // debug purpose
        ]);

        $form->add('default_entity_autocomplete_dynamic_query_builder', 'autocomplete', [
            'class' => Rota::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder_fields' => ['descricaoRota', 'traducaoRota'],
            'json_choice_label' => function (Rota $rota) {
                return sprintf('%s - %s', $rota->getDescricaoRota(), $rota->getTraducaoRota());
            },
            'label' => 'Simples + QueryBuilder Dinamico (busca por Rota.descricaoRota ou Rota.traducaoRota)',
            'required' => false, // debug purpose
            'mapped' => false, // debug purpose

        ]);

        $form->add('default_entity_autocomplete_multiple', 'autocomplete', [
            'class' => SwCgm::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repo, $term, Request $request) {
                return $repo->createQueryBuilder('o')
                    ->where('o.nomCgm LIKE :nomCgm')
                    ->setParameter('nomCgm', "%{$term}%");
            },
            'label' => 'Múltiplo (busca por SwCgm.nomCgm)',
            'multiple' => true,
            'data' => $swcgm, // debug purpose
            'mapped' => false, // debug purpose
            'required' => false, // debug purpose
        ]);

        $form->add('default_entity_autocomplete_multiple_dynamic_query_builder', 'autocomplete', [
            'class' => Rota::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder_fields' => ['descricaoRota', 'traducaoRota'],
            'json_choice_label' => function (Rota $rota) {
                return sprintf('%s - %s', $rota->getDescricaoRota(), $rota->getTraducaoRota());
            },
            'label' => 'Múltiplo + QueryBuilder Dinamico (busca por Rota.descricaoRota ou Rota.traducaoRota)',
            'multiple' => true,
            'mapped' => false, // debug purpose
            'required' => false, // debug purpose
        ]);

        $form->add('default_entity_autocomplete_with_custom_label', 'autocomplete', [
            'class' => SwCgm::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repo, $term, Request $request) {
                return $repo->createQueryBuilder('o')
                    ->where('o.nomCgm LIKE :nomCgm')
                    ->setParameter('nomCgm', "%{$term}%");
            },
            'label' => 'Label (busca por SwCgm.nomCgm)',
            'json_choice_label' => function (SwCgm $swCgm) {
                return 'CUSTOM ' . (string) $swCgm;
            },
            'data' => reset($swcgm), // debug purpose
            'required' => false, // debug purpose
            'mapped' => false, // debug purpose
        ]);

        $form->end();

        $form->with('Retornando Array no QueryBuilder');

        $form->add('default_entity_autocomplete_as_array', 'autocomplete', [
            'class' => SwCgm::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repo, $term, Request $request) {
                return $repo->createQueryBuilder('o')
                    ->where('o.nomCgm LIKE :nomCgm')
                    ->setParameter('nomCgm', "%{$term}%");
            },
            'label' => 'Simples (busca por SwCgm.nomCgm)',
            'json_get_querybuilder_result' => function (QueryBuilder $queryBuilder) {
                return $queryBuilder->getQuery()->getArrayResult();
            },
            /* after submit is an Entity */
            'json_choice_label' => function ($entity) {
                return $entity instanceof SwCgm ? $entity->getNomCgm() : $entity['nomCgm'];
            },
            'data' => reset($swcgm), // debug purpose
            'required' => false, // debug purpose
            'mapped' => false, // debug purpose
        ]);


        $form->add('default_entity_autocomplete_as_array_multiple_default', 'autocomplete', [
            'class' => SwCgm::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repo, $term, Request $request) {
                return $repo->createQueryBuilder('o')
                    ->where('o.nomCgm LIKE :nomCgm')
                    ->setParameter('nomCgm', "%{$term}%");
            },
            'label' => 'Múltiplo (busca por SwCgm.nomCgm)',
            'json_get_querybuilder_result' => function (QueryBuilder $queryBuilder) {
                return $queryBuilder->getQuery()->getArrayResult();
            },
            'multiple' => true,
            'data' => $swcgm, // debug purpose
            'required' => false, // debug purpose
            'mapped' => false, // debug purpose
        ]);

        $form->add('default_entity_autocomplete_as_array_multiple_custom', 'autocomplete', [
            'class' => SwCgm::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repo, $term, Request $request) {
                return $repo->createQueryBuilder('o')
                    ->where('o.nomCgm LIKE :nomCgm')
                    ->setParameter('nomCgm', "%{$term}%");
            },
            'label' => 'Múltiplo + Label (busca por SwCgm.nomCgm)',
            'json_get_querybuilder_result' => function (QueryBuilder $queryBuilder) {
                return $queryBuilder->getQuery()->getArrayResult();
            },
            /* after submit `$entity` is an Entity */
            'json_choice_label' => function ($entity) {
                return 'CUSTOM ' . ($entity instanceof SwCgm ? $entity->getNomCgm() : $entity['nomCgm']);
            },
            'multiple' => true,
            'data' => $swcgm, // debug purpose
            'required' => false, // debug purpose
            'mapped' => false, // debug purpose
        ]);

        $form->end();
    }

    public function prePersist($object)
    {
        dump('----- DEBUG -----');

        dump($_REQUEST[$this->uniqid]);

        $debug = [];

        $form = $this->getForm();

        foreach ($form as $child) {
            $debug[$child->getName()] = [
                'data' => $form->get($child->getName())->getData(),
                'view' => $form->get($child->getName())->getViewData()
            ];
        }

        dump($debug);
        exit;
    }
}
