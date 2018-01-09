<?php

namespace Urbem\AdministrativoBundle\Controller\Administracao;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Sonata\DoctrineORMAdminBundle\Model\ModelManager;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Route;
use Urbem\CoreBundle\Entity\Administracao\Grupo;
use Urbem\CoreBundle\Entity\Administracao\GrupoPermissao;
use Urbem\CoreBundle\Entity\Administracao\Rota;
use Urbem\CoreBundle\Model\Administracao\GrupoPermissaoModel;
use Urbem\CoreBundle\Model\Administracao\RotaModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class GrupoAdminController
 *
 * @package Urbem\AdministrativoBundle\Controller\Administracao
 */
class GrupoAdminController extends Controller
{
    /**
     * Configura um breadcrumb em paginas customizadas dentro do Sonata.
     *
     * @param Request $request
     */
    public function setBreadCrumb(Request $request)
    {
        $paramIdentifier = $this->admin->getIdParameter();

        $hasIdentifier = !is_null($request->get($paramIdentifier));
        $param = $hasIdentifier ? [$paramIdentifier => $request->get($paramIdentifier)] : [];

        $this->admin->setBreadCrumb($param);
    }

    /**
     * Action que renderiza uma tela customizada de permissões.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function permissoesAction(Request $request)
    {
        $codGrupo = $request->get($this->admin->getIdParameter()) ?: null;

        $this->setBreadCrumb($request);

        /** @var ModelManager $modelManager */
        $modelManager = $this->admin->getModelManager();
        $entityManager = $modelManager->getEntityManager(Grupo::class);

        /** @var AbstractSonataAdmin $admin */
        $admin = $this->admin;

        /** @var Grupo $grupo */
        $grupo = $modelManager->find(Grupo::class, $codGrupo);

        /** @var Rota $rota */
        $rota = $modelManager->findOneBy(Rota::class, [
            'descricaoRota' => 'home-urbem',
        ]);

        $rotaModel = new RotaModel($entityManager);

        $rotas = $rotaModel->getChildren($rota);
        $permissoes = $rotaModel->getPermissionsByGrupo($grupo);
        $permissoes = $permissoes->map(function (Rota $rota) {
            return $rota->getCodRota();
        });

        $permissoesUrlAction = $admin->getBaseRouteName() . '_permissoes';

        $form = $this->createFormBuilder([])
            ->add('routes', HiddenType::class, [
                'data' => json_encode($permissoes->toArray()),
            ])
            ->add('grupo', HiddenType::class, [
                'data' => $codGrupo,
            ])
            ->setAction($this->generateUrl($permissoesUrlAction, [
                'id' => $codGrupo,
            ]))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $request->get('form');

            /**
             * Permissões enviadas via POST do formulário.
             */
            $permissoesEnviadas = json_decode($data['routes']);

            /**
             * Diferença entre permissões cadastradas e permissões enviadas.
             */
            $permissoesRevogadas = array_diff($permissoes->toArray(), $permissoesEnviadas);

            $rotaModel = new RotaModel($entityManager);
            $grupoPermissaoModel = new GrupoPermissaoModel($entityManager);

            /**
             * Percorre o array de permissões enviadas e as salva no grupo.
             */
            foreach ($permissoesEnviadas as $codRota) {
                /** @var Rota $rota */
                $rota = $modelManager->find(Rota::class, $codRota);

                if (!$rotaModel->hasPermissionByGrupo($grupo, $rota)) {
                    $grupoPermissaoModel->saveGrupoPermissao($grupo, $rota);
                    $grupoPermissaoModel->saveGrupoPermissaoRotaSuperior($grupo, $rota);
                }
            }

            /**
             * Percorre a diferença entre as permissões cadastradas
             * e as enviadas e remove as que não estavam no POST.
             */
            foreach ($permissoesRevogadas as $codRota) {
                /** @var Rota $rota */
                $rota = $modelManager->find(Rota::class, $codRota);

                if ($rotaModel->hasPermissionByGrupo($grupo, $rota)) {
                    $grupoPermissaoModel->removeGrupoPermissao($grupo, $rota);
                }
            }

            $message = $this->trans('grupo.permissao.updated', [], 'flashes');
            $this->container
                ->get('session')
                ->getFlashBag()
                ->add('success', $message);
        }

        return $this->render('AdministrativoBundle::Sonata/Administracao/Grupo/CRUD/edit__permissoes.html.twig', [
            'action' => 'permissions',
            'form'   => $form->createView(),
            'object' => $grupo,
            'rotas'  => $rotas,
        ]);
    }

    /**
     * Endpoint de rotas.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function apiRotasChildrenAction(Request $request)
    {
        $codRota = $request->get($this->admin->getIdParameter()) ?: null;
        $codGrupo = $request->get('cod_grupo');

        /** @var ModelManager $modelManager */
        $modelManager = $this->admin->getModelManager();
        /** @var EntityManager $entityManager */
        $entityManager = $modelManager->getEntityManager(Rota::class);

        /** @var Rota $rota */
        $rota = $modelManager->find(Rota::class, $codRota);

        /** @var Grupo $grupo */
        $grupo = $modelManager->find(Grupo::class, $codGrupo);

        $rotaModel = new RotaModel($entityManager);

        /** @var array $rotasFilha */
        $rotasFilha = $rotaModel->getChildren($rota);

        $routerService = $this->get('router');

        $rotasFilha = new ArrayCollection($rotasFilha);
        $rotasFilha = $rotasFilha->filter(function (Rota $rota) use ($routerService, $rotaModel, $grupo) {
            /** @var Route */
            $rota->route = $routerService->getRouteCollection()->get($rota->getDescricaoRota());

            $rota->input = [
                'checked' => $rotaModel->hasPermissionByGrupo($grupo, $rota),
                'hasChildren' => $rotaModel->hasChildren($rota)
            ];

            return !is_null($rota->route);
        });

        return $this->render('AdministrativoBundle::Sonata/Administracao/Grupo/API/show__rotas.html.twig', [
            'rotaPai' => $rota,
            'rotas'   => $rotasFilha,
        ]);
    }
}
