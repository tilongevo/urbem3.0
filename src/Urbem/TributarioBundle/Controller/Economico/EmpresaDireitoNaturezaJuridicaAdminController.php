<?php

namespace Urbem\TributarioBundle\Controller\Economico;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomico;
use Urbem\CoreBundle\Entity\Economico\BaixaCadastroEconomico;

/**
 * Class EmpresaDireitoNaturezaJuridicaAdminController
 * @package Urbem\TributarioBundle\Controller\Economico
 */
class EmpresaDireitoNaturezaJuridicaAdminController extends CRUDController
{
    protected $em;

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function alterarAction(Request $request)
    {
        $this->em = $this->getDoctrine()->getEntityManager();

        $cadastroEconomico = $this->em->getRepository(CadastroEconomico::class)->find($request->get('id'));
        $baixaCadastroEconomico = $this->em->getRepository(BaixaCadastroEconomico::class)
            ->findOneBy(['inscricaoEconomica' => $request->get('id'), 'dtTermino' => null], ['timestamp' => 'desc']);

        if ((!$cadastroEconomico || !$cadastroEconomico->getFkEconomicoCadastroEconomicoEmpresaDireito())
            || $baixaCadastroEconomico) {
            return $this->redirect($request->server->get('HTTP_REFERER'));
        }

        return $this->editAction();
    }
}
