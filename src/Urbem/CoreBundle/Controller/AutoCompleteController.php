<?php

namespace Urbem\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AutoCompleteController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        /** @var $admin \Sonata\AdminBundle\Admin\AdminInterface */
        try {
            $request->attributes->set('_route', 'autocomplete');

            $admin = $this->container->get('sonata.admin.pool')->getInstance($request->get('json_from_admin_code'));
            $admin->setRequest($request);

            /** @var $config \Symfony\Component\Form\FormConfigInterface */
            $config = $admin->getForm()->get($request->get('json_from_admin_field'))->getConfig();

            /** @var $queryBuilder \Doctrine\ORM\QueryBuilder */
            $queryBuilder = call_user_func_array($config->getOption('json_query_builder'), [$request]);

            $items = [];

            foreach (call_user_func_array($config->getOption('json_get_querybuilder_result'), [$queryBuilder]) as $result) {
                $items[] = [
                    'id' => call_user_func_array($config->getOption('json_choice_value'), [$result]),
                    'label' => call_user_func_array($config->getOption('json_choice_label'), [$result]),
                ];
            };

            return new JsonResponse([
                'items' => $items
            ]);
        } catch (\Exception $e) {
            return new JsonResponse([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function debugWithoutEntityAction()
    {
        $items = [];
        $items['items'] = [];

        for ($i = 1; $i <= 10; $i++) {
            $items['items'][] = [
                /* when there's no entity, id must be equal to label */
                'id' => 'Item ' . $i,
                'label' => 'Item ' . $i
            ];
        }

        return new JsonResponse($items);
    }
}
