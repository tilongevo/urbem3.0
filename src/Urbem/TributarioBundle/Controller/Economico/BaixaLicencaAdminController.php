<?php

namespace Urbem\TributarioBundle\Controller\Economico;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Economico\BaixaLicenca;

/**
 * Class BaixaLicencaAdminController
 * @package Urbem\TributarioBundle\Controller\Economico
 */
class BaixaLicencaAdminController extends CRUDController
{
    protected $em;

    /**
     * @return Response
     */
    public function baixarAction()
    {
        $this->em = $this->getDoctrine()->getEntityManager();

        $admin = $this->admin;
        $admin->codTipo = $admin::TIPO_BAIXA;

        $baixaLicenca = $this->em->getRepository(BaixaLicenca::class)
            ->findOneBy(
                [
                    'codLicenca' => $this->getRequest()->get('codLicenca'),
                    'exercicio' => $this->getRequest()->get('exercicio'),
                    'codTipo' => $admin->codTipo,
                    'dtTermino' => null
                ],
                [
                    'timestamp' => 'desc'
                ]
            );

        if ($baixaLicenca) {
            return $this->redirect($this->getRequest()->server->get('HTTP_REFERER'));
        }

        return parent::createAction();
    }

    /**
     * @return Response
     */
    public function suspenderAction()
    {
        $this->em = $this->getDoctrine()->getEntityManager();

        $admin = $this->admin;
        $admin->codTipo = $admin::TIPO_SUSPENSAO;

        if ($this->admin->getSuspensao()) {
            return $this->redirect($this->getRequest()->server->get('HTTP_REFERER'));
        }

        return parent::createAction();
    }

    /**
     * @return Response
     */
    public function cancelarSuspensaoAction(Request $request)
    {
        $this->em = $this->getDoctrine()->getEntityManager();

        $admin = $this->admin;
        $admin->codTipo = $admin::TIPO_SUSPENSAO;

        $id = $request->get($this->admin->getIdParameter());
        $object = $this->admin->getObject($id);

        if (!$this->admin->getSuspensao($object)) {
            return $this->redirect($this->getRequest()->server->get('HTTP_REFERER'));
        }

        return parent::editAction();
    }

    /**
     * @return Response
     */
    public function cassarAction()
    {
        $this->em = $this->getDoctrine()->getEntityManager();

        $admin = $this->admin;
        $admin->codTipo = $admin::TIPO_CASSACAO;

        $baixaLicenca = $this->em->getRepository(BaixaLicenca::class)
            ->findOneBy(
                [
                    'codLicenca' => $this->getRequest()->get('codLicenca'),
                    'exercicio' => $this->getRequest()->get('exercicio'),
                    'codTipo' => $admin->codTipo,
                    'dtTermino' => null
                ],
                [
                    'timestamp' => 'desc'
                ]
            );

        if ($baixaLicenca) {
            return $this->redirect($this->getRequest()->server->get('HTTP_REFERER'));
        }

        return parent::createAction();
    }
}
