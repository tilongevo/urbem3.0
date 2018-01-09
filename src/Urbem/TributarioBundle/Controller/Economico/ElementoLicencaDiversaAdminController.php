<?php

namespace Urbem\TributarioBundle\Controller\Economico;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Economico\LicencaDiversa;

/**
 * Class ElementoLicencaDiversaAdminController
 * @package Urbem\TributarioBundle\Controller\Economico
 */
class ElementoLicencaDiversaAdminController extends CRUDController
{
    protected $em;

    /**
     * @return Response
     */
    public function alterarAction(Request $request)
    {
        $this->em = $this->getDoctrine()->getEntityManager();

        $id = $request->get($this->admin->getIdParameter());
        $licencaDiversa = $this->admin->getObject($id);

        if (!$licencaDiversa) {
            return $this->redirect($this->getRequest()->server->get('HTTP_REFERER'));
        }

        return parent::editAction();
    }
}
