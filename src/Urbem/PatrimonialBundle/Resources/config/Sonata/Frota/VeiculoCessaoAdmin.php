<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Frota;

use Doctrine\ORM\EntityManager;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\Form\Form;
use Urbem\CoreBundle\Entity\SwCgmPessoaJuridica;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Exception\Error;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Helper;
use Urbem\CoreBundle\Model;

use Urbem\CoreBundle\Entity\Frota;

class VeiculoCessaoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_frota_veiculo_cessao';

    protected $baseRoutePattern = 'patrimonial/frota/veiculo-cessao';

    /**
     * @param ErrorElement $errorElement
     * @param Frota\VeiculoCessao $veiculoCessao
     */
    public function validate(ErrorElement $errorElement, $veiculoCessao)
    {
        if ($veiculoCessao->getDtTermino() < $veiculoCessao->getDtInicio()) {
            $message = $this->trans('frota.veiculo.cessao.dataFimMenorDataInicio', ['%dtInicial%' => $veiculoCessao->getDtInicio()->format('d/m/Y'), '%dtFinal%' => $veiculoCessao->getDtTermino()->format('d/m/Y')], 'validators');

            $errorElement->with('dtTermino')->addViolation($message)->end();
        }
    }

    /**
     * @param Frota\VeiculoCessao $object
     */
    public function prePersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $this->saveRelationships($object, $this->getForm());
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_PERSIST_DATA);
            $this->forceRedirect("/patrimonial/frota/veiculo-cessao/create?id={$object->getCodVeiculo()}");
        }
    }

    /**
     * @param Frota\VeiculoCessao $object
     * @param Form $form
     */
    public function saveRelationships($object, $form)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());

        // Set FkFrotaVeiculo
        $veiculo = $entityManager
            ->getRepository(Frota\Veiculo::class)
            ->find($object->getCodVeiculo());

        $object->setFkFrotaVeiculo($veiculo);

        // Set FkSwProcesso
        if (strpos($form->get('codProcesso')->getData(), '~')) {
            list($codProcesso, $anoExercicio) = explode('~', $form->get('codProcesso')->getData());
        } else {
            $processo = explode(' - ', $form->get('codProcesso')->getData());
            list($codProcesso, $anoExercicio) = explode('/', $processo[0]);
        }
        $processo = $entityManager
            ->getRepository(SwProcesso::class)
            ->findOneBy([
                'codProcesso' => $codProcesso,
                'anoExercicio' => $anoExercicio
            ]);
        $object->setFkSwProcesso($processo);

        // Set fkSwCgmPessoaJuridica
        if (strpos($form->get('cgmCedente')->getData(), '-')) {
            $cgm = explode('-', $form->get('cgmCedente')->getData());
            $cgm = $cgm[0];
        } else {
            $cgm = $form->get('cgmCedente')->getData();
        }
        $pessoaJuridica = $entityManager
            ->getRepository(SwCgmPessoaJuridica::class)
            ->findOneBy([
                'numcgm' => $cgm
            ]);
        $object->setFkSwCgmPessoaJuridica($pessoaJuridica);
    }

    /**
     * @param Frota\VeiculoCessao $object
     */
    public function preUpdate($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $this->saveRelationships($object, $this->getForm());
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_EDIT_DATA);
            $this->forceRedirect("/patrimonial/frota/veiculo-cessao/{$this->getAdminRequestId()}/edit");
        }
    }

    /**
     * @param Frota\VeiculoCessao $object
     */
    public function postPersist($object)
    {
        $this->redirect($object);
    }

    /**
     * @param Frota\VeiculoCessao $object
     */
    public function redirect($object)
    {
        $this->forceRedirect("/patrimonial/frota/veiculo/{$this->getObjectKey($object->getFkFrotaVeiculo())}/show");
    }

    /**
     * @param Frota\VeiculoCessao $object
     */
    public function postUpdate($object)
    {
        $this->redirect($object);
    }

    /**
     * @param Frota\VeiculoCessao $object
     */
    public function postRemove($object)
    {
        $this->redirect($object);
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
            $codVeiculo = $formData['codVeiculo'];
        } else {
            if ($this->getSubject()->getCodVeiculo()) {
                $codVeiculo = $this->getSubject()->getFkFrotaVeiculo()->getCodVeiculo();
            } else {
                $codVeiculo = $this->getRequest()->query->get('id');
            }
        }

        /**
         * @var EntityManager $entityManager
         */
        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());

        $veiculo = $entityManager
            ->getRepository(Frota\Veiculo::class)
            ->find($codVeiculo);

        $route = $this->getRequest()->get('_sonata_name');
        if ($this->baseRouteName . "_edit" == $route) {
            /** @var Frota\VeiculoCessao $veiculoCessao */
            $veiculoCessao = $entityManager
                ->getRepository(Frota\VeiculoCessao::class)
                ->findOneById($id);

            $veiculo = $entityManager
                ->getRepository(Frota\Veiculo::class)
                ->find($veiculoCessao->getCodVeiculo());
        }

        $fieldOptions['veiculo'] = [
            'class' => 'CoreBundle:Frota\Veiculo',
            'choice_label' => function (Frota\Veiculo $veiculo) {
                return $veiculo->getCodVeiculo().' - '.
                    $veiculo->getPlaca().' - '.
                    $veiculo->getFkFrotaMarca()->getNomMarca().' - '.
                    $veiculo->getFkFrotaModelo()->getNomModelo();
            },
            'label' => 'label.veiculoCessao.codVeiculo',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'data' => $veiculo,
            'mapped' => false,
            'disabled' => true,
        ];

        $fieldOptions['codVeiculo'] = [
            'data' => $veiculo->getCodVeiculo()
        ];

        $fieldOptions['codProcesso'] = [
            'label' => 'label.veiculoCessao.codProcesso',
            'multiple' => false,
            'mapped' => false,
            'required' => false,
            'route' => ['name' => 'carrega_sw_processo'],
            'placeholder' => 'Selecione'
        ];

        $fieldOptions['cgmCedente'] = [
            'label' => 'label.veiculoCessao.cgmCedente',
            'multiple' => false,
            'mapped' => false,
            'required' => false,
            'route' => ['name' => 'carrega_sw_cgm_pessoa_juridica'],
            'placeholder' => 'Selecione'
        ];

        if ($this->id($this->getSubject())) {
            /** @var EntityManager $em */
            $em = $this->modelManager->getEntityManager($this->getClass());

            // Processa codProcesso
            $processo = $em->getRepository(SwProcesso::class)
                ->findOneBy([
                    'codProcesso' => $this->getSubject()->getCodProcesso(),
                    'anoExercicio' => $this->getSubject()->getExercicio()
                ]);
            $fieldOptions['codProcesso']['data'] = $processo;

            // Processa cgmCedente
            $cgm = $em->getRepository(SwCgmPessoaJuridica::class)
                ->findOneBy([
                    'numcgm' => $this->getSubject()->getCgmCedente()
                ]);
            $fieldOptions['cgmCedente']['data'] = $cgm;
        }

        $formMapper
            ->add(
                'veiculo',
                'entity',
                $fieldOptions['veiculo']
            )
            ->add(
                'codVeiculo',
                'hidden',
                $fieldOptions['codVeiculo']
            )
            ->add(
                'codProcesso',
                'autocomplete',
                $fieldOptions['codProcesso']
            )
            ->add(
                'cgmCedente',
                'autocomplete',
                $fieldOptions['cgmCedente']
            )
            ->add(
                'dtInicio',
                'sonata_type_date_picker',
                [
                    'label' => 'label.veiculoCessao.dtInicio',
                    'format' => 'dd/MM/yyyy'
                ]
            )
            ->add(
                'dtTermino',
                'sonata_type_date_picker',
                [
                    'label' => 'label.veiculoCessao.dtFim',
                    'format' => 'dd/MM/yyyy'
                ]
            )
        ;
    }
}
