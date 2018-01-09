<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Arrecadacao;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Urbem\CoreBundle\Entity\Monetario\Agencia;
use Urbem\CoreBundle\Entity\Monetario\Banco;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ResumoLotesReportAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_arrecadacao_relatorio_resumo_lotes';
    protected $baseRoutePattern = 'tributario/arrecadacao/relatorios/resumo-lotes';
    protected $legendButtonSave = ['icon' => 'save', 'text' => 'Gerar Relatório'];
    protected $includeJs = array(
        '/tributario/javascripts/arrecadacao/relatorio-resumo-lotes.js'
    );

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['create']);
        $collection->add('relatorio', 'relatorio');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->setBreadCrumb();
        $qs = $this->getRequest()->get('filter');
        $fieldOptions['codLoteInicial'] = [
            'mapped' => false,
            'required' => false,
            'label' => 'label.arrecadacaoResumoLotesReport.codLoteInicial'
        ];

        $fieldOptions['codLoteFinal'] = [
            'mapped' => false,
            'required' => false,
            'label' => 'label.arrecadacaoResumoLotesReport.codLoteFinal'
        ];

        $fieldOptions['dataLoteInicial'] = [
            'mapped' => false,
            'required' => false,
            'format' => 'dd/MM/yyyy',
            'dp_use_current' => false,
            'label' => 'label.arrecadacaoResumoLotesReport.dataLoteInicial'
        ];

        $fieldOptions['dataLoteFinal'] = [
            'mapped' => false,
            'required' => false,
            'format' => 'dd/MM/yyyy',
            'dp_use_current' => false,
            'label' => 'label.arrecadacaoResumoLotesReport.dataLoteFinal'
        ];

        $fieldOptions['tipoLote'] = [
            'label' => 'label.arrecadacaoResumoLotesReport.tipoLote',
            'choices' => array(
                'label.arrecadacaoResumoLotesReport.automatico' => true,
                'label.arrecadacaoResumoLotesReport.manual' => false,
                'label.arrecadacaoResumoLotesReport.ambos' => ''
            ),
            'mapped' => false,
            'required' => true,
        ];

        $fieldOptions['tipoRelatorio'] = [
            'label' => 'label.arrecadacaoResumoLotesReport.tipoRelatorio',
            'choices' => array(
                'label.economicoRelatorioContadores.sintetico' => 'sintetico',
                'label.economicoRelatorioContadores.analitico' => 'analitico'
            ),
            'mapped' => false,
            'required' => true,
        ];

        $fieldOptions['banco'] = [
            'label' => 'label.arrecadacaoResumoLotesReport.banco',
            'mapped' => false,
            'required' => false,
            'attr' => ['class' => 'select2-parameters js-select-banco '],
            'class' => Banco::class,
            'query_builder' => function ($em) {
                $qb = $em->createQueryBuilder('o');

                $qb->orderBy('o.numBanco', 'ASC');

                return $qb;
            },
            'choice_label' => function (Banco $banco) {
                return sprintf('%d - %s', $banco->getCodBanco(), $banco->getNomBanco());
            }
        ];

        $em = $this->modelManager->getEntityManager($this->getClass());

        $agencias = $em->getRepository(Agencia::class)
            ->findAll();

        foreach ($agencias as $agencia) {
            $agenciaArray[] = [
                $agencia->getNumAgencia() => $agencia->getNumAgencia()
            ];
        }

        $fieldOptions['agencia'] = [
            'label' => 'label.arrecadacaoResumoLotesReport.agencia',
            'choices' => array_shift($agenciaArray),
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'select2-parameters js-select-agencia',
            ],
        ];

        $fieldOptions['numcgm'] = [
            'label' => 'label.arrecadacaoResumoLotesReport.usuario',
            'class' => SwCgm::class,
            'required' => false,
            'route' => [
                'name' => 'api-search-swcgm-by-nomcgm'
            ],
        ];

        $formMapper
            ->with('label.arrecadacaoResumoLotesReport.dados')
            ->add('codLote', 'number', $fieldOptions['codLoteInicial'])
            ->add('codLoteFinal', 'number', $fieldOptions['codLoteFinal'])
            ->end()
            ->with(' ')
            ->add('dataLoteInicial', 'sonata_type_date_picker', $fieldOptions['dataLoteInicial'])
            ->add('dataLoteFinal', 'sonata_type_date_picker', $fieldOptions['dataLoteFinal'])
            ->end()
            ->with(' ')
            ->add('tipoLote', ChoiceType::class, $fieldOptions['tipoLote'])
            ->end()
            ->with(' ')
            ->add('codBanco', 'entity', $fieldOptions['banco'])
            ->add('codAgencia', ChoiceType::class, $fieldOptions['agencia'])
            ->add('exercicio', 'text', ['label' => 'label.arrecadacaoResumoLotesReport.exercicio', 'required' => false, 'data' => (new \DateTime())->format('Y')])
            ->add('numcgm', 'autocomplete', $fieldOptions['numcgm'])
            ->add('tipoRelatorio', ChoiceType::class, $fieldOptions['tipoRelatorio']);
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $params = [
            'codLote' => (!is_null($this->getForm()->get('codLote')->getData())) ? $this->getForm()->get('codLote')->getData() : null,
            'codLoteFinal' => (!is_null($this->getForm()->get('codLoteFinal')->getData())) ? $this->getForm()->get('codLoteFinal')->getData() : null,
            'dataLoteInicial' => (!is_null($this->getForm()->get('dataLoteInicial')->getData())) ? $this->getForm()->get('dataLoteInicial')->getData() : null,
            'dataLoteFinal' => (!is_null($this->getForm()->get('dataLoteFinal')->getData())) ? $this->getForm()->get('dataLoteFinal')->getData() : null,
            'tipoLote' => (!is_null($this->getForm()->get('tipoLote')->getData())) ? $this->getForm()->get('tipoLote')->getData() : null,
            'numBanco' => (!is_null($this->getForm()->get('codBanco')->getData())) ? $this->getForm()->get('codBanco')->getData()->getNumBanco() : null,
            'numAgencia' => (!is_null($this->getForm()->get('codAgencia')->getData())) ? $this->getForm()->get('codAgencia')->getData() : null,
            'exercicio' => (!is_null($this->getForm()->get('exercicio')->getData())) ? $this->getForm()->get('exercicio')->getData() : null,
            'numcgm' => (!is_null($this->getForm()->get('numcgm')->getData())) ? $this->getForm()->get('numcgm')->getData() : null,
            'tipoRelatorio' => $this->getForm()->get('tipoRelatorio')->getData()
        ];
        $this->forceRedirect($this->generateUrl('relatorio', $params));
    }
}
