<?php

namespace Urbem\TributarioBundle\Controller\Imobiliario;

use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\SwMunicipio;
use Urbem\CoreBundle\Model\SwLogradouroModel;

class RelatorioLogradouroAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function consultarMunicipioAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $codUf = $request->get('codUf');

        /** @var QueryBuilder $qb */
        $qb = $em->getRepository(SwMunicipio::class)->createQueryBuilder('o');
        $qb->andWhere('o.codUf = :codUf');
        $qb->setParameter('codUf', $codUf);
        $rlt = $qb->getQuery()->getResult();

        $municipios = array();

        /** @var SwMunicipio $municipio */
        foreach ($rlt as $municipio) {
            $municipios[$municipio->getCodMunicipio()] = (string) $municipio;
        }

        return new JsonResponse($municipios);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function relatorioAction(Request $request)
    {
        $container = $this->container;

        $usuario = $container->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();
        $swLogradouroModel = (new SwLogradouroModel($em));

        $params = $request->query->all();
        $logradouros = $swLogradouroModel->filtraLogradouro($params);

        $entidade = $this->get('urbem.entidade')->getEntidade();

        $html = $this->renderView(
            'TributarioBundle:Imobiliario/Relatorios:logradouros.html.twig',
            [
                'logradouros' => $logradouros,
                'demonstrarNormaLogradouro' => $params['demonstrarNormaLogradouro'],
                'entidade' => $entidade,
                'modulo' => 'Cadastro Imobiliário',
                'subModulo' => 'Relatórios',
                'funcao' => 'Logradouros',
                'nomRelatorio' => 'Relatório de Logradouros',
                'dtEmissao' => new \DateTime(),
                'usuario' => $usuario,
                'versao' => $container->getParameter('version')
            ]
        );

        $filename = sprintf('RelatorioLogradouros_%s.pdf', date('Y-m-d'));

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml(
                $html,
                [
                    'encoding' => 'utf-8',
                    'enable-javascript' => true,
                    'footer-line' => true,
                    'footer-left' => 'URBEM - CNM',
                    'footer-right' => '[page]',
                    'footer-center' => 'www.cnm.org.br',
                    'orientation'=>'Landscape'
                ]
            ),
            200,
            [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $filename)
            ]
        );
    }
}
