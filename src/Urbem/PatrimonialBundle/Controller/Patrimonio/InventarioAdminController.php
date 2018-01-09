<?php

namespace Urbem\PatrimonialBundle\Controller\Patrimonio;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Orcamento\UsuarioEntidade;
use Urbem\CoreBundle\Entity\Organograma\Local;
use Urbem\CoreBundle\Entity\Organograma\Orgao;
use Urbem\CoreBundle\Entity\Patrimonio\Inventario;
use Urbem\CoreBundle\Entity\Patrimonio\InventarioHistoricoBem;
use Urbem\CoreBundle\Model\Administracao\AssinaturaModel;
use Urbem\CoreBundle\Model\Organograma\LocalModel;
use Urbem\CoreBundle\Model\Patrimonial\Patrimonio\InventarioHistoricoBemModel;
use Urbem\CoreBundle\Model\Patrimonial\Patrimonio\InventarioModel;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class InventarioAdminController
 * @package Urbem\PatrimonialBundle\Controller\Patrimonio
 */
class InventarioAdminController extends Controller
{
    /**
     * @param Request $request
     *
     * @return bool
     * @throws \Exception
     */
    public function processarInventarioAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $inventarioObjectKey = $request->get('id');

        /** @var  $inventario */
        $inventario = $this->admin->getObject($inventarioObjectKey);

        if (!$inventario) {
            throw $this->createNotFoundException(sprintf('Impossível encontrar o Inventário com o id: %s ', $inventarioObjectKey));
        }

        try {
            $inventarioModel = new InventarioModel($entityManager);
            $inventarioModel->processarInventario($inventario);

            $message = $this->admin->trans('patrimonial.inventario.processado', [], 'flashes');

            $this->container->get('session')
                ->getFlashBag()
                ->add('success', $message);
        } catch (Exception $e) {
            $message = $this->admin->trans('patrimonial.inventario.processado_error', [], 'flashes');

            $this->container->get('session')
                ->getFlashBag()
                ->add('error', $message);
            throw $e;
        }

