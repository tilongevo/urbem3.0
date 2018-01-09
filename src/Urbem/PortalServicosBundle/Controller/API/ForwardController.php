<?php

namespace  Urbem\PortalServicosBundle\Controller\API;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;

/**
 * Class APIFowardController
 *
 * @package Urbem\PortalServicosBundle\Controller\API
 */
class ForwardController extends BaseController
{
    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function logradouroApiAction(Request $request)
    {
        $response = $this->forward('AdministrativoBundle:SwLogradouroAdmin:apiLogradouro', [
            'id'            => $request->get('id'),
            '_sonata_admin' => 'administrativo.admin.sw_logradouro',
        ]);

        return $response;
    }
}
