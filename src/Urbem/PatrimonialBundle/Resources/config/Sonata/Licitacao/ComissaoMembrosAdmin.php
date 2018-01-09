<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Urbem\CoreBundle\Entity;

class ComissaoMembrosAdmin extends AbstractSonataAdmin
{

    protected $baseRouteName = 'urbem_patrimonial_licitacao_comissao_membros';
    protected $baseRoutePattern = 'patrimonial/licitacao/comissao-membros';

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $session = new Session();
        $codComissao = '2';
        $licitacaoTipoComissao = $session->get('licitacaoTipoComissao');
        if (isset($licitacaoTipoComissao)) {
            $codComissao = $licitacaoTipoComissao;
        }

        switch ($codComissao) {
            case '1':
                $stFiltro = [1, 2];
                break;
            case '2':
                $stFiltro = [1, 2, 3];
                break;
            case '3':
                $stFiltro = [1, 3];
                break;
            case '4':
                $stFiltro = [1];
                break;
        }

        $id = $this->getAdminRequestId();

        $fieldOptions['numcgm'] = [
            'required' => true,
            'label' => 'CGM',
            'attr' => [
                'class' => 'comissao-collection '
            ],
            'property' => 'nomCgm',
            'to_string_callback' => function (Entity\SwCgm $fornecedor, $property) {
                return $fornecedor->getNumcgm() . ' - ' . $fornecedor->getNomCgm();
            },
        ];

        $fieldOptions['dataComissao'] = [
            'required' => false,
            'label' => 'label.patrimonial.licitacao.dadosDesignacaoComissao',
            'mapped' => false,
            'attr' => [
                'readonly' => true
            ]
        ];

        $fieldOptions['vigencia'] = [
            'required' => false,
            'label' => 'label.patrimonial.licitacao.vigencia',
            'attr' => [
                'readonly' => true
            ],
            'mapped' => false
        ];

        $formMapper
            ->add(
                'fkSwCgm',
                'sonata_type_model_autocomplete',
                $fieldOptions['numcgm'],
                ['admin_code' => 'core.admin.filter.sw_cgm']
            )
            ->add(
                'fkNormasNorma',
                'autocomplete',
                [
                    'label' => 'label.patrimonial.licitacao.norma',
                    'multiple' => false,
                    'attr' => ['class' => 'select2-parameters '],
                    'class' => Entity\Normas\Norma::class,
                    'json_from_admin_code' => $this->code,
                    'json_query_builder' => function (EntityRepository $repo, $term, Request $request) {
                        return $repo->createQueryBuilder('o')
                            ->where('lower(o.nomNorma) LIKE lower(:nomNorma)')
                            ->setParameter('nomNorma', "%{$term}%");
                    },
                    'required' => true,
                ]
            )
            ->add('dataComissao', 'text', $fieldOptions['dataComissao'])
            ->add('vigencia', 'text', $fieldOptions['vigencia'])
            ->add('cargo', 'text', [
                'label' => 'label.patrimonial.licitacao.cargoMembro',
                'attr' => [
                    'style' => 'min-width:100px'
                ],
                'required' => true,
            ])
            ->add(
                'fkLicitacaoTipoMembro',
                'entity',
                [
                    'class' => 'CoreBundle:Licitacao\TipoMembro',
                    'choice_label' => function ($codTipoMembro) {
                        return $codTipoMembro->getDescricao();
                    },
                    'query_builder' => function (EntityRepository $repository) use ($stFiltro) {
                        /** @var QueryBuilder $qb */
                        $qb = $repository->createQueryBuilder('tipoMembro');
                        $qb->where($qb->expr()->in('tipoMembro.codTipoMembro', $stFiltro));
                        return $qb;
                    },
                    'placeholder' => 'Selecione',
                    'label' => 'label.patrimonial.licitacao.tipoMembro',
                    'required' => true,
                    'attr' => [
                        'class' => 'select2-parameters comissao-collection tipoMembro'
                    ]
                ]
            )
            ->add(
                'fkLicitacaoNaturezaCargo',
                'entity',
                [
                    'class' => 'CoreBundle:Licitacao\NaturezaCargo',
                    'choice_label' => function ($naturezaCargo) {
                        return $naturezaCargo->getDescricao();
                    },
                    'placeholder' => 'Selecione',
                    'label' => 'label.patrimonial.licitacao.naturezaCargo',
                    'required' => true,
                    'attr' => [
                        'class' => 'select2-parameters comissao-collection '
                    ]
                ]
            );
    }
}
