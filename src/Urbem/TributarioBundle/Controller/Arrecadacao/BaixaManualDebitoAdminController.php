<?php

namespace Urbem\TributarioBundle\Controller\Arrecadacao;

use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Urbem\CoreBundle\Helper\BreadCrumbsHelper;
use Urbem\CoreBundle\Entity\Arrecadacao\CadastroEconomicoCalculo;
use Urbem\CoreBundle\Entity\Arrecadacao\CalculoCgm;
use Urbem\CoreBundle\Entity\Imobiliario\LoteLocalizacao;
use Urbem\CoreBundle\Entity\Imobiliario\ImovelLote;
use Urbem\CoreBundle\Entity\Divida\DividaAtiva;
use Urbem\CoreBundle\Entity\Divida\DividaCgm;
use Urbem\CoreBundle\Entity\Divida\Parcelamento;
use Urbem\CoreBundle\Entity\Divida\DividaParcelamento;
use Urbem\CoreBundle\Entity\Monetario\Agencia;
use Urbem\CoreBundle\Model\Arrecadacao\CarneModel;
use Urbem\CoreBundle\Entity\Arrecadacao\PagamentoAcrescimo;
use Urbem\CoreBundle\Entity\Arrecadacao\PagamentoCalculo;
use Urbem\CoreBundle\Entity\Arrecadacao\ProcessoPagamento;
use Urbem\CoreBundle\Entity\Arrecadacao\PagamentoLote;
use Urbem\CoreBundle\Entity\Arrecadacao\PagamentoDiferenca;
use Urbem\CoreBundle\Entity\Arrecadacao\ObservacaoPagamento;
use Urbem\CoreBundle\Entity\Arrecadacao\Pagamento;
use Urbem\CoreBundle\Entity\Arrecadacao\CarneDevolucao;
use Urbem\CoreBundle\Entity\Arrecadacao\Carne;
use Urbem\CoreBundle\Entity\Arrecadacao\Lote;
use Urbem\CoreBundle\Entity\Imobiliario\Lote as LoteImobiliario;

/**
 * Class BaixaDebitoManualController
 * @package Urbem\TributarioBundle\Controller\Arrecadacao
 */
class BaixaManualDebitoAdminController extends CRUDController
{

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function carregaInscricoesEconomicaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $filtro = $request->get('q');
        $calculo = $em->getRepository(CalculoCgm::class)->findByNumcgm($filtro);

        if (!$calculo) {
            return new JsonResponse();
        }

        $cadastroList = $em->getRepository(CadastroEconomicoCalculo::class)->findByCodCalculo(end($calculo)->getCodCalculo());

        $cadastros = array();

        foreach ($cadastroList as $cadastro) {
            array_push(
                $cadastros,
                array(
                    'id' => $cadastro->getCodCalculo(),
                    'label' => sprintf(
                        '%s - %s',
                        $cadastro->getCodCalculo(),
                        $cadastro->getInscricaoEconomica()
                    )
                )
            );
        }

        $items = array(
            'items' => $cadastros
        );

        return new JsonResponse($items);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function carregaLotesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $qb = $em->getRepository(LoteImobiliario::class)->createQueryBuilder('lote');

        if ($request->get('q')) {
            $qb->andWhere('lote.codLote  >= :codLote');
            $qb->setParameter('codLote', $request->get('q'));
        }

        if ($request->get('codLocalizacao')) {
            $qb->join('lote.fkImobiliarioLoteLocalizacao', 'll');

            $qb->andWhere('ll.codLocalizacao = :codLocalizacao');
            $qb->setParameter('codLocalizacao', $request->get('codLocalizacao'));
        }

        $qb->orderBy('lote.codLote', 'ASC');

        $lotes = [];
        foreach ((array) $qb->getQuery()->getResult() as $lote) {
            $lotes[] = [
                'id' => $lote->getCodLote(),
                'label' => (string) $lote
            ];
        }

