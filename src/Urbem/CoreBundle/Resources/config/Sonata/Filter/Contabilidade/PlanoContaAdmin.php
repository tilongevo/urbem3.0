<?php

namespace Urbem\CoreBundle\Resources\config\Sonata\Filter\Contabilidade;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Contabilidade\PlanoConta;
use Urbem\CoreBundle\Repository\Contabilidade\PlanoContaRepository;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

// code: core.admin.filter.contabilidade_plano_conta
class PlanoContaAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_core_filter_contabilidade_plano_conta';
    protected $baseRoutePattern = 'core/filter/contabilidade_plano_conta';

    public function __construct($code, $class, $baseControllerName)
    {
        parent::__construct($code, PlanoConta::class, $baseControllerName);
    }

    /**
     * @param RouteCollection $routeCollection
     */
    protected function configureRoutes(RouteCollection $routeCollection)
    {
        $routeCollection->clearExcept([]);
    }

    protected function configureFormFields(FormMapper $form)
    {
        // gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterExt.php:177
        // gestaoFinanceira/fontes/PHP/contabilidade/popups/planoConta/LSPlanoConta.php:160
        $form->add('mg_conta_analitica_estrutural_extmmaa', 'autocomplete', [
            'class' => PlanoConta::class,
            'json_from_admin_code' => $this->code,
            'json_choice_label' => function (PlanoConta $planoConta) {
                return sprintf(
                    '%s/%s - %s (%s)',
                    $planoConta->getCodConta(),
                    $planoConta->getExercicio(),
                    $planoConta->getNomConta(),
                    $planoConta->getCodEstrutural()
                );
            },
            'json_query_builder' => function (PlanoContaRepository $repo, $term, Request $request) {
                return $repo->getTCEMgContaAnaliticaEstruturalExtmmaByExericioAndTermAsQueryBuilder($this->getExercicio(), $term);
            },
        ]);
    }
}
