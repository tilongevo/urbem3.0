<?php

namespace Urbem\TributarioBundle\Controller\Imobiliario;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Imobiliario\Confrontacao;
use Urbem\CoreBundle\Entity\Imobiliario\Lote;
use Urbem\CoreBundle\Entity\SwCepLogradouro;
use Urbem\CoreBundle\Entity\SwLogradouro;

class ImovelAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function consultarLoteBairroAction(Request $request)
    {
        /** @var Lote $lote */
        $lote = $this
            ->getDoctrine()
            ->getRepository(Lote::class)
            ->find($request->request->get('codLote'));

        $response = new Response();
        $response->setContent(json_encode((string) $lote->getFkImobiliarioLoteBairros()->last()->getFkSwBairro()));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function consultarLoteEnderecoAction(Request $request)
    {
        /** @var Lote $lote */
        $lote = $this
            ->getDoctrine()
            ->getRepository(Lote::class)
            ->find($request->request->get('codLote'));

        $options = array();

        $confrontacoes = $lote->getFkImobiliarioConfrontacoes()->filter(
            function ($entry) {
                if ($entry->getFkImobiliarioConfrontacaoTrecho()) {
                    if ($entry->getFkImobiliarioConfrontacaoTrecho()->getPrincipal()) {
                        return $entry;
                    }
                }
            }
        );

        /** @var Confrontacao $confrontacao */
        foreach ($confrontacoes as $confrontacao) {
            $options[$confrontacao->getFkImobiliarioConfrontacaoTrecho()->getFkImobiliarioTrecho()->getFkSwLogradouro()->getCodLogradouro()] = (string) $confrontacao->getFkImobiliarioConfrontacaoTrecho()->getFkImobiliarioTrecho()->getFkSwLogradouro();
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
    public function consultarLoteCepAction(Request $request)
    {
        /** @var Lote $lote */
        $lote = $this
            ->getDoctrine()
            ->getRepository(Lote::class)
            ->find($request->request->get('codLote'));

        $options = array();

        $confrontacoes = $lote->getFkImobiliarioConfrontacoes()->filter(
            function ($entry) {
                if ($entry->getFkImobiliarioConfrontacaoTrecho()) {
                    if ($entry->getFkImobiliarioConfrontacaoTrecho()->getPrincipal()) {
                        return $entry;
                    }
                }
            }
        );

        /** @var Confrontacao $confrontacao */
        foreach ($confrontacoes as $confrontacao) {
            $swLogradouro = $confrontacao->getFkImobiliarioConfrontacaoTrecho()->getFkImobiliarioTrecho()->getFkSwLogradouro();
            if ($request->request->get('codLogradouro')) {
                if ($swLogradouro->getCodLogradouro() == $request->request->get('codLogradouro')) {
                    /** @var SwCepLogradouro $swCepLogradouro */
                    foreach ($swLogradouro->getFkSwCepLogradouros() as $swCepLogradouro) {
                        $options[$swCepLogradouro->getCep()] = $swCepLogradouro->getCep();
                    }
                }
            } else {
                /** @var SwCepLogradouro $swCepLogradouro */
                foreach ($swLogradouro->getFkSwCepLogradouros() as $swCepLogradouro) {
                    $options[$swCepLogradouro->getCep()] = $swCepLogradouro->getCep();
                }
            }
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
    public function consultarLogradouroCepAction(Request $request)
    {
        /** @var SwLogradouro $logradouro */
        $logradouro = $this
            ->getDoctrine()
            ->getRepository(SwLogradouro::class)
            ->find($request->request->get('codLogradouro'));

        $options = array();

        /** @var SwCepLogradouro $cepLogradouro */
        foreach ($logradouro->getFkSwCepLogradouros() as $cepLogradouro) {
            $options[$cepLogradouro->getCep()] = $cepLogradouro->getCep();
        }

        $response = new Response();
        $response->setContent(json_encode($options));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
