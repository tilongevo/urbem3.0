<?php

namespace Urbem\TributarioBundle\Controller\Economico;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Economico\BaixaCadastroEconomico;

/**
 * Class AtividadeCadastroEconomicoAdminController
 * @package Urbem\TributarioBundle\Controller\Economico
 */
class AtividadeCadastroEconomicoAdminController extends CRUDController
{
    protected $em;

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function definirAction(Request $request)
    {
        $this->em = $this->getDoctrine()->getEntityManager();

        $baixaCadastroEconomico = $this->em->getRepository(BaixaCadastroEconomico::class)
            ->findOneBy(['inscricaoEconomica' => $request->get('id'), 'dtTermino' => null], ['timestamp' => 'desc']);

        if ($baixaCadastroEconomico) {
            return $this->redirect($request->server->get('HTTP_REFERER'));
        }

        return $this->editAction();
    }
}
