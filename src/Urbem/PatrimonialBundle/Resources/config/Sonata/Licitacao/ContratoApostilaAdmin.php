<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Licitacao\Contrato;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ContratoApostilaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_contrato_apostila';

    protected $baseRoutePattern = 'patrimonial/licitacao/contrato-apostila';
    protected $exibirBotaoIncluir = false;

    const REAJUSTE_PRECO = "label.patrimonial.compras.contrato_apostila.reajustePrecoPrevisoNoContrato";
    const ATUALIZACOES_COMPENSACOES = "label.patrimonial.compras.contrato_apostila.atualizacoesCompensacoes";
    const EMPENHO_DOTACOES = "label.patrimonial.compras.contrato_apostila.empenhoDotacoes";
    const ACRESCIMO_VALOR = "label.patrimonial.compras.contrato_apostila.acrescimoValor";
    const DESCRESCIMO_VALOR = "label.patrimonial.compras.contrato_apostila.descrescimoValor";
    const NAO_HOUVE_ALTERACAO = "label.patrimonial.compras.contrato_apostila.naoHouveAlteracao";

    public function validate(ErrorElement $errorElement, $object)
    {
        $container = $this->getConfigurationPool()->getContainer();

        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());

        $formData = $this->getRequest()->request->get($this->getUniqid());

        $contrato = $entityManager
            ->getRepository('CoreBundle:Licitacao\ContratoApostila')
            ->findOneBy(
                [
                    "codApostila" => $formData['codApostila'],
                    "exercicio" => $formData['exercicioEntidade'],
                    "codEntidade" => $formData['codEntidade'],
                    "numContrato" => $formData['numContrato']
                ]
            );

        $route = $this->getRequest()->get('_sonata_name');
        if ($this->baseRouteName . "_create" == $route) {
            if (count($contrato) > 0) {
                $mensagem = $this->trans('NumeroDaApostilaJaExisteParaOContrato', [], 'messages');

                $container->get('session')->getFlashBag()->add('error', $mensagem);

                $errorElement->with('codApostila')->addViolation($mensagem)->end();
            }
        }
    }

    public function prePersist($object)
    {
        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());

        $formData = $this->getRequest()->request->get($this->getUniqid());
        $numContrato = $formData['numContrato'];
        $exercicioEntidade = $formData['exercicioEntidade'];
        $codEntidade = $formData['codEntidade'];

        /** @var  Licitacao/Contrato $contrato */
        $contrato = $entityManager->getRepository(Contrato::class)->findOneBy(['exercicio' => $exercicioEntidade, 'codEntidade' => $codEntidade, 'numContrato' => $numContrato]);

        $object->setFkLicitacaoContrato($contrato);
    }

    public function postPersist($object)
    {
        $this->redirect();
    }

    public function postUpdate($object)
    {
        $this->redirect();
    }

    public function postRemove($object)
    {
        $this->redirect();
    }

    public function redirect()
    {
        $this->forceRedirect("/patrimonial/compras/contrato/list");
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('exercicio')
            ->add('descricao')
            ->add(
                'dataApostila',
                'doctrine_orm_datetime',
                [
                    'field_type' => 'sonata_type_datetime_picker',
                    'field_options' => [
                        'format' => 'dd/MM/yyyy'
                    ]
                ]
            )
            ->add('valorApostila');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $listMapper
            ->add('exercicio')
            ->add('descricao')
            ->add('dataApostila')
            ->add('valorApostila');

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

        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());

        /** @var  Licitacao/Contrato $contrato */
        $contrato = $entityManager->getRepository(Contrato::class)->findOneBy(['exercicio' => $exercicioEntidade, 'codEntidade' => $codEntidade, 'numContrato' => $numContrato]);

        $route = $this->getRequest()->get('_sonata_name');
        if ($this->baseRouteName . "_edit" == $route) {
            list($codApostila, $numContrato, $codEntidade, $exercicioEntidade) = explode("~", $id);
            /** @var Licitacao/ContratoApostila $contratoApostila */
            $contratoApostila = $entityManager
                ->getRepository('CoreBundle:Licitacao\ContratoApostila')
                ->findOneBy(
                    [
                        "codApostila" => $codApostila,
                        "exercicio" => $exercicioEntidade,
                        "codEntidade" => $codEntidade,
                        "numContrato" => $numContrato
                    ]
                );

            $contrato = $contratoApostila->getFkLicitacaoContrato();
        }
        $formMapper
            ->with('Dados do Contrato')
            ->add(
                'numeroContrato',
                'text',
                [
                    'label' => 'label.patrimonial.compras.contrato.numContrato',
                    'mapped' => false,
                    'data' => $contrato->getNumContrato(),
                    'required' => false,
                    'attr' => [
                        'readOnly' => 'readOnly'
                    ]
                ]
            )
            ->add(
                'codigoEntidade',
                'text',
                [
                    'label' => 'label.patrimonial.compras.contrato.codEntidade',
                    'mapped' => false,
                    'data' => $contrato->getFkOrcamentoEntidade()->getFkSwCgm()->getNomCgm(),
                    'required' => false,
                    'attr' => [
                        'readOnly' => 'readOnly'
                    ]
                ]
            )
            ->add(
                'dtAssinatura',
                'text',
                [
                    'label' => 'label.patrimonial.compras.contrato.dtAssinatura',
                    'mapped' => false,
                    'data' => $contrato->getDtAssinatura()->format('d/m/Y'),
                    'required' => false,
                    'attr' => [
                        'readOnly' => 'readOnly'
                    ]
                ]
            )
            ->add(
                'codTipoInstrumento',
                'text',
                [
                    'label' => 'label.patrimonial.compras.contrato.codTipoInstrumento',
                    'mapped' => false,
                    'required' => false,
                    'data' => $contrato->getFkLicitacaoTipoInstrumento()->getDescricao(),
                    'attr' => [
                        'disabled' => true
                    ]
                ]
            )
            ->add(
                'periodoContrato',
                'text',
                [
                    'label' => 'label.patrimonial.compras.contrato.periodoContrato',
                    'mapped' => false,
                    'required' => false,
                    'data' => $contrato->getInicioExecucao()->format('d/m/Y') .' '. $this->trans('label.patrimonial.compras.contrato.ate') .' '. $contrato->getFimExecucao()->format('d/m/Y'),
                    'attr' => [
                        'readOnly' => 'readOnly'
                    ]
                ]
            )
            ->add(
                'vlContratado',
                'text',
                [
                    'label' => 'label.patrimonial.compras.contrato.vlContratado',
                    'mapped' => false,
                    'data' => $contrato->getValorContratado(),
                    'required' => false,
                    'attr' => [
                        'readOnly' => 'readOnly'
                    ]
                ]
            )
            ->add('numContrato', 'hidden', ['data' => $numContrato, 'mapped' => false])
            ->add('codEntidade', 'hidden', ['data' => $codEntidade, 'mapped' => false])
            ->add('exercicioEntidade', 'hidden', ['data' => $exercicioEntidade, 'mapped' => false])
            ->end()
            ->with('label.patrimonial.compras.contrato.dadosApostilamento')
            ->add('codApostila', null, ['label' => 'label.patrimonial.compras.contrato_apostila.codApostila'])
            ->add(
                'codTipo',
                'choice',
                [
                    'choices' => [
                        self::REAJUSTE_PRECO => 1,
                        self::ATUALIZACOES_COMPENSACOES => 2,
                        self::EMPENHO_DOTACOES => 3
                    ],
                    'expanded' => true,
                    'multiple' => false,
                    'label' => 'label.patrimonial.compras.contrato_apostila.codTipo',
                    'label_attr' => array(
                        'class' => 'checkbox-sonata '
                    ),
                    'attr' => array(
                        'class' => 'checkbox-sonata '
                    )
                ]
            )
            ->add(
                'dataApostila',
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy',
                    'required' => true,
                ]
            )
            ->add(
                'codAlteracao',
                'choice',
                [
                    'choices' => [
                        self::ACRESCIMO_VALOR => 1,
                        self::DESCRESCIMO_VALOR => 2,
                        self::NAO_HOUVE_ALTERACAO => 3
                    ],
                    'expanded' => true,
                    'multiple' => false,
                    'label' => 'label.patrimonial.compras.contrato_apostila.codAlteracao',
                    'required' => true,
                    'label_attr' => array(
                        'class' => 'checkbox-sonata '
                    ),
                    'attr' => array(
                        'class' => 'checkbox-sonata '
                    )
                ]
            )
            ->add('descricao', null, ['label' => 'label.patrimonial.compras.contrato_apostila.descricao'])
            ->add(
                'valorApostila',
                'money',
                [
                    'label' => 'label.patrimonial.compras.contrato_apostila.valorApostila',
                    'attr' => array(
                        'class' => 'money '
                    ),
                    'currency' => 'BRL'
                ]
            )
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $showMapper
            ->add('exercicio')
            ->add('codTipo')
            ->add('codAlteracao')
            ->add('descricao')
            ->add('dataApostila')
            ->add('valorApostila');
    }
}
