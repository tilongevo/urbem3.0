<?php

namespace Urbem\AdministrativoBundle\Controller\Protocolo;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\Form\Form;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class AbstractProcessoController
 *
 * @package Urbem\AdministrativoBundle\Controller\Protocolo
 */
class AbstractProcessoController extends CRUDController
{
    /** @var AbstractSonataAdmin */
    protected $admin;

    /**
     * @return SwProcesso
     */
    protected function getSwProcesso()
    {
        $request = $this->getRequest();
        $swProcessoKey = $request->get($this->admin->getIdParameter());

        /** @var SwProcesso $swProcesso */
        $swProcesso = $this->admin->getObject($swProcessoKey);

        return $swProcesso;
    }

    /**
     * @return Form
     */
    protected function getForm()
    {
        $request = $this->getRequest();
        $swProcesso = $this->getSwProcesso();

        /** @var $form Form */
        $form = $this->admin->getForm();
        $form->setData($swProcesso);
        $form->handleRequest($request);

        return $form;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function redirectToSwProcessoShowPage()
    {
        return $this->redirectToRoute('urbem_administrativo_protocolo_processo_show', [
            'id' => $this->admin->getNormalizedIdentifier($this->getSwProcesso())
        ]);
    }
    /**
     * @param string $message
     * @param array  $params
     * @param string $domain
     * @param string $type
     */
    protected function addFlashMessage($message, array $params = [], $domain = 'flashes', $type = 'success')
    {
        $flashMessage = $this->trans($message, $params, $domain);
        $this->container->get('session')->getFlashBag()->add($type, $flashMessage);
    }
}
