<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Cargo;

use Doctrine\ORM\EntityRepository;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Pessoal\CargoPadrao;
use Urbem\CoreBundle\Entity\Pessoal\CargoSubDivisao;
use Urbem\CoreBundle\Entity\Pessoal\Cbo;
use Urbem\CoreBundle\Entity\Pessoal\CboCargo;
use Urbem\CoreBundle\Entity\Pessoal\SubDivisao;
use Urbem\CoreBundle\Model\Pessoal\CargoPadraoModel;
use Urbem\CoreBundle\Model\Pessoal\CargoSubDivisaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class CargoPadraoAdmin extends AbstractSonataAdmin
{

    protected $baseRouteName = 'urbem_recursos_humanos_pessoal_cargo_padrao';

    protected $baseRoutePattern = 'recursos-humanos/cargo-padrao';


    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codCargo')
            ->add('codPadrao')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {

        $this->setBreadCrumb();
        $listMapper
            ->add('codCargo')
            ->add('codPadrao');
        $this->addActionsGrid($listMapper);
    }

    private function getVagas(SubDivisao $subDivisao, array $cargoSubDivisao, $em)
    {
        $cargoSubDivisaoModel = new CargoSubDivisaoModel($em);

        foreach ($cargoSubDivisao as $cargoSubDivisao) {
            if ($subDivisao->getCodSubDivisao() == $cargoSubDivisao->cod_sub_divisao) {
                return $cargoSubDivisaoModel->getVagasOcupadasCargo(
                    $cargoSubDivisao->cod_regime,
                    $cargoSubDivisao->cod_sub_divisao,
                    $cargoSubDivisao->cod_cargo
                );
            }
        }
        return 0;
    }

    private function getNumeroVagasBySubdivisao(SubDivisao $subDivisao, array $cargoSubDivisao)
    {
        foreach ($cargoSubDivisao as $especialidade) {
            if ($subDivisao->getCodSubDivisao() == $especialidade->cod_sub_divisao) {
                return $especialidade->nro_vaga_criada;
            }
        }
        return 0;
    }


    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {

        $em = $this->modelManager->getEntityManager($this->getClass());
        $subDivisoes = $em->getRepository('CoreBundle:Pessoal\SubDivisao')->findAll();

        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);
        $codCargo = $this->getRequest()->get('codCargo');
        $cargoPadrao = $this->getSubject();

        $codCboCargo = '';
        $codCargoPadrao = '';
        $codNorma = '';
        $vagasPorEspecialidade = [];
        $cargoSubDivisao = [];

        $fieldOptions = [];
        $fieldOptions['codCboCargo'] = [
            'class' => 'CoreBundle:Pessoal\Cbo',
            'choice_label' => function (Cbo $cbo) {
                return $cbo->getCodigo() . ' - ' . $cbo->getDescricao();
            },
            'placeholder' => 'label.selecione',
            'label' => 'label.cargo.cbo',

            'mapped' => false,
            'required' => true,
            'attr' => ['class' => 'select2-parameters ']
        ];

        $cargoPadraoModel = new CargoPadraoModel($em);

        $arrItens = array();
        foreach ($cargoPadraoModel->getPadraoByTimestamp() as $item) {
            $arrItens[$item->descricao . ' - R$ ' . $item->valor] = $item->cod_padrao;
        }

        $fieldOptions['codCargoPadrao'] = [
            'choices' => $arrItens,
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'label' => 'label.cargo.padraoSalarial',
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
            'mapped' => false,
            'attr' => ['class' => 'select2-parameters ']
        ];

        if (!is_null($id)) {
            list($codCargo, $codNorma, $timestamp) = explode("~", $id);

            /** @var CargoPadrao $cargoPadrao */
            $cargoPadrao = $this->getSubject();

            $fieldOptions['codCboCargo']['data'] = $cargoPadrao
                ->getFkPessoalCargo()
                ->getFkPessoalCboCargos()
                ->current()
                ->getFkPessoalCbo();

            $timestamp = array_shift($em->getRepository('CoreBundle:Pessoal\CargoSubDivisao')
                ->findBy(
                    ['codCargo' => $codCargo],
                    ['timestamp' => 'desc'],
                    1
                ))
                ->getTimestamp();

            $fieldOptions['codNorma']['data'] = $cargoPadrao
                ->getFkPessoalCargo()
                ->getFkPessoalCargoSubDivisoes()
                ->last()
                ->getFkNormasNorma();

            $cargoSubDivisaoModel = new CargoSubDivisaoModel($em);

            $cargoSubDivisao = $cargoSubDivisaoModel->getCargoSubDivisaoPorTimestamp($timestamp, $codCargo);
        }

        foreach ($subDivisoes as $subDivisao) {
            /** @var SubDivisao $subDivisao */
            $vagasPorEspecialidade[] = [
                'descricao' => $subDivisao->getDescricao(),
                'nroVagaCriada' => $this->getNumeroVagasBySubdivisao($subDivisao, $cargoSubDivisao),
                'codSubDivisao' => $subDivisao->getCodSubDivisao(),
                'vagasOcupadas' => $this->getVagas($subDivisao, $cargoSubDivisao, $em),
                'regime' => $subDivisao->getFkPessoalRegime(),
            ];
        }

        $formMapper
            ->with('label.cargo.dadosCargoPadrao')
                ->add(
                    'codCargo',
                    'hidden',
                    [
                        'data' => $codCargo,
                        'mapped' => false
                    ]
                )
                ->add('fkPessoalCargo', 'entity', $fieldOptions['codCboCargo'])
                ->add('fkFolhapagamentoPadrao', 'choice', $fieldOptions['codCargoPadrao'])
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

    public function validate(ErrorElement $errorElement, $object)
    {

        $subDivisoes = $this->request->request->get('codSubDivisao');
        $totalCargos = array_sum($subDivisoes);

        if ($totalCargos == 0) {
            $error = $this->trans('rh.gerenciamentoCargo.cargo.existCargo', [], 'flashes');
            $errorElement->addViolation($error)->end();
        }
    }

    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $form = $this->getForm();

        $codCargo = $this->getForm()->get('codCargo')->getData();
        $cargo = $em->getRepository('CoreBundle:Pessoal\Cargo')->findOneByCodCargo($codCargo);
        $object->setFkPessoalCargo($cargo);

        $codPadrao = $this->getForm()->get('fkFolhapagamentoPadrao')->getData();
        $padrao = $em->getRepository('CoreBundle:FolhaPagamento\Padrao')->findOneByCodPadrao($codPadrao);
        $object->setFkFolhapagamentoPadrao($padrao);

        $cboCargo = new CboCargo();
        $cboCargo->setFkPessoalCbo($form->get('fkPessoalCargo')->getData());
        $cboCargo->setFkPessoalCargo($object->getFkPessoalCargo());

        $norma = $form->get('codNorma')->getData();
        $subDivisoes = $this->request->request->get('codSubDivisao');


        foreach ($subDivisoes as $codSubdivisao => $qtdVagas) {
            if ($qtdVagas !== "") {
                $subDivisao = $em->getRepository('CoreBundle:Pessoal\SubDivisao')->findOneByCodSubDivisao($codSubdivisao);

                $cargoSubDivisao = new CargoSubDivisao();
                $cargoSubDivisao->setFkPessoalCargo($object->getFkPessoalCargo());
                $cargoSubDivisao->setFkNormasNorma($norma);
                $cargoSubDivisao->setFkPessoalSubDivisao($subDivisao);
                $cargoSubDivisao->setNroVagaCriada($qtdVagas);
                $em->persist($cargoSubDivisao);
            }
        }

        $em->persist($cboCargo);
        $em->persist($cargoSubDivisao);
        $em->flush();

        $this->forceRedirect("/recursos-humanos/cargo/{$object->getCodCargo()}/show");
    }

    public function preUpdate($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $form = $this->getForm();

        $codCargo = $this->getForm()->get('codCargo')->getData();
        $cargo = $em->getRepository('CoreBundle:Pessoal\Cargo')->findOneByCodCargo($codCargo);
        $object->setFkPessoalCargo($cargo);

        $codPadrao = $this->getForm()->get('fkFolhapagamentoPadrao')->getData();
        $padrao = $em->getRepository('CoreBundle:FolhaPagamento\Padrao')->findOneByCodPadrao($codPadrao);
        $object->setFkFolhapagamentoPadrao($padrao);

        $cboCargo = new CboCargo();
        $cboCargo->setFkPessoalCbo($form->get('fkPessoalCargo')->getData());
        $cboCargo->setFkPessoalCargo($object->getFkPessoalCargo());

        $norma = $form->get('codNorma')->getData();
        $subDivisoes = $this->request->request->get('codSubDivisao');


        foreach ($subDivisoes as $codSubdivisao => $qtdVagas) {
            if ($qtdVagas !== "") {
                $subDivisao = $em->getRepository('CoreBundle:Pessoal\SubDivisao')->findOneByCodSubDivisao($codSubdivisao);

                $cargoSubDivisao = new CargoSubDivisao();
                $cargoSubDivisao->setFkPessoalCargo($object->getFkPessoalCargo());
                $cargoSubDivisao->setFkNormasNorma($norma);
                $cargoSubDivisao->setFkPessoalSubDivisao($subDivisao);
                $cargoSubDivisao->setNroVagaCriada($qtdVagas);
                $em->persist($cargoSubDivisao);
            }
        }

        $em->persist($cboCargo);
        $em->persist($cargoSubDivisao);
        $em->flush();

        $this->forceRedirect("/recursos-humanos/cargo/{$object->getCodCargo()}/show");
    }

    public function postRemove($object)
    {
        $this->forceRedirect("/recursos-humanos/cargo/{$object->getCodCargo()}/show");
    }
}
