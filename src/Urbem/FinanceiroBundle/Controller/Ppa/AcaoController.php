<?php

namespace Urbem\FinanceiroBundle\Controller\Ppa;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Ppa\AcaoRecurso;
use Urbem\CoreBundle\Entity\Ppa\AcaoMetaFisicaRealizada;

class AcaoController extends BaseController
{

    /**
     * Home
     */
    public function homeAction(Request $request)
    {
        $this->setBreadCrumb();
        return $this->render('FinanceiroBundle::PlanoPlurianual/Acao/home.html.twig');
    }

    /**
     * @param array $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        parent::load($configs, $container);
        $this->breadcrumb = $this->get("white_october_breadcrumbs");
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function lancarAction(Request $request)
    {
        $this->setBreadCrumb();

        $container = $this->container;

        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();
        try {
            $form = $request->request->get('form');
            $ppaModel = (new \Urbem\CoreBundle\Model\Ppa\PpaModel($em));
            $ppa = $ppaModel->getPpaExercicio($this->getExercicio());
            $ano = $this->getExercicio() - $ppa->getAnoInicio() + 1;

            $metaFisicaRealizada = $em->getRepository('CoreBundle:Ppa\\Acao')->verificaMetasFisicasRealizadas($ano, $this->getExercicio());
            $listRecurso = new ArrayCollection();
            $dadosGeralArray = clone $listRecurso;
            $dadosMultiArray = clone $listRecurso;
            $dadosArray = clone $listRecurso;
            foreach ($metaFisicaRealizada as $index => $value) {
                $listRecurso->set($value['cod_recurso'], $value['nom_cod_recurso']);
                for ($i=1; $i<5; $i++) {
                    if (!empty($value['ano' . $i])) {
                        $dadosArray->set('ano', $value['ano' . $i]);
                        $dadosArray->set('ano_qtd', $value['ano' . $i . '_qtd']);
                        $dadosArray->set('ano_valor', $value['ano' . $i . '_valor']);
                        $dadosArray->set('ano_realizada', $value['ano' . $i . '_realizada']);
                        $dadosArray->set('ano_justificativa', $value['ano' . $i . '_justificativa']);
                        $dadosMultiArray->set($value['ano' . $i], $dadosArray);
                        $dadosArray = new ArrayCollection();
                    }
                }
                $iterator = $dadosMultiArray->getIterator();
                $iterator->ksort();
                $collection = new ArrayCollection(iterator_to_array($iterator));
                $rrayBloco = new ArrayCollection();
                $rrayBloco->set('nom_cod_recurso', $value['nom_cod_recurso']);
                $rrayBloco->set('num_acao', $value['num_acao']);
                $rrayBloco->set('cod_recurso', $value['cod_recurso']);
                $rrayBloco->set('nom_recurso', $value['nom_recurso']);
                $rrayBloco->set('total_valor', $value['total_valor']);
                $rrayBloco->set('timestamp_acao_dados', $value['timestamp_acao_dados']);
                $rrayBloco->set('cod_acao', $value['cod_acao']);
                $rrayBloco->set('valores', $collection);
                $dadosGeralArray->add($rrayBloco);
            }
            $form = $this->createForm('Urbem\FinanceiroBundle\Form\Ppa\AcaoLancarMetaType', null, array( 'action' => $this->generateUrl('financeiro_ppa_acao_lancar_gravar')));
            $form->handleRequest($request);
            return $this->render('FinanceiroBundle::PlanoPlurianual/Acao/lancar_meta.html.twig', array(
                'ppa' => $ppa,
                'ano' => $ano,
                'exercicio' => $this->getExercicio(),
                'metaFisicaRealizada' => $dadosGeralArray->toArray(),
                'form' => $form->createView(),
                'errors' => $form->getErrors(),
                'listaRecursos' => $listRecurso
            ));

            $em->getConnection()->commit();
        } catch (\Exception $e) {
            $em->getConnection()->rollback();
            $container->get('session')->getFlashBag()->add('error', $container->get('translator')->transChoice('label.ppaAcao.erroLancamento', 0, [], 'messages'));
            throw $e;
        }

        $this->redirect("/financeiro/ppa/acao/home");
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function lancarGravarAction(Request $request)
    {
        $container = $this->container;
        $dataForm = $request->request->all();

        if (!empty($dataForm['meta'])) :
            foreach ($dataForm['meta'] as $codAcao => $metas) {
                $codRecurso = $metas['cod_recurso'];
                $timestampAcaoDados = $metas['timestamp_acao_dados'];

                $acaoRecursos = $this->getDoctrine()->getRepository(AcaoRecurso::class)->findBy(
                    ['codRecurso' => $codRecurso, 'timestampAcaoDados' => $timestampAcaoDados, 'codAcao' => $codAcao]
                );

                foreach ($acaoRecursos as $acaoRecurso) {
                    if (!empty($metas['valores'][$acaoRecurso->getExercicioRecurso()])) {
                        if (!empty($acaoRecurso->getFkPpaAcaoMetaFisicaRealizada())) {
                            $acaoRecurso->getFkPpaAcaoMetaFisicaRealizada()->setValor($metas['valores'][$acaoRecurso->getExercicioRecurso()]['valor']);
                            $acaoRecurso->getFkPpaAcaoMetaFisicaRealizada()->setJustificativa($metas['valores'][$acaoRecurso->getExercicioRecurso()]['justificativa']);
                            $this->getDoctrine()->getManager()->persist($acaoRecurso);
                        } else {
                            $acaoMetaFisicaRealizada = new AcaoMetaFisicaRealizada();
                            $acaoMetaFisicaRealizada->setFkPpaAcaoRecurso($acaoRecurso);
                            $acaoMetaFisicaRealizada->setValor($metas['valores'][$acaoRecurso->getExercicioRecurso()]['valor']);
                            $acaoMetaFisicaRealizada->setJustificativa($metas['valores'][$acaoRecurso->getExercicioRecurso()]['justificativa']);
                            $acaoRecurso->setFkPpaAcaoMetaFisicaRealizada($acaoMetaFisicaRealizada);
                            $this->getDoctrine()->getManager()->persist($acaoRecurso);
                        }
                    }
                }
            }
            $this->getDoctrine()->getManager()->flush();
        endif;
        $container->get('session')->getFlashBag()->add('success', $container->get('translator')->transChoice('label.ppaAcao.msgRecursoAtualizado', 0, [], 'messages'));
        return $this->redirect("/financeiro/ppa/acao/lancar");
    }
}
