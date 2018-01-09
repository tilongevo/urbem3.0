<?php

namespace Urbem\TributarioBundle\Controller\Imobiliario;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Imobiliario\Lote;
use Urbem\CoreBundle\Entity\Imobiliario\LoteLocalizacao;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Model\Imobiliario\LoteModel;

class LoteAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function consultarLoteLocalizacaoValorAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();

        /** @var LoteLocalizacao $loteLocalizacao */
        $loteLocalizacao = $em
            ->getRepository(LoteLocalizacao::class)
            ->createQueryBuilder('o')
            ->where('o.codLocalizacao = :codLocalizacao')
            ->andWhere('lpad(upper(o.valor), 10, \'0\') = :valor')
            ->setParameter('codLocalizacao', $request->request->get('codLocalizacao'))
            ->setParameter('valor', str_pad(strtoupper($request->request->get('valor')), 10, '0', STR_PAD_LEFT))
            ->getQuery()
            ->getResult();

        $response = new Response();
        $response->setContent(json_encode(($loteLocalizacao) ? true : false));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function consultarAssuntoAction(Request $request)
    {
        $assuntos = $this->getDoctrine()
            ->getRepository(SwAssunto::class)
            ->findByCodClassificacao($request->request->get('codClassificacao'), array('codAssunto' => 'ASC'));

        $options = array();
        /** @var SwAssunto $assunto */
        foreach ($assuntos as $assunto) {
            $options[$assunto->getCodAssunto()] = (string) $assunto;
        }

        $response = new Response();
        $response->setContent(json_encode($options));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function consultarProcessoAction(Request $request)
    {
        list($codProcesso, $anoExercicio) = explode('~', $request->request->get('processo'));
        /** @var SwProcesso $processo */
        $processo = $this->getDoctrine()
            ->getRepository(SwProcesso::class)
            ->findOneBy([
                'codProcesso' => $codProcesso,
                'anoExercicio' => $anoExercicio,
            ]);

        $info = array();
        if ($processo) {
            $info = [
                'codProcesso' => $processo->getCodProcesso(),
                'anoExercicio' => $processo->getAnoExercicio(),
                'codAssunto' => $processo->getFkSwAssunto()->getCodAssunto(),
                'nomAssunto' => (string) $processo->getFkSwAssunto(),
                'codClassificacao' => $processo->getFkSwAssunto()->getFkSwClassificacao()->getCodClassificacao(),
                'nomClassificacao' => (string) $processo->getFkSwAssunto()->getFkSwClassificacao(),
            ];
        }

        $response = new Response();
        $response->setContent(json_encode($info));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function consultarProprietariosAction(Request $request)
    {
        $proprietarios = (new LoteModel($this->getDoctrine()->getEntityManager()))
            ->recuperaProprietariosLote($request->request->get('codLote'));

        $remanecentes = $request->request->get('proprietarios');
        $data = true;
        if ((count($proprietarios)) && ($remanecentes != '')) {
            foreach (explode(',', $remanecentes) as $proprietario) {
                if (!in_array($proprietario, $proprietarios)) {
                    $data = false;
                }
            }
        }

        $response = new Response();
        $response->setContent(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function consultarImoveisAction(Request $request)
    {
        /** @var Lote $lote */
        $lote = $this
            ->getDoctrine()
            ->getEntityManager()
            ->getRepository(Lote::class)
            ->find($request->request->get('codLote'));

        $imoveis = (new LoteModel($this->getDoctrine()->getEntityManager()))
            ->verificaLoteImovel($lote);

        $response = new Response();
        $response->setContent(json_encode($imoveis));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
