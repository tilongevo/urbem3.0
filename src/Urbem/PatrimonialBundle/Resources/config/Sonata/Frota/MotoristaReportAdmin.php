<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Frota;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Administracao\Gestao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Administracao\Relatorio;
use Urbem\CoreBundle\Entity\Frota\Motorista;
use Urbem\CoreBundle\Entity\SwCgmPessoaFisica;
use Urbem\CoreBundle\Helper\ArrayHelper;
use Urbem\CoreBundle\Helper\ReportHelper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class MotoristaReportAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_frota_relatorios_motorista';
    protected $baseRoutePattern = 'patrimonial/frota/relatorios/motorista';
    protected $layoutDefaultReport = '/bundles/report/gestaoPatrimonial/fontes/RPT/frota/report/design/relatorioMotorista.rptdesign';
    protected $legendButtonSave = ['icon' => 'receipt', 'text' => 'Gerar relatório'];
    protected $periocidade = ['Dia','Mês','Ano','Intervalo'];
    protected $meses = [1 => 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
    protected $includeJs = ['/financeiro/javascripts/contabilidade/consistenciaPcaspReport/consistenciaPcaspReport.js'];

    const COD_ACAO = '159';

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $fileName = $this->parseNameFile("motorista");
        $motorista = $this->getFormField($this->getForm(), 'motorista');

        $dia = $this->getFormField($this->getForm(), 'dia');
        $mes = $this->getFormField($this->getForm(), 'mes');
        $ano = $this->getFormField($this->getForm(), 'ano');
        $intervaloDe = $this->getFormField($this->getForm(), 'intervaloDe');
        $intervaloAte = $this->getFormField($this->getForm(), 'intervaloAte');

        $periodos = array($dia, $mes, $ano, $intervaloDe, $intervaloAte);
        $periodicidade = $this->getFormField($this->getForm(), 'periodicidade');
        $valores = ReportHelper::getValoresPeriodicidade($periodicidade, $periodos, $this->getExercicio(), true);

        $params = [
            'term_user' => $this->getCurrentUser()->getUserName(),
            'exercicio' => $this->getExercicio(),
            'cod_acao' => self::COD_ACAO,
            'inCodGestao' => Gestao::GESTAO_PATRIMONIAL,
            'inCodModulo' => Modulo::MODULO_FROTA,
            'inCodRelatorio' => Relatorio::PATRIMONIAL_MOTORISTA,
            'inCGMMotorista' => $motorista ? (string) $motorista->getCgmMotorista() : null,
            'stDataInicio' => $valores['data_inicial'],
            'stDataFim' => $valores['data_final'],
        ];

        $apiService = $this->getReportService();
        $apiService->setReportNameFile($fileName);
        $apiService->setLayoutDefaultReport($this->layoutDefaultReport);
        $res = $apiService->getReportContent($params);

        $this->parseContentToPdf(
            $res->getBody()->getContents(),
            $fileName
        );
    }

    /**
     * @param $form
     * @param $fieldName
     * @return string
     */
    public function getFormField($form, $fieldName)
    {
        return ($form->get($fieldName)->getData()) ? $form->get($fieldName)->getData() : '';
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->setBreadCrumb();
        $exercicio = $this->getExercicio();
        $em = $this->getConfigurationPool()->getContainer()->get('doctrine')->getManager();
        $fieldOptions = [];

        $fieldOptions['motorista'] = [
            'attr' => ['class' => 'select2-parameters'],
            'class' => Motorista::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' =>
                function (EntityRepository $repo, $term, Request $request) use ($em) {
                    $qb = $repo->createQueryBuilder('o');
                    $qb->join('o.fkSwCgm', 'cgm');
                    $qb->where($qb->expr()->orX(
                        $qb->expr()->like('LOWER(cgm.nomCgm)', ':nomCgm'),
                        $qb->expr()->eq('cgm.numcgm', ':numcgm')
                    ));
                    $qb->setParameters([
                        'nomCgm' => sprintf('%%%s%%', strtolower($term)),
                        'numcgm' => ((int) $term) ? $term : null
                    ]);
                    return $qb;
                },
            'label' => 'label.motorista.cgmMotorista',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['periodicidade'] = [
            'required' => true,
            'mapped' => false,
            'choices' => ArrayHelper::parseInvertArrayToChoice($this->periocidade),
            'label' => 'label.contabilidade.relatorios.periodicidade',
            'attr' => ['class' => 'select2-parameters ']
        ];

        $fieldOptions['mes'] = [
            'required' => true,
            'mapped' => false,
            'choices' => ArrayHelper::parseInvertArrayToChoice($this->meses),
            'label' => 'label.contabilidade.relatorios.mes',
            'attr' => ['class' => 'select2-parameters '],
        ];

        $fieldOptions['dia'] = [
            'label' => 'label.contabilidade.relatorios.dia',
            'mapped' => false,
            'required' => true,
            'format' => 'dd/MM/yyyy',
            'dp_use_current' => false,
            'dp_default_date' => '01/01/'.$exercicio,
            'dp_min_date' => '01/01/'.$exercicio,
            'dp_max_date' => '31/12/'.$exercicio
        ];

        $fieldOptions['ano'] = [
            'required' => true,
            'mapped' => false,
            'label' => 'label.contabilidade.relatorios.ano',
            'data' => $exercicio,
            'attr' => ['readonly' => 'readonly']
        ];

        $fieldOptions['intervaloDe'] = [
            'label' => 'label.contabilidade.relatorios.intervaloDe',
            'mapped' => false,
            'required' => true,
            'format' => 'dd/MM/yyyy',
            'dp_use_current' => false,
            'dp_default_date' => '01/01/'.$exercicio,
            'dp_min_date' => '01/01/'.$exercicio,
            'dp_max_date' => '31/12/'.$exercicio
        ];

        $fieldOptions['intervaloAte'] = [
            'label' => 'label.contabilidade.relatorios.intervaloAte',
            'mapped' => false,
            'required' => true,
            'format' => 'dd/MM/yyyy',
            'dp_use_current' => false,
            'dp_default_date' => '01/01/'.$exercicio,
            'dp_min_date' => '01/01/'.$exercicio,
            'dp_max_date' => '31/12/'.$exercicio
        ];

        $formMapper
            ->add('motorista', 'autocomplete', $fieldOptions['motorista'])
            ->add('periodicidade', 'choice', $fieldOptions['periodicidade'])
            ->add('mes', 'choice', $fieldOptions['mes'])
            ->add('dia', 'sonata_type_date_picker', $fieldOptions['dia'])
            ->add('ano', 'number', $fieldOptions['ano'])
            ->add('intervaloDe', 'sonata_type_date_picker', $fieldOptions['intervaloDe'])
            ->add('intervaloAte', 'sonata_type_date_picker', $fieldOptions['intervaloAte']);
    }
}
