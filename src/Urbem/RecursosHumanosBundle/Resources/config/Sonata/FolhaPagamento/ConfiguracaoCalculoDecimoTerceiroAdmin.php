<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Urbem\CoreBundle\Entity\Folhapagamento\DecimoEvento;
use Urbem\CoreBundle\Entity\Folhapagamento\Evento;
use Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoDecimo;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\DecimoEventoModel;
use Urbem\CoreBundle\Model\Folhapagamento\EventoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ConfiguracaoCalculoDecimoTerceiroAdmin extends AbstractSonataAdmin
{

    /** @var string */
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_configuracao_calculo_decimo_terceiro';
    /** @var string */
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/configuracao-calculo-decimo-terceiro';

    /** @var boolean */
    protected $exibirBotaoIncluir = false;

    /** @var boolean */
    protected $exibirBotaoEditar = false;

    /** @var boolean */
    protected $exibirBotaoExcluir = false;

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $container = $this->getConfigurationPool()->getContainer();

        if ($this->getRequest()->isMethod('GET')) {
            $codModulo = $this->getRequest()->get('id', false);

            if (!is_numeric($codModulo)) {
                $container->get('session')->getFlashBag()->add('error', 'Não existe configuração cadastrada para o modulo passado');
                $this->forceRedirect('/erro-configuracao');
                return false;
            }
        } else {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $codModulo = $formData['cod_modulo'];
        }

        $this->setUrlReferer($this->request->headers->get('referer'));

        $info = array(
            'cod_modulo' => $codModulo,
            'exercicio' => $this->getExercicio(),
        );

        $em = $this->modelManager->getEntityManager($this->getClass());
        $configuracaoModel = new ConfiguracaoModel($em);
        $atributos = $configuracaoModel->getAtributosDinamicosPorModuloeExercicio($info);

        if (count($atributos) == 0) {
            $container->get('session')->getFlashBag()->add('error', 'Não existe configuração cadastrada');
            $this->forceRedirect('/erro-configuracao');
            return false;
        }

        $this->montaHtmlRHConfiguracaoCalculoDecimoTerceiro($codModulo, $formMapper);
    }

    public function montaHtmlRHConfiguracaoCalculoDecimoTerceiro($cod_modulo, $formMapper)
    {
        $this->setBreadCrumb($cod_modulo ? ['id' => $cod_modulo] : [], 'urbem_recursos_humanos_folha_pagamento_configuracao_calculo_decimo_terceiro_create');
        $entityManager = $this->getConfigurationPool()
            ->getContainer()
            ->get('doctrine')
            ->getManager();

        $eventoModel = new EventoModel($entityManager);
        $eventoEntity = $eventoModel->getEventoPensaoFuncaoPadrao();

        $configuracaoModel = new ConfiguracaoModel($entityManager);
        $atributo['adiantamento_13_salario'] = $configuracaoModel->getConfiguracao('adiantamento_13_salario', ConfiguracaoModel::MODULO_RH_FOLHAPAGAMENTO, true);
        $atributo['mes_calculo_decimo'] = $configuracaoModel->getConfiguracao('mes_calculo_decimo', ConfiguracaoModel::MODULO_RH_FOLHAPAGAMENTO, true);

        /** @var DecimoEvento $eventoDecimo */
        $eventoDecimo = $entityManager->getRepository(DecimoEvento::class)->findOneBy(
            ['codTipo' => 1],
            ['timestamp' => 'desc']
        );

        $fieldOptions['codEvento13Salario'] = [
            'class' => Evento::class,
            'choice_label' => function ($evento) {
                return $evento->getCodigo() . ' - ' . $evento->getDescricao();
            },
            'label' => 'label.configuracao13salario.codEvento13Salario',
            'query_builder' => $eventoEntity,
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'data' => ($eventoDecimo) ? $eventoDecimo->getFkFolhapagamentoEvento() : null,
        ];

        $fieldOptions['adiantamento_13_salario'] = [
            'choices' => [
                'Sim' => 'true',
                'Não' => 'false'
            ],
            'expanded' => true,
            'multiple' => false,
            'label' => 'label.configuracao13salario.adiantamento13Salario',
            'label_attr' => [
                'class' => 'checkbox-sonata'
            ],
            'attr' => [
                'class' => 'checkbox-sonata'
            ],
            'mapped' => false,
            'required' => true,
            'data' => ($atributo['adiantamento_13_salario'] == '') ? 'true' : $atributo['adiantamento_13_salario'],
        ];

        $fieldOptions['mes_calculo_decimo'] = [
            'choices' => [
                'Novembro' => 11,
                'Dezembro' => 12
            ],
            'expanded' => true,
            'multiple' => false,
            'label' => 'label.configuracao13salario.saldo13',
            'label_attr' => [
                'class' => 'checkbox-sonata'
            ],
            'attr' => [
                'class' => 'checkbox-sonata'
            ],
            'mapped' => false,
            'required' => true,
            'data' => $atributo['mes_calculo_decimo'],
        ];

        $fieldOptions['fkFolhapagamentoBeneficioEventos'] = [
            'label' => false,
        ];

        if ($this->id($this->getSubject())) {
            $fieldOptions['codEvento13Salario']['data'] = $this->getSubject()
                ->getFkFolhapagamentoBeneficioEventos()->last()->getFkFolhapagamentoEvento();

            $fieldOptions['textoComplementarValeTransporte']['data'] = $this->getSubject()
                ->getFkFolhapagamentoBeneficioEventos()->last()->getFkFolhapagamentoEvento()
                ->getFkFolhapagamentoEventoEventos()->last()->getObservacao();
        }

        $formMapper
            ->with('label.configuracao13salario.eventos')
            ->add(
                "cod_modulo",
                'hidden',
                [
                    'mapped' => false,
                    'data' => $cod_modulo,
                ]
            )
            ->add(
                'codEvento13Salario',
                'entity',
                $fieldOptions['codEvento13Salario']
            )
            ->add(
                'adiantamento_13_salario',
                'choice',
                $fieldOptions['adiantamento_13_salario']
            )
            ->end()
            ->with('label.configuracao13salario.competencia')
            ->add(
                'mes_calculo_decimo',
                'choice',
                $fieldOptions['mes_calculo_decimo']
            )
            ->end();
    }

    /**
     * @param mixed $object
     * @throws \Exception
     */
    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Administracao\Configuracao');
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $childrens = $this->getForm()->all();

            $cod_modulo = (isset($childrens['cod_modulo'])) ? $childrens['cod_modulo']->getViewData() : '';

            $configuracaoModel = new ConfiguracaoModel($em);

            foreach ($childrens as $key => $children) {
                if ($key != 'cod_modulo' and $key != 'codEvento13Salario') {
                    $info = explode('_', $key);

                    $cod_atributo = str_replace('atributo_', '', $key);

                    $valor = $children->getViewData();

                    $info = array(
                        'cod_modulo' => $cod_modulo,
                        'parametro' => $cod_atributo,
                        'valor' => $valor,
                        'exercicio' => $this->getExercicio()
                    );
                    $configuracaoModel->updateAtributosDinamicos($info);
                }

                if ($key == 'codEvento13Salario') {
                    $info = explode('_', $key);

                    $cod_atributo = str_replace('atributo_', '', $key);

                    $valor = $children->getViewData();

                    $info = array(
                        'cod_modulo' => $cod_modulo,
                        'parametro' => $cod_atributo,
                        'valor' => $valor,
                        'exercicio' => $this->getExercicio()
                    );


                    $tipoEventoDecimo = $em->getRepository(TipoEventoDecimo::class)->findOneBy(
                        ['codTipo' => $configuracaoModel::TIPO_EVENTO_DECIMO]
                    );

                    $evento = $em->getRepository(Evento::class)->findOneBy(
                        ['codEvento' => $info['valor']]
                    );

                    $decimoEventoModel = new DecimoEventoModel($em);
                    $decimoEventoModel->buildOneDecimoEvento($tipoEventoDecimo, $evento);
                }
            }

            $container->get('session')->getFlashBag()->add('success', 'Configuração alterada com sucesso!');

            (new RedirectResponse($this->generateUrl('create', array('id' => $info['cod_modulo']))))->send();
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', self::ERROR_REMOVE_DATA);
            throw $e;
        }
    }
}
