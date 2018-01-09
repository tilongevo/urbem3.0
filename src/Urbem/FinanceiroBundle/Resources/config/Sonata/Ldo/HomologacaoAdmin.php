<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Ldo;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityRepository;

class HomologacaoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_ldo_homologar_ldo';
    protected $baseRoutePattern = 'financeiro/ldo/homologar-ldo';

    protected $includeJs = array(
        '/financeiro/javascripts/ldo/homologar-ldo.js'
    );

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove("show");
        $collection->remove("delete");
        $collection->remove("export");
        $collection->remove("batch");
        $collection->add('get_exercicio_ldo_homologado', 'get-exercicio-ldo-homologado', array(), array(), array(), '', array(), array('POST'));
        $collection->add('get_veiculo_publicacao_tipo', 'get-veiculo-publicacao-tipo', array(), array(), array(), '', array(), array('POST'));
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $formOptions = array();

        $formOptions['codPpa'] = array(
            'label' => 'label.homologacaoLdo.codPpa',
            'class' => 'CoreBundle:Ppa\Ppa',
            'placeholder' => 'label.selecione',
            'attr' => array(
                'class' => 'select2-parameters'
            )
        );

        $formOptions['ano'] = array(
            'label' => 'label.homologacaoLdo.ano',
            'choices' => array(),
            'placeholder' => 'label.selecione',
            'attr' => array(
                'class' => 'select2-parameters'
            )
        );

        $formOptions['dtEncaminhamento'] = array(
            'label' => 'label.homologacaoLdo.dtEncaminhamento',
            'format' => 'dd/MM/yyyy',
        );

        $formOptions['nroProtocolo'] = array(
            'label' => 'label.homologacaoLdo.nroProtocolo'
        );

        $formOptions['dtDevolucao'] = array(
            'label' => 'label.homologacaoLdo.dtDevolucao',
            'format' => 'dd/MM/yyyy',
        );

        $formOptions['fkPpaPeriodicidade'] = array(
            'label' => 'label.homologacaoLdo.codPeriodicidade',
            'class' => 'CoreBundle:Ppa\Periodicidade',
            'choice_label' => 'nomPeriodicidade',
            'attr' => array(
                'class' => 'select2-parameters'
            )
        );

        $formOptions['codTipoVeiculosPublicidade'] = array(
            'label' => 'label.homologacaoLdo.codTipoVeiculosPublicidade',
            'mapped' => false,
            'class' => 'CoreBundle:Licitacao\TipoVeiculosPublicidade',
            'choice_label' => 'descricao',
            'attr' => array(
                'class' => 'select2-parameters'
            )
        );

        $formOptions['fkLicitacaoVeiculosPublicidade'] = array(
            'label' => 'label.homologacaoLdo.numcgmVeiculo',
            'choices' => array(),
            'placeholder' => 'label.selecione',
            'attr' => array(
                'class' => 'select2-parameters'
            ),
        );

        $fieldOptions['normaCodNorma'] = array(
            'label' => false,
            'mapped' => false,
            'required' => true,
            'attr' => ['class' => 'select2-parameters '],
            'route' => ['name' => 'urbem_financeiro_ppa_acao_autocomplete_norma']
        );

        if ($this->id($this->getSubject())) {
            $formOptions['fkLicitacaoVeiculosPublicidade']['data'] = $this->getSubject()
            ->getFkLicitacaoVeiculosPublicidade()
            ->getNumcgm();
            $formOptions['normaCodNorma']['data'] = $this->getSubject()->getFkNormasNorma();
        }

        $formMapper
            ->with('label.homologacaoLdo.homologacaoLdo')
                ->add(
                    'codPpa',
                    'entity',
                    $formOptions['codPpa']
                )
                ->add(
                    'ano',
                    'choice',
                    $formOptions['ano']
                )
            ->end()
            ->with('label.homologacaoLdo.dadosPrimeiraHomologacaoLDO')
                ->add(
                    'dtEncaminhamento',
                    'sonata_type_date_picker',
                    $formOptions['dtEncaminhamento']
                )
                ->add(
                    'nroProtocolo',
                    'number',
                    $formOptions['nroProtocolo']
                )
                ->add(
                    'dtDevolucao',
                    'sonata_type_date_picker',
                    $formOptions['dtDevolucao']
                )
                ->add(
                    'codTipoVeiculosPublicidade',
                    'entity',
                    $formOptions['codTipoVeiculosPublicidade']
                )
                ->add(
                    'fkLicitacaoVeiculosPublicidade',
                    'choice',
                    $formOptions['fkLicitacaoVeiculosPublicidade'],
                    array(
                        'admin_code' => 'patrimonial.admin.veiculos_publicidade'
                    )
                )
                ->add(
                    'fkPpaPeriodicidade',
                    'entity',
                    $formOptions['fkPpaPeriodicidade']
                )
            ->end()
            ->with('label.homologacaoLdo.norma')
                ->add(
                    'normaCodNorma',
                    'autocomplete',
                    $fieldOptions['normaCodNorma']
                )
            ->end()
        ;

        $admin = $this;
        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formMapper, $admin, $entityManager) {
                $form = $event->getForm();
                $data = $event->getData();
                $subject = $admin->getSubject($data);

                if (isset($data['codPpa']) && $data['codPpa'] != "") {
                    if ($form->has('ano')) {
                        $form->remove('ano');
                    }

                    $anos = (new \Urbem\CoreBundle\Model\Ldo\HomologacaoModel($entityManager))
                    ->getExercicioLdoHomologado($data['codPpa'], true);

                    $codPpa = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                        'ano',
                        'choice',
                        null,
                        array(
                            'choices' => $anos,
                            'label' => 'label.homologacaoLdo.codPpa',
                            'auto_initialize' => false,
                            'placeholder' => 'label.selecione',
                            'attr' => array(
                                'class' => 'select2-parameters'
                            )
                        )
                    );

                    $form->add($codPpa);
                }

                if (isset($data['codTipoVeiculosPublicidade'])) {
                    if ($form->has('fkLicitacaoVeiculosPublicidade')) {
                        $form->remove('fkLicitacaoVeiculosPublicidade');
                    }

                    $numcgmVeiculos = (new \Urbem\CoreBundle\Model\Ldo\HomologacaoModel($entityManager))
                    ->getVeiculoPublicacaoTipo($data['codTipoVeiculosPublicidade'], true);

                    $numcgmVeiculo = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                        'fkLicitacaoVeiculosPublicidade',
                        'entity',
                        null,
                        array(
                            'class' => 'CoreBundle:Licitacao\VeiculosPublicidade',
                            'choice_label' => 'fkSwCgm.nomCgm',
                            'query_builder' => function (EntityRepository $er) use ($data) {
                                return $er->createQueryBuilder('vp')
                                    ->where('vp.codTipoVeiculosPublicidade = :codTipoVeiculosPublicidade')
                                    ->setParameter('codTipoVeiculosPublicidade', $data['codTipoVeiculosPublicidade']);
                            },
                            'label' => 'label.homologacaoLdo.numcgmVeiculo',
                            'auto_initialize' => false,
                            'placeholder' => 'label.selecione',
                            'attr' => array(
                                'class' => 'select2-parameters'
                            ),
                            // 'data' => $data['fkLicitacaoVeiculosPublicidade']
                        )
                    );
                    $form->add($numcgmVeiculo);
                }
            }
        );
    }

    /**
     * @param \Sonata\CoreBundle\Validator\ErrorElement $errorElement
     * @param mixed $object
     */
    public function validate(\Sonata\CoreBundle\Validator\ErrorElement $errorElement, $object)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $dtEncaminhamento = (new \Urbem\CoreBundle\Model\Ldo\HomologacaoModel($entityManager))
        ->checarDataEncaminhamento($object);

        if (is_object($dtEncaminhamento)) {
            $error = $this->getTranslator()->trans('label.homologacaoLdo.erroDtEncaminhamento', array('%dtEncaminhamento%' => $dtEncaminhamento));
            $errorElement->with('dtEncaminhamento')->addViolation($error)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $error);
        }
    }

    /**
     * @param mixed $id
     * @return object|\Urbem\CoreBundle\Entity\Ldo\Homologacao
     */
    public function getObject($id)
    {
        $ids = explode("~", $id);
        list($codPpa, $ano) = $ids;

        $object = $this->getModelManager()->findOneBy($this->getClass(), array(
            'codPpa' => $codPpa,
            'ano' => $ano
        ));

        if (count($object) == 0) {
            $uniqid = $this->getRequest()->query->get('uniqid');
            $formData = $this->getRequest()->request->get($uniqid);
            $entityManager = $this->modelManager->getEntityManager($this->getClass());
            $timestamp = new \DateTime('now');

            $dtEncaminhamento = \DateTime::createFromFormat('d/m/Y', $formData['dtEncaminhamento']);
            $dtDevolucao = \DateTime::createFromFormat('d/m/Y', $formData['dtDevolucao']);
            $codPeriodicidade = $entityManager->getRepository('CoreBundle:Ppa\Periodicidade')
            ->findOneByCodPeriodicidade($formData['codPeriodicidade']);
            $numcgmVeiculo = $entityManager->getRepository('CoreBundle:Licitacao\VeiculosPublicidade')
            ->findOneByNumcgm($formData['numcgmVeiculo']);
            $codNorma = $entityManager->getRepository('CoreBundle:Normas\Norma')
            ->findOneByCodNorma($formData['codNorma']);
            $object = new \Urbem\CoreBundle\Entity\Ldo\Homologacao();
            $object->setCodPpa($formData['codPpa']);
            $object->setAno($formData['ano']);
            $object->setTimestamp($timestamp->format("Y-m-d H:i:s"));
            $object->setDtEncaminhamento($dtEncaminhamento);
            $object->setDtDevolucao($dtDevolucao);
            $object->setNroProtocolo($formData['nroProtocolo']);
            $object->setCodPeriodicidade($codPeriodicidade);
            $object->setNumcgmVeiculo($numcgmVeiculo);
            $object->setCodNorma($codNorma);
        }

        foreach ($this->getExtensions() as $extension) {
            $extension->alterObject($this, $object);
        }

        return $object;
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        
        $object->setCodPpa($this->getForm()->get('codPpa')->getData()->getCodPpa());
        $object->setFkNormasNorma($entityManager->getRepository('CoreBundle:Normas\Norma')->find((int) $this->getForm()->get('normaCodNorma')->getData()));
    }

    /**
     * @param mixed $object
     */
    public function preUpdate($object)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        
        $object->setCodPpa($this->getForm()->get('codPpa')->getData()->getCodPpa());
        $object->setFkNormasNorma($entityManager->getRepository('CoreBundle:Normas\Norma')->find((int) $this->getForm()->get('normaCodNorma')->getData()));
    }

    /**
     * @param mixed $object
     */
    public function postPersist($object)
    {
        $this->getRequest()->getSession()->getFlashBag()->add("success", $this->getTranslator()->trans('msgSucesso'));
        $this->forceRedirect($this->generateUrl('create'));
    }

    /**
     * @param mixed $object
     */
    public function postUpdate($object)
    {
        $this->getRequest()->getSession()->getFlashBag()->add("success", $this->getTranslator()->trans('msgSucesso'));
        $this->forceRedirect($this->generateUrl('create'));
    }
}
