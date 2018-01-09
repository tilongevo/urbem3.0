<?php

namespace Urbem\AdministrativoBundle\Controller\Protocolo;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;

use Sonata\DoctrineORMAdminBundle\Model\ModelManager;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Urbem\CoreBundle\Entity\Organograma\Orgao;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Entity\SwProcessoApensado;
use Urbem\CoreBundle\Entity\SwSituacaoProcesso;
use Urbem\CoreBundle\Model\SwProcessoModel;

/**
 * Class ProcessoAcoesController
 *
 * @package Urbem\AdministrativoBundle\Controller\Protocolo
 */
class ProcessoEtapasController extends AbstractProcessoController
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function despacharAction(Request $request)
    {
        $routeName = str_replace('Action', '', __FUNCTION__);
        $request->request->set('routeName', $routeName);

        $this->admin->setLabel($this->trans('label.processo.despachar'));

        $form = $this->getForm();
        if ($form->isSubmitted()) {
            $swProcesso = $this->getSwProcesso();

            /** @var ModelManager $modelManager */
            $modelManager = $this->admin->getModelManager();

            /** @var SwProcessoApensado $swProcessoApensado */
            $swProcessoApensado = $modelManager->findOneBy(SwProcessoApensado::class, [
                'codProcessoPai'          => $swProcesso->getCodProcesso(),
                'timestampDesapensamento' => null
            ]);

            if (is_null($swProcessoApensado)) {
                $entityManager = $modelManager->getEntityManager(SwProcesso::class);
                $descricao = $form->get('formType')->get('descricao')->getData();

                $entityManager->getConnection()->beginTransaction();
                try {
                    (new SwProcessoModel($entityManager))
                        ->despachar($swProcesso, $this->admin->getCurrentUser(), $descricao);

                    $entityManager->getConnection()->commit();

                    $this->addFlashMessage('swProcesso.despacho.success');
                } catch (\Exception $exception) {
                    $this->addFlashMessage('swProcesso.despacho.error.exception', [], 'flashes', 'error');
                    $entityManager->getConnection()->rollback();
                }
            } else {
                $this->addFlashMessage('swProcesso.despacho.error.processoApensado', [], 'flashes', 'error');
            }

            return $this->redirectToSwProcessoShowPage();
        }

        return $this->editAction();
    }

    /**
     * @return RedirectResponse     *
     */
    public function receberAction()
    {
        /** @var ModelManager $modelManager */
        $modelManager = $this->admin->getModelManager();
        $swProcesso = $this->getSwProcesso();

        /** @var SwProcessoApensado $swProcessoApensado */
        $swProcessoApensado = $modelManager->findOneBy(SwProcessoApensado::class, [
            'codProcessoPai'          => $swProcesso->getCodProcesso(),
            'timestampDesapensamento' => null
        ]);

        if (is_null($swProcessoApensado)) {
            $entityManager = $modelManager->getEntityManager(SwProcesso::class);
            $entityManager->getConnection()->beginTransaction();
            try {
                (new SwProcessoModel($entityManager))
                    ->receber($swProcesso, $this->admin->getCurrentUser());

                $entityManager->getConnection()->commit();

                $this->addFlashMessage('swProcesso.receber.success');
            } catch (\Exception $exception) {
                $this->addFlashMessage('swProcesso.receber.error.exception', [], 'flashes', 'error');
                $entityManager->getConnection()->rollback();
            }
        } else {
            $this->addFlashMessage('swProcesso.receber.error.processoApensado', [], 'flashes', 'error');
        }

        return $this->redirectToSwProcessoShowPage();
    }

    /**
     * @return RedirectResponse
     */
    public function cancelarEncaminhamentoAction()
    {
        /** @var ModelManager $modelManager */
        $modelManager = $this->admin->getModelManager();
        $swProcesso = $this->getSwProcesso();

        /** @var SwProcessoApensado $swProcessoApensado */
        $swProcessoApensado = $modelManager->findOneBy(SwProcessoApensado::class, [
            'codProcessoPai'          => $swProcesso->getCodProcesso(),
            'timestampDesapensamento' => null
        ]);

        if (is_null($swProcessoApensado)) {
            $entityManager = $modelManager->getEntityManager(SwProcesso::class);
            $entityManager->getConnection()->beginTransaction();

            try {
                (new SwProcessoModel($entityManager))
                    ->cancelarEncaminhamento($swProcesso);

                $entityManager->getConnection()->commit();

                $this->addFlashMessage('swProcesso.cancelarEncaminhamento.success');
            } catch (\Exception $exception) {
                $this->addFlashMessage('swProcesso.cancelarEncaminhamento.error.exception', [], 'flashes', 'error');
                $entityManager->getConnection()->rollback();
            }
        } else {
            $this->addFlashMessage('swProcesso.cancelarEncaminhamento.error.processoApensado', [], 'flashes', 'error');
        }

        return $this->redirectToSwProcessoShowPage();
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function arquivarAction(Request $request)
    {
        $routeName = str_replace('Action', '', __FUNCTION__);
        $request->request->set('routeName', $routeName);

        $this->admin->setLabel($this->trans('label.processo.arquivamento.arquivar'));

        $form = $this->getForm();
        if ($form->isSubmitted()) {
            $swProcesso = $this->getSwProcesso();

            /** @var ModelManager $modelManager */
            $modelManager = $this->admin->getModelManager();
            $entityManager = $modelManager->getEntityManager(SwProcesso::class);

            $form = $form->get('formType');
            $swSituacaoProcesso = $form->get('fkSwSituacaoProcesso')->getData();
            $textoComplementar = $form->get('textoComplementar')->getData();
            $swHistorico = $form->get('fkSwHistoricoArquivamento')->getData();
            $localizacao = $form->get('localizacao')->getData();

            $entityManager->getConnection()->beginTransaction();
            try {
                $swCgm = $this->admin->getCurrentUser()->getFkSwCgm();

                (new SwProcessoModel($entityManager))
                    ->arquivar($swHistorico, $swSituacaoProcesso, $swProcesso, $swCgm, $localizacao, $textoComplementar);

                $entityManager->getConnection()->commit();

                $this->addFlashMessage('swProcesso.arquivar.success');
            } catch (\Exception $exception) {
                $this->addFlashMessage('swProcesso.arquivar.error.exception', [], 'flashes', 'error');
                $entityManager->getConnection()->rollback();
            }

            return $this->redirectToSwProcessoShowPage();
        }

        return $this->editAction();
    }

    /**
     * @return RedirectResponse
     */
    public function desarquivarAction()
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->admin->getModelManager()->getEntityManager(SwProcesso::class);
        $swProcesso = $this->getSwProcesso();

        $entityManager->getConnection()->beginTransaction();

        try {
            (new SwProcessoModel($entityManager))->desarquivar($swProcesso);

            $entityManager->getConnection()->commit();

            $this->addFlashMessage('swProcesso.desarquivar.success');
        } catch (\Exception $exception) {
            $this->addFlashMessage('swProcesso.desarquivar.error.exception', [], 'flashes', 'error');
            $entityManager->getConnection()->rollback();
        }

        return $this->redirectToSwProcessoShowPage();
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function apensarAction(Request $request)
    {
        $routeName = str_replace('Action', '', __FUNCTION__);
        $request->request->set('routeName', $routeName);

        $this->admin->setLabel($this->trans('label.processo.apensar.apensar'));

        $form = $this->getForm();
        if ($form->isSubmitted()) {
            $swProcesso = $this->getSwProcesso();

            /** @var ModelManager $modelManager */
            $modelManager = $this->admin->getModelManager();
            $entityManager = $modelManager->getEntityManager(SwProcesso::class);

            $form = $form->get('formType');

            /** @var ArrayCollection $swProcessosFilhos */
            $swProcessosFilhos = $form->get('swProcessos')->getData();

            $entityManager->getConnection()->beginTransaction();
            try {
                (new SwProcessoModel($entityManager))
                    ->apensarProcessos($swProcesso, $swProcessosFilhos);

                $entityManager->getConnection()->commit();

                $this->addFlashMessage('swProcesso.apensar.success');
            } catch (\Exception $exception) {
                $this->addFlashMessage('swProcesso.apensar.error.exception', [], 'flashes', 'error');
                $entityManager->getConnection()->rollback();
            }

            return $this->redirectToSwProcessoShowPage();
        }

        return $this->editAction();
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function desapensarAction(Request $request)
    {
        $routeName = str_replace('Action', '', __FUNCTION__);
        $request->request->set('routeName', $routeName);

        $this->admin->setLabel($this->trans('label.processo.apensar.desapensar'));

        $form = $this->getForm();
        if ($form->isSubmitted()) {
            $swProcesso = $this->getSwProcesso();

            /** @var ModelManager $modelManager */
            $modelManager = $this->admin->getModelManager();
            $entityManager = $modelManager->getEntityManager(SwProcesso::class);

            $form = $form->get('formType');

            /** @var ArrayCollection $swProcessosFilhos */
            $swProcessosFilhos = $form->get('swProcessos')->getData();

            $entityManager->getConnection()->beginTransaction();
            try {
                (new SwProcessoModel($entityManager))
                    ->desapensarProcessos($swProcesso, $swProcessosFilhos);

                $entityManager->getConnection()->commit();

                $this->addFlashMessage('swProcesso.desapensar.success');
            } catch (\Exception $exception) {
                $this->addFlashMessage('swProcesso.desapensar.error.exception', [], 'flashes', 'error');
                $entityManager->getConnection()->rollback();
            }

            return $this->redirectToSwProcessoShowPage();
        }

        return $this->editAction();
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function encaminharAction(Request $request)
    {
        $request->request->set('routeName', 'encaminhar');

        $this->admin->setLabel($this->trans('label.processo.encaminhar_processo'));

        $form = $this->getForm();

        if (true === $form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();

            $orgao = null;

            foreach ($form->all() as $field) {
                if (false === strpos($field->getName(), 'nivel_organograma_')) {
                    continue;
                }

                if (true === empty($field->getData())) {
                    continue;
                }

                $orgao = $field->getData();
            }

            try {
                (new SwProcessoModel($em))->encaminhar(
                    $this->getSwProcesso(),
                    $em->getRepository(SwSituacaoProcesso::class)->findOneBy(['codSituacao' => SwSituacaoProcesso::EM_ANDAMENTO_RECEBER]),
                    $this->getUser(),
                    $em->getRepository(Orgao::class)->findOneBy([
                        'codOrgao' => $orgao,
                    ])
                );

                $this->addFlashMessage('swProcesso.encaminhar.success');

            } catch (\Exception $exception) {
                $this->addFlashMessage('swProcesso.encaminhar.error.exception', [], 'flashes', 'error');
            }

            return $this->redirectToSwProcessoShowPage();
        }

        return $this->editAction();
    }
}
