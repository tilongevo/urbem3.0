<?php

namespace Urbem\FinanceiroBundle\Controller\Contabilidade\LancamentoContabil;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Contabilidade\ContaCredito;
use Urbem\CoreBundle\Entity\Contabilidade\ContaDebito;
use Urbem\CoreBundle\Entity\Contabilidade\Lote;
use Urbem\CoreBundle\Entity\Contabilidade\PlanoConta;
use Urbem\CoreBundle\Entity\Contabilidade\ValorLancamento;
use Urbem\CoreBundle\Model\Contabilidade\LoteModel;

class ImplantacaoSaldoController extends BaseController
{
    const LOTE_CODIGO = 1;
    const LOTE_TIPO = 'I';
    const LOTE_HISTORICO = 1;
    const COD_DEBITO = 'D';
    const COD_CREDITO = 'C';
    const PLANO_CONTA_PADRAO = 0;

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $this->setBreadCrumb();

        $data = array();
        $form = $this->generateForm($data);

        $form->handleRequest($request);

        return $this->render(
            'FinanceiroBundle::Contabilidade/LancamentoContabil/ImplantacaoSaldo/index.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @param $data
     * @return mixed
     */
    private function generateForm($data)
    {
        $em = $this->getDoctrine()->getManager();
        $exercicio = $this->getExercicio();

        $grupos = $em->getRepository('CoreBundle:Contabilidade\PlanoConta')
            ->getGrupos($exercicio);

        $form = $this->createFormBuilder($data)
            ->add(
                'codEntidade',
                EntityType::class,
                array (
                    'class' => 'CoreBundle:Orcamento\Entidade',
                    'label' => 'label.implantacaoSaldo.codEntidade',
                    'choice_value' => 'codEntidade',
                    'required' => false,
                    'placeholder' => 'label.selecione',
                    'query_builder' => function ($em) use ($exercicio) {
                        $qb = $em->createQueryBuilder('o');
                        $qb->where('o.exercicio = :exercicio');
                        $qb->setParameter('exercicio', $exercicio);
                        $qb->orderBy('o.codEntidade', 'ASC');
                        return $qb;
                    }
                )
            )
            ->add(
                'codGrupo',
                ChoiceType::class,
                array (
                    'choices' => $grupos,
                    'required' => false,
                    'label' => 'label.implantacaoSaldo.codGrupo',
                    'placeholder' => 'label.selecione'
                )
            )
            ->add(
                'codContaDe',
                'autocomplete',
                [
                    'label' => 'label.implantacaoSaldo.de',
                    'class' => PlanoConta::class,
                    'route' => ['name' => 'get_plano_conta'],
                    'required' => false,
                    'attr' => array(
                        'class' => 'select2-parameters '
                    )
                ]
            )
            ->add(
                'codContaAte',
                'autocomplete',
                [
                    'label' => 'label.implantacaoSaldo.ate',
                    'class' => PlanoConta::class,
                    'route' => ['name' => 'get_plano_conta'],
                    'required' => false,
                    'attr' => array(
                        'class' => 'select2-parameters '
                    )
                ]
            )
            ->setAction($this->generateUrl('contabilidade_lancamento_contabil_implantacao_saldo_grid'))
            ->getForm();

        return $form;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getPlanoContaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $exercicio = $this->getExercicio();

        $search = $request->query->get('q');
        if (is_numeric($search)) {
            $result = $em->getRepository(PlanoConta::class)
                ->getCodReduzidoByCodPlanoOrNomConta($exercicio, $search);
        } else {
            $result = $em->getRepository(PlanoConta::class)
                ->getCodReduzidoByCodPlanoOrNomConta($exercicio, null, $search);
        }

        $codReduzido_arr = array();
        if ($result) {
            array_push($codReduzido_arr, [
                'id' => $result['cod_plano'],
                'label' => sprintf(
                    '%d - %s',
                    $result['cod_plano'],
                    $result['nom_conta']
                ),
            ]);
        }

        return new JsonResponse(['items' => $codReduzido_arr]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function gridAction(Request $request)
    {
        $container = $this->container;

        $this->setBreadCrumb();

        $em = $this->getDoctrine()->getManager();
        $exercicio = $this->getExercicio();

        $formData = $request->request->get('form');

        $codEntidade = (integer) $formData['codEntidade'];
        $entidade = $em->getRepository('CoreBundle:Orcamento\Entidade')
            ->findOneBy([
                'exercicio' => $exercicio,
                'codEntidade' => $codEntidade
            ]);

        $dtLancamento = mktime(0, 0, 0, 1, 1, $exercicio);
        $dtLancamento = date('d/m/Y', $dtLancamento);


        $codGrupo = (integer) $formData['codGrupo'];
        $codContaDe = (integer) $formData['codContaDe'];
        $codContaAte = (integer) $formData['codContaAte'];

        try {
            $contas = $em->getRepository('CoreBundle:Contabilidade\PlanoConta')
                ->getIntervaloContas(
                    $codEntidade,
                    $codGrupo,
                    $exercicio,
                    $codContaDe,
                    $codContaAte
                );

            return $this->render(
                'FinanceiroBundle::Contabilidade/LancamentoContabil/ImplantacaoSaldo/grid.html.twig',
                array(
                    'entidade' => $entidade,
                    'codGrupo' => $codGrupo,
                    'codContaDe' => $codContaDe,
                    'codContaAte' => $codContaAte,
                    'dtLancamento' => $dtLancamento,
                    'contas' => $contas
                )
            );
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->get('tranlator')->trans('label.implantacaoSaldo.mensagemErroBusca'));
            $container->get('session')->getFlashBag()->add('error', $e->getMessage());
        }

        return $this->redirectToRoute('contabilidade_lancamento_contabil_implantacao_saldo');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function gravarAction(Request $request)
    {
        $container = $this->container;
        $em = $this->getDoctrine()->getManager();

        try {
            $dataForm = $request->request->all();

            $contas = $em->getRepository('CoreBundle:Contabilidade\PlanoConta')
                ->getIntervaloContas(
                    $dataForm['codEntidade'],
                    $dataForm['codGrupo'],
                    $dataForm['exercicio'],
                    $dataForm['codContaDe'],
                    $dataForm['codContaAte']
                );

            $lote = $em->getRepository(Lote::class)
                ->getLoteByExercicio($this->getExercicio());
            if (!$lote) {
                $loteModel = new LoteModel($em);
                $lote = new Lote();
                $lote->setCodLote(self::LOTE_CODIGO);
                $lote->setExercicio($this->getExercicio());
                $lote->setCodEntidade($dataForm['codEntidade']);
                $lote->setTipo(self::LOTE_TIPO);
                $lote->setNomLote("Implantação de Saldo Automática");
                $lote->setDtLote(new \DateTime());
                $loteModel->save($lote);
            }

            $planoContaRepository = $em->getRepository('CoreBundle:Contabilidade\PlanoConta');
            foreach ($contas as $conta) {
                if (array_key_exists($conta['cod_plano'], $dataForm['valor'])) {
                    if ($dataForm['tipo'][$conta['cod_plano']] == self::COD_DEBITO) {
                        $codPlanoDebito = $conta['cod_plano'];
                        $codPlanoCredito = self::PLANO_CONTA_PADRAO;
                    } else {
                        $codPlanoDebito = self::PLANO_CONTA_PADRAO;
                        $codPlanoCredito = $conta['cod_plano'];
                    }
                    $codEstruturalDebito = '';
                    $codEstruturalCredito = '';
                    $vlLancamento = (float) $dataForm['valor'][$conta['cod_plano']];
                    $codLote = self::LOTE_CODIGO;
                    $codHistorico = self::LOTE_HISTORICO;
                    $tipo = self::LOTE_TIPO;
                    $complemento = "";

                    if (($conta['sequencia']) && (($dataForm['valor'][$conta['cod_plano']] == "") || ($dataForm['valor'][$conta['cod_plano']] == "0.00"))) {
                        $valorLancamento = $em->getRepository('CoreBundle:Contabilidade\ValorLancamento')
                            ->findOneBy([
                                'sequencia' => $conta['sequencia'],
                                'codLote' => self::LOTE_CODIGO,
                                'tipo' => self::LOTE_TIPO,
                                'exercicio' => $conta['exercicio'],
                                'codEntidade' => $dataForm['codEntidade']
                            ]);
                        $em->remove($valorLancamento);
                        $em->flush();
                    } elseif (($conta['sequencia']) && (($dataForm['valor'][$conta['cod_plano']] != "") || ($dataForm['valor'][$conta['cod_plano']] != "0.00"))) {
                        $valorLancamento = $em->getRepository('CoreBundle:Contabilidade\ValorLancamento')
                            ->findOneBy([
                                'sequencia' => $conta['sequencia'],
                                'codLote' => self::LOTE_CODIGO,
                                'tipo' => self::LOTE_TIPO,
                                'exercicio' => $conta['exercicio'],
                                'codEntidade' => $dataForm['codEntidade']
                            ]);

                        if ($valorLancamento->getTipoValor() == $dataForm['tipo'][$conta['cod_plano']]) {
                            if ($dataForm['tipo'][$conta['cod_plano']] == self::COD_CREDITO) {
                                $valorLancamento->setVlLancamento(((float) $dataForm['valor'][$conta['cod_plano']]) * -1);
                            } else {
                                $valorLancamento->setVlLancamento((float) $dataForm['valor'][$conta['cod_plano']]);
                            }
                            $em->persist($valorLancamento);
                            $em->flush();
                        } else {
                            $em->remove($valorLancamento);
                            $em->flush();

                            $planoContaRepository->insertLancamento(
                                $dataForm['exercicio'],
                                $codPlanoDebito,
                                $codPlanoCredito,
                                $codEstruturalDebito,
                                $codEstruturalCredito,
                                $vlLancamento,
                                $codLote,
                                $dataForm['codEntidade'],
                                $codHistorico,
                                $tipo,
                                $complemento
                            );
                        }
                    } elseif ((!$conta['sequencia']) && (($dataForm['valor'][$conta['cod_plano']] != "") && ($dataForm['valor'][$conta['cod_plano']] != "0.00"))) {
                        $planoContaRepository->insertLancamento(
                            $dataForm['exercicio'],
                            $codPlanoDebito,
                            $codPlanoCredito,
                            $codEstruturalDebito,
                            $codEstruturalCredito,
                            $vlLancamento,
                            $codLote,
                            $dataForm['codEntidade'],
                            $codHistorico,
                            $tipo,
                            $complemento
                        );
                    }
                }
            }

            $container->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('label.implantacaoSaldo.mensagemSucesso'));
            return $this->redirectToRoute('contabilidade_lancamento_contabil_implantacao_saldo');
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('label.implantacaoSaldo.mensagemErro'));
            $container->get('session')->getFlashBag()->add('error', $e->getMessage());
            return $this->redirectToRoute('contabilidade_lancamento_contabil_implantacao_saldo');
        }
    }
}
