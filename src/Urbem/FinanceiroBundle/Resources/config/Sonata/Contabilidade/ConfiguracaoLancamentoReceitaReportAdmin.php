<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Contabilidade;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Administracao\Gestao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Administracao\Relatorio;
use Urbem\CoreBundle\Entity\Orcamento\ContaReceita;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ConfiguracaoLancamentoReceitaReportAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_financeiro_contabilidade_relatorio_configuracao_lancamento_receita';
    protected $baseRoutePattern = 'financeiro/contabilidade/relatorios/configuracao-lancamento-receita';
    protected $layoutDefaultReport = '/bundles/report/gestaoFinanceira/fontes/RPT/contabilidade/report/design/relatorioConfiguracaoLancamentoReceita.rptdesign';
    protected $legendButtonSave = ['icon' => 'receipt', 'text' => 'Gerar Relatório'];

    /**
    +     * @param RouteCollection $collection
    +     */
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
                    'class' => ContaReceita::class,
                    'label' => 'label.configuracaoLancamentoReceita.elemento',
                    'placeholder' => 'label.selecione',
                    'mapped' => false,
                    'required' => false,
                    'choice_value' => 'codEstrutural',
                    'choice_label' => function (ContaReceita $receita) {
                            return "{$receita->getCodEstrutural()} - {$receita->getDescricao()}";
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
        ;
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $exercicio = $this->getExercicio();
        $fileName = $this->parseNameFile("configuracaoLancamentoReceita");

        $params = [
                'cod_classificacao_receita' => $this::getCodigoClassificacao(),
                'exercicio' => $exercicio,
                'cod_acao' => '2808',
                'inCodGestao' => Gestao::GESTAO_FINANCEIRA,
                'inCodModulo' => Modulo::MODULO_CONTABILIDADE,
                'inCodRelatorio' => Relatorio::FINANCEIRO_CONFIGURACAO_LANCAMENTO_RECEITA,
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
