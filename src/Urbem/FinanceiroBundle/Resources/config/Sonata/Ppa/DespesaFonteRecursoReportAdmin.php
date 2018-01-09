<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Ppa;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Administracao\Gestao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Administracao\Relatorio;
use Urbem\CoreBundle\Entity\Ppa\Ppa;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class DespesaFonteRecursoReportAdmin
 * @package Urbem\FinanceiroBundle\Resources\config\Sonata\Ppa
 */
class DespesaFonteRecursoReportAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_financeiro_ppa_relatorios_despesa_fonte_recursos';
    protected $baseRoutePattern = 'financeiro/plano-plurianual/ppa/relatorios/despesa-fonte-recursos';
    protected $layoutDefaultReport = '/bundles/report/gestaoFinanceira/fontes/RPT/ppa/report/design/despesaFonteRecurso.rptdesign';
    protected $legendButtonSave = ['icon' => 'receipt', 'text' => 'Gerar Relatório'];

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('create'));
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $entity = $this->getForm()->get('ppa')->getData();
        $exercicios = $this->getArrayExercicios($entity);
        $fileName = $this->parseNameFile("despesaFonteRecurso");
        $params = [
            'ano_inicio' => $entity->getAnoInicio(),
            'cod_ppa' => $entity->getCodPpa(),
            'exercicio' => $this->getExercicio(),
            'cod_acao' => '2732',
            'inCodGestao' => Gestao::GESTAO_FINANCEIRA,
            'inCodModulo' => Modulo::MODULO_PPA,
            'inCodRelatorio' => Relatorio::FINANCEIRO_DESPESA_FONTE_RECURSO,
            'term_user' => $this->getCurrentUser()->getUserName()
        ];

        $params = array_merge($params, $exercicios);

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
     * @param $entity
     * @return array
     */
    public function getArrayExercicios($entity)
    {
        $aInicial = $entity->getAnoInicio();
        $aFinal = $entity->getAnoFinal();
        $exercicios = [];
        $aux = 1;
        for ($i = $aInicial; $i <= $aFinal; $i++) {
            $exercicios['exercicio' . $aux++] = (int) $i;
        }
        return $exercicios;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->setBreadCrumb();

        $formMapper
            ->add(
                'ppa',
                'entity',
                array(
                    'class' => Ppa::class,
                    'label' => 'label.ppa.ppa',
                    'required' => true,
                    'placeholder' => 'label.selecione',
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                    'mapped' => false,
                )
            )
        ;
    }
}
