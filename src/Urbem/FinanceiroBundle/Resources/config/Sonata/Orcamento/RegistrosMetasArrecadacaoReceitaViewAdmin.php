<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Orcamento;

use Urbem\CoreBundle\Entity\Orcamento\PrevisaoReceita;
use Urbem\CoreBundle\Helper\ArrayHelper;
use Urbem\CoreBundle\Model\Orcamento\ElaboracaoOrcamentoModel;
use Urbem\CoreBundle\Model\Orcamento\PrevisaoReceitaModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class RegistrosMetasArrecadacaoReceitaViewAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_orcamento_registro_metas_arrecadacao_receita';
    protected $baseRoutePattern = 'financeiro/orcamento/elaboracao-receita/metas-arrecadacao-receita';

    protected $exibirBotaoIncluir = false;

    protected $exibirBotaoEditar = true;

    protected $exibirBotaoExcluir = false;

    protected function configureRoutes(RouteCollection $routeCollection)
    {
        $routeCollection->remove('batch');
        $routeCollection->remove('export');
        $routeCollection->remove('delete');
        $routeCollection->remove('show');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);
        $em = $this->modelManager->getEntityManager($this->getClass());

        $metasArrecadacao = new ElaboracaoOrcamentoModel($em);
        if (!$id) {
            $this->exibirBotaoSalvar = false;
            $entidades = $repository = $em->getRepository("CoreBundle:Orcamento\\Entidade")->findEntidades($this->getExercicio());

            $formMapper
                ->with('Metas de Arrecadação da Receita')
                ->add(
                    'dadosLancamento',
                    'customField',
                    [
                        'label' => false,
                        'mapped' => false,
                        'template' => 'FinanceiroBundle::Orcamento/ElaboracaoOrcamento/listEntidades.html.twig',
                        'data' => [
                            'entidadesInfo' => $entidades
                        ],
                        'attr' => [
                            'class' => ''
                        ]
                    ]
                )
                ->end();

            return;
        }

        $metas = $metasArrecadacao->getListaMetasArrecadacaoReceita($this->getExercicio(), $id);
        $codReceitas = [];
        array_walk($metas, function ($item) use (&$codReceitas) {
            $codReceitas[] = $item->getCodReceita();
        });

        $previsaoReceitas = new PrevisaoReceitaModel($em);
        $previsoes = $previsaoReceitas->getPrevisaoReceita(array_unique($codReceitas), $this->getExercicio());
        $periodos = [];

        array_walk($metas, function (&$item) use ($previsoes, &$periodos) {
            $res = ArrayHelper::searchCollectionById($previsoes, 'codReceita', $item->getCodReceita(), true, 'periodo');
            $item->setPrevisoes($res);
            $periodos = count($res) ? array_keys($res) : $periodos;
        });
        if (!count($metas)) {
            $this->exibirBotaoSalvar = false;
        }

        $formMapper
            ->with('Lançar Metas de Arrecadação da Receita')
            ->add(
                'dadosLancamento',
                'customField',
                [
                    'label' => false,
                    'mapped' => false,
                    'template' => 'FinanceiroBundle::Orcamento\ElaboracaoOrcamento\lancarMetasArrecadacao.html.twig',
                    'data' => [
                        'metasInfo' => $metas,
                        'previsoesInfo' => $previsoes,
                        'periodosInfo' => $this->parsePeriodos($periodos),
                    ],
                    'attr' => [
                        'class' => ''
                    ]
                ]
            )
            ->end();
    }

    private function parsePeriodos($periodos)
    {
        foreach ($periodos as $key => $value) {
            $periodos[$key] = $value + 1;
        }

        return $periodos;
    }

    public function preUpdate($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $exercicio = $this->getExercicio();

        $repository = $em->getRepository("CoreBundle:Orcamento\\PrevisaoReceita");
        $dataForm = $this->getRequest()->request->all();
        $itens = $dataForm['cod_receita'];

        foreach ($itens as $codReceita => $periodo) {
            array_walk($periodo, function ($valorReceita, $key) use ($codReceita, $em, $repository, $exercicio) {

                $previsaoReceita = $repository->findOneBy(['exercicio' => $exercicio, 'codReceita' => $codReceita, 'periodo' => $key]);
                if (!$previsaoReceita) {
                    $previsaoReceita = new PrevisaoReceita();
                }
                $previsaoReceita->setExercicio($exercicio);
                $previsaoReceita->setCodReceita($codReceita);
                $previsaoReceita->setPeriodo($key);
                $previsaoReceita->setVlPeriodo(($valorReceita == "" ? 0 : $valorReceita));

                $em->persist($previsaoReceita);
            });
        }

        $em->flush();
        $this->forceRedirect('/financeiro/orcamento/elaboracao-receita/metas-arrecadacao-receita/create');
    }
}
