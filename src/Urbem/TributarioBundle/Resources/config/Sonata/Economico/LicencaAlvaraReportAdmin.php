<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Economico;

use Doctrine\Common\Collections\ArrayCollection;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomico;
use Urbem\CoreBundle\Helper\ArrayHelper;
use Urbem\CoreBundle\Helper\ReportHelper;
use Urbem\CoreBundle\Model\Economico\CadastroEconomicoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class LicencaAlvaraReportAdmin
 * @package Urbem\TributarioBundle\Resources\config\Sonata\Economico
 */
class LicencaAlvaraReportAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_economico_relatorio_licenca_alvara';
    protected $baseRoutePattern = 'tributario/cadastro-economico/relatorios/licenca-alvara';
    protected $legendButtonSave = ['icon' => 'receipt', 'text' => 'Gerar Relatório'];

    protected $includeJs = [
        '/tributario/javascripts/economico/licenca-alvara.js'
    ];

    protected $periocidade = ['dia' => 'Dia', 'mes' => 'Mês', 'ano' => 'Ano', 'intervalo' => 'Intervalo'];
    protected $meses = [1 => 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('create'));
        $collection->add('relatorio', 'relatorio');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions['numeroLicenca'] = [
            'mapped' => false,
            'required' => false,
            'label' => 'label.licencaAlvaraReport.numeroLicenca'
        ];

        $fieldOptions['inscricaoEconomica'] = array(
            'attr'        => ['class' => 'select2-parameters '],
            'class'       => CadastroEconomico::class,
            'query_builder' => function ($em) {
                $qb = $em->createQueryBuilder('o');
                $qb->orderBy('o.inscricaoEconomica', 'ASC');
                return $qb;
            },
            'mapped' => false,
            'required' => false,
            'label' => 'label.licencaAlvaraReport.inscricaoEconomica'
        );

        $fieldOptions['periodicidade'] = array(
            'required' => false,
            'mapped' => false,
            'choices' => ArrayHelper::parseInvertArrayToChoice($this->periocidade),
            'label' => 'label.contabilidade.relatorios.periodicidade',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione',
        );

        $fieldOptions['mes'] = array(
            'required' => false,
            'mapped' => false,
            'choices' => ArrayHelper::parseInvertArrayToChoice($this->meses),
            'label' => 'label.contabilidade.relatorios.mes',
            'attr' => [
                'class' => 'select2-parameters '
            ],
        );

        $fieldOptions['dia'] = array(
            'label' => 'label.contabilidade.relatorios.dia',
            'mapped' => false,
            'required' => true,
            'format' => 'dd/MM/yyyy',
            'dp_use_current' => false,
            'dp_default_date' => date('d/m/Y')
        );

        $fieldOptions['ano'] = array(
            'required' => false,
            'mapped' => false,
            'label' => 'label.contabilidade.relatorios.ano',
        );

        $fieldOptions['intervaloDe'] = array(
            'label' => 'label.contabilidade.relatorios.intervaloDe',
            'mapped' => false,
            'required' => true,
            'format' => 'dd/MM/yyyy',
            'dp_use_current' => false,
            'dp_default_date' => '01/01/' . $this->getExercicio(),
            'dp_min_date' => '01/01/' . $this->getExercicio(),
            'dp_max_date' => '31/12/' . $this->getExercicio()
        );

        $fieldOptions['intervaloAte'] = array(
            'label' => 'label.contabilidade.relatorios.intervaloAte',
            'mapped' => false,
            'required' => true,
            'format' => 'dd/MM/yyyy',
            'dp_use_current' => false,
            'dp_default_date' => '01/01/' . $this->getExercicio(),
            'dp_min_date' => '01/01/' . $this->getExercicio(),
            'dp_max_date' => '31/12/' . $this->getExercicio()
        );

        $fieldOptions['situacao'] = [
            'choices' => array(
                'Ativa' => 'Ativa',
                'Vencida' => 'Vencida',
                'Baixada' => 'Baixada',
                'Suspensa' => 'Suspensa',
                'Cassada' => 'Cassada',
                'Todas' => 'Todas'
            ),
            'mapped' => false,
            'required' => true,
            'label' => 'label.licencaAlvaraReport.situacao'
        ];

        $formMapper
            ->add('numeroLicenca', NumberType::class, $fieldOptions['numeroLicenca'])
            ->add('inscricaoEconomica', EntityType::class, $fieldOptions['inscricaoEconomica'])
            ->add('periodicidade', ChoiceType::class, $fieldOptions['periodicidade'])
            ->add('mes', ChoiceType::class, $fieldOptions['mes'])
            ->add('ano', NumberType::class, $fieldOptions['ano'])
            ->add('dia', 'sonata_type_date_picker', $fieldOptions['dia'])
            ->add('intervaloDe', 'sonata_type_date_picker', $fieldOptions['intervaloDe'])
            ->add('intervaloAte', 'sonata_type_date_picker', $fieldOptions['intervaloAte'])
            ->add('situacao', ChoiceType::class, $fieldOptions['situacao'])
        ;
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $dia = $this->getForm()->get('dia')->getData();
        $mes = $this->getForm()->get('mes')->getData();
        $ano = $this->getForm()->get('ano')->getData();
        $intervaloDe = $this->getForm()->get('intervaloDe')->getData();
        $intervaloAte = $this->getForm()->get('intervaloAte')->getData();

        $periodos = array($dia, $mes, $ano, $intervaloDe, $intervaloAte);
        $periodicidade = $this->getForm()->get('periodicidade')->getData();
        $valores = ReportHelper::getValoresPeriodicidade(array_search($periodicidade, array_keys($this->periocidade)), $periodos, $ano, false);

        $params = array(
            'numeroLicenca' => $this->getForm()->get('numeroLicenca')->getData(),
            'inscricaoEconomica' => (!is_null($this->getForm()->get('inscricaoEconomica')->getData()) ? $this->getForm()->get('inscricaoEconomica')->getData()->getInscricaoEconomica() : null),
            'periodicidade' => $this->getForm()->get('periodicidade')->getData(),
            'mes' => $this->getForm()->get('mes')->getData(),
            'dia' => !is_null($this->getForm()->get('dia')->getData()) ? $this->getForm()->get('dia')->getData()->format('Y-m-d') : null,
            'ano' => $this->getForm()->get('ano')->getData(),
            'intervaloDe' => $valores['data_inicial'],
            'intervaloAte' => $valores['data_final'],
            'situacao' => $this->getForm()->get('situacao')->getData(),
        );

        $this->forceRedirect($this->generateUrl('relatorio', $params));
    }
}
