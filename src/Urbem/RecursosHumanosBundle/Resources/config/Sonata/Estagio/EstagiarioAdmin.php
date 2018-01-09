<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Estagio;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\SwCgmPessoaFisica;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class EstagiarioAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_estagio_estagiario';

    protected $baseRoutePattern = 'recursos-humanos/estagio/estagiario';

    protected $includeJs = [
        '/recursoshumanos/javascripts/estagio/estagiarioForm.js'
    ];

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('numcgm', null, [
                'label' => 'label.estagio.cgm'
            ])
            ->add('nomPai', null, [
                'label' => 'label.nome_pai'
            ])
            ->add('nomMae', null, [
                'label' => 'label.nome_mae'
            ])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('fkSwCgmPessoaFisica', null, [
                'label' => 'label.estagio.cgm',
                'admin_code' => 'core.admin.filter.sw_cgm_pessoa_fisica'
            ])
            ->add('nomPai', null, [
                'label' => 'label.nome_pai'
            ])
            ->add('nomMae', null, [
                'label' => 'label.nome_mae'
            ])
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $fieldOptions['fkSwCgmPessoaFisica'] = [
            'label' => 'label.estagio.cgm',
            'class' => SwCgmPessoaFisica::class,
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

        $fieldOptions['rg'] = [
            'mapped' => false,
            'label' => 'RG',
            'attr' => [
                'readonly' => 'readonly'
            ]
        ];

        $fieldOptions['cpf'] = [
            'mapped' => false,
            'label' => 'CPF',
            'attr' => [
                'readonly' => 'readonly'
            ]
        ];

        $fieldOptions['endereco'] = [
            'mapped' => false,
            'label' => 'Endereço',
            'attr' => [
                'readonly' => 'readonly'
            ]
        ];

        $fieldOptions['tel_fixo'] = [
            'mapped' => false,
            'label' => 'Telefone Fixo',
            'attr' => [
                'readonly' => 'readonly'
            ]
        ];

        $fieldOptions['tel_cel'] = [
            'mapped' => false,
            'label' => 'Telefone Celular',
            'attr' => [
                'readonly' => 'readonly'
            ]
        ];

        $formMapper
            ->add('fkSwCgmPessoaFisica', 'autocomplete', $fieldOptions['fkSwCgmPessoaFisica'], [
                'admin_code' => 'core.admin.filter.sw_cgm_pessoa_fisica'
            ])
            ->add('rg', 'text', $fieldOptions['rg'])
            ->add('cpf', 'text', $fieldOptions['cpf'])
            ->add('endereco', 'text', $fieldOptions['endereco'])
            ->add('tel_fixo', 'text', $fieldOptions['tel_fixo'])
            ->add('tel_cel', 'text', $fieldOptions['tel_cel'])
            ->add('nomPai')
            ->add('nomMae');
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $estagiario = $this->getSubject();

        $estagios = $estagiario->getFkEstagioEstagiarioEstagios();

        $showMapper
            ->add('numcgm')
            ->add('nomPai')
            ->add('nomMae');
    }

    public function postPersist($object)
    {
        $this->forceRedirect(
            "/recursos-humanos/estagio/estagiario/{$this->getObjectKey($object)}/show"
        );
    }

    public function postUpdate($object)
    {
        $this->forceRedirect(
            "/recursos-humanos/estagio/estagiario/{$this->getObjectKey($object)}/show"
        );
    }
}
