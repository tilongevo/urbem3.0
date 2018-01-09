<?php

namespace Urbem\AdministrativoBundle\Controller\Protocolo;

use Doctrine\ORM\EntityManager;

use Sonata\DoctrineORMAdminBundle\Model\ModelManager;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwAssuntoAtributo;
use Urbem\CoreBundle\Entity\SwAtributoProtocolo;
use Urbem\CoreBundle\Entity\SwDocumento;
use Urbem\CoreBundle\Exception\Error;
use Urbem\CoreBundle\Model\SwAtributoProtocoloModel;
use Urbem\CoreBundle\Model\SwDocumentoModel;
use Urbem\CoreBundle\Model\SwProcessoModel;
use Doctrine\Common\Inflector\Inflector;

/**
 * Class ProcessoAdminController
 *
 * @package Urbem\AdministrativoBundle\Controller\Protocolo
 */
class ProcessoAdminController extends AbstractProcessoController
{
    const FILE_FIELD_PREFIX = 'documento_';
    const ATTR_FIELD_PREFIX = 'atributo_dinamico_';

    public function batchActionReceber()
    {
        $request = $this->admin->getRequest()->request->get('data');
        $request = json_decode($request);

        /** @var EntityManager $entityManager */
        $entityManager = $this->getDoctrine()->getManager();
        $container = $this->container;

        try {
            $usuario = $container->get('security.token_storage')->getToken()->getUser()->getId();
            $usuario = $entityManager->getRepository('CoreBundle:SwCgm')->find($usuario);

            $swProcessoModel = new SwProcessoModel($entityManager);

            foreach ($request->idx as $processo) {
                list($codProcesso, $anoExercicio) = explode("~", $processo);
                $processo = $entityManager->getRepository('CoreBundle:SwProcesso')->findOneBy(['codProcesso' => $codProcesso, 'anoExercicio' => $anoExercicio]);
                $situacao = $entityManager->getRepository('CoreBundle:SwSituacaoProcesso')->findOneByNomSituacao('Em andamento, recebido');

                $parameters['codSituacao'] = 2;
                $parameters['codProcesso'] = $processo;
                $andamento = $entityManager->getRepository('CoreBundle:SwAndamento')->findOneBy(
                    [
                        'anoExercicio' => $processo->getAnoExercicio(),
                        'codProcesso'  => $processo->getCodProcesso(),
                        'codSituacao'  => $parameters['codSituacao']
                    ],
                    [
                        'timestamp' => 'DESC'
                    ]
                );

                // Recebimento
                $recebimentoExists = $entityManager->getRepository('CoreBundle:SwRecebimento')->findOneBy(
                    ['codProcesso' => $codProcesso, 'anoExercicio' => $anoExercicio, 'codAndamento' => $andamento->getCodAndamento()]
                );

                if ($recebimentoExists) {
                    $this->addFlash('sonata_flash_error', sprintf(Error::PROCESS_ALREADY_EXISTS . ': %s/%s', $codProcesso, $anoExercicio));

                    throw new Exception(Error::PROCESS_ALREADY_EXISTS);
                }

                $swProcessoModel->receber($processo, $situacao, $andamento, $usuario);
            }
        } catch (Exception $e) {
            $this->addFlash('sonata_flash_error', 'Falha ao receber processos');

            return new RedirectResponse(
                $this->admin->generateUrl('list', $this->admin->getFilterParameters())
            );
        }
        $this->addFlash('sonata_flash_success', 'Processos recebidos com sucesso');

        return new RedirectResponse(
            $this->admin->generateUrl('list', $this->admin->getFilterParameters())
        );
    }

    public function batchActionEncaminhar()
    {
        $requestData = $this->admin->getRequest()->request->get('data');

        $requestData = json_decode($requestData);

        $request = $this->admin->getRequest()->request->get('encaminhar');
        $length = count($request) - 1;
        $codOrgao = $request['orgao_' . $length];

        /** @var EntityManager $entityManager */
        $entityManager = $this->getDoctrine()->getManager();
        $container = $this->container;

        try {
            $usuario = $container->get('security.token_storage')->getToken()->getUser()->getId();
            $usuario = $entityManager->getRepository('CoreBundle:SwCgm')->find($usuario);

            $orgao = $entityManager->getRepository('CoreBundle:Organograma\Orgao')->findOneByCodOrgao($codOrgao);
            $situacao = $entityManager->getRepository('CoreBundle:SwSituacaoProcesso')->findOneByNomSituacao('Em andamento, a receber');

            $swProcessoModel = new SwProcessoModel($entityManager);
            foreach ($requestData->idx as $processo) {
                list($codProcesso, $anoExercicio) = explode('~', $processo);
                $processo = $entityManager->getRepository('CoreBundle:SwProcesso')->findOneBy(['codProcesso' => $codProcesso, 'anoExercicio' => $anoExercicio]);

                $swProcessoModel->encaminhar($processo, $situacao, $usuario, $orgao);
            }
        } catch (Exception $e) {
            $this->addFlash('sonata_flash_error', 'Falha ao encaminhar processo');

            return new RedirectResponse(
                $this->admin->generateUrl('list', $this->admin->getFilterParameters())
            );
        }
        $this->addFlash('sonata_flash_success', 'Processo encaminhado com sucesso');

        return new RedirectResponse(
            $this->admin->generateUrl('list', $this->admin->getFilterParameters())
        );
    }

