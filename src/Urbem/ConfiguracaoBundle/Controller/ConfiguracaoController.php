<?php

namespace Urbem\ConfiguracaoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ConfiguracaoController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function autocompleteAction(Request $request)
    {
        /* src/Urbem/ConfiguracaoBundle/Admin/ConfiguracaoAdmin.php::getObject */
        $request->request->set('id', $request->get('service'));

        /* src/Urbem/CoreBundle/Controller/AutoCompleteController.php */
        $request->request->set('json_from_admin_code', 'configuracao.admin.configuracao');

        return $this->forward('CoreBundle:AutoComplete:index', [], $request->query->all());
    }
}
