<?php

namespace Urbem\CoreBundle\Resources\config\Sonata\Filter\Licitacao;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Compras\Modalidade;
use Urbem\CoreBundle\Entity\Licitacao\Licitacao;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Repository\Patrimonio\Licitacao\LicitacaoRepository;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

// service: core.admin.filter.licitacao_licitacao
class LicitacaoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_core_filter_licitacao_licitacao';
    protected $baseRoutePattern = 'core/filter/licitacao_licitacao';

    public function __construct($code, $class, $baseControllerName)
    {
        parent::__construct($code, Licitacao::class, $baseControllerName);
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
        $form->add('autocomplete_field', 'autocomplete', [
            'class' => Licitacao::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (LicitacaoRepository $repo, $term, Request $request) {
                $entidade = $request->get('cascade_entidade');
                $entidade = $this->getConfigurationPool()
                    ->getContainer()
                    ->get('doctrine.orm.entity_manager')
                    ->getRepository(Entidade::class)
                    ->getByKey($entidade);

                $modalidade = $request->get('cascade_modalidade');
                $modalidade = $this->getConfigurationPool()
                    ->getContainer()
                    ->get('doctrine.orm.entity_manager')
                    ->getRepository(Modalidade::class)
                    ->getByKey($modalidade);

                $exercicio = $request->get('cascade_exercicio');

                return $repo->getByTermAsQueryBuilder($term, $entidade, $modalidade, $exercicio);
            },
        ]);
    }
}
