<?php

namespace Urbem\PatrimonialBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\DoctrineORMAdminBundle\Model\ModelManager;
use Urbem\CoreBundle\Entity\Compras\Solicitacao;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\SolicitacaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class IncluirOutraSolicitacaoAdmin
 *
 * @package Urbem\PatrimonialBundle\Admin
 */
class IncluirOutraSolicitacaoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_compras_solicitacoes_itens';
    protected $baseRoutePattern = 'patrimonial/compras/solicitacao/solicitacoes-itens';

    protected $inCodModulo = ConfiguracaoModel::MODULO_PATRIMONIAL_COMPRAS;
    protected $msgErroHomologacao = null;

    protected $includeJs = [
        '/patrimonial/javascripts/compras/solicitacoesitens.js',
    ];

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['edit']);
        $collection->add('incluir', '{id}/incluir');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        /** @var ModelManager $modelManager */
        $modelManager = $this->getModelManager();
        $entityManager = $modelManager->getEntityManager($this->getClass());

        /** @var Solicitacao $solicitacao */
        $solicitacao = $this->getSubject();

        $catalogoItem = null;

        $fieldOptions = [];
        $fieldOptions['exercicioHidden']['data'] = null;
        if (!$this->getRequest()->isMethod('GET')) {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $codSolicitacao = $formData['codSolicitacao'];
            $exercicio = $formData['exercicio'];
            $codEntidade = $formData['codEntidade'];
        } else {
            $fieldOptions['exercicioHidden']['data'] = $solicitacao->getExercicio();
        }

        $solicitacaoModel = new SolicitacaoModel($entityManager);
        $exercicio = $this->getExercicio();

        $fieldOptions['codEntidade'] = [
            'attr'         => ['class' => 'select2-parameters '],
            'class'        => Entidade::class,
            'choice_value' => 'codEntidade',
            'choices'      => $modelManager->findBy(Entidade::class, ['exercicio' => $exercicio]),
            'label'        => 'label.comprasDireta.codEntidade',
            'placeholder'  => 'label.selecione',
            'required'     => true,
            'mapped'       => false,
        ];

        $fieldOptions['codSolicitacao'] = [
            'attr'          => [
                'class' => 'select2-parameters ',
            ],
            'class'         => Solicitacao::class,
            'label'         => 'label.patrimonial.compras.solicitacao.solicitacao',
            'placeholder'   => 'label.selecione',
            'required'      => true,
            'query_builder' => $solicitacaoModel->montaRecuperaRelacionamentoSolicitacaoQuery($exercicio),
            'disabled'      => true,
            'mapped'        => false,
        ];

        $fieldOptions['codSolicitacaoHidden']['mapped'] = false;
        $fieldOptions['codSolicitacaoHidden']['data'] = $solicitacao->getCodSolicitacao();
        $fieldOptions['exercicioHidden']['mapped'] = false;
        $fieldOptions['codEntidadeHidden']['mapped'] = false;
        $fieldOptions['codEntidadeHidden']['data'] = $solicitacao->getCodEntidade();

        $fieldOptions['exercicioItem'] = [
            'mapped'   => false,
            'required' => false,
            'data'     => $exercicio,
        ];

        $fieldOptions['exercicio'] = [
            'attr'   => ['class' => 'ano '],
            'data'   => $exercicio,
            'mapped' => false,
        ];

        $fieldOptions['registroPrecoHidden'] = [
            'data'   => $solicitacao->getRegistroPrecos(),
            'mapped' => false,
        ];

        $formMapper
            ->with('label.mapa.solicitacao')
            ->add('exercicio', 'text', $fieldOptions['exercicio'])
            ->add('codEntidade', 'entity', $fieldOptions['codEntidade'], ['admin_code' => 'financeiro.admin.entidade'])
            ->add('codSolicitacao', 'entity', $fieldOptions['codSolicitacao'])
            ->add('codSolicitacaoHidden', 'hidden', $fieldOptions['codSolicitacaoHidden'])
            ->add('codEntidadeHidden', 'hidden', $fieldOptions['codEntidadeHidden'])
            ->add('exercicioHidden', 'hidden', $fieldOptions['exercicioHidden'])
            ->add('exercicioItem', 'hidden', $fieldOptions['exercicioItem'])
            ->add('registroPrecoHidden', 'hidden', $fieldOptions['registroPrecoHidden'])
            ->end()
            ->with('label.comprasDireta.items', ['class' => 'col s12 solicitacao-items',])
            ->end();

        $formMapper
            ->getFormBuilder()
            ->setAction('incluir');
    }
}
