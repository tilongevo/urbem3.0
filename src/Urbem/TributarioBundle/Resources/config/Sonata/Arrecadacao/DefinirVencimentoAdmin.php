<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Arrecadacao;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\Pager;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Arrecadacao\Desconto;
use Urbem\CoreBundle\Entity\Arrecadacao\GrupoCredito;
use Urbem\CoreBundle\Entity\Arrecadacao\GrupoVencimento;
use Urbem\CoreBundle\Entity\Arrecadacao\VencimentoParcela;
use Urbem\CoreBundle\Model\Arrecadacao\DescontoModel;
use Urbem\CoreBundle\Model\Arrecadacao\VencimentoParcelaModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class DefinirVencimentoAdmin
 * @package Urbem\TributarioBundle\Resources\config\Sonata\Arrecadacao
 */
class DefinirVencimentoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_arrecadacao_calendario_fiscal_definir_vencimentos';
    protected $baseRoutePattern = 'tributario/arrecadacao/calendario-fiscal/definir-vencimentos';
    protected $includeJs = array(
        '/tributario/javascripts/arrecadacao/vencimento-desconto.js',
        '/tributario/javascripts/arrecadacao/parcelas.js'
    );
    protected $exibirBotaoExcluir = false;
    protected $exibirBotaoIncluir = false;

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('list', 'edit'));
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        /** @var Pager $pager */
        $pager = $this->getDatagrid()->getPager();
        $pager->setCountColumn(array('codGrupo'));

        $datagridMapper
            ->add(
                'codGrupo',
                null,
                [
                    'label' => 'label.calendarioFiscal.grupoCreditos',
                ],
                'entity',
                [
                    'class' => GrupoCredito::class,
                    'attr' => array(
                        'class' => 'select2-parameters '
                    )
                ]
            )
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('fkArrecadacaoCalendarioFiscal.codGrupo', null, array('label' => 'label.codigo'))
            ->add('fkArrecadacaoCalendarioFiscal.fkArrecadacaoGrupoCredito.descricao', null, array('label' => 'label.calendarioFiscal.grupoCreditos'))
            ->add('anoExercicio', null, array('label' => 'label.exercicio'))
            ->add('descricao', null, array('label' => 'label.descricao'))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array('template' => 'TributarioBundle:Sonata/Arrecadacao/CRUD:list__action_definirVencimentos.html.twig'),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions = array();

        $fieldOptions['dadosGrupoVencimento'] = array(
            'label' => false,
            'mapped' => false,
            'data' => array(
                'grupoVencimento' => $this->getSubject()
            ),
            'template' => 'TributarioBundle::Arrecadacao/CalendarioFiscal/grupoVencimento.html.twig',
        );

        $fieldOptions['dataVencimento'] = array(
            'label' => 'label.calendarioFiscal.vencimentoValorIntegral',
            'required' => true,
            'mapped' => false,
            'format' => 'dd/MM/yyyy',
        );

        $fieldOptions['desconto'] = array(
            'label' => 'label.definirVencimentos.desconto',
            'required' => true,
            'mapped' => false
        );

        $fieldOptions['formaDesconto'] = array(
            'label' => 'label.definirVencimentos.formaDesconto',
            'mapped' => false,
            'choices' => array(
                'label.definirVencimentos.percentual' => 'per',
                'label.definirVencimentos.valorAbsoluto' => 'abs'
            ),
            'attr' => [
                'class' => 'select2-parameters '
            ],
        );

        $fieldOptions['fkArrecadacaoDescontos'] = array(
            'label' => false,
            'mapped' => false,
            'template' => 'TributarioBundle::Arrecadacao/CalendarioFiscal/descontos.html.twig',
            'data' => array(
                'descontos' => array()
            )
        );

        $fieldOptions['dataVencimentoParcelamento'] = array(
            'label' => 'label.definirVencimentos.vencimento',
            'required' => true,
            'mapped' => false,
            'format' => 'dd/MM/yyyy',
        );

        $fieldOptions['descontoParcelamento'] = array(
            'label' => 'label.definirVencimentos.desconto',
            'required' => true,
            'mapped' => false
        );

        $fieldOptions['dataVencimentoDesconto'] = array(
            'label' => 'label.definirVencimentos.vencimentoDesconto',
            'required' => true,
            'mapped' => false,
            'format' => 'dd/MM/yyyy',
        );

        $fieldOptions['formaDescontoParcelamento'] = array(
            'label' => 'label.definirVencimentos.formaDesconto',
            'mapped' => false,
            'choices' => array(
                'label.definirVencimentos.percentual' => 'perparc',
                'label.definirVencimentos.valorAbsoluto' => 'absparc'
            ),
            'attr' => [
                'class' => 'select2-parameters '
            ],
        );

        $fieldOptions['quantidadeParcelas'] = array(
            'label' => 'label.definirVencimentos.quantidadeParcelas',
            'required' => true,
            'mapped' => false
        );

        $fieldOptions['fkArrecadacaoVencimentoParcelas'] = array(
            'label' => false,
            'mapped' => false,
            'template' => 'TributarioBundle::Arrecadacao/CalendarioFiscal/parcelas.html.twig',
            'data' => array(
                'parcelas' => array()
            )
        );

        if ($this->id($this->getSubject())) {
            /** @var GrupoVencimento $grupoVencimento */
            $grupoVencimento = $this->getSubject();

            $fieldOptions['fkArrecadacaoDescontos']['data'] = array(
                'descontos' => $grupoVencimento->getFkArrecadacaoDescontos()
            );

            $fieldOptions['fkArrecadacaoVencimentoParcelas']['data'] = array(
                'parcelas' => $grupoVencimento->getFkArrecadacaoVencimentoParcelas()
            );
        }

        $formMapper
            ->with('label.definirVencimentos.dados')
                ->add('dadosGrupoVencimento', 'customField', $fieldOptions['dadosGrupoVencimento'])
            ->end()
            ->with('label.definirVencimentos.dadosVencimentosDescontos')
                ->add('dataVencimento', 'sonata_type_date_picker', $fieldOptions['dataVencimento'])
                ->add('desconto', 'number', $fieldOptions['desconto'])
                ->add('formaDesconto', 'choice', $fieldOptions['formaDesconto'])
                ->add('fkArrecadacaoDescontos', 'customField', $fieldOptions['fkArrecadacaoDescontos'])
            ->end()
            ->with('label.definirVencimentos.parcelamento')
                ->add('dataVencimentoParcelamento', 'sonata_type_date_picker', $fieldOptions['dataVencimentoParcelamento'])
                ->add('descontoParcelamento', 'number', $fieldOptions['descontoParcelamento'])
                ->add('dataVencimentoDesconto', 'sonata_type_date_picker', $fieldOptions['dataVencimentoDesconto'])
                ->add('formaDescontoParcelamento', 'choice', $fieldOptions['formaDescontoParcelamento'])
                ->add('quantidadeParcelas', 'number', $fieldOptions['quantidadeParcelas'])
                ->add('fkArrecadacaoVencimentoParcelas', 'customField', $fieldOptions['fkArrecadacaoVencimentoParcelas'])
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
            ->add('codGrupo')
            ->add('codVencimento')
            ->add('anoExercicio')
            ->add('descricao')
            ->add('dataVencimentoParcelaUnica')
            ->add('limiteInicial')
            ->add('limiteFinal')
            ->add('utilizarUnica')
        ;
    }

    /**
     * @param mixed $object
     * @throws \Exception
     */
    public function preUpdate($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            /** @var EntityManager $em */
            $em = $this->modelManager->getEntityManager($this->getClass());

            $descontos = $em->getRepository(Desconto::class)
                ->findBy([
                    'codGrupo' => $object->getCodGrupo(),
                    'anoExercicio' => $object->getAnoExercicio()
                ]);

            foreach ($descontos as $desconto) {
                $em->remove($desconto);
            }
            $em->flush();

            $parcelas = $em->getRepository(VencimentoParcela::class)
                ->findBy([
                    'codGrupo' => $object->getCodGrupo(),
                    'anoExercicio' => $object->getAnoExercicio()
                ]);

            foreach ($parcelas as $parcela) {
                $em->remove($parcela);
            }
            $em->flush();

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
    public function saveRelationships($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        // Descontos
        $descontoModel = new DescontoModel($em);
        $descontos = $this->getRequest()->request->get('descontos');

        foreach ($descontos as $desconto) {
            list($dataVencimento, $valor, $formaDesconto) = explode('__', $desconto);

            $params = array(
                'grupoVencimento' => $object,
                'dataVencimento' => $dataVencimento,
                'formaDesconto' => $formaDesconto,
                'valor' => $valor
            );

            $descontoModel->saveDesconto($params);
        }

        // Parcelas
        $vencimentoParcelaModel = new VencimentoParcelaModel($em);
        $parcelas = $this->getRequest()->request->get('parcelas');

        foreach ($parcelas as $parcela) {
            list($dataVencimento, $valor, $dataVencimentoDesconto, $formaDesconto, $quantidadeParcelas) = explode('__', $parcela);

            $params = array(
                'grupoVencimento' => $object,
                'dataVencimento' => $dataVencimento,
                'valor' => $valor,
                'dataVencimentoDesconto' => $dataVencimentoDesconto,
                'formaDesconto' => $formaDesconto,
            );

            $vencimentoParcelaModel->saveVencimentoParcela($params);
        }
    }
}
