<?php

namespace Urbem\RecursosHumanosBundle\Controller\Pessoal;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Urbem\CoreBundle\Entity\Pessoal\ServidorDependente;
use Urbem\CoreBundle\Model\Pessoal\PensaoModel;

class ServidorDependenteAdminController extends Controller
{
    public function inativarAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        /** @var ServidorDependente $servidorDependente */
        $servidorDependente = $this->admin->getSubject();
        $pensao = $servidorDependente->getFkPessoalPensoes()->last();

        $pensaoModel = new PensaoModel($em);
        $pensaoModel->removePensao($pensao);

        $message = $this->admin->trans('rh.pessoal.pensao.remove', [], 'flashes');
        $this->container->get('session')
                        ->getFlashBag()
                        ->add('success', $message);

        return $this->redirect("/recursos-humanos/pessoal/pensao-alimenticia/list");
    }
}
