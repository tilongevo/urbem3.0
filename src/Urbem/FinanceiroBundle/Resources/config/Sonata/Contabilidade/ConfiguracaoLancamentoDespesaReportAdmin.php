<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Contabilidade;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Administracao\Gestao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Administracao\Relatorio;
use Urbem\CoreBundle\Entity\Orcamento\ContaDespesa;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ConfiguracaoLancamentoDespesaReportAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_financeiro_contabilidade_relatorio_configuracao_lancamento_despesa';
    protected $baseRoutePattern = 'financeiro/contabilidade/relatorios/configuracao-lancamento-despesa';
    protected $layoutDefaultReport = '/bundles/report/gestaoFinanceira/fontes/RPT/contabilidade/report/design/relatorioConfiguracaoLancamentoDespesa.rptdesign';
    protected $legendButtonSave = ['icon' => 'receipt', 'text' => 'Gerar Relatório'];

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('create'));
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);
        $exercicio = $this->getExercicio();

        $formMapper
            ->add(
                'elemento',
                'entity',
                array(
                    'class' => ContaDespesa::class,
                    'label' => 'label.configuracaoLancamentoDespesa.elemento',
                    'placeholder' => 'label.selecione',
                    'mapped' => false,
                    'required' => false,
                    'choice_value' => 'codEstrutural',
                    'choice_label' => function (ContaDespesa $contaDespesa) {
                        return "{$contaDespesa->getCodEstrutural()} - {$contaDespesa->getDescricao()}";
                    },
                    'attr' => ['class' => 'select2-parameters'],
                    'query_builder' => function ($em) use ($exercicio) {
                        $qb = $em->createQueryBuilder('o');
                        $qb->where('o.exercicio = :exercicio');
                        $qb->setParameter('exercicio', $exercicio);
                        return $qb;
                    },
                )
            )
            ->add(
                'tipoLancamento',
                'choice',
                array(
                    'placeholder' => 'label.selecione',
                    'choices' => array(
                        'Empenho' => 'empenho',
                        'Liquidação' => 'liquidacao',
                        'Almoxarifado' => 'almoxarifado'
                    ),
                    'mapped' => false,
                    'required' => false,
                    'label' => 'label.configuracaoLancamentoDespesa.tipoLancamento',
                )
            )
        ;
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $exercicio = $this->getExercicio();
        $fileName = $this->parseNameFile("configuracaoLancamentoDespesa");

        $params = [
            'cod_classificacao' => $this::getCodigoClassificacao(),
            'exercicio' => $exercicio,
            'tipo_lancamento' => $this::getTipoLancamento(),
            'cod_acao' => '2806',
            'inCodGestao' => Gestao::GESTAO_FINANCEIRA,
            'inCodModulo' => Modulo::MODULO_CONTABILIDADE,
            'inCodRelatorio' => Relatorio::FINANCEIRO_CONFIGURACAO_LANCAMENTO_DESPESA,
            'term_user' => $this->getCurrentUser()->getUserName()
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
     * @return string
     */
    private function getTipoLancamento()
    {
        $this->getForm()->get('tipoLancamento')->getData() == null
            ?
            $tipo_lancamento = ''
            :
            $tipo_lancamento = $this->getForm()->get('tipoLancamento')->getData();

        return $tipo_lancamento;
    }

    /**
     * @return string
     */
    private function getCodigoClassificacao()
    {
        $this->getForm()->get('elemento')->getData() == null
            ?
            $cod_classificacao = ''
            :
            $cod_classificacao = $this->getForm()->get('elemento')->getData()->getCodEstrutural();

        return $cod_classificacao;
    }
}