        $items = [
            'items' => $lotes
        ];

        return new JsonResponse($items);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function carregaInscricoesMunicipaisAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $qb = $em->getRepository(ImovelLote::class)->createQueryBuilder('imovelLote');

        if ($request->get('q')) {
            $qb->andWhere('imovelLote.inscricaoMunicipal >= :inscricaoMunicipal');
            $qb->setParameter('inscricaoMunicipal', $request->get('q'));
        }

        if ($request->get('codLote')) {
            $qb->andWhere('imovelLote.codLote = :codLote');
            $qb->setParameter('codLote', $request->get('codLote'));
        }

        $qb->orderBy('imovelLote.inscricaoMunicipal', 'ASC');

        $inscricoesMunicipais = [];
        foreach ((array) $qb->getQuery()->getResult() as $inscricaoMunicipal) {
            $inscricoesMunicipais[] = [
                'id' => $inscricaoMunicipal->getInscricaoMunicipal(),
                'label' => (string) $inscricaoMunicipal
            ];
        }

        $items = [
            'items' => $inscricoesMunicipais
        ];

        return new JsonResponse($items);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function carregaCobrancasAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $cobrancas = [];
        if (!$request->request->get('numcgm')) {
            return new JsonResponse($cobrancas);
        }

        $qb = $em->getRepository(DividaAtiva::class)->createQueryBuilder('dividaAtiva');
        $qb->innerJoin('CoreBundle:Divida\DividaCgm', 'dc', 'WITH', 'dc.codInscricao = dividaAtiva.codInscricao AND dc.exercicio = dividaAtiva.exercicio');
        $qb->innerJoin('CoreBundle:Divida\DividaParcelamento', 'da', 'WITH', 'da.codInscricao = dividaAtiva.codInscricao AND da.exercicio = dividaAtiva.exercicio');
        $qb->innerJoin('CoreBundle:Divida\Parcelamento', 'dp', 'WITH', 'dp.numParcelamento = da.numParcelamento');
        $qb->andWhere('dp.numeroParcelamento != -1');
        $qb->andWhere('dp.exercicio != \'-1\'');
        $qb->andWhere($qb->expr()->eq('dc.numcgm', (int) $request->request->get('numcgm')));

        foreach ((array) $qb->getQuery()->getResult() as $cobranca) {
            $cobrancaAno = sprintf(
                '%d/%s',
                $cobranca->getFkDividaDividaParcelamentos()->last()->getFkDividaParcelamento()->getNumeroParcelamento(),
                $cobranca->getFkDividaDividaParcelamentos()->last()->getFkDividaParcelamento()->getExercicio()
            );

            $cobrancas[$cobrancaAno] = $cobrancaAno;
        }

        $items = array(
            'items' => $cobrancas
        );

        return new JsonResponse($cobrancas);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function carregaAgenciasAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $agencias = [];
        if (!$request->request->get('codBanco')) {
            return new JsonResponse($agencias);
        }

        $agenciaList = $em->getRepository(Agencia::class)->findByCodBanco($request->request->get('codBanco'));

        foreach ((array) $agenciaList as $agencia) {
            $agencias[$agencia->getCodAgencia()] = $agencia->getNumAgencia().' - '.$agencia->getNomAgencia();
        }

        return new JsonResponse($agencias);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function calculaValoresAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $carne = new CarneModel($em);
        $date = explode('/', $request->query->get('data'));
        $params = [
            'numeracao' => $request->query->get('numeracao'),
            'data' => $date[2].'-'.$date[1].'-'.$date[0]
        ];

        $valores = $carne->calculaValores($params);

        if ($valores) {
            return new JsonResponse($valores);
        }

