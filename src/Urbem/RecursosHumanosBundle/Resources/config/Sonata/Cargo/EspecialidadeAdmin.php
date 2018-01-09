<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Cargo;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Urbem\CoreBundle\Entity\Pessoal;

class EspecialidadeAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_pessoal_cargo_especialidade';

    protected $baseRoutePattern = 'recursos-humanos/cargo/especialidade';

    public function prePersist($object)
    {

        /**
         * @TODO Tarefa incompleta, o @Vicente estava trabalhando nisso parou no meio e não lembra o que era,
         * por ser tratar de um erro de PSR e não deveria estar na master, estamos lançando uma exception =/
         */
        throw new \RuntimeException($object);
        die();

        $cbo = $this->getForm()->get('codCboEspecialidade')->getData();
        if ($cbo != null) {
            $cboEspecialidade = new Pessoal\CboEspecialidade();
            $cboEspecialidade->setCodEspecialidade($object);
            $cboEspecialidade->setCodCbo($cbo);
            $object->addCodCboEspecialidade($cboEspecialidade);
        }

        $padrao = $this->getForm()->get('codEspecialidadePadrao')->getData();
        if ($padrao != null) {
            $especialidadePadrao = new Pessoal\EspecialidadePadrao();
            $especialidadePadrao->setCodEspecialidade($object);
            $especialidadePadrao->setCodPadrao($padrao);
            $object->addCodEspecialidadePadrao($especialidadePadrao);
        }

        $cadastrados = [];
        $norma = $this->getForm()->get('codNorma')->getData();
        $subDivisoes = $object->getCodEspecialidadeSubDivisao();
        foreach ($subDivisoes as $subDivisao) {
            $cadastrados[] = $subDivisao->getCodSubDivisao()->getCodSubDivisao();
            $subDivisao->setCodNorma($norma);
        }
        $em = $this->modelManager->getEntityManager($this->getClass());
        $subDivisoes = $em->getRepository('CoreBundle:Pessoal\SubDivisao')->findAll();
        foreach ($subDivisoes as $subDivisao) {
            if (!in_array($subDivisao->getCodSubDivisao(), $cadastrados)) {
                $especialidadeSubDivisao = new Pessoal\EspecialidadeSubDivisao();
                $especialidadeSubDivisao->setNroVagaCriada(0);
                $especialidadeSubDivisao->setCodNorma($norma);
                $especialidadeSubDivisao->setCodSubDivisao($subDivisao);
                $especialidadeSubDivisao->setCodEspecialidade($object);
                $object->addCodEspecialidadeSubDivisao($especialidadeSubDivisao);
            }
        }
    }

    public function preUpdate($object)
    {



        $id = $this->getAdminRequestId();
        $em = $this->modelManager->getEntityManager($this->getClass());
        $especialidade = $em->getRepository('CoreBundle:Pessoal\Especialidade')->find($id);

        $formData = $this->getRequest()->request->get($this->getUniqid());

//        dump($formData['codNorma']);
//        die();

        foreach($especialidade->getCodEspecialidadePadrao() as $especialidadePadrao) {
            $especialidadePadraoRemove = $em->getRepository('CoreBundle:Pessoal\EspecialidadePadrao')->findOneBy(['codEspecialidade' => $id, 'codPadrao' => $especialidadePadrao->getCodPadrao()]);
            $em->remove($especialidadePadraoRemove);
            $em->flush();
            $object->removeCodEspecialidadePadrao($especialidadePadrao);
            #ok
        }

        foreach($especialidade->getCodCboEspecialidade() as $cboEspecialidade) {
            $cboEspecialidadeRemove = $em->getRepository('CoreBundle:Pessoal\CboEspecialidade')->findOneBy(['codEspecialidade' => $id, 'codCbo' => $cboEspecialidade->getCodCbo()]);
            $em->remove($cboEspecialidadeRemove);
            $em->flush();
            $object->removeCodCboEspecialidade($cboEspecialidade);
            #ok
        }

        $cbo = $this->getForm()->get('codCboEspecialidade')->getData();
        #ok

        if ($cbo != null) {
            $cboEspecialidade = new Pessoal\CboEspecialidade();
            $cboEspecialidade->setCodEspecialidade($object);
            $cboEspecialidade->setCodCbo($cbo);
            $object->addCodCboEspecialidade($cboEspecialidade);
        }

        $padrao = $this->getForm()->get('codEspecialidadePadrao')->getData();


        if ($padrao != null) {
            $especialidadePadrao = new Pessoal\EspecialidadePadrao();
            $especialidadePadrao->setCodEspecialidade($object);
            $especialidadePadrao->setCodPadrao($padrao);
            $object->addCodEspecialidadePadrao($especialidadePadrao);
        } #ok
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codCargo', null, ['label' => 'label.especialidade.codCargo'], 'entity', [
                'class' => 'CoreBundle:Pessoal\Cargo',
                'choice_label' => 'descricao',
                'placeholder' => 'label.selecione',
                'attr' => ['class' => 'select2-parameters ']
            ])
            ->add('descricao', null, ['label' => 'label.descricao'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codEspecialidade', 'number', ['label' => 'label.codigo'])
            ->add('descricao', 'text', ['label' => 'label.descricao'])
            ->add('codCargo', 'collection', ['label' => 'label.especialidade.codCargo'])
            ->add('codEspecialidadePadrao', 'collection', ['label' => 'label.especialidade.codEspecialidadePadrao'])
            ->add('codCboEspecialidade', 'collection', ['label' => 'label.especialidade.codCboEspecialidade'])
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions = [];

        $entityManager = $this->modelManager->getEntityManager($this->getClass());


        if ($this->id($this->getSubject())) {
            $normasNormaId = $entityManager->getRepository('CoreBundle:Pessoal\EspecialidadeSubDivisao')->findOneByCodEspecialidade($id);
        }


        $fieldOptions['codCargo'] = [
          'class' => 'CoreBundle:Pessoal\Cargo',
          'choice_label' => 'descricao',
          'placeholder' => 'label.selecione',
          'label' => false,
          'attr' => ['class' => 'select2-parameters ']
        ];

        $fieldOptions['codEspecialidadePadrao'] = [
            'class' => 'CoreBundle:Folhapagamento\Padrao',
            'choice_label' => 'descricao',
            'placeholder' => 'label.selecione',
            'label' => 'label.especialidade.codEspecialidadePadrao',
            'attr' => ['class' => 'select2-parameters '],
            'mapped' => false,
        ];

        $fieldOptions['codCboEspecialidade'] = [
            'class' => 'CoreBundle:Pessoal\Cbo',
            'choice_label' => 'descricao',
            'placeholder' => 'label.selecione',
            'label' => 'label.especialidade.codCboEspecialidade',
            'attr' => ['class' => 'select2-parameters '],
            'mapped' => false,
        ];


//        $fieldOptions['codNorma'] = [
//            'class' => 'CoreBundle:Normas\Norma',
//            'choice_label' => 'descricao',
//            'placeholder' => 'label.selecione',
//            'label' => 'label.cargo.norma',
//            'choice_attr' => function ($entidade, $key, $index) use ($normasNormaId) {
//
//                if ($index == $normasNormaId->getCodNorma()->getCodNorma()) {
//                    return ['selected' => 'selected'];
//                } else {
//                    return ['selected' => false];
//                }
//            },
//            'mapped' => false,
//            'attr' => ['class' => 'select2-parameters ']
//        ];



        $fieldOptions['codNorma'] = [
            'class' => 'CoreBundle:Normas\Norma',
            'choice_label' => function ($codNorma) {
                $return = $codNorma->getNumNorma();
                $return .= '/'.$codNorma->getExercicio();
                $return .= ' - '.$codNorma->getDescricao();

                return $return;
            },
            'placeholder' => 'label.selecione',
            'label' => 'label.cargo.norma',
            'mapped' => false,
            'attr' => ['class' => 'select2-parameters ']
        ];

        if ($this->id($this->getSubject())) {
            $em = $this->modelManager->getEntityManager($this->getClass());
            $especialidade = $em->getRepository('CoreBundle:Pessoal\Especialidade')->find($this->getAdminRequestId());
            foreach ($especialidade->getCodEspecialidadeSubDivisao() as $subdivicao) {
                $norma = $subdivicao->getCodNorma();
                break;
            }
            $fieldOptions['codNorma']['data'] = $norma;
            $padroes = $especialidade->getCodEspecialidadePadrao();
            foreach ($padroes as $padrao) {
                $fieldOptions['codEspecialidadePadrao']['data'] = $padrao->getCodPadrao();
            }
            $cbos = $especialidade->getCodCboEspecialidade();
            foreach ($cbos as $cbo) {
                $fieldOptions['codCboEspecialidade']['data'] = $cbo->getCodCbo();
            }
            $fieldOptions['codCargo']['attr'] = ['class' => 'select2-parameters '];
        } else {
            $formMapper
                ->with('label.cargo.dadosCargo')
                    ->add('codCargo', 'entity', $fieldOptions['codCargo'])
                ->end()
            ;
        }

        $formMapper
            ->with('label.cargo.dadosEspecialidade')
                ->add('descricao', 'text', ['label' => 'label.cargo.espDescricao'])
                ->add('codCboEspecialidade', 'entity', $fieldOptions['codCboEspecialidade'])
                ->add('codEspecialidadePadrao', 'entity', $fieldOptions['codEspecialidadePadrao'])
            ->end()
            ->with('label.cargo.normaRegulamentadoraCargo')
                ->add('codNorma', 'entity', $fieldOptions['codNorma'])
            ->end()
            ->with('label.cargo.quantidadeVagasCargo')
                ->add(
                    'codEspecialidadeSubDivisao',
                    'sonata_type_collection',
                    array(
                        'by_reference' => false,
                        'label' => false,
                        'type_options' => array(
                            'delete' => false,
                            'delete_options' => array(
                                'type' => 'hidden'
                            ),
                        )
                    ),
                    array(
                        'edit' => 'inline',
                        'inline' => 'table',
                    )
                )
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add('codEspecialidade', null, ['label' => 'label.codigo'])
            ->add('descricao', null, ['label' => 'label.descricao'])
            ->add('codCargo', 'collection', ['label' => 'label.especialidade.codCargo'])
            ->add('codEspecialidadePadrao', 'collection', ['label' => 'label.especialidade.codEspecialidadePadrao'])
            ->add('codCboEspecialidade', 'collection', ['label' => 'label.especialidade.codCboEspecialidade'])
        ;
    }
}
