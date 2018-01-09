<?php

namespace Urbem\TributarioBundle\Controller\DividaAtiva\CobrancaAdministrativa;

use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Inflector\Inflector;
use Doctrine\ORM\EntityManager;
use Exception;
use Sonata\AdminBundle\Controller\CRUDController;
use Sonata\DatagridBundle\ProxyQuery\ProxyQueryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Arrecadacao\ModeloCarne;
use Urbem\CoreBundle\Entity\Arrecadacao\Parcela as ArrecadacaoParcela;
use Urbem\CoreBundle\Entity\Divida\DividaAtiva;
use Urbem\CoreBundle\Entity\Divida\DividaParcelamento;
use Urbem\CoreBundle\Entity\Divida\Documento;
use Urbem\CoreBundle\Entity\Divida\EmissaoDocumento;
use Urbem\CoreBundle\Entity\Divida\Modalidade;
use Urbem\CoreBundle\Entity\Divida\ModalidadeVigencia;
use Urbem\CoreBundle\Model\Divida\DividaAtivaModel;
use Urbem\CoreBundle\Model\Divida\DocumentoModel;
use Urbem\CoreBundle\Model\Tributaria\DividaAtiva\CobrancaAdministrativa\CarneDividaModel;
use Urbem\PrestacaoContasBundle\Model\EntidadesModel;

