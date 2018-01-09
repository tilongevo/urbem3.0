<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Arrecadacao;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Arrecadacao\ArrecadacaoModulos;
use Urbem\CoreBundle\Entity\Arrecadacao\TabelaConversao;
use Urbem\CoreBundle\Entity\Arrecadacao\TabelaConversaoValores;
use Urbem\CoreBundle\Model\Arrecadacao\TabelaConversaoModel;
use Urbem\CoreBundle\Model\Arrecadacao\TabelaConversaoValoresModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class TabelaConversaoAdmin
 * @package Urbem\TributarioBundle\Resources\config\Sonata\Arrecadacao
 */
class TabelaConversaoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_arrecadacao_conversao_valores_tabela_conversao';
    protected $baseRoutePattern = 'tributario/arrecadacao/conversao-valores/tabela-conversao';
    protected $includeJs = array(
        '/tributario/javascripts/arrecadacao/tabela-conversao.js'
    );
    protected $exibirBotaoExcluir = false;

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codTabela', null, array('label' => 'label.codigo'))
            ->add('nomeTabela', null, array('label' => 'label.descricao'))
            ->add('exercicio', null, array('label' => 'label.exercicio'))
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codTabela', null, array('label' => 'label.codigo'))
            ->add('nomeTabela', null, array('label' => 'label.descricao'))
            ->add('exercicio', null, array('label' => 'label.exercicio'))
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

        $fieldOptions = array();

        $fieldOptions['nomeTabela'] = array(
            'label' => 'label.descricao',
        );

        $fieldOptions['exercicio'] = array(
            'label' => 'label.exercicio',
            'data' => $this->getExercicio()
        );

        $fieldOptions['parametro1'] = array(
            'label' => 'label.tabelaConversao.parametro1',
            'required' => false,
        );

        $fieldOptions['parametro2'] = array(
            'label' => 'label.tabelaConversao.parametro2',
            'required' => false,
        );

        $fieldOptions['parametro3'] = array(
            'label' => 'label.tabelaConversao.parametro3',
            'required' => false,
        );

        $fieldOptions['parametro4'] = array(
            'label' => 'label.tabelaConversao.parametro4',
            'required' => false,
        );

        $fieldOptions['fkArrecadacaoArrecadacaoModulos'] = array(
            'class' => ArrecadacaoModulos::class,
            'label' => 'label.grupoCredito.moduloField',
            'required' => true,
            'attr' => ['class' => 'select2-parameters'],
            'placeholder' => 'label.selecione',
            'query_builder' => function ($em) {
                $qb = $em->createQueryBuilder('am');
                $qb->innerJoin(Modulo::class, 'm', 'WITH', 'm.codModulo = am.codModulo');
                $qb->orderBy('m.codModulo', 'ASC');
                return $qb;
            }
        );

        $fieldOptions['condicaoParametro1'] = array(
            'label' => 'label.tabelaConversao.condicaoParametro1',
            'mapped' => false,
            'required' => false,
        );

        $fieldOptions['condicaoParametro2'] = array(
            'label' => 'label.tabelaConversao.condicaoParametro2',
            'mapped' => false,
            'required' => false,
        );

        $fieldOptions['condicaoParametro3'] = array(
            'label' => 'label.tabelaConversao.condicaoParametro3',
            'mapped' => false,
            'required' => false,
        );

        $fieldOptions['condicaoParametro4'] = array(
            'label' => 'label.tabelaConversao.condicaoParametro4',
            'mapped' => false,
            'required' => false,
        );

        $fieldOptions['valor'] = array(
            'label' => 'label.tabelaConversao.valor',
            'mapped' => false,
            'required' => false,
        );

        $fieldOptions['fkArrecadacaoTabelaConversaoValoreses'] = array(
            'label' => false,
            'mapped' => false,
            'template' => 'TributarioBundle::Arrecadacao/ConversaoValores/valores.html.twig',
            'data' => array(
                'valores' => array()
            )
        );

        if ($this->id($this->getSubject())) {
            /** @var TabelaConversao $tabelaConversao */
            $tabelaConversao = $this->getSubject();

            $fieldOptions['fkArrecadacaoTabelaConversaoValoreses']['data'] = array(
                'valores' => $tabelaConversao->getFkArrecadacaoTabelaConversaoValoreses()
            );

            $fieldOptions['exercicio']['data'] = $this->getSubject()->getExercicio();
            $fieldOptions['exercicio']['disabled'] = true;
        }

        $formMapper
            ->with('label.tabelaConversao.dados')
                ->add('nomeTabela', 'text', $fieldOptions['nomeTabela'])
                ->add('exercicio', TextType::class, $fieldOptions['exercicio'])
                ->add('fkArrecadacaoArrecadacaoModulos', EntityType::class, $fieldOptions['fkArrecadacaoArrecadacaoModulos'])
                ->add('parametro1', TextType::class, $fieldOptions['parametro1'])
                ->add('parametro2', TextType::class, $fieldOptions['parametro2'])
                ->add('parametro3', TextType::class, $fieldOptions['parametro3'])
                ->add('parametro4', TextType::class, $fieldOptions['parametro4'])
            ->end()
            ->with('label.tabelaConversao.dadosValores')
                ->add('condicaoParametro1', TextType::class, $fieldOptions['condicaoParametro1'])
                ->add('condicaoParametro2', TextType::class, $fieldOptions['condicaoParametro2'])
                ->add('condicaoParametro3', TextType::class, $fieldOptions['condicaoParametro3'])
                ->add('condicaoParametro4', TextType::class, $fieldOptions['condicaoParametro4'])
                ->add('valor', NumberType::class, $fieldOptions['valor'])
                ->add('fkArrecadacaoTabelaConversaoValoreses', 'customField', $fieldOptions['fkArrecadacaoTabelaConversaoValoreses'])
            ->end()
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
            ->with('label.tabelaConversao.dados')
                ->add('nomeTabela', null, array('label' => 'label.descricao'))
                ->add('exercicio', null, array('label' => 'label.exercicio'))
                ->add('fkArrecadacaoArrecadacaoModulos', null, array('label' => 'label.grupoCredito.moduloField'))
                ->add('parametro1', null, array('label' => 'label.tabelaConversao.parametro1'))
                ->add('parametro2', null, array('label' => 'label.tabelaConversao.parametro2'))
                ->add('parametro3', null, array('label' => 'label.tabelaConversao.parametro3'))
                ->add('parametro4', null, array('label' => 'label.tabelaConversao.parametro4'))
                ->add(
                    'fkArrecadacaoTabelaConversaoValoreses',
                    'string',
                    array(
                        'label' => 'label.tabelaConversao.listaValores',
                        'template' => 'TributarioBundle::Arrecadacao/ConversaoValores/dadosValores.html.twig',
                    )
                )
            ->end()
        ;
    }

    /**
     * @param mixed $object
     * @throws \Exception
     */
    public function prePersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            // codTabela
            $em = $this->modelManager->getEntityManager($this->getClass());
            $tabelaConversaoModel = new TabelaConversaoModel($em);
            $codTabela = $tabelaConversaoModel->getNextVal($object->getExercicio());

            $object->setCodTabela($codTabela);
            $this->setIfEmptyParameter1($object);

            $this->saveRelationships($object);
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
            $container->get('session')->getFlashBag()->add('error', $e->getMessage());
            throw $e;
        }
    }

    /**
     * @param $object
     */
    private function saveRelationships($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $tabelaConversaoValoresModel = new TabelaConversaoValoresModel($em);

        // Tabela Conversao Valores
        $valores = $this->getRequest()->request->get('valores');
        if (!is_null($valores)) {
            foreach ($valores as $valor) {
                list($condicaoParametro1, $condicaoParametro2, $condicaoParametro3, $condicaoParametro4, $number) = explode('__', $valor);

                $params = array(
                    'tabelaConversao' => $object,
                    'parametro1' => $condicaoParametro1,
                    'parametro2' => $condicaoParametro2,
                    'parametro3' => $condicaoParametro3,
                    'parametro4' => $condicaoParametro4,
                    'valor' => $number,
                );

                $tabelaConversaoValoresModel->saveTabelaConversaoValores($params);
            }
        }
    }

    /**
     * @param mixed $object
     * @throws \Exception
     */
    public function preUpdate($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $em = $this->modelManager->getEntityManager($this->getClass());

            $this->setIfEmptyParameter1($object);

            $tabelaConversaoValores = $em->getRepository(TabelaConversaoValores::class)
                ->findBy([
                    'codTabela' => $object->getCodTabela(),
                    'exercicio' => $object->getExercicio()
                ]);

            if ($tabelaConversaoValores) {
                foreach ($tabelaConversaoValores as $tabelaConversaoValor) {
                    $em->remove($tabelaConversaoValor);
                }

                $em->flush();
            }
            $this->saveRelationships($object);
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
            $container->get('session')->getFlashBag()->add('error', $e->getMessage());
            throw $e;
        }
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function toString($object)
    {
        return $object instanceof TabelaConversao
            ? $object->getNomeTabela()
            : $this->getTranslator()->trans('label.tabelaConversao.modulo');
    }

    /**
     * @param mixed $object
     * @return void
     */
    protected function setIfEmptyParameter1($object)
    {
        if (!$object->getParametro1()) {
            $object->setParametro1('');
        }
    }
}
