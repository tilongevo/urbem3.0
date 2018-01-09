<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao;

use Urbem\CoreBundle\Entity\Licitacao\PublicacaoContrato;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\ContratoModel;
use Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade;
use Urbem\CoreBundle\Helper\DatePK;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class PublicacaoContratoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_publicacao_contrato';

    protected $baseRoutePattern = 'patrimonial/licitacao/publicacao-contrato';

    protected $exibirBotaoIncluir = false;

    /**
     * @param PublicacaoContrato $publicacaoContrato
     */
    public function prePersist($publicacaoContrato)
    {
        $formData = $this->getRequest()->request->get($this->getUniqid());
        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());

        $contratoModel = new ContratoModel($entityManager);
        $contrato = $contratoModel->getOneContrato($formData['exercicioEntidade'], $formData['codEntidade'], $formData['numContrato']);

        $publicacaoContrato->setFkLicitacaoContrato($contrato);
    }

    /**
     * @param PublicacaoContrato $publicacaoContrato
     */
    public function postPersist($publicacaoContrato)
    {
        $this->redirectShow($publicacaoContrato);
    }

    /**
     * @param PublicacaoContrato $publicacaoContrato
     */
    public function postUpdate($publicacaoContrato)
    {
        $this->redirectShow($publicacaoContrato);
    }

    /**
     * @param PublicacaoContrato $publicacaoContrato
     */
    public function postRemove($publicacaoContrato)
    {
        $this->redirectShow($publicacaoContrato);
    }

    /**
     * @param PublicacaoContrato $publicacaoContrato
     */
    public function redirectShow(PublicacaoContrato $publicacaoContrato){
        $url = '/patrimonial/compras/contrato/' . $this->getObjectKey($publicacaoContrato->getFkLicitacaoContrato()).'/show';
        $this->forceRedirect($url);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('exercicio')
            ->add('dtPublicacao')
            ->add('observacao')
            ->add('numPublicacao');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('exercicio')
            ->add('dtPublicacao')
            ->add('observacao')
            ->add('numPublicacao');
        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        if (!$this->getRequest()->isMethod('GET')) {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $numContrato = $formData['numContrato'];
            $exercicioEntidade = $formData['exercicioEntidade'];
            $codEntidade = $formData['codEntidade'];
        } else {
            list($exercicioEntidade, $codEntidade, $numContrato) = explode("~", $id);
        }

        $exercicio = $this->getExercicio();

        if ($this->id($this->getSubject())) {
            $exercicio = $this->getSubject()->getExercicio();
        }

        $fieldOptions['fkLicitacaoVeiculosPublicidade'] = [
            'class' => VeiculosPublicidade::class,
            'choice_label' => 'fkSwCgm.nomCgm',
            'label' => 'label.patrimonial.compras.publicacao_contrato.veiculoPublicidade',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'placeholder' => 'Selecione',
            'required' => true
        ];

        $now = new \DateTime();
        $fieldOptions['dtPublicacao'] = [
            'dp_default_date' => $now->format('d/m/Y'),
            'format' => 'dd/MM/yyyy',
            'pk_class' => DatePK::class,
            'label' => 'label.patrimonial.compras.publicacao_contrato.dtPublicacao',
            'required' => true,
        ];

        $fieldOptions['exercicio'] = [
            'attr' => [
                'readonly' => true
            ],
            'data' => $exercicio
        ];

        $formMapper
            ->add('exercicio', null, $fieldOptions['exercicio'])
            ->add('numContrato', 'hidden', ['data' => $numContrato, 'mapped' => false])
            ->add('codEntidade', 'hidden', ['data' => $codEntidade, 'mapped' => false])
            ->add('exercicioEntidade', 'hidden', ['data' => $exercicioEntidade, 'mapped' => false])
            ->add('fkLicitacaoVeiculosPublicidade', null, $fieldOptions['fkLicitacaoVeiculosPublicidade'], ['admin_code' => 'patrimonial.admin.veiculos_publicidade'])
            ->add('dtPublicacao', 'datepkpicker', $fieldOptions['dtPublicacao'])
            ->add('numPublicacao', null, ['label' => 'label.patrimonial.compras.publicacao_contrato.numPublicacao'])
            ->add('observacao', null, ['label' => 'label.patrimonial.compras.publicacao_contrato.observacao']);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('exercicio')
            ->add('dtPublicacao')
            ->add('observacao')
            ->add('numPublicacao');
    }
}
