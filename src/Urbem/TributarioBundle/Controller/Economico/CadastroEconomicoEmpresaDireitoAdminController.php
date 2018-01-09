<?php

namespace Urbem\TributarioBundle\Controller\Economico;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomico;

/**
 * Class CadastroEconomicoEmpresaDireitoAdminController
 * @package Urbem\TributarioBundle\Controller\Economico
 */
class CadastroEconomicoEmpresaDireitoAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function converterEmpresaDireitoAction(Request $request)
    {
        $this->em = $this->getDoctrine()->getEntityManager();

        $cadastroEconomico = $this->em->getRepository(CadastroEconomico::class)->find($request->get('id'));
        if (!$cadastroEconomico || $cadastroEconomico->getFkEconomicoCadastroEconomicoEmpresaDireito()) {
            return $this->redirect($request->server->get('HTTP_REFERER'));
        }

        $this->admin->converterEmpresaDireito = true;

        return $this->editAction();
    }
}
