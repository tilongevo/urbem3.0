<?php

namespace Urbem\CoreBundle\Resources\config\Sonata\Filter\Empenho;

use function foo\func;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Empenho\Empenho;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Repository\Empenho\EmpenhoRepository;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

// code: core.admin.filter.empenho_empenho
class EmpenhoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_core_filter_empenho_empenho';
    protected $baseRoutePattern = 'core/filter/empenho_empenho';

    public function __construct($code, $class, $baseControllerName)
    {
        parent::__construct($code, Empenho::class, $baseControllerName);
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
        $form->add('autocomplete_nota_fiscal_empenho_field', 'autocomplete', [
            'class' => Empenho::class,
            'json_choice_label' => function (Empenho $empenho) {
                return sprintf('%s (%s)', (string) $empenho, $empenho->getFkEmpenhoPreEmpenho()->getFkSwCgm());
            },
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EmpenhoRepository $repo, $term, Request $request) {
                $entidade = $request->get('cascade_entidade');
                $entidade = $this->getConfigurationPool()
                    ->getContainer()
                    ->get('doctrine.orm.entity_manager')
                    ->getRepository(Entidade::class)
                    ->getByKey($entidade);

                $exercicio = $request->get('cascade_exercicio');

                return $repo->getEmpenhoNotaAsQueryBuilder($term, $entidade, $exercicio);
            },
        ]);

        $form->add('autocomplete_empenho_complementar_field', 'autocomplete', [
            'class' => Empenho::class,
            'json_choice_label' => function (Empenho $empenho) {
                return sprintf('%s (%s)', (string) $empenho, $empenho->getFkEmpenhoPreEmpenho()->getFkSwCgm());
            },
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EmpenhoRepository $repo, $term, Request $request) {
                $entidade = $request->get('cascade_entidade');
                $entidade = $this->getConfigurationPool()
                    ->getContainer()
                    ->get('doctrine.orm.entity_manager')
                    ->getRepository(Entidade::class)
                    ->getByKey($entidade);

                $exercicio = $request->get('cascade_exercicio');

                return $repo->getEmpenhoComplementarAsQueryBuilder($term, $entidade, $exercicio);
            },
        ]);
    }
}
