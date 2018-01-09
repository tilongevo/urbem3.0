<?php

namespace Urbem\TributarioBundle\Controller\DividaAtiva;

use DateTime;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Urbem\CoreBundle\Entity\Administracao\ModeloDocumento;
use Urbem\CoreBundle\Entity\Divida\DividaCgm;
use Urbem\CoreBundle\Entity\Divida\DividaParcelamento;
use Urbem\CoreBundle\Entity\Divida\Documento;
use Urbem\CoreBundle\Entity\Divida\EmissaoDocumento;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Model\Divida\DocumentoModel;

/**
 * Class EmitirDocumentoAdminController
 *
 * @package Urbem\TributarioBundle\Controller\DividaAtiva
 */
class EmitirDocumentoAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function filtroAction(Request $request)
    {
        $request->query->set('filtro', 1);

        return parent::createAction();
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction()
    {
        $request = $this->getRequest();

        if ($request->get('filtro')) {
            $this->admin->filtro = $request->get($request->get('uniqid'));
            if (!$this->admin->filtro) {
                return new RedirectResponse('/tributario/divida-ativa/emissao-documentos/emitir-documento/filtro');
            }

            $request->query->set('filtro', 0);
            $request->request->replace([]);

            return parent::createAction();
        }

        $form = $this->admin->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && !$request->get('filtro')) {
            $documentos = $this->admin->emitirDocumentos();

            $this->admin->setBreadcrumb();

            return $this->render(
                'TributarioBundle::DividaAtiva/EmitirDocumento/lista_downloads.html.twig',
                [
                    'documentos' => $documentos,
                ]
            );
        }

        return new RedirectResponse('/tributario/divida-ativa/emissao-documentos/emitir-documento/filtro');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function apiDocumentoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $results = ['items' => []];
        if (!$request->get('q')) {
            return new JsonResponse($results);
        }

        $qb = $em->getRepository(ModeloDocumento::class)->createQueryBuilder('md');
        $qb->join(Documento::class, 'd', 'WITH', 'd.codDocumento = md.codDocumento AND d.codTipoDocumento = md.codTipoDocumento');
        $qb->join('d.fkDividaEmissaoDocumentos', 'ed');
        $qb->join(DividaParcelamento::class, 'dp', 'WITH', 'dp.numParcelamento = d.numParcelamento');
        $qb->join(DividaCgm::class, 'dc', 'WITH', 'dc.codInscricao = dp.codInscricao AND dc.exercicio = dp.exercicio');
        $qb->join(SwCgm::class, 's', 'WITH', 's.numcgm = dc.numcgm');

        if ($request->get('codTipoDocumento')) {
            $qb->andWhere('md.codTipoDocumento = :codTipoDocumento');
            $qb->setParameter('codTipoDocumento', $request->get('codTipoDocumento'));
        }

        $qb->andWhere('(md.codDocumento = :codDocumento OR LOWER(md.nomeDocumento) LIKE LOWER(:nomeDocumento))');
        $qb->setParameter('codDocumento', (int) $request->get('q'));
        $qb->setParameter('nomeDocumento', sprintf('%%%s%%', $request->get('q')));

        $qb->orderBy('md.codDocumento', 'ASC');

        foreach ((array) $qb->getQuery()->getResult() as $modeloDocumento) {
            $results['items'][] = [
                'id' => sprintf(
                    '%d~%d',
                    $modeloDocumento->getCodTipoDocumento(),
                    $modeloDocumento->getCodDocumento()
                ),
                'label' => sprintf(
                    '%d - %s',
                    $modeloDocumento->getCodDocumento(),
                    $modeloDocumento->getNomeDocumento()
                ),
            ];
        }

        return new JsonResponse($results);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function downloadDocumentoAction(Request $request)
    {
        setlocale(LC_ALL, 'pt_BR.utf8');

        $em = $this->getDoctrine()->getManager();

        $id = $request->get($this->admin->getIdParameter());
        list($numParcelamento, $numEmissao, $codTipoDocumento, $codDocumento, $numDocumento, $exercicio) = explode('~', $id);

        $emissaoDocumento = $em->getRepository(EmissaoDocumento::class)->findOneBy(
            [
                'numParcelamento' => $numParcelamento,
                'numEmissao' => $numEmissao,
                'codTipoDocumento' => $codTipoDocumento,
                'codDocumento' => $codDocumento,
                'numDocumento' => $numDocumento,
                'exercicio' => $exercicio
            ],
            [
                'timestamp' => 'DESC',
            ]
        );

        if (!$emissaoDocumento) {
            return $this->redirect($request->server->get('HTTP_REFERER'));
        }

        $documento = $emissaoDocumento->getFkDividaDocumento();
        $modeloDocumento = $documento->getFkAdministracaoModeloDocumento();

        $tributarioTemplatePath = $this->container->getParameter('tributariobundle');

        $nomeArquivo = str_replace(['.agt', '.odt'], '', $modeloDocumento->getNomeArquivoAgt());
        $template = sprintf('%s%s', $tributarioTemplatePath['templateOdt'], sprintf('%s%s', $nomeArquivo, '.odt'));
        $dadosArquivo = $this->getDadosDocumento($nomeArquivo, $documento);

        if (empty($dadosArquivo)) {
            $this->admin->container->get('session')->getFlashBag()->add('error', $this->admin->getTranslator()->trans('label.dividaAtivaEmitirDocumento.erro'));

            return $this->redirect($request->server->get('HTTP_REFERER'));
        }

        $openTBS = $this->get('opentbs');
        $openTBS->ResetVarRef(false);
        $openTBS->VarRef = $dadosArquivo['vars'];
        $openTBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8);

        foreach ($dadosArquivo['blocks'] as $block => $dados) {
            $openTBS->MergeBlock($block, $dados);
        }

        $openTBS->Show(OPENTBS_DOWNLOAD, sprintf('%s%s', $nomeArquivo, '.odt'));
    }

    /**
    * @param string    $nomeArquivo
    * @param Documento $documento
    * @return array
    */
    private function getDadosDocumento($nomeArquivo, Documento $documento)
    {
        $em = $this->getDoctrine()->getManager();
        $documentoModel = new DocumentoModel($em);

        if (in_array($nomeArquivo, ['termoInscricaoDAUrbem', 'certidaoDAUrbem', 'notificacaoDAUrbem'])) {
            return $documentoModel->fetchDadosCertidaoDAUrbem($documento, $nomeArquivo);
        }

        if (in_array($nomeArquivo, ['termoConsolidacaoDAUrbem', 'termoParcelamentoDAUrbem'])) {
            return $documentoModel->fetchDadosTermoConsolidacaoDAUrbem($documento, $nomeArquivo);
        }

        if (in_array($nomeArquivo, ['memorialCalculoDAUrbem'])) {
            return $documentoModel->fetchDadosMemorialCalculoDAUrbem($documento, $nomeArquivo);
        }

        if (in_array($nomeArquivo, ['certidaoDivida', 'termoInscricao'])) {
            return $documentoModel->fetchDadosCertidaoDivida($documento, $nomeArquivo);
        }

        if (in_array($nomeArquivo, ['notificacaoDivida'])) {
            return $documentoModel->fetchDadosNotificacaoDivida($documento, $nomeArquivo);
        }

        if (in_array($nomeArquivo, ['termoComposicaoDAMariana'])) {
            return $documentoModel->fetchDadosTermoComposicaoDAMariana($documento, $nomeArquivo);
        }

        return [];
    }
}
