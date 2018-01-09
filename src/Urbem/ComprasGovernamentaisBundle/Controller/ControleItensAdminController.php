<?php

namespace Urbem\ComprasGovernamentaisBundle\Controller;

use Exception;
use Twig_Error_Runtime;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Administracao\Usuario;

class ControleItensAdminController extends CRUDController
{
    /**
     * @param Request $request
     */
    public function autorizarRequisicaoAction(Request $request)
    {
        $id = $request->get($this->admin->getIdParameter());
        $existingObject = $this->admin->getObject($id);

        if (!$existingObject) {
            throw $this->createNotFoundException(sprintf('unable to find the object with id : %s', $id));
        }

        $this->admin->checkAccess('autorizar_requisicao', $existingObject);

        $this->admin->setSubject($existingObject);

        $form = $this->admin->getForm();
        $form->setData($existingObject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash(
                'sonata_flash_error',
                $this->trans(
                    'flash_edit_error',
                    array('%name%' => $this->escapeHtml($this->admin->toString($existingObject))),
                    'SonataAdminBundle'
                )
            );
        }

        if (!$form->isSubmitted()) {
            $formView = $form->createView();
            $this->setFormTheme($formView, $this->admin->getFormTheme());

            return $this->render(
                $this->admin->getTemplate('edit'),
                [
                    'action' => 'edit',
                    'form' => $formView,
                    'object' => $existingObject,
                ],
                null
            );
        }

        try {
            $this->admin->autorizarRequisicao($existingObject);

            $this->container
                ->get('session')
                ->getFlashBag()
                ->add(
                    'success',
                    $this->get('translator')->trans('label.comprasGovernamentaisControleItens.autorizarRequisicaoSuccess')
                );

            $redirectUrl = $this->admin->generateObjectUrl('list', $existingObject);
        } catch (Exception $e) {
            $redirectUrl = $this->admin->generateObjectUrl('autorizar_requisicao', $existingObject);
        }

        return new RedirectResponse($redirectUrl);
    }

    /**
     * @param Request $request
     */
    public function autorizarSolicitacaoCompraAction(Request $request)
    {
        return new RedirectResponse($this->admin->generateUrl('list'));
    }

    /**
     * @param Request $request
     */
    public function recusarRequisicaoAction(Request $request)
    {
        $id = $request->get($this->admin->getIdParameter());
        $existingObject = $this->admin->getObject($id);

        if (!$existingObject) {
            throw $this->createNotFoundException(sprintf('unable to find the object with id : %s', $id));
        }

        $this->admin->checkAccess('recusar_requisicao', $existingObject);

        $this->admin->setSubject($existingObject);

        try {
            $this->admin->recusarRequisicao($existingObject);

            $this->container
                ->get('session')
                ->getFlashBag()
                ->add(
                    'success',
                    $this->get('translator')->trans('label.comprasGovernamentaisControleItens.recusarRequisicaoSuccess')
                );

            $redirectUrl = $this->admin->generateObjectUrl('list', $existingObject);
        } catch (Exception $e) {
            $this->container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('contactSupport'));

            $redirectUrl = $this->admin->generateObjectUrl('list', $existingObject);
        }

        return new RedirectResponse($redirectUrl);
    }

    /**
     * Sets the admin form theme to form view. Used for compatibility between Symfony versions.
     *
     * @param FormView $formView
     * @param string   $theme
     */
    private function setFormTheme(FormView $formView, $theme)
    {
        $twig = $this->get('twig');

        try {
            $twig
                ->getRuntime('Symfony\Bridge\Twig\Form\TwigRenderer')
                ->setTheme($formView, $theme);
        } catch (Twig_Error_Runtime $e) {
            $twig
                ->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')
                ->renderer
                ->setTheme($formView, $theme);
        }
    }
}
