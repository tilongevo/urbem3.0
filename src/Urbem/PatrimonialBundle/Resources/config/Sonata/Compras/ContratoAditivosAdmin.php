<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Compras;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Licitacao\Contrato;
use Urbem\CoreBundle\Entity\Licitacao\ContratoAditivos;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Model\Patrimonial\Compras\ContratoAditivoModel;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\ContratoModel;
use Urbem\CoreBundle\Model\SwCgmModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Model\Patrimonial\Compras;

class ContratoAditivosAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_compras_contrato_aditivos';

    protected $baseRoutePattern = 'patrimonial/compras/contrato-aditivos';

    protected $exibirBotaoIncluir = false;

    /**
     * @param ContratoAditivos $contratoAditivos
     */
    public function prePersist($contratoAditivos)
    {
        $contratoAditivos->setExercicio($this->getExercicio());
        $container = $this->getConfigurationPool()->getContainer();
        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());

        $formData = $this->getRequest()->request->get($this->getUniqid());
        /** @var Contrato $contrato */
        $contrato = $entityManager
            ->getRepository('CoreBundle:Licitacao\Contrato')
            ->findOneBy(
                [
                    "numContrato" => $formData['numContrato'],
                    "codEntidade" => $formData['codEntidade'],
                    "exercicio" => $formData['exercicioEntidade']
                ]
            );

        $contratoAditivos->setFkLicitacaoContrato($contrato);

        $contratoAditivo = $entityManager
            ->getRepository('CoreBundle:Licitacao\ContratoAditivos')
            ->findOneByNumAditivo($contratoAditivos->getNumAditivo());

        if ($contratoAditivo) {
            $mensagem = 'Número do aditivo já esta sendo utilizado.';
            $container->get('session')->getFlashBag()->add('error', $mensagem);

            $this->redirectShow($contratoAditivos);
        }
    }

    /**
     * @param ContratoAditivos $contratoAditivos
     */
    public function postPersist($contratoAditivos)
    {
        $this->redirectShow($contratoAditivos);
    }

    /**
     * @param ContratoAditivos $contratoAditivos
     */
    public function postUpdate($contratoAditivos)
    {
        $this->redirectShow($contratoAditivos);
    }

    /**
     * @param ContratoAditivos $contratoAditivos
     */
    public function postRemove($contratoAditivos)
    {
        $this->redirectShow($contratoAditivos);
    }

    /**
     * @param ContratoAditivos $contratoAditivos
     */
    public function redirectShow(ContratoAditivos $contratoAditivos){
        $url = '/patrimonial/compras/contrato/' . $this->getObjectKey($contratoAditivos->getFkLicitacaoContrato()).'/show';
        $this->forceRedirect($url);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('exercicioContrato')
            ->add('codEntidade')
            ->add('numContrato')
            ->add('exercicio')
            ->add('numAditivo')
            ->add('dtVencimento')
            ->add('dtAssinatura')
            ->add('inicioExecucao')
            ->add('valorContratado')
            ->add('objeto')
            ->add('fundamentacao')
            ->add('fimExecucao')
            ->add('justificativa');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('codEntidade')
            ->add('numContrato')
            ->add('exercicioContrato')
            ->add('exercicio')
            ->add('numAditivo')
            ->add('dtVencimento')
            ->add('dtAssinatura')
            ->add('inicioExecucao')
            ->add('valorContratado')
            ->add('objeto')
            ->add('fundamentacao')
            ->add('fimExecucao')
            ->add('justificativa');
        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);
        $exercicioEntidade = $codEntidade = $numContrato = null;
        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());
        $contrato = null;
        $route = $this->getRequest()->get('_sonata_name');
        if ($this->getRequest()->isMethod('GET')) {
            if (!is_null($route)) {
                list($exercicioEntidade, $codEntidade, $numContrato) = explode("~", $id);
            }
        }

        $fieldOptions['fkSwCgm'] = [
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'to_string_callback' => function (SwCgm $swCgm, $property) {
                return strtoupper($swCgm->getNomCgm());
            },
            'class' => SwCgm::class,
            'property' => 'nomCgm',
            'label' => 'label.patrimonial.compras.contrato.cgmResponsavelJuridico',
            'placeholder' => 'Selecione'
        ];

        $fieldOptions['fkLicitacaoTipoTermoAditivo'] = [
            'class' => 'CoreBundle:Licitacao\TipoTermoAditivo',
            'choice_label' => 'descricao',
            'label' => 'label.patrimonial.compras.contrato.tipoTermoAditivo',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'Selecione'
        ];

        $fieldOptions['fkLicitacaoTipoAlteracaoValor'] = [
            'class' => 'CoreBundle:Licitacao\TipoAlteracaoValor',
            'choice_label' => 'descricao',
            'label' => 'label.patrimonial.compras.contrato.tipoAlteracaoValor',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'Selecione'
        ];

        $fieldOptions['padraoTamanho'] = [
            'attr' => [
                'maxlength' => 250
            ]
        ];
        $fieldOptions['objeto'] =  $fieldOptions['padraoTamanho'];
        $fieldOptions['justificativa'] =  $fieldOptions['padraoTamanho'];
        $fieldOptions['fundamentacao'] =  [
            'label' => 'label.patrimonial.compras.contrato.fundamentacao',
            'attr' => [
                'maxlength' => 100
            ]
        ];


        $formMapper
            ->add('numContrato', 'hidden', ['data' => $numContrato, 'mapped' => false])
            ->add('codEntidade', 'hidden', ['data' => $codEntidade, 'mapped' => false])
            ->add('exercicioEntidade', 'hidden', ['data' => $exercicioEntidade, 'mapped' => false])
            ->add('numAditivo', null, ['label' => 'Número do Aditivo'])
            ->add('fkSwCgm', 'sonata_type_model_autocomplete', $fieldOptions['fkSwCgm'])
            ->add('fkLicitacaoTipoTermoAditivo', 'entity', $fieldOptions['fkLicitacaoTipoTermoAditivo'])
            ->add('fkLicitacaoTipoAlteracaoValor', 'entity', $fieldOptions['fkLicitacaoTipoAlteracaoValor'])
            ->add(
                'dtAssinatura',
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy',
                    'label' => 'Data da Assinatura',
                    'required' => true,
                ]
            )
            ->add(
                'inicioExecucao',
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy',
                    'label' => 'Data de Início de Execução',
                    'required' => true,
                ]
            )
            ->add(
                'fimExecucao',
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy',
                    'label' => 'Data de Término da Execução',
                    'required' => false,
                ]
            )
            ->add(
                'dtVencimento',
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy',
                    'label' => 'Data Final de Vigência',
                    'required' => true,
                ]
            )
            ->add(
                'valorContratado',
                'money',
                [
                    'label' => 'Valor Contratado',
                    'attr' => array(
                        'class' => 'money '
                    ),
                    'currency' => 'BRL'
                ]
            )
            ->add('objeto', 'textarea', $fieldOptions['objeto'])
            ->add('justificativa', 'textarea', $fieldOptions['justificativa'])
            ->add('fundamentacao', 'textarea', $fieldOptions['fundamentacao']);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('exercicioContrato')
            ->add('codEntidade')
            ->add('numContrato')
            ->add('exercicio')
            ->add('numAditivo')
            ->add('dtVencimento')
            ->add('dtAssinatura')
            ->add('inicioExecucao')
            ->add('valorContratado')
            ->add('objeto')
            ->add('fundamentacao')
            ->add('fimExecucao')
            ->add('justificativa');
    }
}
