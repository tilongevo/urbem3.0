<?php

namespace Urbem\ComprasGovernamentaisBundle\Controller;

use Exception;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Administracao\Usuario;

class RequisicaoAdminController extends CRUDController
{
    /**
     * @param Request $request
     */
    public function updateAction(Request $request)
    {
        $id = $request->get($this->admin->getIdParameter());
        $existingObject = $this->admin->getObject($id);

        if (!$existingObject) {
            throw $this->createNotFoundException(sprintf('unable to find the object with id : %s', $id));
        }

        $this->admin->checkAccess('edit', $existingObject);

        $this->admin->setSubject($existingObject);

        $this->admin->preUpdate($existingObject);

        try {
            $this->admin->update($existingObject);

            $this->container
                ->get('session')
                ->getFlashBag()
                ->add(
                    'success',
                    $this->get('translator')->trans('label.comprasGovernamentaisRequisicao.editSuccess')
                );

            $redirectUrl = $this->admin->generateObjectUrl('list', $existingObject);
        } catch (Exception $e) {
            $this->container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('contactSupport'));

            $redirectUrl = $this->admin->generateObjectUrl('list', $existingObject);
        }

        return new RedirectResponse($redirectUrl);
    }

    /**
     * @param Request $request
     */
    public function homologarAction(Request $request)
    {
        $id = $request->get($this->admin->getIdParameter());
        $existingObject = $this->admin->getObject($id);

        if (!$existingObject) {
            throw $this->createNotFoundException(sprintf('unable to find the object with id : %s', $id));
        }

        $this->admin->checkAccess('homologar', $existingObject);

        $this->admin->setSubject($existingObject);

        try {
            $this->admin->homologarRequisicao($existingObject);

            $this->container
                ->get('session')
                ->getFlashBag()
                ->add(
                    'success',
                    $this->get('translator')->trans('label.comprasGovernamentaisRequisicao.homologarSuccess')
                );

            $redirectUrl = $this->admin->generateObjectUrl('list', $existingObject);
        } catch (Exception $e) {
            $this->container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('contactSupport'));

            $redirectUrl = $this->admin->generateObjectUrl('list', $existingObject);
        }

        return new RedirectResponse($redirectUrl);
    }

    /**
     * @param Request $request
     */
    public function anularAction(Request $request)
    {
        $id = $request->get($this->admin->getIdParameter());
        $existingObject = $this->admin->getObject($id);

        if (!$existingObject) {
            throw $this->createNotFoundException(sprintf('unable to find the object with id : %s', $id));
        }

        $this->admin->checkAccess('anular', $existingObject);

        $this->admin->setSubject($existingObject);

        try {
            $this->admin->anularRequisicao($existingObject);

            $this->container
                ->get('session')
                ->getFlashBag()
                ->add(
                    'success',
                    $this->get('translator')->trans('label.comprasGovernamentaisRequisicao.anularSuccess')
                );

            $redirectUrl = $this->admin->generateObjectUrl('list', $existingObject);
        } catch (Exception $e) {
            $this->container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('contactSupport'));

            $redirectUrl = $this->admin->generateObjectUrl('list', $existingObject);
        }

        return new RedirectResponse($redirectUrl);
    }

    /**
     * @param Request $request
     */
    public function anularHomologacaoAction(Request $request)
    {
        $id = $request->get($this->admin->getIdParameter());
        $existingObject = $this->admin->getObject($id);

        if (!$existingObject) {
            throw $this->createNotFoundException(sprintf('unable to find the object with id : %s', $id));
        }

        $this->admin->checkAccess('anular_homologacao', $existingObject);

        $this->admin->setSubject($existingObject);

        try {
            $this->admin->anularHomologacao($existingObject);

            $this->container
                ->get('session')
                ->getFlashBag()
                ->add(
                    'success',
                    $this->get('translator')->trans('label.comprasGovernamentaisRequisicao.anularHomologacaoSuccess')
                );

            $redirectUrl = $this->admin->generateObjectUrl('list', $existingObject);
        } catch (Exception $e) {
            $this->container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('contactSupport'));

            $redirectUrl = $this->admin->generateObjectUrl('list', $existingObject);
        }

        return new RedirectResponse($redirectUrl);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function apiRequisitanteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $results = ['items' => []];
        if (!$request->get('q')) {
            return new JsonResponse($results);
        }

        $qb = $this->getDoctrine()->getRepository(Usuario::class)->createQueryBuilder('u');

        $qb->join('u.fkAlmoxarifadoRequisicoes', 'r');
        $qb->join('u.fkSwCgm', 'cgm');

        $qb->andWhere('LOWER(cgm.nomCgm) LIKE :nomCgm');
        $qb->setParameter('nomCgm', sprintf('%%%s%%', strtolower($request->get('q'))));

        foreach ($qb->getQuery()->getResult() as $usuario) {
            $results['items'][] = [
                'id' => $usuario->getNumcgm(),
                'label' => (string) $usuario,
            ];
        }

        return new JsonResponse($results);
    }
}
