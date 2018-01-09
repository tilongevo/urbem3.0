<?php

namespace Urbem\FinanceiroBundle\Controller\Orcamento;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sonata\AdminBundle\Controller\CRUDController as BaseController;
use Urbem\CoreBundle\Entity\Orcamento\Despesa;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Model\Ppa\AcaoModel;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Urbem\CoreBundle\Entity\Orcamento\Recurso;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Urbem\CoreBundle\Helper\BreadCrumbsHelper;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class DespesaAdminController extends BaseController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function findDespesa(Request $request)
    {
        $codDespesa = trim($request->query->get('despesa'));
        $exercicio = $request->query->get('exercicio');

        $despesa = $this->getDoctrine()
            ->getRepository(Despesa::class)
            ->getReceitaByExercicioAndCodReceita($exercicio, $codDespesa);

        $despesa = array_shift($despesa);

        if (is_null($despesa)) {
            $despesa['cod_despesa'] = '';
            $despesa['mascara_classificacao'] = '';
            $despesa['descricao'] = '';
            $despesa['nom_recurso'] = '';
        }

        $entidade = $this->getDoctrine()
            ->getRepository(Entidade::class)
            ->findOneBy([
                'exercicio' => $despesa['exercicio'],
                'codEntidade' => $despesa['cod_entidade']
            ]);

        $despesa['nome_entidade'] = '';
        if (!empty($despesa)) {
            $despesa['nome_entidade'] = $entidade->getFkSwCgm()->getNomCgm();
        }

        $response = new Response();
        $response->setContent(json_encode($despesa));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
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
     */
    public function acaoListAction(Request $request)
    {
        $this->setBreadCrumb([], 'urbem_financeiro_orcamento_elaboracao_orcamento_despesa_acao_list');

        $form = $request->request->has('acao_despesa')?$request->request->get('acao_despesa'):$this->_getDefaultForm();
        
        $em = $this->getDoctrine()->getManager();
        $acaoModel = new AcaoModel($em);
        
        $configAcao = $acaoModel->getConfigAcaoDespesa($this->admin->getExercicio(), null, true);
        
        $param = [
            'stTitulo' => $form['descricao'],
            'inCodRecurso' => $form['recurso'],
            'inCodAcao' => $form['codDe'],
            'inCodAcaoFim' => $form['codAte'],
            'stAcao' => 'incluirAcao'
        ];
        
        $limit = 10;
        $page = isset($form['pagina'])?$form['pagina']:1;
        $offset = ($page-1)*$limit;
        
        $nRows = $acaoModel->getAcaoDespesas($configAcao['cod_ppa'], $configAcao['ano'], $param, 'acao.num_acao', true);
        $nPaginas = ceil($nRows['total']/$limit);
        
        if ($nPaginas != $form['nPaginas']) {
            $page = 1;
        }
        
        $acaoDespesas = $acaoModel->getAcaoDespesas($configAcao['cod_ppa'], $configAcao['ano'], $param, 'acao.num_acao', false, $limit, $offset);

        $formulario = $this->createForm(
            'Urbem\FinanceiroBundle\Form\Orcamento\ElaboracaoOrcamento\AcaoDespesaType',
            null, 
            ['action' => $this->generateUrl('urbem_financeiro_orcamento_elaboracao_orcamento_despesa_acao_list')]
        );
        
        $optionFields = [];
        
        $optionFields['codDe'] = [
            'label' => 'label.elaboracaoDespesa.codAcaoInicial',
            'required' => false
        ];
        if (!empty($form['codDe'])) {
            $optionFields['codDe']['data'] = intval($form['codDe']);
        }
        $optionFields['codAte'] = [
            'label' => 'label.elaboracaoDespesa.codAcaoFinal',
            'required' => false
        ];
        if (!empty($form['codAte'])) {
            $optionFields['codAte']['data'] = intval($form['codAte']);
        }
        $optionFields['descricao'] = [
            'label' => 'Descrição',
            'data' => $form['descricao'],
            'required' => false
        ];
        $optionFields['recurso'] = [
            'label' => 'label.suplementacao.recurso',
            'placeholder' => 'label.selecione',
            'class' => Recurso::class,
            'query_builder' => function ($em) {
            return $em
            ->createQueryBuilder('rec')
            ->where('rec.exercicio = :exercicio')
            ->setParameter(':exercicio', $this->admin->getExercicio())
            ->orderBy('rec.codRecurso', 'ASC');
            },
            'required' => false
        ];
        if (!empty($form['recurso'])) {
            $optionFields['recurso']['data'] = intval($form['recurso']);
        }
        
        $optionFields['pagina'] = [
            'data' => $page
        ];
        $optionFields['nPaginas'] = [
            'data' => $nPaginas
        ];
        
        $formulario = $formulario
            ->add('codDe', NumberType::class, $optionFields['codDe'])
            ->add('codAte', NumberType::class, $optionFields['codAte'])
            ->add('descricao', TextType::class, $optionFields['descricao'])
            ->add('recurso', EntityType::class, $optionFields['recurso'])
            ->add('pagina', HiddenType::class, $optionFields['pagina'])
            ->add('nPaginas', HiddenType::class, $optionFields['nPaginas'])
        ;
        
        $formAcao = $formulario->createView();
        
        $formulario = $this->createForm(
            'Urbem\FinanceiroBundle\Form\Orcamento\ElaboracaoOrcamento\IncluirDespesaType',
            null,
            ['action' => $this->generateUrl('urbem_financeiro_orcamento_elaboracao_orcamento_despesa_create')]
        );
        
        $formulario = $formulario
            ->add('exercicio', HiddenType::class, ['data' => $this->admin->getExercicio()])
            ->add('codAno', HiddenType::class)
            ->add('codAcao', HiddenType::class)
        ;
        
        $formActIncluir = $formulario->createView();
        
        $data = [
            'form' => $formAcao,
            'formAct' => $formActIncluir,
            'table' => $acaoDespesas,
            'exercicio' => $this->admin->getExercicio(),
            'nPaginas' => $nPaginas,
            'paginaAtual' => $page
        ];
        
        return $this->render(
            'FinanceiroBundle::Ppa/Acao/acaoDespesa.html.twig',
            $data
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getDespesaAction(Request $request)
    {
        $exercicio = $this->admin->getExercicio();
        $despesa = $this->getDoctrine()
            ->getRepository(Despesa::class)
            ->recuperaCodEstrutural($exercicio, $request->get('q'));
        $list = [];
        foreach ($despesa as $v) {
            array_push($list, ['id' => $v->cod_conta, 'label' => $v->cod_estrutural .' - '. $v->descricao ]);
        }
        return new JsonResponse(['items' => $list]);
    }
    
    /**
     * @return string[]|number[]
     */
    private function _getDefaultForm()
    {
        return [
            'descricao' => "",
            'recurso' => "",
            'codDe' => "",
            'codAte' => "",
            'incluirAcao' => "",
            'nPaginas' => 0
        ];
    }
    
    /**
     * @param array $param
     * @param null $route
     */
    private function setBreadCrumb($param = [], $route = null)
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
