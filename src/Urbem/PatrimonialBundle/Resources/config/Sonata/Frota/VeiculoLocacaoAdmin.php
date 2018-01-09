<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Frota;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Urbem\CoreBundle\Entity\Empenho\Empenho;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\SwCgmPessoaJuridica;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Exception\Error;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Helper;
use Urbem\CoreBundle\Model;

use Urbem\CoreBundle\Entity\Frota;

class VeiculoLocacaoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_frota_veiculo_locacao';

    protected $baseRoutePattern = 'patrimonial/frota/veiculo-locacao';
    // protected $model = Model\Patrimonial\Frota\VeiculoLocacaoModel::class;

    protected $parentParameters;

    /**
     * @param ErrorElement $errorElement
     * @param Frota\VeiculoLocacao $veiculoLocacao
     */
    public function validate(ErrorElement $errorElement, $veiculoLocacao)
    {

        if ($veiculoLocacao->getDtTermino() < $veiculoLocacao->getDtInicio()) {
            $message = $this->trans('frota.veiculo.locacao.dataFimMenorDataInicio', ['%dtInicial%' => $veiculoLocacao->getDtInicio()->format('d/m/Y'), '%dtFinal%' => $veiculoLocacao->getDtTermino()->format('d/m/Y')], 'validators');
            $errorElement->with('dtTermino')->addViolation($message)->end();
        }

        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $form = $this->getForm();

        $codEmpenho = $form->get('codEmpenho')->getData();
        $codEntidade = $form->get('codEntidade')->getData()->getCodEntidade();
        $exercicio = $form->get('exercicio')->getData();

        $empenhoEmpenho = $entityManager
            ->getRepository(Empenho::class)
            ->findOneBy([
                'codEmpenho' => $codEmpenho,
                'codEntidade' => $codEntidade,
                'exercicio' => $exercicio
            ]);

        if(is_null($empenhoEmpenho)) {
            $message = $this->trans('frota.veiculo.locacao.numeroEmpenhoInexistente', [], 'validators');
            $errorElement->with('codEmpenho')->addViolation($message)->end();
        }
    }

    /**
     * @param Frota\VeiculoLocacao $object
     */
    public function prePersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();

        try {
            $this->saveRelationships($object, $this->getForm());
        } catch (\Exception $e) {
            throw $e;
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_PERSIST_DATA);
            $this->forceRedirect("/patrimonial/frota/veiculo-locacao/create?id={$this->getObjectKey($object)}");
        }
    }

    /**
     * @param Frota\VeiculoLocacao $object
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
        if (strpos($form->get('cgmLocatario')->getData(), '-')) {
            $cgm = explode('-', $form->get('cgmLocatario')->getData());
            $cgm = $cgm[0];
        } else {
            $cgm = $form->get('cgmLocatario')->getData();
        }

        $pessoaJuridica = $entityManager
            ->getRepository(SwCgmPessoaJuridica::class)
            ->findOneBy([
                'numcgm' => $cgm
            ]);
        $object->setFkSwCgmPessoaJuridica($pessoaJuridica);

        $codEmpenho = $form->get('codEmpenho')->getData();
        $codEntidade = $form->get('codEntidade')->getData()->getCodEntidade();
        $exercicio = $form->get('exercicio')->getData();

        $empenhoEmpenho = $entityManager
            ->getRepository(Empenho::class)
            ->findOneBy([
                'codEmpenho' => $codEmpenho,
                'codEntidade' => $codEntidade,
                'exercicio' => $exercicio
            ]);
        $object->setFkEmpenhoEmpenho($empenhoEmpenho);
    }

    /**
     * @param Frota\VeiculoLocacao $object
     */
    public function preUpdate($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $this->saveRelationships($object, $this->getForm());
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_EDIT_DATA);
            $this->forceRedirect("/patrimonial/frota/veiculo-locacao/{$this->getObjectKey($object)}/edit");
        }
    }

    /**
     * @param Frota\VeiculoLocacao $object
     */
    public function postPersist($object)
    {
        $this->redirect($object);
    }

    /**
     * @param Frota\VeiculoLocacao $object
     */
    public function redirect($object)
    {
        $this->forceRedirect("/patrimonial/frota/veiculo/{$this->getObjectKey($object->getFkFrotaVeiculo())}/show");
    }

    /**
     * @param Frota\VeiculoLocacao $object
     */
    public function postUpdate($object)
    {
        $this->redirect($object);
    }

    /**
     * @param Frota\VeiculoLocacao $object
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
        $exercicio = $this->getExercicio();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        if ($this->getRequest()->isMethod('GET')) {
            $codVeiculo = $this->getAdminRequestId();
        } else {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $codVeiculo = $formData['codVeiculo'];
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
            /** @var Frota\VeiculoLocacao $veiculoLocacao */
            $veiculoLocacao = $entityManager
                ->getRepository(Frota\VeiculoLocacao::class)
                ->findOneById($id);

            $veiculo = $entityManager
                ->getRepository(Frota\Veiculo::class)
                ->find($veiculoLocacao->getCodVeiculo());
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
            'label' => 'label.veiculoLocacao.codProcesso',
            'multiple' => false,
            'class' => SwProcesso::class,
            'mapped' => false,
            'required' => false,
            'route' => ['name' => 'carrega_sw_processo'],
            'placeholder' => 'Selecione'
        ];

        $fieldOptions['cgmLocatario'] = [
            'label' => 'label.veiculoLocacao.cgmLocatario',
            'class' => SwCgmPessoaJuridica::class,
            'multiple' => false,
            'mapped' => false,
            'required' => false,
            'route' => ['name' => 'carrega_sw_cgm_pessoa_juridica'],
            'placeholder' => 'Selecione'
        ];

        $fieldOptions['exercicio'] = [
            'label' => 'label.patrimonial.participante_certificacao.exercicio',
            'data' => $exercicio
        ];

        $fieldOptions['codEntidade'] = [
            'class' => 'CoreBundle:Orcamento\Entidade',
            'label' => 'label.patrimonial.participante_certificacao.entidade',
            'mapped' => false,
            'choice_label' => 'fkSwCgm.nomCgm',
            'query_builder' => function ($entityManager) use ($exercicio) {
                return $entityManager
                    ->createQueryBuilder('entidade')
                    ->where('entidade.exercicio = :exercicio')
                    ->setParameter(':exercicio', $exercicio);
            },
            'choice_value' => 'cod_entidade',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione'
        ];

        $fieldOptions['codEmpenho'] = [
            'label' => 'label.ordem.codEmpenho',
            'attr' =>[
                'min' => 1,
            ]
        ];


        if ($this->id($this->getSubject())) {
            /** @var EntityManager $em */
            $em = $this->modelManager->getEntityManager($this->getClass());

            // Processa codProcesso
            $processo = $em->getRepository(SwProcesso::class)
                ->findOneBy([
                    'codProcesso' => $this->getSubject()->getCodProcesso(),
                    'anoExercicio' => $this->getSubject()->getAnoExercicio()
                ]);
            $fieldOptions['codProcesso']['data'] = $processo;

            // Processa cgmLocatario
            $cgm = $em->getRepository(SwCgmPessoaJuridica::class)
                ->findOneBy([
                    'numcgm' => $this->getSubject()->getCgmLocatario()
                ]);
            $fieldOptions['cgmLocatario']['data'] = $cgm;
            $empenho = $this->getSubject()->getFkEmpenhoEmpenho();
            $fieldOptions['codEmpenho']['data'] = $empenho->getCodEmpenho();
            $fieldOptions['codEntidade']['data'] = $empenho;
            $fieldOptions['exercicio']['data'] = $empenho->getExercicio();
        }

        $formMapper
            ->with('label.veiculoLocacao.veiculoLocacao')
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
                    'cgmLocatario',
                    'autocomplete',
                    $fieldOptions['cgmLocatario']
                )
                ->add(
                    'dtContrato',
                    'sonata_type_date_picker',
                    [
                        'label' => 'label.veiculoLocacao.dtContrato',
                        'format' => 'dd/MM/yyyy'
                    ]
                )
                ->add(
                    'dtInicio',
                    'sonata_type_date_picker',
                    [
                        'label' => 'label.veiculoLocacao.dtInicio',
                        'format' => 'dd/MM/yyyy'
                    ]
                )
                ->add(
                    'dtTermino',
                    'sonata_type_date_picker',
                    [
                        'label' => 'label.veiculoLocacao.dtTermino',
                        'format' => 'dd/MM/yyyy'
                    ]
                )
                ->add('exercicio', null, $fieldOptions['exercicio'])
                ->add(
                    'codEntidade',
                    'entity',
                    $fieldOptions['codEntidade']
                )
                ->add(
                    'codEmpenho',
                    'integer',
                    $fieldOptions['codEmpenho']
                )
                ->add(
                    'vlLocacao',
                    'money',
                    [
                        'label' => 'label.veiculoLocacao.vlLocacao',
                        'attr' => array(
                            'class' => 'money '
                        ),
                        'currency' => 'BRL'
                    ]
                )
            ->end()
        ;

    }
}
