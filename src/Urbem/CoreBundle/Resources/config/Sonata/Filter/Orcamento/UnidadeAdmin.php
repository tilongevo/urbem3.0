<?php

namespace Urbem\CoreBundle\Resources\config\Sonata\Filter\Orcamento;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Orcamento\Orgao;
use Urbem\CoreBundle\Entity\Orcamento\Unidade;
use Urbem\CoreBundle\Form\Transform\EntityTransform;
use Urbem\CoreBundle\Repository\Orcamento\UnidadeRepository;

// code: core.admin.filter.orcamento_unidade
class UnidadeAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_core_filter_orcamento_unidade';
    protected $baseRoutePattern = 'core/filter/orcamento_unidade';

    public function __construct($code, $class, $baseControllerName)
    {
        parent::__construct($code, Unidade::class, $baseControllerName);
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
            'class' => Unidade::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (UnidadeRepository $repo, $term, Request $request) {
                return $repo->getByTermAsQueryBuilder($term);
            },
        ]);

        $form->add('autocomplete_field_by_orgao', 'autocomplete', [
            'class' => Unidade::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (UnidadeRepository $repo, $term, Request $request) {
                $exercicio = $request->get('cascade_exercicio');

                $orgao = $request->get('cascade_orgao');
                $orgao = 0 == $orgao ? null : $orgao;

                if (true === is_numeric($orgao)) {
                    $numOrgao = $orgao;

                    $orgao = new Orgao();
                    $orgao->setExercicio($exercicio);
                    $orgao->setNumOrgao($numOrgao);
                    $orgao->setNomOrgao($orgao);

                } else {
                    $em = $this->getConfigurationPool()->getContainer()->get('doctrine.orm.entity_manager');

                    $orgao = (new EntityTransform(
                        $em->getRepository(Orgao::class),
                        $em->getClassMetadata(Orgao::class)
                    ))->reverseTransform($orgao);

                    $orgao = null === $orgao ? $orgao : $orgao->first();
                }

                return $repo->getByExercicioAndOrgaoAsQueryBuilder($exercicio, $orgao);
            },
        ]);
    }
}
