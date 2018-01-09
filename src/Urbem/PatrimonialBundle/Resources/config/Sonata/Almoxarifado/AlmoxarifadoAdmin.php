<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Repository\SwCgmPessoaFisicaRepository;
use Urbem\CoreBundle\Repository\SwCgmRepository;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Model;

use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Entity\Almoxarifado;

use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\AlmoxarifadoModel;

/**
 * Class AlmoxarifadoAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado
 */
class AlmoxarifadoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_almoxarifado_almoxarifado';
    protected $baseRoutePattern = 'patrimonial/almoxarifado/almoxarifado';

    protected $model = Model\Patrimonial\Almoxarifado\AlmoxarifadoModel::class;

    protected $includeJs = [
        '/patrimonial/javascripts/almoxarifado/almoxarifado.js',
    ];

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add(
            'dados_almoxarifado',
            'dados-almoxarifado/' . $this->getRouterIdParameter()
        );
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $select2Params = ['attr' => ['class' => 'select2-parameters ']];

        $datagridMapperOptions = [];
        $datagridMapperOptions['fkSwCgm'] = [
            'choice_label' => 'nomCgm',
            'query_builder' => function (SwCgmRepository $repository) {
                $queryBuilder = $repository->createQueryBuilder('cgm');
                $queryBuilder
                    ->join('cgm.fkSwCgmPessoaJuridica', 'pessoaJuridica')
                    ->join('cgm.fkAlmoxarifadoAlmoxarifado', 'almoxarifado');

                return $queryBuilder;
            }
        ];

        $datagridMapperOptions['fkSwCgmPessoaFisica'] = [
            'choice_label' => 'fkSwCgm.nomCgm',
            'query_builder' => function (SwCgmPessoaFisicaRepository $repository) {
                $queryBuilder = $repository->createQueryBuilder('pessoaFisica');
                $queryBuilder
                    ->join(
                        Almoxarifado\Almoxarifado::class,
                        'almoxarifado',
                        'WITH',
                        'almoxarifado.fkSwCgmPessoaFisica = pessoaFisica'
                    );

                return $queryBuilder;
            }
        ];

        $datagridMapperOptions['fkSwCgm'] =
            array_merge($datagridMapperOptions['fkSwCgm'], $select2Params);

        $datagridMapperOptions['fkSwCgmPessoaFisica'] =
            array_merge($datagridMapperOptions['fkSwCgmPessoaFisica'], $select2Params);

        $datagridMapper
            ->add('fkSwCgm', null, [
                'label' => 'label.almoxarifado.cgmAlmoxarifado'
            ], null, $datagridMapperOptions['fkSwCgm'])
            ->add('fkSwCgmPessoaFisica', null, [
                'label' => 'label.almoxarifado.cgmResponsavel'
            ], null, $datagridMapperOptions['fkSwCgmPessoaFisica'], [
                'admin_code' => 'core.admin.filter.sw_cgm_pessoa_fisica'
            ]);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('fkSwCgm.nomCgm', null, [
                'label' => 'label.almoxarifado.cgmAlmoxarifado',
                'associated_property' => function (Entity\SwCgm $cgm) {
                    return strtoupper($cgm->getNomCgm());
                }
            ])
            ->add('fkSwCgmPessoaFisica', null, [
                'label' => 'label.almoxarifado.cgmResponsavel',
                'admin_code' => 'core.admin.filter.sw_cgm_pessoa_fisica',
                'associated_property' => function (Entity\SwCgmPessoaFisica $pessoaFisica) {
                    return strtoupper($pessoaFisica->getFkSwCgm()->getNomCgm());
                }
            ]);

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $objectId = $this->getAdminRequestId();

        $this->setBreadCrumb($objectId ? ['id' => $objectId] : []);

        $fieldOptions['fkSwCgm'] = [
            'label' => 'label.almoxarifado.cgmAlmoxarifado',
            'class' => Entity\SwCgm::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repository, $term, Request $request) {
                $queryBuilder = $repository->createQueryBuilder('swCgm');
                $queryBuilder
                    ->join('swCgm.fkSwCgmPessoaJuridica', 'pessoaJuridica');
                if (!is_numeric($term)) {
                    $queryBuilder->where(
                        $queryBuilder->expr()->like(
                            $queryBuilder->expr()->lower('swCgm.nomCgm'),
                            $queryBuilder->expr()->lower(':term')
                        )
                    )
                        ->setParameter('term', '%'.$term.'%');
                } else {
                    $term = (int) $term;
                    $queryBuilder
                        ->where('swCgm.numcgm = :term')
                        ->setParameter('term', $term);
                }

                $queryBuilder->orderBy('swCgm.nomCgm');
                return $queryBuilder;
            }
        ];

        $fieldOptions['telefone'] = [
            'label' => 'label.telefone',
            'mapped' => false,
            'required' => false,
            'attr' => ['readonly' => 'readonly']
        ];

        $fieldOptions['endereco'] = [
            'label' => 'label.servidor.endereco',
            'mapped' => false,
            'required' => false,
            'attr' => ['readonly' => 'readonly']
        ];

        $fieldOptions['fkSwCgmPessoaFisica'] = [
            'label' => 'label.almoxarifado.cgmResponsavel',
            'class' => Entity\SwCgmPessoaFisica::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repository, $term, Request $request) {
                $queryBuilder = $repository->createQueryBuilder('SwCgmPessoaFisica');
                $queryBuilder
                    ->join('SwCgmPessoaFisica.fkSwCgm', 'swCgm');
                if (!is_numeric($term)) {
                    $queryBuilder->where(
                        $queryBuilder->expr()->like(
                            $queryBuilder->expr()->lower('swCgm.nomCgm'),
                            $queryBuilder->expr()->lower(':term')
                        )
                    )
                        ->setParameter('term', '%'.$term.'%');
                } else {
                    $term = (int) $term;
                    $queryBuilder
                        ->where('swCgm.numcgm = :term')
                        ->setParameter('term', $term);
                }

                $queryBuilder->orderBy('swCgm.nomCgm');
                return $queryBuilder;
            }
        ];

        $formMapper
            ->add('fkSwCgm', 'autocomplete', $fieldOptions['fkSwCgm'], [
                'admin_code' => 'core.admin.filter.sw_cgm'
            ])
            ->add('telefone', 'text', $fieldOptions['telefone'])
            ->add('endereco', 'text', $fieldOptions['endereco'])
            ->add('fkSwCgmPessoaFisica', 'autocomplete', $fieldOptions['fkSwCgmPessoaFisica'], [
                'admin_code' => 'core.admin.filter.sw_cgm_pessoa_fisica'
            ]);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add('fkSwCgm.nomCgm', null, [
                'label' => 'label.almoxarifado.cgmAlmoxarifado',
                'associated_property' => function (Entity\SwCgm $cgm) {
                    return strtoupper($cgm->getNomCgm());
                }
            ])
            ->add('fkSwCgm.foneComercial', null, [
                'label' => 'label.telefone'
            ])
            ->add('fkSwCgm', null, [
                'label' => 'label.servidor.endereco',
                'associated_property' => function (Entity\SwCgm $cgm) {
                    return sprintf(
                        "%s, %s, %s",
                        trim($cgm->getLogradouro()),
                        trim($cgm->getNumero()),
                        trim($cgm->getBairro())
                    );
                }
            ])
            ->add('fkSwCgmPessoaFisica', null, [
                'label' => 'label.almoxarifado.cgmResponsavel',
                'admin_code' => 'core.admin.filter.sw_cgm_pessoa_fisica',
                'associated_property' => function (Entity\SwCgmPessoaFisica $pessoaFisica) {
                    return strtoupper($pessoaFisica->getFkSwCgm()->getNomCgm());
                }
            ]);
    }
}
