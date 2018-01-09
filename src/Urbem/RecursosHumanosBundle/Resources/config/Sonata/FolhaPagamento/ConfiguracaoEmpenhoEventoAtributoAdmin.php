<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoAtributoValor;
use Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoEvento;
use Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLocal;
use Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLotacao;
use Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoSubdivisao;
use Urbem\CoreBundle\Model\Administracao\AtributoDinamicoModel;
use Urbem\CoreBundle\Model\Administracao\CadastroModel;
use Urbem\CoreBundle\Model\Administracao\ModuloModel;
use Urbem\CoreBundle\Model\Folhapagamento\ConfigEmpenhoModel;
use Urbem\CoreBundle\Model\Folhapagamento\ConfiguracaoEmpenhoAtributoValorModel;
use Urbem\CoreBundle\Model\Folhapagamento\ConfiguracaoEmpenhoEventoModel;
use Urbem\CoreBundle\Model\Folhapagamento\ConfiguracaoEmpenhoLocalModel;
use Urbem\CoreBundle\Model\Folhapagamento\ConfiguracaoEmpenhoLotacaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\ConfiguracaoEmpenhoModel;
use Urbem\CoreBundle\Model\Folhapagamento\ConfiguracaoEmpenhoSubdivisaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\EventoModel;
use Urbem\CoreBundle\Model\Orcamento\PaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ConfiguracaoEmpenhoEventoAtributoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_configuracao_empenho_evento_atributo';

    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/configuracao/empenho-evento-atributo';

    protected $customHeader = 'RecursosHumanosBundle:FolhaPagamento:Configuracao/cabecalhoEventoAtributo.html.twig';

    protected $exibirBotaoIncluir = false;

    protected $botaoIncluirComParametros = true;

    public $data;

    const MODULO_PESSOAL = 'Pessoal';

    const CADASTRO_SERVIDOR = 'Cadastro de servidor';

    public function createQuery($context = 'list')
    {
        $id = $this->getAdminRequestId();

        $query = parent::createQuery($context);

        if ($id) {
            $query->join('Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoAtributoValor', 'b', 'WITH', 'o.id = b.codConfiguracaoEmpenho');
            $query->andWhere(
                $query->expr()->eq('o.codConfigEmpenho', ':param')
            );
            $query->setParameter('param', $id);
        }

        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);
        $this->data = $id;

        $listMapper
            ->add('exercicio', null, ['label' => 'label.exercicio', 'sortable' => false])
            ->add('exercicioPao', null, ['label' => 'label.configuracaoEmpenho.exercicioPao', 'sortable' => false])
            ->add('exercicioDespesa', null, ['label' => 'label.configuracaoEmpenho.exercicioDespesa', 'sortable' => false])
            ->add('numPao', null, ['label' => 'label.configuracaoEmpenho.numPao', 'sortable' => false])
            ->add('vigencia', null, ['label' => 'label.vigencia', 'sortable' => false])
        ;

        $this->data = $id;

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        if ($this->getRequest()->isMethod('GET')) {
            $codConfigEmpenho = $this->getAdminRequestId();
        } else {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $codConfigEmpenho = $formData['codConfigEmpenho'];
        }

        $atributosDinamicos = $this->getAtributos();

        $fieldOptions['eventos'] = [
            'class' => 'CoreBundle:Folhapagamento\Evento',
            'label' => 'label.evento',
            'placeholder' => 'label.selecione',
            'multiple' => true,
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters'
            ],
        ];

        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Folhapagamento\ConfigEmpenho');
        $configuracaoEmpenhoEventos = $em->getRepository('CoreBundle:Folhapagamento\ConfiguracaoEmpenhoEvento')->findByCodConfiguracaoEmpenho($id);

        $fieldOptions['eventos']['choice_attr'] = function ($eventos, $key, $index) use ($configuracaoEmpenhoEventos) {
            foreach ($configuracaoEmpenhoEventos as $evento) {
                if ($evento->getCodEvento() == $eventos) {
                    return ['selected' => 'selected'];
                }
            }

            return ['selected' => false];
        };

        $fieldOptions['subdivisoes'] = [
            'mapped' => false,
            'multiple' => true,
            'expanded' => false,
            'class' => 'CoreBundle:Pessoal\SubDivisao',
            'choice_label' => 'descricao',
            'label' => 'label.subdivisao',
            'attr' => [
                'class' => 'select2-parameters'
            ],
        ];

        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Folhapagamento\ConfigEmpenho');
        $configuracaoEmpenhoSubdivisoes = $em->getRepository('CoreBundle:Folhapagamento\ConfiguracaoEmpenhoSubdivisao')->findByCodConfiguracaoEmpenho($id);

        $fieldOptions['subdivisoes']['choice_attr'] = function ($subdivisoes, $key, $index) use ($configuracaoEmpenhoSubdivisoes) {
            foreach ($configuracaoEmpenhoSubdivisoes as $subdivisao) {
                if ($subdivisao->getCodSubDivisao() == $subdivisoes) {
                    return ['selected' => 'selected'];
                }
            }

            return ['selected' => false];
        };

        $formMapper
            ->add(
                'codConfigEmpenho',
                'hidden',
                [
                    'mapped' => false,
                    'data' => $codConfigEmpenho
                ]
            )
            ->add(
                'atributosList',
                'choice',
                [
                    'required' => true,
                    'choices' => $atributosDinamicos,
                    'placeholder' => 'Selecione',
                    'label' => 'label.atributoDinamico',
                    'mapped' => false,
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                ]
            )
            ->add(
                'valor',
                'text',
                [
                    'mapped' => false,
                ]
            )
            ->add(
                'codConfiguracao',
                'entity',
                [
                    'class' => 'CoreBundle:Folhapagamento\ConfiguracaoEvento',
                    'choice_label' => 'descricao',
                    'label' => 'label.configuracao',
                    'attr' => [
                        'class' => 'select2-parameters'
                    ],
                ]
            )
            ->add(
                'eventos',
                'entity',
                $fieldOptions['eventos']
            )
            ->add(
                'subdvisoes',
                'entity',
                $fieldOptions['subdivisoes']
            )
            ->add(
                'numPao',
                'entity',
                [
                    'class' => 'CoreBundle:Orcamento\Pao',
                    'choice_label' => 'nom_pao',
                    'label' => 'label.configuracaoEmpenho.numPao',
                    'query_builder' => $this->getListaOrcamentoPao(),
                    'attr' => [
                        'class' => 'select2-parameters'
                    ],
                ]
            )
            ->add(
                'codDespesa',
                'entity',
                [
                    'class' => 'CoreBundle:Orcamento\ContaDespesa',
                    'choice_label' => 'descricao',
                    'label' => 'label.dotacao',
                    'attr' => [
                        'class' => 'select2-parameters'
                    ],
                ]
            )
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $showMapper
            ->add('exercicioPao', null, ['label' => 'label.configuracaoEmpenho.exercicioPao'])
            ->add('exercicioDespesa', null, ['label' => 'label.configuracaoEmpenho.exercicioDespesa'])
            ->add('exercicio', null, ['label' => 'label.exercicio'])
            ->add('sequencia', null, ['label' => 'label.configuracaoEmpenho.sequencia'])
            ->add('vigencia', null, ['label' => 'label.vigencia'])
        ;
    }

    private function getListaOrcamentoPao()
    {
        $now = new \DateTime();
        $exercicio = $now->format('Y');

        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Orcamento\Pao');

        $model = new PaoModel($em);
        return $model->getListaOrcamentoPao($exercicio);
    }

    public function prePersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Folhapagamento\ConfigEmpenho');

            $this->salvaRelacionamentos($object);

            $container->get('session')->getFlashBag()->add('success', 'Contrato adicionado com sucesso');
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            $container->get('session')->getFlashBag()->add('error', self::ERROR_REMOVE_DATA);
            throw $e;
        }
    }

    private function salvaRelacionamentos($object)
    {
        // ConfigEmpenho
        $codConfigEmpenho = $this->getForm()->get('codConfigEmpenho')->getData();
        $configEmpenhoObject = $this->recuperaCodConfigEmpenho($codConfigEmpenho);

        // configuracaoEmpenho
        $object->setCodConfigEmpenho($configEmpenhoObject);

        // verifica se existe configuracao empenho cadastrado para o id
        $configs = $this->recuperaConfiguracaoEmpenho($codConfigEmpenho);

        $sequencia = $this->getSequencia($configs);

        // Sequencia
        $object->setSequencia($sequencia);

        // Exercicio ConfigEmpenho
        $exercicio = $this->recuperaExercicio($configEmpenhoObject);

        // ExercicioPao
        $exercicioPao = $object->getNumPao()->getExercicio();
        $object->setExercicioPao($exercicioPao);

        // ExercicioDespesa
        $exercicioDespesa = $object->getCodDespesa()->getExercicio();
        $object->setExercicioDespesa($exercicioDespesa);

        // Exercicio ConfiguracaoEmpenhoEvento
        $object->setExercicio($exercicio);

        // Vigencia
        $object->setVigencia($configEmpenhoObject->getVigencia());

        // Salva Eventos
        $eventos = $this->getForm()->get('eventos')->getData();
        $codConfiguracao = $this->getForm()->get('codConfiguracao')->getData();

        $infoEventos = [
            'eventos' => $eventos,
            'codConfiguracao' => $codConfiguracao,
            'codConfigEmpenho' => $configEmpenhoObject
        ];

        $this->saveEventos($infoEventos, $object);

        // Salva Subdivisao
        $regimes = $this->getForm()->get('subdvisoes')->getData();
        $codConfiguracao = $this->getForm()->get('codConfiguracao')->getData();

        $infoSubdivisoes = [
            'subdivisoes' => $regimes,
            'codConfiguracao' => $codConfiguracao,
            'codConfigEmpenho' => $configEmpenhoObject
        ];

        $this->saveSubdivisoes($infoSubdivisoes, $object);

        // Salva atributo valor
        $atributo = $this->getForm()->get('atributosList')->getData();
        $valor = $this->getForm()->get('valor')->getData();
        $this->salvaAtributoValor($object, array('atributo' => $atributo, 'valor' => $valor));
    }

    public function preUpdate($object)
    {
        $id = $object->getCodConfigEmpenho()->getCodConfigEmpenho();

        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoSubdivisao');
        $configuracaoEmpenhoSubdivisoes = $em->getRepository('CoreBundle:Folhapagamento\ConfiguracaoEmpenhoSubdivisao')->findByCodConfiguracaoEmpenho($id);

        foreach ($configuracaoEmpenhoSubdivisoes as $subdivisao) {
            $em->remove($subdivisao);
        }

        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoEvento');
        $configuracaoEmpenhoEventos = $em->getRepository('CoreBundle:Folhapagamento\ConfiguracaoEmpenhoEvento')->findByCodConfiguracaoEmpenho($id);

        foreach ($configuracaoEmpenhoEventos as $evento) {
            $em->remove($evento);
        }

        $em->flush();

        $this->salvaRelacionamentos($object);
    }

    public function salvaAtributoValor($object, $info)
    {
        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoAtributoValor');

        $moduloModel = new ModuloModel($em);
        $codModulo = $moduloModel->findOneBynomModulo(self::MODULO_PESSOAL);

        $cadastroModel = new CadastroModel($em);
        $codCadastro = $cadastroModel->findOneBynomCadastro(self::CADASTRO_SERVIDOR);

        $model = new ConfiguracaoEmpenhoAtributoValorModel($em);

        $configuracaoEmpenhoAtributoValor = new ConfiguracaoEmpenhoAtributoValor();
        $configuracaoEmpenhoAtributoValor->setExercicio($object->getExercicio());
        $configuracaoEmpenhoAtributoValor->setCodConfiguracao($object->getCodConfiguracao()->getCodConfiguracao());
        $configuracaoEmpenhoAtributoValor->setSequencia($object->getSequencia());
        $configuracaoEmpenhoAtributoValor->setCodConfiguracaoEmpenho($object);
        $configuracaoEmpenhoAtributoValor->setCodAtributo($info['atributo']);
        $configuracaoEmpenhoAtributoValor->setValor($info['valor']);
        $configuracaoEmpenhoAtributoValor->setCodModulo($codModulo->getCodModulo());
        $configuracaoEmpenhoAtributoValor->setCodCadastro($codCadastro->getCodCadastro());

        $model->save($configuracaoEmpenhoAtributoValor);
    }

    private function getSequencia($configs)
    {
        $total = count($configs);
        if ($total) {
            return $total + 1;
        }

        return 1;
    }

    public function recuperaConfiguracaoEmpenho($codConfigEmpenho)
    {
        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenho');
        $configuracaoEmpenhoModel = new ConfiguracaoEmpenhoModel($em);
        return $configuracaoEmpenhoModel->findByCodConfigEmpenho($codConfigEmpenho);
    }

    public function recuperaCodConfigEmpenho($codConfigEmpenho)
    {
        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Folhapagamento\ConfigEmpenho');
        $configEmpenhoModel = new ConfigEmpenhoModel($em);
        return $configEmpenhoModel->findOneByCodConfigEmpenho($codConfigEmpenho);
    }

    private function recuperaExercicio($object)
    {
        $vigencia = $object->getVigencia();
        return $vigencia->format('Y');
    }

    public function saveEventos($info, $object)
    {
        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoEvento');

        $model = new ConfiguracaoEmpenhoEventoModel($em);
        $codConfiguracao = $info['codConfiguracao'];
        $configEmpenho = $info['codConfigEmpenho'];

        $exercicio = $this->recuperaExercicio($configEmpenho);

        $em_e = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Folhapagamento\Evento');
        $model_e = new EventoModel($em_e);

        foreach ($info['eventos'] as $evento) {
            $sequenciaEvento = $model_e->getCodEventoSequenciaCalculo($evento->getCodEvento());
            if (is_null($sequenciaEvento)) {
                $sequencia = 1;
            }
            $configuracaoEmpenhoEvento = new ConfiguracaoEmpenhoEvento();
            $configuracaoEmpenhoEvento->setExercicio($exercicio);
            $configuracaoEmpenhoEvento->setCodEvento($evento);
            $configuracaoEmpenhoEvento->setCodConfiguracao($codConfiguracao->getCodConfiguracao());
            $configuracaoEmpenhoEvento->setSequencia($sequencia);
            $configuracaoEmpenhoEvento->setCodConfiguracaoEmpenho($object);
            $sequencia++;

            $model->save($configuracaoEmpenhoEvento);
        }
    }

    public function saveSubdivisoes($info, $object)
    {
        $sequencia = 1;

        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoSubdivisao');

        $model = new ConfiguracaoEmpenhoSubdivisaoModel($em);
        $codConfiguracao = $info['codConfiguracao'];
        $configEmpenho = $info['codConfigEmpenho'];

        $exercicio = $this->recuperaExercicio($configEmpenho);

        foreach ($info['subdivisoes'] as $subdivisao) {
            $configuracaoEmpenhoEvento = new ConfiguracaoEmpenhoSubdivisao();
            $configuracaoEmpenhoEvento->setExercicio($exercicio);
            $configuracaoEmpenhoEvento->setCodSubDivisao($subdivisao);
            $configuracaoEmpenhoEvento->setCodConfiguracao($codConfiguracao->getCodConfiguracao());
            $configuracaoEmpenhoEvento->setSequencia($sequencia);
            $configuracaoEmpenhoEvento->setCodConfiguracaoEmpenho($object);

            $model->save($configuracaoEmpenhoEvento);
        }
    }

    private function getAtributos()
    {
        $info = array(
            'cod_modulo' => self::MODULO_PESSOAL,
            'cod_cadastro' => self::CADASTRO_SERVIDOR,
        );

        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Administracao\AtributoDinamico');
        $atributoDinamicoModel = new AtributoDinamicoModel($em);

        $atributos = $atributoDinamicoModel->getAtributosDinamicosPorModuloeCadastro($info);

        $atributosDinamicos = [];
        foreach ($atributos as $atributo) {
            $atributosDinamicos[$atributo['nom_atributo']] = $atributo['cod_atributo'];
        }

        return $atributosDinamicos;
    }

    public function postPersist($object)
    {
        (new RedirectResponse("/recursos-humanos/folha-pagamento/configuracao/configuracao-autorizacao-empenho/list"))->send();
        exit;
    }
}
