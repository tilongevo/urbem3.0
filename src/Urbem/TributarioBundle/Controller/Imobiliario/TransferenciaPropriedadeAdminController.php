<?php

namespace Urbem\TributarioBundle\Controller\Imobiliario;

use DateTime;
use Exception;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Urbem\CoreBundle\Entity\Imobiliario\Imovel;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Helper\BreadCrumbsHelper;
use Urbem\CoreBundle\Entity\Imobiliario\TransferenciaImovel;
use Urbem\CoreBundle\Entity\Imobiliario\TransferenciaEfetivacao;
use Urbem\CoreBundle\Entity\Imobiliario\DocumentoNatureza;
use Urbem\CoreBundle\Entity\Imobiliario\TransferenciaDocumento;
use Urbem\CoreBundle\Entity\Imobiliario\Proprietario;
use Urbem\CoreBundle\Entity\Imobiliario\ExProprietario;
use Urbem\CoreBundle\Entity\Imobiliario\TransferenciaAdquirente;
use Urbem\CoreBundle\Entity\Imobiliario\TransferenciaCancelamento;
use Urbem\CoreBundle\Entity\SwAssunto;

/**
 * Class TransferenciaPropriedadeController
 * @package Urbem\TributarioBundle\Controller\Imobiliario
 */
class TransferenciaPropriedadeAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function consultaProprietariosAction(Request $request)
    {
        /** @var Imovel $imovel */
        $imovel = $this
            ->getDoctrine()
            ->getRepository(Imovel::class)
            ->find($request->request->get('inscricaoMunicipal'));

        $proprietarios = array();
        /** @var Proprietario $proprietario */
        foreach ($imovel->getFkImobiliarioProprietarios() as $proprietario) {
            if (!$proprietario->getPromitente()) {
                $proprietarios[] = [
                    'numcgm' => $proprietario->getNumcgm(),
                    'nomCgm' => $proprietario->getFkSwCgm()->getNomCgm(),
                    'cota' => $proprietario->getCota()
                ];
            }
        }

        $response = new Response();
        $response->setContent(json_encode($proprietarios));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function consultaImovelAction(Request $request)
    {
        /** @var Imovel $imovel */
        $imovel = $this
            ->getDoctrine()
            ->getRepository(Imovel::class)
            ->find($request->request->get('inscricaoMunicipal'));

        $info = array();
        if ($imovel) {
            $info = [
                'localizacao' => $imovel->getLocalizacao(),
                'codigoComposto' => $imovel->getLocalizacao()->getCodigoComposto(),
                'codLocalizacao' => $imovel->getLocalizacao()->getCodLocalizacao(),
                'lote' => $imovel->getLote(),
                'numLote' => (string) $imovel->getLote(),
                'codLote' => $imovel->getLote()->getCodLote()
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
    public function consultaAdquirenteAction(Request $request)
    {
        /** @var SwCgm $swCgm */
        $swCgm = $this
            ->getDoctrine()
            ->getRepository(SwCgm::class)
            ->find($request->request->get('numcgm'));

        $adquirente = array();
        if ($swCgm) {
            $adquirente = [
                'numcgm' => $swCgm->getNumcgm(),
                'nomCgm' => $swCgm->getNomCgm()
            ];
        }

        $response = new Response();
        $response->setContent(json_encode($adquirente));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function assuntoAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $assuntos = $em
            ->getRepository(SwAssunto::class)
            ->findByCodClassificacao(
                $request->get('classificacao')
            );

        $results = [];
        foreach ((array) $assuntos as $assunto) {
            $results[] = [
                'key' => $assunto->getCodAssunto(),
                'value' => $assunto->getNomAssunto(),
            ];
        }

        return new JsonResponse($results);
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function efetivarAction(Request $request)
    {
        $id = $request->get('id');
        $this->setBreadCrumb($id ? ['id' => $id] : [], $request->get('_route'));

        $form = $this->createForm(
            'Urbem\TributarioBundle\Form\Imobiliario\TransferenciaPropriedadeType',
            null,
            [
                'action' => $this->generateUrl('urbem_tributario_imobiliario_transferencia_propriedade_efetivar_salvar')
            ]
        );
        $form->handleRequest($request);

        $params = array('codTransferencia' => $id);
        /** @var TransferenciaImovel $transferenciaImovel */
        $transferenciaImovel = $this->getDoctrine()->getRepository(TransferenciaImovel::class)->findOneBy($params);

        $adquirintes = null;
        $proprietarios = null;

        $documentos = $this->getDoctrine()->getRepository(DocumentoNatureza::class)->findBy(['codNatureza' => $transferenciaImovel->getCodNatureza()]);

        if ($transferenciaImovel->getFkImobiliarioTransferenciaAdquirentes()) {
            $adquirintes = $transferenciaImovel->getFkImobiliarioTransferenciaAdquirentes();
        }

        if ($transferenciaImovel->getFkImobiliarioImovel() && $transferenciaImovel->getFkImobiliarioImovel()->getFkImobiliarioProprietarios()) {
            $proprietarios = $transferenciaImovel->getFkImobiliarioImovel()->getFkImobiliarioProprietarios();
        }

        return $this->render('TributarioBundle::Imobiliario/TransferenciaPropriedade/efetivar_transferencia.html.twig', array(
            'transferenciaImovel' => $transferenciaImovel,
            'documentos' => $documentos,
            'efetivar' => true,
            'adquirentes' => $adquirintes,
            'proprietarios' => $proprietarios,
            'form' => $form->createView(),
            'errors' => $form->getErrors()
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function efetivarSalvarAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();
        $container = $this->container;

        $form = $request->get('transferencia_propriedade');
        $documentosRequest = $request->get('documentos');

        try {
            /** @var TransferenciaImovel $transferenciaImovel */
            $transferenciaImovel = $em->getRepository(TransferenciaImovel::class)->findOneBy(
                array(
                    'codTransferencia' => $request->request->get('codTransferencia')
                )
            );

            $documentoNaturezas = $em->getRepository(DocumentoNatureza::class)->findBy(
                array(
                    'codNatureza' => $transferenciaImovel->getFkImobiliarioNaturezaTransferencia()->getCodNatureza()
                )
            );

            // apaga documentos
            foreach ($transferenciaImovel->getFkImobiliarioTransferenciaDocumentos() as $transferenciaDocumento) {
                $transferenciaImovel->removeFkImobiliarioTransferenciaDocumentos($transferenciaDocumento);
            }

            // adiciona documentos
            $documentosObrigatorio = [];
            foreach ((array) $documentoNaturezas as $documentosNatureza) {
                if ($documentosNatureza->getTransferencia()) {
                    $transferenciaDocumento = new TransferenciaDocumento();
                    $transferenciaDocumento->setCodTransferencia($request->request->get('codTransferencia'));
                    $transferenciaDocumento->setCodDocumento($documentosNatureza->getCodDocumento());

                    $documentosObrigatorio[] = $transferenciaDocumento;
                }
            }

            $documentosNaoObrigatorio = [];
            foreach ((array) $documentosRequest as $documentosNatureza) {
                $transferenciaDocumento = new TransferenciaDocumento();
                $transferenciaDocumento->setCodTransferencia($request->request->get('codTransferencia'));
                $transferenciaDocumento->setCodDocumento($documentosNatureza['codDocumento']);

                $documentosNaoObrigatorio[] = $transferenciaDocumento;
            }

            $em->persist($transferenciaImovel);
            $em->flush();

            foreach ((array) $documentosObrigatorio as $documento) {
                $transferenciaImovel->addFkImobiliarioTransferenciaDocumentos($documento);
            }

            foreach ((array) $documentosNaoObrigatorio as $documento) {
                $transferenciaImovel->addFkImobiliarioTransferenciaDocumentos($documento);
            }

            $proprietarios = $em->getRepository(Proprietario::class)->findBy(
                array(
                    'inscricaoMunicipal' => $transferenciaImovel->getInscricaoMunicipal()
                )
            );
            // Remove proprietarios anteriores
            foreach ((array) $proprietarios as $proprietario) {
                $em->remove($proprietario);
            }
            $em->flush();

            // Add proprietarios em ex proprietario
            foreach ((array) $proprietarios as $proprietario) {
                $exProprietario = new ExProprietario();
                $exProprietario->setNumcgm($proprietario->getNumcgm());
                $exProprietario->setInscricaoMunicipal($transferenciaImovel->getInscricaoMunicipal());
                $exProprietario->setOrdem($proprietario->getOrdem());
                $exProprietario->setCota($proprietario->getCota());
            }
            $em->persist($exProprietario);
            $em->flush();

            $adquirentes = $em->getRepository(TransferenciaAdquirente::class)->findBy(
                array(
                    'codTransferencia' => $request->request->get('codTransferencia')
                )
            );
            // Remove ExProprietarios anteriores
            foreach ((array) $adquirentes as $adquirente) {
                $em->remove($adquirente);
            }
            $em->flush();

            // Add adquirentes em novo proprietario
            foreach ((array) $adquirentes as $adquirente) {
                $proprietario = new Proprietario();
                $proprietario->setNumcgm($adquirente->getNumcgm());
                $proprietario->setInscricaoMunicipal($transferenciaImovel->getInscricaoMunicipal());
                $proprietario->setOrdem($adquirente->getOrdem());
                $proprietario->setPromitente(false);
                $proprietario->setCota($adquirente->getCota());

                $em->persist($proprietario);
            }
            $em->flush();

            $transferenciaEfetivacao = new TransferenciaEfetivacao();
            $transferenciaEfetivacao->setDtEfetivacao(new DateTime($form['dtEfetivacao']));
            $transferenciaEfetivacao->setObservacao($form['observacoes']);

            $transferenciaEfetivacao->setFkImobiliarioTransferenciaImovel($transferenciaImovel);
            $transferenciaImovel->setFkImobiliarioTransferenciaEfetivacao($transferenciaEfetivacao);

            $em->persist($transferenciaImovel);
            $em->flush();
            $em->getConnection()->commit();

            $container->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('label.imobiliarioTransferenciaPropriedade.msgSucesso'));
        } catch (Exception $e) {
            $em->getConnection()->rollBack();
            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('contactSupport'));
        }

        return new RedirectResponse($this->generateUrl('urbem_tributario_imobiliario_transferencia_propriedade_list'));
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function cancelarAction(Request $request)
    {
        $id = $request->get('id');
        $this->setBreadCrumb($id ? ['id' => $id] : [], $request->get('_route'));

        $form = $this->createForm(
            'Urbem\TributarioBundle\Form\Imobiliario\TransferenciaPropriedadeType',
            null,
            [
                'action' => $this->generateUrl('urbem_tributario_imobiliario_transferencia_propriedade_cancelar_transferencia')
            ]
        );
        $form->handleRequest($request);

        $params = array('codTransferencia' => $id);
        /** @var TransferenciaImovel $transferenciaImovel */
        $transferenciaImovel = $this->getDoctrine()->getRepository(TransferenciaImovel::class)->findOneBy($params);

        return $this->render('TributarioBundle::Imobiliario/TransferenciaPropriedade/cancelar_transferencia.html.twig', array(
            'transferenciaImovel' => $transferenciaImovel,
            'form' => $form->createView(),
            'errors' => $form->getErrors()
        ));
    }

    /**
     * @param Request $request
     */
    public function cancelarTransferenciaAction(Request $request)
    {
        $container = $this->container;
        $em = $this->getDoctrine()->getManager();

        try {
            $transferenciaImovel = $em->getRepository(TransferenciaImovel::class)->findOneBy(
                [
                    'codTransferencia' => $request->get('codTransferencia')
                ]
            );

            $transferenciaCancelamento = new TransferenciaCancelamento();
            $transferenciaCancelamento->setMotivo('');
            $transferenciaImovel->setFkImobiliarioTransferenciaCancelamento($transferenciaCancelamento);
            $em->persist($transferenciaCancelamento);
            $em->flush();
            $container->get('session')->getFlashBag()->add('success', $this->get('translator')
                ->trans('label.imobiliarioTransferenciaPropriedade.msgCancelarSucesso', ['%codTransferencia%' => $request->get('codTransferencia')]));
        } catch (Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('contactSupport'));
        }
        (new RedirectResponse($this->generateUrl('urbem_tributario_imobiliario_transferencia_propriedade_list')))->send();
    }

    /**
     * @param array $param
     * @param null $route
     */
    public function setBreadCrumb($param = [], $route = null)
    {
        $entityManager = $this->getDoctrine()->getManager();

        BreadCrumbsHelper::getBreadCrumb(
            $this->get("white_october_breadcrumbs"),
            $this->get("router"),
            $route,
            $entityManager,
            $param
        );
    }
}