    protected function getConfigBatchCustomized()
    {
        $action = $this->getRequest()->request->get('action');
        $template = null;
        if ($action == 'encaminhar') {
            $template = 'AdministrativoBundle:Sonata:Processo/CRUD/encaminharProcessoLote.html.twig';
        }

        $entityManager = $this->getDoctrine()->getManager();
        $formEncaminhar = $this->createForm(
            'Urbem\AdministrativoBundle\Form\Protocolo\Processo\EncaminharType',
            null,
            ['em' => $entityManager]
        );

        return [
            'template'       => $template,
            'formCustomized' => $formEncaminhar->createView()
        ];
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
        $formCustomized = $custom['formCustomized'];

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
                'action'         => 'list',
                'action_label'   => $actionLabel,
                'datagrid'       => $datagrid,
                'form'           => $formView,
                'data'           => $data,
                'csrf_token'     => $this->getCsrfToken('sonata.batch'),
                // customizado
                'formCustomized' => $formCustomized,
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
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function assuntoClassificacaoAction(Request $request)
    {
        $codClassificacao = $request->get('codClassificacao');
        $entityManager = $this->getDoctrine()->getManager();
        $swAssuntoArray = $entityManager
            ->getRepository('CoreBundle:SwAssunto')
            ->findBy(['codClassificacao' => $codClassificacao], ['nomAssunto' => 'ASC']);

        $swAssuntoArrayList = [];

        /** @var SwAssunto $swAssunto */
        foreach ($swAssuntoArray as $swAssunto) {
            $swAssuntoArrayList[] = [
                'label' => $swAssunto->getNomAssunto(),
                'value' => $this->admin->id($swAssunto)
            ];
        }

        return new JsonResponse($swAssuntoArrayList);
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function documentosAssuntoAction(Request $request)
    {
        $assuntoObjectKey = $request->get('id');

        /** @var ModelManager $modelManager */
        $modelManager = $this->admin->getModelManager();
        $entityManager = $modelManager->getEntityManager(SwDocumento::class);

        /** @var SwAssunto $swAssunto */
        $swAssunto = $modelManager->find(SwAssunto::class, $assuntoObjectKey);

        $swDocumentosArray = [];

        if (!is_null($swAssunto)) {
            $swDocumentosArray = (new SwDocumentoModel($entityManager))->getDocumentosBySwAssunto($swAssunto);
        }

        return $this->render('@Administrativo/Sonata/Processo/API/form__documentos.html.twig', [
            'swDocumentoArray' => $swDocumentosArray,
            'fileFieldPrefix'  => self::FILE_FIELD_PREFIX
        ]);
    }

    /**
     * @param FormBuilder         $formBuilder
     * @param SwAtributoProtocolo $swAtributoProtocolo
     *
     * @internal param Form $form
     */
    private function addAtributoDinamico(FormBuilder $formBuilder, SwAtributoProtocolo $swAtributoProtocolo)
    {
        $defaultOptions = [
            'attr'       => ['class' => 'campo-sonata form-control'],
            'data'       => $swAtributoProtocolo->getValorPadrao(),
            'label'      => ucwords($swAtributoProtocolo->getNomAtributo()),
            'label_attr' => ['class' => 'control-label '],
            'mapped'     => false,
            'required'   => $swAtributoProtocolo->getObrigatorio()
        ];

        $fieldName = self::ATTR_FIELD_PREFIX . $swAtributoProtocolo->getCodAtributo();

        switch ($swAtributoProtocolo->getTipo()) {
            case 't':
                $formBuilder->add($fieldName, TextType::class, $defaultOptions);

                break;
            case 'n':
                $formBuilder->add($fieldName, NumberType::class, array_merge($defaultOptions, [
                    'data' => abs($defaultOptions['data'])
                ]));

                break;
            case 'l':
                $arrayData = explode("\r\n", $swAtributoProtocolo->getValorPadrao());

                $choices = [];
                foreach ($arrayData as $choice) {
                    if (!empty($choice)) {
                        $choices[$choice] = $choice;
                    }
                }

                $formBuilder->add($fieldName, ChoiceType::class, array_merge($defaultOptions, [
                    'attr'        => ['class' => 'select2-parameters '],
                    'choices'     => $choices,
                    'placeholder' => 'label.selecione'
                ]));
        }
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function atributoDinamicoAction(Request $request)
    {
        $assuntoObjectKey = $request->get('id');

        /** @var ModelManager $modelManager */
        $modelManager = $this->admin->getModelManager();
        $entityManager = $modelManager->getEntityManager(SwAssuntoAtributo::class);

        /** @var SwAssunto $swAssunto */
        $swAssunto = $modelManager->find(SwAssunto::class, $assuntoObjectKey);

        $swAtributoProtocoloArray = [];

        if (!is_null($swAssunto)) {
            $swAtributoProtocoloArray = (new SwAtributoProtocoloModel($entityManager))->getAtributosBySwAssunto($swAssunto);
        }

        $formBuilder = $this->createFormBuilder([]);

        /** @var SwAtributoProtocolo $swAtributoProtocolo */
        foreach ($swAtributoProtocoloArray as $swAtributoProtocolo) {
            $this->addAtributoDinamico($formBuilder, $swAtributoProtocolo);
        }

        $form = $formBuilder->getForm();

        return $this->render('@Administrativo/Sonata/Processo/API/form__atributos.html.twig', [
            'form'                 => $form->createView(),
            'swAtirbutoProtocolos' => $swAtributoProtocoloArray
        ]);
    }
}