        (new RedirectResponse($request->headers->get('referer')))->send();
        return false;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function apiLocalAction(Request $request)
    {
        $codOrgao = $request->get('cod_orgao');
        $exercicio = $request->get('exercicio');
        $idInventario = $request->get('id_inventario');
        $mode = $request->get('mode');

        $modelManager = $this->getDoctrine()->getManager();

        /** @var Orgao $orgao */
        $orgao = $modelManager->find(Orgao::class, $codOrgao);

        $entityManager = $this->getDoctrine()->getEntityManager();

        $locais = (new LocalModel($entityManager))
            ->getLocalInHistoricoBem($orgao, $exercicio, $idInventario);

        if ($mode == 'table') {
            return $this->render('PatrimonialBundle::Sonata/Patrimonio/Inventario/CRUD/show__bem_orgao__locais.html.twig', [
                'locais' => $locais
            ]);
        }

        return new JsonResponse($locais);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function apiHistoricoBemAction(Request $request)
    {
        $codOrgao = $request->get('cod_orgao');
        $codLocal = $request->get('cod_local');
        $mode = $request->get('mode');

        $doctrine = $this->getDoctrine();
        $modelManager = $doctrine->getManager();

        /** @var Orgao $orgao */
        $orgao = $modelManager->find(Orgao::class, $codOrgao);

        /** @var Local $local */
        $local = $modelManager->find(Local::class, $codLocal);

        $entityManager = $doctrine->getEntityManager();

        $historicos = (new InventarioHistoricoBemModel($entityManager))
            ->getHistoricoBemWithLocalAndOrgao($orgao, $local);

        if ($mode == 'table') {
            return $this->render('PatrimonialBundle::Sonata/Patrimonio/Inventario/CRUD/show__bem_orgao__locais__historico.html.twig', [
                'historicos' => $historicos
            ]);
        }

        return new JsonResponse($historicos);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function termoAberturaInventarioAction(Request $request)
    {
        $id = $request->get($this->admin->getIdParameter());
        /** @var Inventario $object */
        $object = $this->admin->getObject($id);

        /** @var UsuarioEntidade $entidadeUsuario */
        $entidadeUsuario = $object->getFkAdministracaoUsuario()->getFkOrcamentoUsuarioEntidades()->first();

        $container = $this->container;
        $usuario = $container->get('security.token_storage')->getToken()->getUser();

        $dtEmissao = (new \DateTime())->format('Y-m-d H:i:s');

        $doctrine = $this->getDoctrine();
        $entityManager = $doctrine->getEntityManager();

        $inventarioModel = new InventarioModel($entityManager);
        $dados = $inventarioModel->carregaDadosAberturaInventario($object->getExercicio(), $object->getIdInventario());

        $assinaturas = (new AssinaturaModel($entityManager))->carregaListaAssinaturasAberturaInventario($object->getExercicio(), 6);

        $inventario = [];
        $locais = [];
        foreach ($dados as $index => $dado) {
            $inventario[$dado['cod_orgao']]['orgao'] = $dado['nom_orgao'];
            $inventario[$dado['cod_orgao']]['cod_orgao'] = $dado['cod_orgao'];
            $locais[$dado['cod_orgao']]['cod_orgao'] = $dado['cod_orgao'];
            $locais[$dado['cod_orgao']]['nom_local'] = $dado['nom_local'];
            $locais[$dado['cod_orgao']][$dado['cod_local']] = [
                 'nom_local' => $dado['nom_local'], 'codigo' => $dado['cod_bem'], 'descricao' => $dado['descricao'], 'placa' => $dado['num_placa']
            ];
        }

        $html = $this->renderView(
            'PatrimonialBundle:Patrimonial/Inventario:pdfAberturaInventario.html.twig',
            [
                'object' => $object,
                'invetarios' => $inventario,
                'locais' => $locais,
                'modulo' => 'Patrimonial',
                'subModulo' => 'Patrimonio\Inventário',
                'funcao' => 'Abertura de Inventário',
                'nomRelatorio' => 'Abertura de Inventário',
                'dtEmissao' => $dtEmissao,
                'usuario' => $usuario,
                'entidadeUsuario' => $entidadeUsuario,
                'versao' => $container->getParameter('version'),
                'assinaturas' => $assinaturas
            ]
        );

        $filename = sprintf('Abertura-de-Inventario-%s.pdf', date('Y-m-d'));

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml(
                $html,
                [
                    'encoding' => 'utf-8',
                    'enable-javascript' => false,
                    'footer-line' => true,
                    'footer-left' => 'URBEM - CNM',
                    'footer-right' => '[page]',
                    'footer-center' => 'www.cnm.org.br'
                ]
            ),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $filename)
            ]
        );
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function termoEncerramentoInventarioAction(Request $request)
    {
        $id = $request->get($this->admin->getIdParameter());
        /** @var Inventario $object */
        $object = $this->admin->getObject($id);

        /** @var UsuarioEntidade $entidadeUsuario */
        $entidadeUsuario = $object->getFkAdministracaoUsuario()->getFkOrcamentoUsuarioEntidades()->first();

        $container = $this->container;
        $usuario = $container->get('security.token_storage')->getToken()->getUser();

        $dtEmissao = (new \DateTime())->format('Y-m-d H:i:s');

        $doctrine = $this->getDoctrine();
        $entityManager = $doctrine->getEntityManager();

        $inventarioModel = new InventarioModel($entityManager);
        $dados = $inventarioModel->carregaDadosEncerramentoInventario($object->getExercicio(), $object->getIdInventario());

        $assinaturas = (new AssinaturaModel($entityManager))->carregaListaAssinaturasAberturaInventario($object->getExercicio(), 6);

        $inventario = [];
        $locais = [];
        foreach ($dados as $index => $dado) {
            $inventario[$dado['cod_orgao']]['orgao'] = $dado['nom_orgao'];
            $inventario[$dado['cod_orgao']]['cod_orgao'] = $dado['cod_orgao'];
            $locais[$dado['cod_orgao']]['cod_orgao'] = $dado['cod_orgao'];
            $locais[$dado['cod_orgao']]['nom_local'] = $dado['nom_local'];
            $locais[$dado['cod_orgao']][$dado['cod_local']] = [
                'nom_local' => $dado['nom_local'], 'codigo' => $dado['cod_bem'], 'descricao' => $dado['descricao'], 'placa' => $dado['num_placa'], 'situacao' => $dado['nom_situacao']
            ];
        }

        $html = $this->renderView(
            'PatrimonialBundle:Patrimonial/Inventario:pdfEncerramentoInventario.html.twig',
            [
                'object' => $object,
                'invetarios' => $inventario,
                'locais' => $locais,
                'modulo' => 'Patrimonial',
                'subModulo' => 'Patrimonio\Inventário',
                'funcao' => 'Encerramento de Inventário',
                'nomRelatorio' => 'Encerramento de Inventário',
                'dtEmissao' => $dtEmissao,
                'usuario' => $usuario,
                'entidadeUsuario' => $entidadeUsuario,
                'versao' => $container->getParameter('version'),
                'assinaturas' => $assinaturas
            ]
        );

        $filename = sprintf('Encerramento-de-Inventario-%s.pdf', date('Y-m-d'));

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml(
                $html,
                [
                    'encoding' => 'utf-8',
                    'enable-javascript' => false,
                    'footer-line' => true,
                    'footer-left' => 'URBEM - CNM',
                    'footer-right' => '[page]',
                    'footer-center' => 'www.cnm.org.br'
                ]
            ),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $filename)
            ]
        );
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function exportarColetoraTxtAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $filter = $request->get('filter');
        $places = $filter['local']['value'];
        $typeArchive = $filter['typeArchive']['value'];
        $formatPlaces = implode(',', $places);
        $html = '';
        /** @var InventarioModel $inventarioModel */
        $inventarioModel = new InventarioModel($entityManager);
        if ($typeArchive == 'Inventario') {
            $getListColetoraInventario = $inventarioModel->getListColetoraInventario($formatPlaces);

            foreach ($getListColetoraInventario as $listInventario) {
                $html .= str_pad($listInventario->num_placa, 50, ' ') . $listInventario->descricao . " \n";
            }
        }
        if ($typeArchive == 'Cadastro') {
            $getListColetoraInventario = $inventarioModel->getListColetoraCadastro($formatPlaces);

            foreach ($getListColetoraInventario as $listInventario) {
                $html .= $listInventario->descricao . " \r\n";
            }
        }
        return new Response(
            $html,
            200,
            [
                'Content-Type' => 'application/text',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $typeArchive.'.txt')
            ]
        );
    }
}