        return new JsonResponse([]);
    }

    /**
     *  @param Request $request
     *  @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *  @throws \Exception
     */
    public function estornarAction(Request $request)
    {
        $container = $this->container;
        $em = $this->getDoctrine()->getManager();

        list($numeracao, $codConvenio) = explode('~', $request->get('id'));

        try {
            $carne = $em->getRepository(Carne::class)->findOneByNumeracao($numeracao);
            $exercicio = $carne->getExercicio();

            $ocorrenciaPagamento = 1;

            $params = [
                'numeracao' => $numeracao,
                'ocorrenciaPagamento' => $ocorrenciaPagamento,
                'codConvenio' => $codConvenio
            ];

            $paramsSemConvenio = $params;
            array_pop($paramsSemConvenio);

            $codLote = $this->getCodLote($numeracao);

            //DELETE FROM arrecadacao.pagamento_acrescimo
            $pagamentoAcrescimo = $em->getRepository(PagamentoAcrescimo::class)->findBy($params);
            if ($pagamentoAcrescimo) {
                $this->makeRemove($pagamentoAcrescimo);
            }

            //DELETE FROM arrecadacao.pagamento_calculo
            $pagamentoCalculo = $em->getRepository(PagamentoCalculo::class)->findBy($paramsSemConvenio);

            if ($pagamentoCalculo) {
                $this->makeRemove($pagamentoCalculo);
            }

            //DELETE FROM arrecadacao.processo_pagamento
            $processoPagamento = $em->getRepository(ProcessoPagamento::class)->findBy($params);

            if ($processoPagamento) {
                $this->makeRemove($processoPagamento);
            }

            //DELETE FROM arrecadacao.pagamento_lote
            if ($codLote) {
                $paramTemp = ['codLote' => $codLote, 'exercicio' => $exercicio];
                $pagamentoLote = $em->getRepository(PagamentoLote::class)->findBy(array_merge($params, $paramTemp));

                if ($pagamentoLote) {
                    $this->makeRemove($pagamentoLote);
                }
            }

            //DELETE FROM arrecadacao.pagamento_diferenca
            $pagamentoDiferenca = $em->getRepository(PagamentoDiferenca::class)->findBy($params);

            if ($pagamentoDiferenca) {
                $this->makeRemove($pagamentoDiferenca);
            }

            //DELETE FROM arrecadacao.observacao_pagamento
            $observacaoPagamento = $em->getRepository(ObservacaoPagamento::class)->findBy($paramsSemConvenio);

            if ($observacaoPagamento) {
                $this->makeRemove($observacaoPagamento);
            }

            //DELETE FROM arrecadacao.pagamento
            $pagamento = $em->getRepository(Pagamento::class)->findBy($paramsSemConvenio);
            if ($pagamento) {
                $this->makeRemove($pagamento);
            }

            //DELETE FROM arrecadacao.carne_devolucao
            $carneDevolucao = $em->getRepository(CarneDevolucao::class)->findByNumeracao($numeracao);
            if ($carneDevolucao) {
                $this->makeRemove($carneDevolucao);
            }

            //DELETE FROM arrecadacao.lote
            if ($codLote) {
                $lote = $em->getRepository(Lote::class)->findBy(['codLote' => $codLote, 'exercicio' => $exercicio]);
                if ($lote) {
                    $this->makeRemove($lote);
                }
            }

            $container->get('session')->getFlashBag()
                        ->add('success', $this->get('translator')->trans('label.baixaDebitos.msgEstornoSucesso', ['%numeracao%' => $numeracao]));
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('contactSupport'));
            throw $e;
        }

        return $this->redirect($this->generateUrl('urbem_tributario_arrecadacao_baixa_manual_debito_list'));
    }

    /**
     * @param array
     * @return void
     */
    protected function makeRemove(array $objectList)
    {
        $em = $this->getDoctrine()->getManager();

        foreach ($objectList as $object) {
            $em->remove($object);
        }

        $em->flush();
    }

    /**
     *  @param  $numeracao string
     *  @return int $codLote | false
     */
    protected function getCodLote($numeracao)
    {
        $em = $this->getDoctrine()->getManager();

        return (new CarneModel($em))->getCodLote($numeracao);
    }
}
