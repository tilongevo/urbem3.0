<?php

namespace Urbem\CoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Urbem\CoreBundle\Entity\Administracao\Configuracao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Helper;

/**
 * Class HomeController
 *
 * @package Urbem\CoreBundle\Controller
 */
class HomeController extends BaseController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $data = new \DateTime();

        $year = (!$request->request->get('exercicio')) ? $data->format('Y') : $request->request->get('exercicio');

        $mensagem = $this->getDoctrine()
            ->getRepository('CoreBundle:Administracao\Configuracao')
            ->findOneBy(['codModulo' => 2, 'exercicio' => $year, 'parametro' => 'mensagem']);

        $logoTipo = $this->getDoctrine()
            ->getRepository('CoreBundle:Administracao\Configuracao')
            ->findOneBy(['codModulo' => Modulo::MODULO_ADMINISTRATIVO, 'exercicio' => $year, 'parametro' => 'logotipo']);

        $this->get('urbem.session.service')
            ->setLogoTipo($logoTipo instanceof Configuracao ? $logoTipo->getValor() : '');

        $this->setBreadCrumb();

        return $this->render('CoreBundle::Home/index.html.twig', [
            'mensagem'=> $mensagem instanceof Configuracao ? $mensagem->getValor() : ''
        ]);
    }

    /**
     * Utilizada para download de arquivos
     *
     * @param  Request $request
     *
     * @return Response
     * @throws \Exception
     */
    public function downloadAction(Request $request)
    {
        if (empty($request->get("bundle")) || empty($request->get("module")) || empty($request->get("file"))) {
            throw new \Exception('Arquivo não encontrado!');
        }

        /** @var Helper\LoadFileHelper $loadFile */
        $loadFile = $this->container->get('urbem.helper.loadfile');
        $loadFile->setIsDownload(true);
        $loadFile->setBundle($request->get("bundle"));
        $loadFile->setModule($request->get("module"));
        $loadFile->setFileName($request->get("file"));

        return $loadFile->getFile();
    }

    /**
     * Utilizada para visualiação de arquivos
     *
     * @param  Request $request [description]
     *
     * @return Response
     * @throws \Exception
     */
    public function showAction(Request $request)
    {
        if (empty($request->get("bundle")) || empty($request->get("module")) || empty($request->get("file"))) {
            throw new \Exception('Arquivo não encontrado!');
        }

        /** @var Helper\LoadFileHelper $loadFile */
        $loadFile = $this->container->get('urbem.helper.loadfile');
        $loadFile->setBundle($request->get("bundle"));
        $loadFile->setModule($request->get("module"));
        $loadFile->setFileName($request->get("file"));

        return $loadFile->getFile();
    }
    
    /**
     * Seta o exercício selecionado no menu
     * @param  Request $request
     * @return JsonResponse
     */
    public function exercicioAction(Request $request)
    {
        $this->get('urbem.session.service')
        ->setExercicio($request->request->get('exercicio'));

        $logoTipo = $this->getDoctrine()
            ->getRepository('CoreBundle:Administracao\Configuracao')
            ->findOneBy(['codModulo' => Modulo::MODULO_ADMINISTRATIVO, 'exercicio' => $request->request->get('exercicio'), 'parametro' => 'logotipo']);

        $this->get('urbem.session.service')
            ->setLogoTipo($logoTipo instanceof Configuracao ? $logoTipo->getValor() : '');

        $exercicio = [
            'exercicio' => $this->get('urbem.session.service')
            ->getExercicio()
        ];

        return new JsonResponse($exercicio);
    }

    /**
     * @Route("/acesso-negado", name="acessoNegado")
     */
    public function acessoNegadoAction(Request $request)
    {
        return $this->render('CoreBundle::Exception/exception_forbidden.html.twig');
    }

    /**
     * @Route("/pagina-nao-encontrada", name="paginaNaoEncontrada")
     */
    public function paginaNaoEncontradaAction(Request $request)
    {
        return $this->render('CoreBundle::Exception/exception_route_notfound.html.twig');
    }
}
