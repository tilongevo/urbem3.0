<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado;

use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CentroCustoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Entity\Orcamento\Despesa;

class CentroCustoDotacaoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_almoxarifado_centro_custo_dotacao';
    protected $baseRoutePattern = 'patrimonial/almoxarifado/centro-custo-dotacao';

    protected $exibirBotaoIncluir = false;

    /**
     * @param ErrorElement $errorElement
     * @param mixed $centroCustoDotacao
     */
    public function validate(ErrorElement $errorElement, $centroCustoDotacao)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $formData = $this->getRequest()->request->get($this->getUniqid());

        $centroEntidade = $entityManager
            ->getRepository('CoreBundle:Almoxarifado\CentroCustoEntidade')
            ->findOneByCodCentro($formData['codHCentro']);

        $entidade = $entityManager
            ->getRepository('CoreBundle:Orcamento\Entidade')
            ->findOneBy(
                [
                    'codEntidade' => $centroEntidade->getCodEntidade(),
                ]
            );

        $despesa = $entityManager
            ->getRepository('CoreBundle:Orcamento\Despesa')
            ->findOneBy(
                [
                    'codDespesa' => $formData['codDespesa'],
                    'codEntidade' => $entidade->getCodEntidade(),
                    'exercicio' => $formData['exercicio']
                ]
            );

        if (is_null($despesa)) {
            $message = $this->trans('centro_custo_dotacao.sem_despesa', [], 'validators');
            $errorElement->with('codDespesa')->addViolation($message)->end();
        }

        $ccDotacao = $entityManager
            ->getRepository(Almoxarifado\CentroCustoDotacao::class)
            ->findOneBy([
                'codCentro' => $formData['codHCentro'],
                'codEntidade' => $entidade->getCodEntidade(),
                'codDespesa' => $despesa->getCodDespesa()
            ]);

        if (!is_null($ccDotacao)) {
            $message = $this->trans('centro_custo_dotacao.dotacao_cadastrada', [], 'validators');
            $errorElement->with('codDespesa')->addViolation($message)->end();
        }
    }

    public function prePersist($centroCustoDotacao)
    {
        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());

        $formData = $this->getRequest()->request->get($this->getUniqid());

        $centroEntidade = $entityManager
            ->getRepository('CoreBundle:Almoxarifado\CentroCustoEntidade')
            ->findOneByCodCentro($formData['codHCentro']);

        $despesa = $entityManager
            ->getRepository('CoreBundle:Orcamento\Despesa')
            ->findOneBy(
                [
                    'codDespesa' => $centroCustoDotacao->getCodDespesa(),
                    'codEntidade' => $centroEntidade->getCodEntidade(),
                    'exercicio' => $formData['exercicio']
                ]
            );

        $centroCustoDotacao->setFkAlmoxarifadoCentroCustoEntidade($centroEntidade);
        $centroCustoDotacao->setFkOrcamentoDespesa($despesa);
    }

    /**
     * @param Almoxarifado\CentroCustoDotacao $centroCustoDotacao
     */
    public function postPersist($centroCustoDotacao)
    {
        $url =  '/patrimonial/almoxarifado/centro-custo/'. $this->getObjectKey($centroCustoDotacao->getFkAlmoxarifadoCentroCustoEntidade()->getFkAlmoxarifadoCentroCusto()) . '/show';
        $this->forceRedirect($url);
    }

    public function postUpdate($centroCustoDotacao)
    {
        $url =  '/patrimonial/almoxarifado/centro-custo/'. $this->getObjectKey($centroCustoDotacao->getFkAlmoxarifadoCentroCustoEntidade()->getFkAlmoxarifadoCentroCusto()) . '/show';
        $this->forceRedirect($url);
    }

    public function postRemove($centroCustoDotacao)
    {
        $url =  '/patrimonial/almoxarifado/centro-custo/'. $this->getObjectKey($centroCustoDotacao->getFkAlmoxarifadoCentroCustoEntidade()->getFkAlmoxarifadoCentroCusto()) . '/show';
        $this->forceRedirect($url);
    }
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $this->setBreadCrumb();

        $datagridMapper
            ->add('exercicio')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('exercicio')
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto');

        if (!$this->getRequest()->isMethod('GET')) {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $id = $formData['codHCentro'];
        }

        $route = $this->getRequest()->get('_sonata_name');
        if ($this->baseRouteName . "_edit" == $route) {
            $ids = explode('~', $id);
            $id = $ids[2];
        }

        /** @var Almoxarifado\CentroCusto $centro */
        $centro = $em
            ->getRepository('CoreBundle:Almoxarifado\CentroCusto')
            ->findOneByCodCentro($id);

        $exercicio = $this->getExercicio();

        $ccModel = new CentroCustoModel($em);
        $ccDotacao = $ccModel->getDotacaoByEntidade($centro->getFkAlmoxarifadoCentroCustoEntidades()->last()->getCodEntidade(), $exercicio, $this->getCurrentUser()->getFkSwCgm()->getNumcgm());

        $ccDotacaoChoices = [];

        foreach ($ccDotacao as $dotacao) {
            $descricao = $dotacao['descricao'];
            $mascara = $dotacao['mascara_classificacao'];

            $choiceValue = $dotacao['cod_despesa'];
            $choiceKey = $descricao . " - ". $mascara;

            $ccDotacaoChoices[$choiceKey] = $choiceValue;
        }

        $formMapper
            ->add('exercicio', 'hidden', ['data' => $exercicio, 'mapped' => false])
            ->add('codHCentro', 'hidden', ['data' => $id, 'mapped' => false])
            ->add('descricao', 'text', [
                'data' => $centro->getDescricao(),
                'mapped' => false,
                'disabled' => true,
                'label' => 'label.patrimonial.almoxarifado.centrodecusto.descricao'
            ])
            ->add('codDespesa', 'choice', [
                'label' => 'Dotação',
                'required' => true,
                'choices' => $ccDotacaoChoices,
                'attr' => [
                    'class' => 'select2-parameters '
                ]
            ])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $showMapper
            ->add('exercicio')
        ;
    }
}
