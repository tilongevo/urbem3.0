<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Cargo;

use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Pessoal\Cbo;
use Urbem\CoreBundle\Entity\Pessoal\CboEspecialidade;
use Urbem\CoreBundle\Entity\Pessoal\EspecialidadePadrao;
use Urbem\CoreBundle\Entity\Pessoal\EspecialidadeSubDivisao;
use Urbem\CoreBundle\Entity\Pessoal\SubDivisao;
use Urbem\CoreBundle\Model\Pessoal\CargoPadraoModel;
use Urbem\CoreBundle\Model\Pessoal\EspecialidadeSubDivisaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class CargoEspecialidadeAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_pessoal_cargo_especialidade';

    protected $baseRoutePattern = 'recursos-humanos/cargo-especialidade';

    public function getFormTheme()
    {
        return array_merge(
            parent::getFormTheme(),
            array('PatrimonialBundle:Patrimonial\Grupo:grupoPlanoAnaliticas.html.twig')
        );
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codEspecialidade')
            ->add('codCargo')
            ->add('descricao')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('codEspecialidade')
            ->add('codCargo')
            ->add('descricao')
            ->add('_action', 'actions', [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ]
            ])
        ;
    }

    private function getNumeroVagasBySubdivisao(SubDivisao $subDivisao, array $especialidadeSubDivisao)
    {
        foreach ($especialidadeSubDivisao as $especialidade) {
            if ($subDivisao->getCodSubDivisao() == $especialidade->cod_sub_divisao) {
                return $especialidade->nro_vaga_criada;
            }
        }
        return 0;
    }

    private function getVagas(SubDivisao $subDivisao, array $especialidadeSubDivisao, $em)
    {
        $especialidadeSubDivisaoModel = new EspecialidadeSubDivisaoModel($em);

        foreach ($especialidadeSubDivisao as $especialidade) {
            if ($subDivisao->getCodSubDivisao() == $especialidade->cod_sub_divisao) {
                return $especialidadeSubDivisaoModel->getVagasOcupadasEspecialidade(
                    $especialidade->cod_regime,
                    $especialidade->cod_sub_divisao,
                    $especialidade->cod_especialidade
                );
            }
        }
        return 0;
    }

    public function validate(ErrorElement $errorElement, $object)
    {

        $subDivisoes = $this->request->request->get('codSubDivisao');
        $totalCargos = array_sum($subDivisoes);

        if ($totalCargos == 0) {
            $error = $this->trans('rh.gerenciamentoCargo.cargo.existCargo', [], 'flashes');
            $errorElement->addViolation($error)->end();
        }
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $subDivisoes = $em->getRepository('CoreBundle:Pessoal\SubDivisao')->findAll();
        $id = $this->getAdminRequestId();
        $codCargo = $this->getRequest()->get('codCargo');
        $cargoEspecialidade = $this->getSubject();
        $especialidadeSubDivisao = [];
        $vagasPorEspecialidade = [];

        $codCboCargo = '';
        $codCargoPadrao = '';
        $codNorma = '';

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        if (!is_null($id)) {
            $timestamp = array_shift($em->getRepository('CoreBundle:Pessoal\EspecialidadeSubDivisao')
                ->findBy(
                    ['codEspecialidade' => $id],
                    ['timestamp' => 'desc'],
                    1
                ))
            ->getTimestamp();

            $especialidadeSubDivisaoModel = new EspecialidadeSubDivisaoModel($em);

            $especialidadeSubDivisao = $especialidadeSubDivisaoModel->getEspecialidadeSubDivisaoPorTimestamp($timestamp, $id);

            $codCboCargo = $cargoEspecialidade->getFkPessoalCboEspecialidades()->last()->getFkPessoalCbo();

            $codCargoPadrao = $cargoEspecialidade
                ->getFkPessoalEspecialidadePadroes()
                ->last()
                ->getFkFolhapagamentoPadrao()
                ->getCodPadrao();


            $codNorma = $cargoEspecialidade
                ->getFkPessoalEspecialidadeSubDivisoes()
                ->last()
                ->getFkNormasNorma();
        }

        foreach ($subDivisoes as $subDivisao) {
            /** @var SubDivisao $subDivisao */
            $vagasPorEspecialidade[] = [
                'descricao' => $subDivisao->getDescricao(),
                'nroVagaCriada' => $this->getNumeroVagasBySubdivisao($subDivisao, $especialidadeSubDivisao),
                'codSubDivisao' => $subDivisao->getCodSubDivisao(),
                'vagasOcupadas' => $this->getVagas($subDivisao, $especialidadeSubDivisao, $em),
                'regime' => $subDivisao->getFkPessoalRegime(),
            ];
        }

        $fieldOptions = [];

        $fieldOptions['codCboCargo'] = [
            'class' => 'CoreBundle:Pessoal\Cbo',
            'choice_label' => function (Cbo $cbo) {
                return $cbo->getCodCbo() . ' - ' .
                    $cbo->getDescricao();
            },
            'placeholder' => 'label.selecione',
            'label' => 'label.cargo.cbo',
            'data' => $codCboCargo,
            'mapped' => false,
            'required' => true,
            'attr' => ['class' => 'select2-parameters ']
        ];

        $cargoPadrao = new CargoPadraoModel($em);

        $arrItens = array();
        foreach ($cargoPadrao->getPadraoByTimestamp() as $item) {
            $arrItens[$item->descricao . ' - R$ ' . $item->valor] = $item->cod_padrao;
        }

        $fieldOptions['codCargoPadrao'] = [
            'choices' => $arrItens,
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'label' => 'label.exercicio',
            'data' =>  $codCargoPadrao
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

        $formMapper
            ->with('Dados da Especialização')
                ->add(
                    'codCargo',
                    'hidden',
                    [
                        'data' => $codCargo,
                        'mapped' => false
                    ]
                )
                ->add('descricao')
                ->add('fkPessoalCboEspecialidades', 'entity', $fieldOptions['codCboCargo'])
                ->add('fkPessoalEspecialidadePadroes', 'choice', $fieldOptions['codCargoPadrao'])
            ->end()
            ->with('label.cargo.normaRegulamentadoraCargo')
                ->add('codNorma', 'entity', $fieldOptions['codNorma'])
            ->end()
            ->with('Quantidade de Vagas por Cargo')
                ->add(
                    'subDivisao',
                    'customField',
                    [
                        'label' => false,
                        'mapped' => false,
                        'template' => 'RecursosHumanosBundle::Pessoal/Cargo/vagasCargo.html.twig',
                        'data' => $vagasPorEspecialidade
                    ]
                )
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codEspecialidade')
            ->add('codCargo')
            ->add('descricao')
        ;
    }

    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $codCargo = $this->getForm()->get('codCargo')->getData();
        $cargo = $em->getRepository('CoreBundle:Pessoal\Cargo')->findOneByCodCargo($codCargo);
        $object->setFkPessoalCargo($cargo);
    }


    public function postPersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $form = $this->getForm();

        $codEspecialidadePadrao = $this->getForm()->get('fkPessoalEspecialidadePadroes')->getData();
        $padrao = $em->getRepository('CoreBundle:Folhapagamento\Padrao')->findOneByCodPadrao($codEspecialidadePadrao);

        $especialidadePadrao = new EspecialidadePadrao();
        $especialidadePadrao->setFkPessoalEspecialidade($object);
        $especialidadePadrao->setFkFolhapagamentoPadrao($padrao);

        $cboEspecialidade = new CboEspecialidade();
        $cboEspecialidade->setFkPessoalCbo($form->get('fkPessoalCboEspecialidades')->getData());
        $cboEspecialidade->setFkPessoalEspecialidade($object);

        $norma = $form->get('codNorma')->getData();
        $subDivisoes = $this->request->request->get('codSubDivisao');

        foreach ($subDivisoes as $codSubdivisao => $qtdVagas) {
            if ($qtdVagas !== "") {
                $subDivisao = $em->getRepository('CoreBundle:Pessoal\SubDivisao')->findOneByCodSubDivisao($codSubdivisao);
                $especialidadeSubDivisao = new EspecialidadeSubDivisao();
                $especialidadeSubDivisao->setFkNormasNorma($norma);
                $especialidadeSubDivisao->setFkPessoalSubDivisao($subDivisao);
                $especialidadeSubDivisao->setNroVagaCriada($qtdVagas);
                $especialidadeSubDivisao->setFkPessoalEspecialidade($object);
                $em->persist($especialidadeSubDivisao);
            }
        }

        $em->persist($cboEspecialidade);
        $em->persist($especialidadePadrao);
        $em->flush();

        $this->forceRedirect("/recursos-humanos/cargo/{$object->getCodCargo()}/show");
    }

    public function postUpdate($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $subDivisoes = $this->request->request->get('codSubDivisao');
        $form = $this->getForm();
        $norma = $form->get('codNorma')->getData();

        $cboEspecialidade = new CboEspecialidade();
        $cboEspecialidade->setFkPessoalCbo($form->get('fkPessoalCboEspecialidades')->getData());
        $cboEspecialidade->setFkPessoalEspecialidade($object);

        $codEspecialidadePadrao = $this->getForm()->get('fkPessoalEspecialidadePadroes')->getData();
        $padrao = $em->getRepository('CoreBundle:Folhapagamento\Padrao')->findOneByCodPadrao($codEspecialidadePadrao);

        $especialidadePadrao = new EspecialidadePadrao();
        $especialidadePadrao->setFkPessoalEspecialidade($object);
        $especialidadePadrao->setFkFolhapagamentoPadrao($padrao);


        foreach ($subDivisoes as $codSubdivisao => $qtdVagas) {
            if (($qtdVagas !== "") && ($qtdVagas != "0")) {
                $subDivisao = $em->getRepository('CoreBundle:Pessoal\SubDivisao')->findOneByCodSubDivisao($codSubdivisao);
                $especialidadeSubDivisao = new EspecialidadeSubDivisao();
                $especialidadeSubDivisao->setFkNormasNorma($norma);
                $especialidadeSubDivisao->setFkPessoalSubDivisao($subDivisao);
                $especialidadeSubDivisao->setNroVagaCriada($qtdVagas);
                $especialidadeSubDivisao->setFkPessoalEspecialidade($object);
                $em->persist($especialidadeSubDivisao);
            }
        }

        $em->persist($cboEspecialidade);
        $em->persist($especialidadePadrao);
        $em->flush();

        $this->forceRedirect("/recursos-humanos/cargo/{$object->getCodCargo()}/show");
    }

    public function postRemove($object)
    {
        $this->forceRedirect("/recursos-humanos/cargo/{$object->getCodCargo()}/show");
    }
}
