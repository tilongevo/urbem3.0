<?php

namespace Urbem\AdministrativoBundle\Controller\Administracao;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Model\Administracao\UsuarioModel;
use WebDriver\Container;

/**
 * Class UsuarioAdminController
 *
 * @package Urbem\AdministrativoBundle\Controller\Administracao
 */
class UsuarioAdminController extends CRUDController
{
    /**
     * Endpoint para campos autocomplete de usuarios
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function searchAction(Request $request)
    {
        $q = $request->get('q');

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getEntityManager();

        $usuarios = [];

        if (is_null($q) || empty($q)) {
            return new JsonResponse();
        }

        $usuarioModel = new UsuarioModel($em);
        $searchResults = $usuarioModel->search($q);

        /** @var Usuario $usuario */
        foreach ($searchResults as $usuario) {
            array_push($usuarios, [
                'id' => $usuario->getNumcgm(),
                'label' => strtoupper($usuario->getFkSwCgm()->getNomCgm())
            ]);
        }

        $items = ['items' => $usuarios];

        return new JsonResponse($items);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function resendPasswordAction(Request $request)
    {
        /** @var ContainerInterface $container */
        $container = $this->container;

        try {
            $id = $request->get('id');

            $em = $this->getDoctrine()->getEntityManager();

            /** @var Usuario $usuario */
            $usuario = $em->getRepository(Usuario::class)->find($id);
            $password = (new UsuarioModel($em))->randPassword(6);
            $usuario->setPlainPassword($password);
            $usuario->setPasswordRequestedAt(new \DateTime());
            $em->persist($usuario);

            $userManager = $container->get('fos_user.user_manager');
            $userManager->updateUser($usuario, false);
            $em->flush();

            $mailer = $container->get('mailer');

            $message = (new \Swift_Message($this->get('translator')->trans('label.usuario.emailMunicipe.resendPasswordSubject')))
                ->setFrom($container->getParameter('mailer_user'))
                ->setTo($usuario->getEmail())
                ->setBody(
                    $container->get('twig')->render(
                        'AdministrativoBundle:Administracao/Usuario:resend_password.html.twig',
                        array(
                            'usuario' => $usuario,
                            'link' => $container->getParameter('api_prod_http'),
                            'password' => $password
                        )
                    )
                );
            $mailer->send($message);
            $this->addFlash('sonata_flash_success', $this->get('translator')->trans('label.usuario.reenviarSenhaMsgSucesso'));
        } catch (\Exception $e) {
            $this->addFlash('sonata_flash_error', $e->getMessage());
        }
        return new RedirectResponse(
            $this->admin->generateUrl('list')
        );
    }
}
