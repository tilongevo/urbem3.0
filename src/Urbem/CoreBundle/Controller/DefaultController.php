<?php

namespace Urbem\CoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Model;

class DefaultController extends BaseController
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $cidadaoModel = new Model\Cse\CidadaoModel($this->db);
        // replace this example code with whatever you need
        return $this->render(
            'CoreBundle::Default/index.html.twig',
            [
                'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
                'cidadao' => $cidadaoModel->getAllCidadao()
            ]
        );
    }
}
