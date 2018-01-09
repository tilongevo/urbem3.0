<?php

namespace Urbem\TributarioBundle\Controller\DividaAtiva\CobrancaAdministrativa;

use Doctrine\Common\Inflector\Inflector;
use Doctrine\ORM\EntityManager;
use Exception;
use Sonata\AdminBundle\Controller\CRUDController;
use Sonata\DatagridBundle\ProxyQuery\ProxyQueryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Arrecadacao\Carne;
use Urbem\CoreBundle\Entity\Arrecadacao\CarneDevolucao;
use Urbem\CoreBundle\Entity\Arrecadacao\Parcela as ArrecadacaoParcela;
use Urbem\CoreBundle\Entity\Divida\Parcela;
use Urbem\CoreBundle\Entity\Divida\Parcelamento;
use Urbem\CoreBundle\Entity\Divida\ParcelamentoCancelamento;

class EstornarCobrancaAdminController extends CRUDController
{
    protected $codMotivoDevolucao = 12;

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
                'action' => 'list',
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
        $template = 'TributarioBundle:Sonata/DividaAtiva/CobrancaAdministrativa/CRUD:batch_confirmation_custom.html.twig';

        return [
            'template' => $template,
        ];
    }

    /**
     * @return Response
     * @throws \Exception
     */
    public function batchActionMotivo()
    {
        $request = $this->admin->getRequest()->request->get('data');
        $request = json_decode($request);
        $motivo = $this->admin->getRequest()->request->get('motivo');

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $container = $this->container;

        try {
            foreach ($request->idx as $key => $num_parcelamento) {
                $parcelamento = $em->getRepository(Parcelamento::class)->findOneByNumParcelamento($num_parcelamento);

                $dividaParcelas = $em->getRepository(Parcela::class)->findBy(
                    [
                        'numParcelamento' => $num_parcelamento,
                        'cancelada' => false,
                        'paga' => false
                    ]
                );

                $parcelamentoCancelamento = $this->insertParcelamentoCancelamento($num_parcelamento, $motivo);

                $this->estornarCobranca($parcelamento, $dividaParcelas);

                $parcelamento->setFkDividaParcelamentoCancelamento($parcelamentoCancelamento);
            }

            $em->persist($parcelamento);
            $em->flush();

            $this->addFlash('sonata_flash_success', $this->admin->trans('label.tributarioEstornarCobranca.messageEstornoSucesso'));

            return new RedirectResponse(
                $this->admin->generateUrl('list')
            );
        } catch (Exception $e) {
            $this->addFlash('sonata_flash_error', $this->admin->trans('label.tributarioEstornarCobranca.messageEstornoErro'));

            return new RedirectResponse(
                $this->admin->generateUrl('list', $this->admin->getFilterParameters())
            );
        }
    }

    /**
     *  @param $parcelamento
     *  @param $parcelas
     *  @return void
     *
     */
    protected function estornarCobranca($parcelamento, $parcelas = [])
    {
        foreach ($parcelas as $parcela) {
            $parcela->setCancelada(true);

            if ($parcela->getFkDividaParcelaCalculos() &&
                $parcela->getFkDividaParcelaCalculos()->last()->getFkArrecadacaoCalculo() &&
                $parcela->getFkDividaParcelaCalculos()->last()->getFkArrecadacaoCalculo()->getFkArrecadacaoLancamentoCalculos()) {
                    $codLancamento = ($parcela->getFkDividaParcelaCalculos()->last()->getFkArrecadacaoCalculo()->getFkArrecadacaoLancamentoCalculos()->last()) ?: false;
                    $this->setCarneDevolucao($codLancamento, $parcela->getNumParcela());
            }

            $parcelamento->addFkDividaParcelas($parcela);
        }
    }

    /**
     * @param   $codLancamento
     * @param   $parcela
     * @return  void
     */
    protected function setCarneDevolucao($codLancamento, $parcela)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $rsArrecadacaoParcela = $em->getRepository(ArrecadacaoParcela::class)->findOneBy(
            [
                'codLancamento' => $codLancamento->getCodLancamento(),
                'nrParcela' => $parcela
            ]
        );

        $codParcela = $rsArrecadacaoParcela->getCodParcela();

        if ($codParcela) {
            $carne = $em->getRepository(Carne::class)->findOneByCodParcela($codParcela);
            $this->insertCarneDevolucao($carne->getNumeracao(), $carne->getCodConvenio());
        }
    }

    /**
     *  @param  $numeracao
     *  @param  $codConvenio
     *  @return void
     */
    protected function insertCarneDevolucao($numeracao, $codConvenio)
    {
        if ($numeracao && $codConvenio) {
            /** @var EntityManager $em */
            $em = $this->getDoctrine()->getManager();

            $carneDevolucao = new CarneDevolucao();
            $carneDevolucao->setNumeracao($numeracao);
            $carneDevolucao->setCodConvenio($codConvenio);
            $carneDevolucao->setCodMotivo($this->codMotivoDevolucao);
            $carneDevolucao->setDtDevolucao(new \DateTime('NOW'));

            $em->persist($carneDevolucao);
            $em->flush();
        }
    }

    /**
     * @param  $numParcelamento
     * @param  $motivo
     * @return ParcelamentoCancelamento
     */
    protected function insertParcelamentoCancelamento($numParcelamento, $motivo)
    {
        $parcelamentoCancelamento = new ParcelamentoCancelamento();
        $parcelamentoCancelamento->setNumParcelamento($numParcelamento);
        $parcelamentoCancelamento->setNumcgm($this->admin->getCurrentUser()->getNumcgm());
        $parcelamentoCancelamento->setMotivo($motivo);

        return $parcelamentoCancelamento;
    }
}
