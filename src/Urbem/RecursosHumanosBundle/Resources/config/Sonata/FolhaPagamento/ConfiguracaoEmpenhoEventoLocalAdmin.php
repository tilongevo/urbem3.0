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
use Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoEvento;
use Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLocal;
use Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLotacao;
use Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoSubdivisao;
use Urbem\CoreBundle\Model\Folhapagamento\ConfigEmpenhoModel;
use Urbem\CoreBundle\Model\Folhapagamento\ConfiguracaoEmpenhoEventoModel;
use Urbem\CoreBundle\Model\Folhapagamento\ConfiguracaoEmpenhoLocalModel;
use Urbem\CoreBundle\Model\Folhapagamento\ConfiguracaoEmpenhoLotacaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\ConfiguracaoEmpenhoModel;
use Urbem\CoreBundle\Model\Folhapagamento\ConfiguracaoEmpenhoSubdivisaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\EventoModel;
use Urbem\CoreBundle\Model\Orcamento\PaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ConfiguracaoEmpenhoEventoLocalAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_configuracao_empenho_evento_local';

    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/configuracao/empenho-evento-local';

    protected $customHeader = 'RecursosHumanosBundle:FolhaPagamento:Configuracao/cabecalhoEventoLocal.html.twig';

    protected $exibirBotaoIncluir = false;

    protected $botaoIncluirComParametros = true;

    public $data;

    public function createQuery($context = 'list')
    {
        $id = $this->getAdminRequestId();

        $query = parent::createQuery($context);

        if ($id) {
            $query->join('Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLocal', 'b', 'WITH', 'o.id = b.codConfiguracaoEmpenho');
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
        $this->setCustomHeader(null);

        if ($this->getRequest()->isMethod('GET')) {
            $codConfigEmpenho = $this->getAdminRequestId();
        } else {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $codConfigEmpenho = $formData['codConfigEmpenho'];
        }

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
                'codLocal',
                'entity',
                [
                    'class' => 'CoreBundle:Organograma\Local',
                    'choice_label' => 'descricao',
                    'label' => 'label.local',
                    'mapped' => false,
                    'attr' => [
                        'class' => 'select2-parameters'
                    ],
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
                    ]
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
                    'required' => true,
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
        $this->setCustomHeader(null);

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

        // Salva local
        $local = $this->getForm()->get('codLocal')->getData();
        $this->salvaLocal($object, $local);
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

    public function salvaLocal($object, $local)
    {
        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLocal');

        $model = new ConfiguracaoEmpenhoLocalModel($em);

        $configuracaoEmpenhoLotacao = new ConfiguracaoEmpenhoLocal();
        $configuracaoEmpenhoLotacao->setExercicio($object->getExercicio());
        $configuracaoEmpenhoLotacao->setCodConfiguracao($object->getCodConfiguracao()->getCodConfiguracao());
        $configuracaoEmpenhoLotacao->setSequencia($object->getSequencia());
        $configuracaoEmpenhoLotacao->setCodConfiguracaoEmpenho($object);
        $configuracaoEmpenhoLotacao->setCodLocal($local);

        $model->save($configuracaoEmpenhoLotacao);
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

    public function postPersist($object)
    {
        (new RedirectResponse("/recursos-humanos/folha-pagamento/configuracao/configuracao-autorizacao-empenho/list"))->send();
        exit;
    }
}
