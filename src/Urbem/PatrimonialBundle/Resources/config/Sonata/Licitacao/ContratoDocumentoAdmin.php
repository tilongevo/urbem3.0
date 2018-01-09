<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao;

use Urbem\CoreBundle\Entity\Licitacao\ContratoDocumento;
use Urbem\CoreBundle\Entity\Licitacao\Documento;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\ContratoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ContratoDocumentoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_contrato_documento';

    protected $baseRoutePattern = 'patrimonial/licitacao/contrato-documento';

    protected $exibirBotaoIncluir = false;

    /**
     * @param ContratoDocumento $contratoDocumento
     */
    public function prePersist($contratoDocumento)
    {
        $formData = $this->getRequest()->request->get($this->getUniqid());
        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());

        $contratoModel = new ContratoModel($entityManager);
        $contrato = $contratoModel->getOneContrato($formData['exercicioEntidade'], $formData['codEntidade'], $formData['numContrato']);
        $contratoDocumento->setFkLicitacaoContrato($contrato);
    }

    /**
     * @param ContratoDocumento $contratoDocumento
     */
    public function postPersist($contratoDocumento)
    {
        $this->redirectShow($contratoDocumento);
    }

    /**
     * @param ContratoDocumento $contratoDocumento
     */
    public function postUpdate($contratoDocumento)
    {
        $this->redirectShow($contratoDocumento);
    }

    /**
     * @param ContratoDocumento $contratoDocumento
     */
    public function postRemove($contratoDocumento)
    {
        $this->redirectShow($contratoDocumento);
    }

    /**
     * @param ContratoDocumento $contratoDocumento
     */
    public function redirectShow(ContratoDocumento $contratoDocumento){
        $url = '/patrimonial/compras/contrato/' . $this->getObjectKey($contratoDocumento->getFkLicitacaoContrato()).'/show';
        $this->forceRedirect($url);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('exercicio')
            ->add('numDocumento')
            ->add('dtEmissao')
            ->add('dtValidade');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('exercicio')
            ->add('numDocumento')
            ->add('dtEmissao')
            ->add('dtValidade');
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

        if (!is_null($this->getSubject()->getExercicio())) {
            $exercicio = $this->getSubject()->getExercicio();
        }

        $fieldOptions['fkLicitacaoDocumento'] = [
            'class' => Documento::class,
            'choice_label' => 'nomDocumento',
            'label' => 'label.patrimonial.compras.contrato_documento.documento',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'required' => true,
            'placeholder' => 'Selecione'
        ];

        $fieldOptions['exercicio'] = [
            'attr' => [
                'readonly' => true
            ],
            'data' => $exercicio
        ];

        $formMapper
            ->add('exercicio', null, $fieldOptions['exercicio'])
            ->add('numDocumento', null, ['label' => 'label.patrimonial.compras.contrato_documento.numDocumento'])
            ->add('numContrato', 'hidden', ['data' => $numContrato, 'mapped' => false])
            ->add('codEntidade', 'hidden', ['data' => $codEntidade, 'mapped' => false])
            ->add('exercicioEntidade', 'hidden', ['data' => $exercicioEntidade, 'mapped' => false])
            ->add('fkLicitacaoDocumento', null, $fieldOptions['fkLicitacaoDocumento'])
            ->add(
                'dtEmissao',
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy',
                    'label' => 'Data Emissão',
                    'required' => true,
                ]
            )
            ->add(
                'dtValidade',
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy',
                    'label' => 'Data Validade',
                    'required' => true,
                ]
            );
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('exercicio')
            ->add('numDocumento')
            ->add('dtEmissao')
            ->add('dtValidade')
            ->add('timestamp');
    }
}
