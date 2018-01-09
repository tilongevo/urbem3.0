<?php

namespace Urbem\TributarioBundle\Controller\Imobiliario;

use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\SwMunicipio;
use Urbem\CoreBundle\Model\SwBairroModel;

class RelatorioBairroAdminController extends CRUDController
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
        $swBairroModel = (new SwBairroModel($em));

        $params = $request->query->all();

        $bairros = $swBairroModel->filtraBairro($params);

        $entidade = $this->get('urbem.entidade')->getEntidade();

        $html = $this->renderView(
            'TributarioBundle:Imobiliario/Relatorios:bairros.html.twig',
            [
                'bairros' => $bairros,
                'filtros' => $params,
                'entidade' => $entidade,
                'modulo' => 'Cadastro Imobiliário',
                'subModulo' => 'Relatórios',
                'funcao' => 'Bairros',
                'nomRelatorio' => 'Bairros',
                'dtEmissao' => new \DateTime(),
                'usuario' => $usuario,
                'versao' => $container->getParameter('version')
            ]
        );

        $filename = sprintf('RelatorioBairros_%s.pdf', date('Y-m-d-His'));

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