class CobrarDividaAtivaAdminController extends CRUDController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function emitirDocumentoAction()
    {
        $this->admin->setBreadcrumb();
        $em = $this->getDoctrine()->getManager();
        $request = $this->getRequest();

        $carne = false;
        if ($request->query->get('emitirCarne')) {
            $carne = $request->query->get('modelo');
        }

        $session = $this->getRequest()->getSession();
        $dividas = $session->get('dividasBatch');
        $dividaPart = explode('~', reset($dividas));
        $dividaAtiva = $em->getRepository(DividaAtiva::class)->findOneBy(
            [
                'codInscricao' => $dividaPart[1],
                'exercicio' => $dividaPart[0],
            ]
        );

        $dividaParcelamento = $em->getRepository(DividaParcelamento::class)->findOneBy(
            [
                'codInscricao' => $dividaPart[1],
                'exercicio' => $dividaPart[0]
            ],
            [
                'numParcelamento' => 'DESC'
            ]
        );

        $numcgm = $dividaParcelamento->getFkDividaDividaAtiva()->getFkDividaDividaCgns()->last()->getNumcgm();

        $documentos = [];
        if ($request->query->get('emitirDocumentos')) {
            $tipoDocumentos = $this->admin->getDocumentos($request->query->get('codModalidade'));

            $documento = false;
            $parcelamento = $dividaParcelamento->getFkDividaParcelamento();
            if ($parcelamento) {
                $documento = $parcelamento->getFkDividaDocumentos();
            }

            $i = 0;
            foreach ($tipoDocumentos as $tipo) {
                $contribuinte = $this->admin->getCgmByDividaAtiva($dividaPart[1], $dividaPart[0]);
                $documentos[$i]['contribuinte'] = sprintf('%d - %s', $contribuinte->getNumcgm(), $contribuinte->getNomcgm());
                $documentos[$i]['modeloDocumento'] = $tipo->nome_documento;

                $criteria = Criteria::create()
                    ->where(Criteria::expr()->eq("codTipoDocumento", $tipo->cod_tipo_documento))
                    ->andWhere(Criteria::expr()->eq("codDocumento", $tipo->cod_documento))
                ;
                $documentoCriteria = $documento->matching($criteria);
                $documentos[$i]['documento'] = $documentoCriteria[0];
                $i++;
            }
        }

        return $this->render(
            'TributarioBundle::DividaAtiva/CobrancaAdministrativa/CobrarDividaAtiva/lista_downloads.html.twig',
            [
                'documentos' => $documentos,
                'carne' => $carne,
                'dividaAtiva' => $dividaAtiva,
                'lancamento' => $request->query->get('lancamento'),
                'numcgm' => $numcgm
            ]
        );
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
        $dadosArquivo = $this->getDadosDocumento($documento, $nomeArquivo);

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
     * Batch action.
     *
     * @return RedirectResponse|Response
     * @internal param Request $request
     *
     */
    public function batchAction()
    {
        $custom = $this->getConfigBatchCustomized();
        $template = $custom['template'];
        $request = $this->getRequest();

        $restMethod = $this->getRestMethod();

        if ('POST' !== $restMethod) {
            throw $this->createNotFoundException(sprintf('Invalid request type "%s", POST expected', $restMethod));
        }

        // check the csrf token
        $this->validateCsrfToken('sonata.batch');

        $confirmation = $request->get('confirmation', false);

        if ($data = json_decode($request->get('data'), true)) {
            $action = $data['action'];
            $idx = $data['idx'];
            $allElements = $data['all_elements'];

            $request->request->replace(array_merge($request->request->all(), $data));
        } else {
            $request->request->set('idx', $request->get('idx', []));
            $request->request->set('all_elements', $request->get('all_elements', false));
            $action = $request->get('action');
            $idx = $request->get('idx');
            $allElements = $request->get('all_elements');
            $data = $request->request->all();

            unset($data['_sonata_csrf_token']);
        }
        // customizado
        $data['template'] = $template;

        $batchActions = $this->admin->getBatchActions();
        if (!array_key_exists($action, $batchActions)) {
            throw new \RuntimeException(sprintf('The `%s` batch action is not defined', $action));
        }

        $camelizedAction = Inflector::classify($action);
        $isRelevantAction = sprintf('batchAction%sIsRelevant', $camelizedAction);

        if (method_exists($this, $isRelevantAction)) {
            $nonRelevantMessage = call_user_func([$this, $isRelevantAction], $idx, $allElements);
        } else {
            $nonRelevantMessage = count($idx) != 0 || $allElements; // at least one item is selected
        }

        if (!$nonRelevantMessage) { // default non relevant message (if false of null)
            $nonRelevantMessage = 'flash_batch_empty';
        }

        $datagrid = $this->admin->getDatagrid();
        $datagrid->buildPager();

        if (true !== $nonRelevantMessage) {
            $this->addFlash('sonata_flash_info', $nonRelevantMessage);

            return new RedirectResponse(
                $this->admin->generateUrl(
                    'list',
                    ['filter' => $this->admin->getFilterParameters()]
                )
            );
        }

        $askConfirmation = isset($batchActions[$action]['ask_confirmation']) ?
            $batchActions[$action]['ask_confirmation'] :
            true;

        if ($askConfirmation && $confirmation != 'ok') {
            $translationDomain = (!empty($batchActions[$action]['translation_domain']) ?: $this->admin->getTranslationDomain());
            $actionLabel = $this->admin->trans($batchActions[$action]['label'], [], $translationDomain);

            $formView = $datagrid->getForm()->createView();

            return $this->render($this->admin->getTemplate('batch_confirmation'), [
                'action' => 'edit',
                'action_label' => $actionLabel,
                'datagrid' => $datagrid,
                'form' => $formView,
                'data' => $data,
                'csrf_token' => $this->getCsrfToken('sonata.batch'),
            ], null);
        }

        // execute the action, batchAction
        $finalAction = sprintf('batchAction%s', $camelizedAction);

        if (!is_callable([$this, $finalAction])) {
            throw new \RuntimeException(sprintf('A `%s::%s` method must be callable', get_class($this), $finalAction));
        }

        $query = $datagrid->getQuery();

        $query->setFirstResult(null);
        $query->setMaxResults(null);

        $this->admin->preBatchAction($action, $query, $idx, $allElements);

        if (count($idx) > 0) {
            $this->admin->getModelManager()->addIdentifiersToQuery($this->admin->getClass(), $query, $idx);
        } elseif (!$allElements) {
            $query = null;
        }

        return call_user_func([$this, $finalAction], $query);
    }

    /**
     * @return array
     */
    protected function getConfigBatchCustomized()
    {
        $action = $this->getRequest()->request->get('action');
        $template = 'TributarioBundle:Sonata/DividaAtiva/CobrancaAdministrativa/CobrarDividaAtiva/CRUD:batch_confirmation_custom.html.twig';

        return [
            'template' => $template,
        ];
    }

    /**
     * @return Response
     * @throws \Exception
     */
    public function batchActionCobrarDivida()
    {
        $request = $this->admin->getRequest()->request->get('data');
        $request = json_decode($request);
        $modalidade = $this->admin->getRequest()->request->get('modalidades');
        $parcelas = $this->admin->getRequest()->request->get('parcelas');
        $dtVencimento = $this->admin->getRequest()->request->get('dtVencimento');

        $dividaAtivaBatch = $request->idx;
        sort($dividaAtivaBatch);

        $session = $this->getRequest()->getSession();

        $dividaAtivaModel = new DividaAtivaModel($this->getDoctrine()->getManager());

        $validateModalidadeParcelas = $dividaAtivaModel->validateModalidadeParcelas($modalidade, $parcelas, $dividaAtivaBatch);
        if (is_numeric($validateModalidadeParcelas)) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('label.tributarioCobrarDividaAtiva.erroParcelas', ['parcelas' => $validateModalidadeParcelas]));
            $this->forceRedirect($this->generateUrl('list'));
        }

        $session->set('dividasBatch', $dividaAtivaBatch);

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $container = $this->container;

        return new RedirectResponse(
            $this->admin->generateUrl(
                'edit',
                [
                    'id' => reset($dividaAtivaBatch),
                    'modalidade' => $modalidade,
                    'parcelas' => $parcelas,
                    'dtVencimento' => $dtVencimento
                ]
            )
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function simulacaoAction(Request $request)
    {
        $this->em = $this->getDoctrine()->getEntityManager();
        $container = $this->container;
        $entidade = $this->get('urbem.entidade')->getEntidade();
        $session = $this->getRequest()->getSession();
        $dividaAtiva = (array) $session->get('dividasBatch');

        if (!$dividaAtiva) {
            return;
        }

        $dividaAtivaPieces = explode('~', $dividaAtiva[0]);
        $exercicio = $dividaAtivaPieces[0];
        $inscricao = $dividaAtivaPieces[1];
        $codModalidade = $request->get('codModalidade');
        $dtPagamento = $request->get('dtPagamento');
        $usuario = $container->get('security.token_storage')->getToken()->getUser();

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml(
                $this->renderView(
                    'TributarioBundle:DividaAtiva/CobrancaAdministrativa/CobrarDividaAtiva/Relatorios:simulacao_cobranca_pdf.html.twig',
                    [
                        'contribuinte' => $this->admin->getCgmByDividaAtiva($inscricao, $exercicio),
                        'exercicio' => $exercicio,
                        'inscricao' => $this->admin->getInscricaoMunicipal($inscricao, $exercicio),
                        'inscricoesVinculadas' => $dividaAtiva,
                        'dtPagamento' => $dtPagamento,
                        'entidade' => $entidade,
                        'modalidade' => $codModalidade,
                        'endereco' => $this->admin->getCgmAddress($inscricao, $exercicio),
                        'admin' => $this->admin,
                        'versao' => $container->getParameter('version'),
                        'usuario' => $usuario,
                        'modulo' => 'Tributário',
                        'subModulo' => 'Dívida Ativa',
                        'funcao' => 'Cobrar Dívida Ativa',
                        'nomRelatorio' => 'Cobrar Dívida Ativa ',
                        'dtEmissao' => new \DateTime('now'),
                        'logoTipo' => $container->get('urbem.configuracao')->getLogoTipo(),
                        'modulo' => 'Tributário',
                    ]
                ),
                [
                    'orientation' => 'Landscape',
                    'encoding' => 'utf-8',
                    'enable-javascript' => true,
                    'margin-top'    => 30,
                ]
            ),
            200,
            [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => sprintf(
                    'inline; filename="%s-%d-%s.pdf"',
                    'CobrarDividaAtiva',
                    date('d-m-Y'),
                    sprintf('%d_%d', $inscricao, $exercicio)
                )
            ]
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function downloadCarneAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $codLancamento = $request->query->get('lancamento');
        $parcelaList = $em->getRepository(ArrecadacaoParcela::class)->findBy(['codLancamento' => $codLancamento]);

        $boletos = [];
        if ($parcelaList) {
            foreach ($parcelaList as $parcela) {
                $parcelaBoleto = $em->getRepository(DividaAtiva::class)->getParcelaBoleto($parcela->getCodParcela(), $parcela->getVencimento());

                $boletos[] = array_merge(
                    $parcelaBoleto,
                    [
                        'barcode' => $this->admin->generateBarCode(
                            $parcela->getFkArrecadacaoCarnes()->last()->getExercicio(),
                            $parcela->getValor(),
                            $parcela->getVencimento(),
                            $parcela->getFkArrecadacaoCarnes()->last()->getNumeracao()
                        )
                    ]
                );
            }
        }

        $carneModel = new CarneDividaModel($em);

        $entidadeModel = new EntidadesModel($em);
        $entidades = $entidadeModel->getEntidades($this->admin->getExercicio());
        $currentEntidade = $this->admin->getEntidade();
        $codEntidade = $currentEntidade->getCodEntidade();

        $dadosEntidade = [];
        foreach ($entidades as $key => $value) {
            if ($value['cod_entidade'] == $codEntidade) {
                $dadosEntidade = $value;
            }
        }

        $param['exercicio'] = $this->get('urbem.session.service')->getExercicio();
        $param['cod_modulo'] = Modulo::MODULO_ADMINISTRATIVO;

        $numcgm = $request->query->get('numcgm');
        $exercicio = $request->query->get('exercicio');
        $contribuinte = $em->getRepository(DividaAtiva::class)->getDadosContribuinte($numcgm, $exercicio, $codLancamento);

        $session = $this->getRequest()->getSession();
        $dividas = $session->get('dividasBatch');
        $dividaPart = explode('~', reset($dividas));

        $html = $this->renderView(
            'TributarioBundle:DividaAtiva/CobrancaAdministrativa/CobrarDividaAtiva/Relatorios:carne.html.twig',
            [
                'boletos' => $boletos,
                'logotipo' => $carneModel->getLogoTipo($param),
                'contribuinte' => $contribuinte,
                'boletoModel' => $carneModel,
                'admin' => $this->admin,
                'entidade' => $dadosEntidade,
                'cobranca' => $request->query->get('cobranca')
            ]
        );

        $filename = sprintf('EmissaoUrbem-%s.pdf', strtotime('now'));

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml(
                $html,
                [
                    'encoding' => 'utf-8',
                    'enable-javascript' => true,
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
    * @param string    $nomeArquivo
    * @param Documento $documento
    * @return array
    */
    private function getDadosDocumento(Documento $documento, $nomeArquivo)
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

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function carregaNumParcelasAjaxAction(Request $request)
    {
        $codModalidade = (int) $request->request->get('codModalidade');

        $numParcelas = [];
        if ($codModalidade) {
            $numParcelas = $this->admin->getNumParcelas($codModalidade);
        }

        $items = [
            'items' => $numParcelas
        ];

        return new JsonResponse($items);
    }
}
