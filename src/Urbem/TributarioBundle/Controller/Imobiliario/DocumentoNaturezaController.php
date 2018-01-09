<?php

namespace Urbem\TributarioBundle\Controller\Imobiliario;

use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\TributarioBundle\Resources\config\Sonata\Imobiliario\NaturezaTransferenciaAdmin;

/**
 * Class DocumentoNaturezaController
 * @package Urbem\TributarioBundle\Controller\Imobiliario
 */
class DocumentoNaturezaController extends BaseController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $results = [];
        foreach ((array) NaturezaTransferenciaAdmin::$obrigatorioArray as $key => $obrigatorio) {
            $results[$key] = [
                'label' => $this->get('translator')->trans($obrigatorio['label']),
                'value' => $obrigatorio['value']
            ];
        }

        return new JsonResponse($results);
    }
}
