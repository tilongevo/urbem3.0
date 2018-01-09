<?php

namespace Urbem\PortalServicosBundle\Resources\config\Sonata;

use Doctrine\ORM\EntityManager;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Model\Administracao\GrupoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class PortalServicosAbstractSonataAdmin
 *
 * @package Urbem\PortalServicosBundle\Resources\config\Sonata
 */
class PortalServicosAbstractAdmin extends AbstractSonataAdmin
{
    /**
     * @param string      $action
     * @param null|object $object
     *
     * @return Response|boolean
     */
    public function checkAccess($action, $object = null)
    {
        if (!in_array("ROLE_MUNICIPE", $this->getCurrentUser()->getRoles())) {
            return (new RedirectResponse('/portal-cidadao'))->send();
        }

        return true;
    }
}
