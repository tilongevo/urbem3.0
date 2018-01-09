<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Economico;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Economico\Atividade;
use Urbem\CoreBundle\Entity\Economico\VigenciaAtividade;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class RelatorioAtividadeAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_economico_relatorio_atividade';
    protected $baseRoutePattern = 'tributario/cadastro-economico/relatorios/atividades';
    protected $legendButtonSave = ['icon' => 'save', 'text' => 'Gerar Relatório'];

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $routes)
    {
        $routes->add('filtro', '');

        $routes->clearExcept(['create', 'filtro']);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->setBreadCrumb();

        $fieldOptions = [];
        $fieldOptions['vigencia'] = [
            'class' => VigenciaAtividade::class,
            'mapped' => false,
            'placeholder' => 'Selecione',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'label' => 'label.economicoRelatorioAtividade.vigencia'
        ];

        $fieldOptions['nomAtividade'] = [
            'mapped' => false,
            'required' => false,
            'label' => 'label.economicoRelatorioAtividade.nomAtividade'
        ];

        $fieldOptions['atividadeInicial'] = [
            'class' => Atividade::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');

                $qb->andWhere('(o.codEstrutural LIKE :term OR LOWER(o.nomAtividade) LIKE LOWER(:term))');
                $qb->setParameter('term', sprintf('%%%s%%', $term));

                $qb->orderBy('o.codEstrutural', 'ASC');

                return $qb;
            },
            'json_choice_value' => function (Atividade $atividade) {
                return $atividade->getCodAtividade();
            },
            'required' => false,
            'attr' => [
                'class' => 'select2-parameters',
            ],
            'label' => 'label.economicoRelatorioAtividade.atividadeInicial',
        ];

        $fieldOptions['atividadeFinal'] = [
            'class' => Atividade::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');

                $qb->andWhere('(o.codEstrutural LIKE :term OR LOWER(o.nomAtividade) LIKE LOWER(:term))');
                $qb->setParameter('term', sprintf('%%%s%%', $term));

                $qb->orderBy('o.codEstrutural', 'ASC');

                return $qb;
            },
            'json_choice_value' => function (Atividade $atividade) {
                return $atividade->getCodAtividade();
            },
            'required' => false,
            'attr' => [
                'class' => 'select2-parameters',
            ],
            'label' => 'label.economicoRelatorioAtividade.atividadeFinal',
        ];

        $fieldOptions['ordenacao'] = [
            'choices' => [
                'Código Atividade' => 'codEstrutural',
                'Descrição Atividade' => 'nomAtividade',
            ],
            'mapped' => false,
            'placeholder' => 'Selecione',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'label' => 'label.economicoRelatorioAtividade.ordernacao'
        ];

        $formMapper
            ->with('label.economicoRelatorioAtividade.cabecalhoFiltro')
                ->add('vigencia', 'entity', $fieldOptions['vigencia'])
                ->add('nomAtividade', 'text', $fieldOptions['nomAtividade'])
                ->add(
                    'atividadeInicial',
                    'autocomplete',
                    $fieldOptions['atividadeInicial'],
                    [
                        'admin_code' => 'tributario.admin.economico_atividade'
                    ]
                )
                ->add(
                    'atividadeFinal',
                    'autocomplete',
                    $fieldOptions['atividadeFinal'],
                    [
                        'admin_code' => 'tributario.admin.economico_atividade'
                    ]
                )
                ->add('ordenacao', 'choice', $fieldOptions['ordenacao'])
            ->end();
    }
}
