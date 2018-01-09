<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Cargo;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Entity\Pessoal;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CargoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_pessoal_cargo';

    protected $baseRoutePattern = 'recursos-humanos/cargo';

    protected $model = Model\Pessoal\CargoModel::class;

    /**
     * @param $form
     * @return bool
     */
    protected function isEspecialidade($form)
    {
        return $form->get('cargoEspecialidade')->getData() === true;
    }

    protected function addActionsGrid(ListMapper $listMapper)
    {
        $listMapper
            ->add('_action', 'actions', [
                'actions' => [
                    'show' => ['template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'],
                    'delete' => ['template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'],
                ]
            ])
        ;
    }

    protected function setEspecialidade($form, $object)
    {
        $espDescricao = $form->get('espDescricao')->getData();

        $especialidade = new Pessoal\Especialidade();
        $especialidade->setDescricao($espDescricao);
        $especialidade->setCodCargo($object);

        return $especialidade;
    }

    protected function setCboEspecialidade($form, $especialidade)
    {
        $cbo = $form->get('espCbo')->getData();
        if (!empty($cbo)) {
            $espCbo = new Pessoal\CboEspecialidade();
            $espCbo->setCodEspecialidade($especialidade);
            $espCbo->setCodCbo($cbo);
            $especialidade->addCodCboEspecialidade($espCbo);
        }
    }

    protected function setEspecialidadePadrao($form, $especialidade)
    {
        $padrao = $form->get('espPadrao')->getData();
        if ($padrao != null) {
            $espPadrao = new Pessoal\EspecialidadePadrao();
            $espPadrao->setCodEspecialidade($especialidade);
            $espPadrao->setCodPadrao($padrao);
            $especialidade->addCodEspecialidadePadrao($espPadrao);
        }
    }

    protected function setEspecialidadeSubDivisao($form, $especialidade, $object, $em)
    {
        $cadastrados = [];
        $norma = $form->get('codNorma')->getData();
        $subDivisoes = $object->getCodCargoSubDivisao();
        $object->setCodCargoSubDivisao(new ArrayCollection());
        $object->setCodEspecialidade(new ArrayCollection());
        $object->setCodCargoEspecialidadeSubDivisao(new ArrayCollection());

        foreach ($subDivisoes as $subDivisao) {
            $cadastrados[] = $subDivisao->getCodSubDivisao()->getCodSubDivisao();

            $especialidadeSubDivisao = new Pessoal\EspecialidadeSubDivisao();
            $especialidadeSubDivisao->setNroVagaCriada($subDivisao->getNroVagaCriada());
            $especialidadeSubDivisao->setCodNorma($norma);
            $especialidadeSubDivisao->setCodSubDivisao($subDivisao->getCodSubDivisao());
            $especialidadeSubDivisao->setCodEspecialidade($especialidade);
            $especialidadeSubDivisao->setCodCargo($object);
            $especialidade->addCodEspecialidadeSubDivisao($especialidadeSubDivisao);
        }

        $subDivisoes = $em->getRepository('CoreBundle:Pessoal\SubDivisao')->findAll();
        foreach ($subDivisoes as $subDivisao) {
            if (!in_array($subDivisao->getCodSubDivisao(), $cadastrados)) {
                $especialidadeSubDivisao = new Pessoal\EspecialidadeSubDivisao();
                $especialidadeSubDivisao->setNroVagaCriada(0);
                $especialidadeSubDivisao->setCodNorma($norma);
                $especialidadeSubDivisao->setCodSubDivisao($subDivisao);
                $especialidadeSubDivisao->setCodEspecialidade($especialidade);
                $especialidadeSubDivisao->setCodCargo($object);
                $especialidade->addCodEspecialidadeSubDivisao($especialidadeSubDivisao);
            }
        }

        $object->addCodEspecialidade($especialidade);
    }

    protected function setCboCargo($form, $object)
    {
        $cbo = $form->get('codCboCargo')->getData();
        if ($cbo != null) {
            $cboCargo = new Pessoal\CboCargo();
            $cboCargo->setCodCargo($object);
            $cboCargo->setCodCbo($cbo);
            $object->addCodCboCargo($cboCargo);
        }
    }

    protected function setCargoPadrao($form, $object)
    {
        $padrao = $form->get('codCargoPadrao')->getData();
        if ($padrao != null) {
            $cargoPadrao = new Pessoal\CargoPadrao();
            $cargoPadrao->setCodCargo($object);
            $cargoPadrao->setCodPadrao($padrao);
            $object->addCodCargoPadrao($cargoPadrao);
        }
    }

    protected function setCargoSubDivisao($form, $object, $em)
    {
        $cadastrados = [];
        $norma = $form->get('codNorma')->getData();
        $subDivisoes = $object->getCodCargoSubDivisao();

        $object->setCodEspecialidade(new ArrayCollection());
        $object->setCodCargoEspecialidadeSubDivisao(new ArrayCollection());

        foreach ($subDivisoes as $subDivisao) {
            $cadastrados[] = $subDivisao->getCodSubDivisao()->getCodSubDivisao();
            $subDivisao->setCodNorma($norma);
        }

        $subDivisoes = $em->getRepository('CoreBundle:Pessoal\SubDivisao')->findAll();
        foreach ($subDivisoes as $subDivisao) {
            if (!in_array($subDivisao->getCodSubDivisao(), $cadastrados)) {
                $cargoSubDivisao = new Pessoal\CargoSubDivisao();
                $cargoSubDivisao->setNroVagaCriada(0);
                $cargoSubDivisao->setCodNorma($norma);
                $cargoSubDivisao->setCodSubDivisao($subDivisao);
                $cargoSubDivisao->setCodCargo($object);
            }
        }
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('descricao', null, array('label' => 'Descrição'))
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('descricao', null, array('label' => 'label.descricao'))
            ->add('fkSwEscolaridade', null, array('label' => 'label.cargo.codEscolaridade'))
            ->add('cargoCc', null, array('label' => 'label.cargo.cargoCc'))
            ->add('funcaoGratificada', null, array('label' => 'label.cargo.funcaoGratificada'))
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
        $codNorma = $codCboCargo = $cargoEspecialidade = $espPadrao = $espCbo =
        $codCargoPadrao = $codEspecialidade = '';
        $cargoEspecialidadeAttr = ['class' => 'select2-parameters '];
        $cargoEspecialidadeChecked = false;

        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        // Verificar se é especialidade
        $isEspecialidade = $this->getSubject()->getFkPessoalEspecialidades()->count() > 0;

        $requisitos = [];

        if ($this->id($this->getSubject())) {
            $cargoEspecialidadeAttr = ['disabled' => 'disabled'];
            $codCargo = $this->getSubject()->getCodCargo();

            $cargosRequisitosPorCod = array_map(
                function ($item) {
                    return $item->getCodRequisito();
                },
                $this
                    ->getSubject()
                    ->getFkPessoalCargoRequisitos()
                    ->toArray()
            );

            $requisitos = $this
                ->getDoctrine()
                ->getRepository(Pessoal\Requisito::class)
                ->findBy(
                    [
                        'codRequisito' => $cargosRequisitosPorCod
                    ]
                );


            if (!$isEspecialidade) {
                $codCboCargo = $entityManager->getRepository('CoreBundle:Pessoal\CboCargo')->findOneByCodCargo($codCargo);
                $codCboCargo = !empty($codCboCargo) ? $codCboCargo->getCodCbo() : '';
                $codCargoPadrao = $entityManager->getRepository('CoreBundle:Pessoal\CargoPadrao')->findOneByCodCargo($codCargo);
                $codCargoPadrao = !empty($codCargoPadrao) ? $codCargoPadrao->getCodPadrao() : '';
                $codNorma = $entityManager->getRepository('CoreBundle:Pessoal\CargoSubDivisao')->findOneByCodCargo($codCargo);
                $codNorma = !empty($codNorma) ? $codNorma->getCodNorma() : '';
            }
        } else {
            // Somente para ação no cadastro
            $totalSubDivisoes = count($entityManager->getRepository('CoreBundle:Pessoal\SubDivisao')->findAll());
            $cargo = $this->getSubject();

            while ($totalSubDivisoes > 0) {
                $cargoSubDivisao = new Pessoal\CargoSubDivisao();
                $cargoSubDivisao->setNroVagaCriada(0);
                $especialidadeSubDivisao = new Pessoal\EspecialidadeSubDivisao();
                $especialidadeSubDivisao->setNroVagaCriada(0);


                $totalSubDivisoes--;
            }
        }

        $fieldOptions['espPadrao'] = [
            'class' => 'CoreBundle:Folhapagamento\Padrao',
            'choice_label' => 'descricao',
            'placeholder' => 'label.selecione',
            'label' => 'label.cargo.padrao',
            'mapped' => false,
            'required' => false,
            'data' => $espPadrao,
            'attr' => ['class' => 'select2-parameters ']
        ];

        $fieldOptions['espCbo'] = [
            'class' => 'CoreBundle:Pessoal\Cbo',
            'choice_label' => 'descricao',
            'placeholder' => 'label.selecione',
            'label' => 'label.cargo.cbo',
            'mapped' => false,
            'required' => false,
            'data' => $espCbo,
            'attr' => ['class' => 'select2-parameters ']
        ];

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
            'data' => $codNorma,
            'mapped' => false,
            'attr' => ['class' => 'select2-parameters ']
        ];

        $fieldOptions['codRequisito'] = [
            'class' => 'CoreBundle:Pessoal\Requisito',
            'choice_label' => 'descricao',
            'placeholder' => 'label.selecione',
            'label' => 'label.cargo.codRequisito',
            'multiple' => true,
            'attr' => ['class' => 'select2-parameters '],
            'mapped' => false,
            'data' => $requisitos
        ];

        $fieldOptions['codEscolaridade'] = [
            'class' => 'CoreBundle:SwEscolaridade',
            'choice_label' => 'descricao',
            'placeholder' => 'label.selecione',
            'label' => 'label.cargo.codEscolaridade',
            'attr' => ['class' => 'select2-parameters ']
        ];

        $fieldOptions['cargoEspecialidade'] = [
            'label' => 'label.cargo.cargoEspecialidade',
            'required' => false,
            'mapped' => false,
            'attr' => $cargoEspecialidadeAttr,
            'data' => $cargoEspecialidadeChecked
        ];

        // CBO OU CBO_ESPECIALIDADE
        $fieldOptions['codCboCargo'] = [
            'class' => 'CoreBundle:Pessoal\Cbo',
            'choice_label' => 'descricao',
            'placeholder' => 'label.selecione',
            'label' => 'label.cargo.cbo',
            'data' => $codCboCargo,
            'mapped' => false,
            'required' => false,
            'attr' => ['class' => 'select2-parameters ']
        ];

        // PADRAO OU ESPECIALIDADE_ESPECIALIDADE
        $fieldOptions['codCargoPadrao'] = [
            'class' => 'CoreBundle:Folhapagamento\Padrao',
            'choice_label' => 'descricao',
            'placeholder' => 'label.selecione',
            'label' => 'label.cargo.padrao',
            'data' => $codCargoPadrao,
            'mapped' => false,
            'required' => false,
            'attr' => ['class' => 'select2-parameters ']
        ];

        $fieldOptions['espDescricao'] = [
            'data' => $cargoEspecialidade,
            'label' => 'label.cargo.espDescricao',
            'mapped' => false,
            'required' => false
        ];

        $formMapper
            ->with('label.cargo.dadosCargo')
                ->add('descricao', null, array('label' => 'label.descricao'))
                ->add('fkSwEscolaridade', 'entity', $fieldOptions['codEscolaridade'])
                ->add('codRequisito', 'entity', $fieldOptions['codRequisito'])
                ->add('atribuicoes', null, array('label' => 'Descrição das Atribuições'))
                ->add('cargoCc', null, array('label' => ' Cargo Confiança'))
                ->add('funcaoGratificada', null, array('label' => ' Função Gratificada'))

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
            ->add('descricao', null, array('label' => 'label.descricao'))
            ->add('codRequisito', 'entity', array('label' => 'Requisitos'))
            ->add('cargoCc', null, array('label' => 'label.cargo.cargoCc'))
            ->add('codEscolaridade.descricao', null, array('label' => 'label.cargo.codEscolaridade'))
            ->add('funcaoGratificada', null, array('label' => 'label.cargo.funcaoGratificada'))
            ->add('atribuicoes', null, array('label' => 'label.cargo.atribuicoes'))
            ->add('codEspecialidade', null, array('label' => 'label.cargo.codEspecialidade', 'route' => ['name' => 'urbem_recursos_humanos_pessoal_cargo_show']))
        ;
    }

    public function postPersist($object)
    {
        $form = $this->getForm();
        $em = $this->modelManager->getEntityManager($this->getClass());

        $requisitos = $form->get('codRequisito')->getData();

        foreach ($requisitos as $item) {
            $requisito = new Pessoal\CargoRequisito();
            $requisito->setFkPessoalCargo($object);
            $requisito->setFkPessoalRequisito($item);
            $em->persist($requisito);
        }
        $em->flush();

        $this->forceRedirect("/recursos-humanos/cargo/{$object->getCodCargo()}/show");
    }

    public function preUpdate($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $cargoRequisitosArrayCollection = $object->getFkPessoalCargoRequisitos();

        foreach ($cargoRequisitosArrayCollection as $cargoRequisito) {
            $em->remove($cargoRequisito);
        }
        $em->flush();
    }

    public function postUpdate($object)
    {
        $form = $this->getForm();
        $em = $this->modelManager->getEntityManager($this->getClass());

        $requisitos = $form->get('codRequisito')->getData();

        foreach ($requisitos as $item) {
            $requisito = new Pessoal\CargoRequisito();
            $requisito->setFkPessoalCargo($object);
            $requisito->setFkPessoalRequisito($item);
            $em->persist($requisito);
        }
        $em->flush();

        $this->forceRedirect("/recursos-humanos/cargo/{$object->getCodCargo()}/show");
    }
}
