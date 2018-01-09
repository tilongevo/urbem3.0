<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Administracao\Gestao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Administracao\Relatorio;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class CargoReportAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_pessoal_relatorios_cargo';
    protected $baseRoutePattern = 'recursos-humanos/pessoal/relatorios/cargo';
    protected $layoutDefaultReport = '/bundles/report/gestaoRH/fontes/RPT/pessoal/report/design/cargos.rptdesign';
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

        $fieldOptions['apresentar'] = [
            'choices' => [
                'Padrões' => 'stApresentaPadroes',
                'Padrões com Valor' => 'stApresentaPadroesValor',
                'Progressões' => 'stApresentaProgressoes',
                'Saldo de Vagas' => 'stApresentaSaldoVagas',
                'Reajustes Salariais' => 'stApresentaReajustes',
                'Servidores' => 'stApresentaServidores'
            ],
            'required' => true,
            'expanded' => true,
            'multiple' => true,
            'label_attr' => ['class' => 'checkbox-sonata'],
            'attr' => ['class' => 'checkbox-sonata '],
            'mapped' => false
        ];

        $fieldOptions['ordenacao'] = [
            'choices' => [
                'Código' => 1,
                'Descrição' => 2,
                'CBO' => 3,
            ],
            'expanded' => false,
            'multiple' => false,
            'attr' => ['class' => 'select2-parameters '],
            'mapped' => false
        ];

        $formMapper
            ->add('stTipoFiltro', 'hidden', ['mapped' => false])
            ->add('boAgrupar', 'hidden', ['mapped' => false])
            ->add('boQuebrar', 'hidden', ['mapped' => false])
            ->add('stCodigos', 'hidden', ['mapped' => false])
            ->add('apresentar', 'choice', $fieldOptions['apresentar'])
            ->add('ordenacao', 'choice', $fieldOptions['ordenacao']);
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
        $periodoMovimentacao = new PeriodoMovimentacaoModel($em);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);

        $apresentar = $this->getForm()->get('apresentar')->getData();
        $ordenacao = $this->getForm()->get('ordenacao')->getData();
        $stTipoFiltro = !empty($this->getForm()->get('stTipoFiltro')->getData()) ? $this->getForm()->get('stTipoFiltro')->getData() : '';
        $boAgrupar = !empty($this->getForm()->get('boAgrupar')->getData()) ? 'true' : 'false';
        $boQuebrar = !empty($this->getForm()->get('boQuebrar')->getData()) ? 'true' : 'false';
        $stCodigos = !empty($this->getForm()->get('stCodigos')->getData()) ? $this->getForm()->get('stCodigos')->getData() : '';
        $exercicio = $this->getExercicio();

        $fileName = $this->parseNameFile("cargos");

        $stEntidade = '';
        $entidade = '2';
        $stCompetencia = $periodoFinal->getDtFinal()->format('Y-m-d');
        $params = [
            'inExercicio' => $exercicio,
            'exercicio' => $exercicio,
            'inCodGestao' => Gestao::GESTAO_RECURSOS_HUMANOS,
            'inCodModulo' => Modulo::MODULO_PESSOAL,
            'inCodRelatorio' => Relatorio::RECURSOS_HUMANOS_PESSOAL_CARGOS,
            'term_user' => $this->getCurrentUser()->getUserName(),
            'stCompetencia' => $stCompetencia,
            'stApresentaPadroes' => in_array('stApresentaPadroes', $apresentar),
            'stApresentaPadroesValor' => in_array('stApresentaPadroesValor', $apresentar),
            'stApresentaProgressoes' => in_array('stApresentaProgressoes', $apresentar),
            'stApresentaSaldoVagas' => in_array('stApresentaSaldoVagas', $apresentar),
            'stApresentaReajustes' => in_array('stApresentaReajustes', $apresentar),
            'stApresentaServidores' => in_array('stApresentaServidores', $apresentar),
            'stOrdenacao' => $ordenacao,
            'stTipoFiltro' => $stTipoFiltro,
            'boQuebrar' => (boolean) $boQuebrar,
            'boAgrupar' => (boolean) $boAgrupar,
            'entidade' => $entidade,
            'stEntidade' => $stEntidade,
            'stCompetencia' => $stCompetencia,
            'stCodigos' => $stCodigos,
            'cod_acao' => 1012
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
}
