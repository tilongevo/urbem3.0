<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Patrimonio;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Urbem\CoreBundle\Entity\Organograma\Local;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractOrganogramaSonata;

class TransferirAdmin extends AbstractOrganogramaSonata
{

    protected $baseRouteName = 'urbem_patrimonial_patrimonio_bem_transferir';

    protected $baseRoutePattern = 'patrimonial/patrimonio/bem/transferir';

    protected $includeJs = [
        '/administrativo/javascripts/organograma/estruturaDinamicaOrganograma.js',
        '/core/javascripts/sw-processo.js',
        '/patrimonial/javascripts/patrimonio/transferir-bem.js'
    ];

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $exercicio = $this->getExercicio();


        if (!$this->id($this->getSubject()) && 'POST' == $this->getRequest()->getMethod()) {
            $this->executeScriptLoadData($this->getRequest()->request->get($this->getUniqid()));
        }

        $formMapper
            ->with('Local de Origem')
            ->add(
                'responsavel',
                'autocomplete',
                [
                    'label' => 'label.bem.responsavel',
                    'multiple' => false,
                    'mapped' => false,
                    'required' => true,
                    'route' => ['name' => 'carrega_sw_cgm'],
                    'placeholder' => 'Selecione'
                ]
            )
        ;
        $this->createFormOrganograma($formMapper, true);
        $formMapper
            ->add(
                'local_origem',
                'entity',
                [
                    'class' => Local::class,
                    'choice_label' => 'descricao',
                    'label' => 'label.bem.local',
                    'mapped' => false,
                    'attr' => array(
                        'class' => 'select2-parameters '
                    ),
                    'placeholder' => 'label.selecione'
                ]
            )
            ->end()
        ;

        $formMapper
            ->with('Bens')
            ->end()
        ;
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $request = $this->getRequest()->request;
        if (!$request->get('codBem')) {
            $errorElement->addViolation('bem.transferir.selecionarBem');
        }
    }

    public function prePersist($object)
    {
        $request = $this->getRequest()->request;
        $form = $request->get($this->getUniqid());
        $params = [];
        foreach ($form as $fieldName => $value) {
            $params[] = "$fieldName=$value";
        }

        $bens = $request->get('codBem');
        foreach ($bens as $fieldName => $value) {
            $params[] = "codBem[$fieldName]=$value";
        }
        $this->forceRedirect('/patrimonial/patrimonio/bem/transferir-destino/create?'. implode('&', $params));
    }
}
