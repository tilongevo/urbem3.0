<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\DoctrineORMAdminBundle\Model\ModelManager;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem;
use Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto;
use Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial;
use Urbem\CoreBundle\Entity\Almoxarifado\Marca;
use Urbem\CoreBundle\Entity\Frota\Veiculo;
use Urbem\CoreBundle\Entity\Orcamento\ContaDespesa;
use Urbem\CoreBundle\Model\Orcamento\ContaDespesaModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CatalogoItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\RequisicaoItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Frota\VeiculoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class SaidasDiversasItemAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado
 */
class SaidasDiversasItemAdmin extends AbstractAdmin
{
    protected $baseRoutePattern = 'patrimonial/almoxarifado/saida/diversas/item';

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['create']);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $modelManager = $this->modelManager;

        /** @var EntityManager $entityManager */
        $entityManager = $modelManager->getEntityManager($this->getClass());

        $fieldOptions = [];
        $fieldOptions['fkAlmoxarifadoCatalogoItem'] = [
            'attr' => ['class' => 'select2-parameters catalogo-item '],
            'class' => CatalogoItem::class,
            'disabled' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' =>
                function (EntityRepository $repo, $term, Request $request) use ($entityManager) {
                    return (new CatalogoItemModel($entityManager))
                        ->searchByDescricaoWithAlmoxarifadoQuery($term, $request->get('cod_almoxarifado'));
                },
            'label' => 'label.entradaDiversos.codItem',
            'req_params' => [
                'cod_almoxarifado' => 'varJsCodAlmoxarifado'
            ],
            'required' => true
        ];

        $fieldOptions['unidadeMedida'] = [
            'data' => [
                'unidade_medida' => null
            ],
            'label' => 'label.entradaDiversos.unidade',
            'mapped' => false,
            'template' => 'PatrimonialBundle:Sonata\Almoxarifado\SaidasDiversas\CRUD:field__dumb.html.twig'
        ];

        $fieldOptions['marca'] = [
            'attr' => ['class' => 'select2-parameters '],
            'class' => Marca::class,
            'choices' => [],
            'label' => 'label.entradaDiversos.codMarca',
            'mapped' => false,
            'placeholder' => 'label.selecione',
            'required' => true
        ];

        $fieldOptions['centro'] = [
            'attr' => ['class' => 'select2-parameters '],
            'class' => CentroCusto::class,
            'choices' => [],
            'label' => 'label.entradaDiversos.codCentro',
            'mapped' => false,
            'placeholder' => 'label.selecione',
            'required' => true
        ];

        $fieldOptions['saldoEstoque'] = [
            'data' => [
                'saldo_estoque' => null
            ],
            'label' => 'label.saidaDiversas.saldo',
            'mapped' => false,
            'required' => true,
            'template' => 'PatrimonialBundle:Sonata\Almoxarifado\SaidasDiversas\CRUD:field__dumb.html.twig'
        ];

        $fieldOptions['quantidade'] = [
            'attr' => ['class' => 'quantity '],
            'label' => 'label.entradaDiversos.quantidade',
            'mapped' => false,
            'required' => true
        ];

        $fieldOptions['desdobramento'] = [
            'attr' => ['class' => 'select2-parameters '],
            'choice_label' => 'codEstrutural',
            'class' => ContaDespesa::class,
            'label' => 'label.almoxarifado.requisicao.devolucao.codContaDespesa',
            'mapped' => false,
            'query_builder' => (new ContaDespesaModel($entityManager))->getListaDeContasDepesas($this->getExercicio()),
            'required' => true
        ];

        $fieldOptions['veiculo'] = [
            'attr' => ['class' => 'select2-parameters catalogo-item '],
            'class' => Veiculo::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' =>
                function (EntityRepository $repo, $term, Request $request) use ($entityManager) {
                    $queryBuilder = (new VeiculoModel($entityManager))->getVeiculosNaoBaixadosQuery();
                    $alias = $queryBuilder->getRootAlias();
                    $term = $request->get('q');

                    return $queryBuilder
                        // Exemplo: 130 - IWZ - / CHEVROLET / SPIN MT LTZ
                        ->andWhere("LOWER(CONCAT({$alias}.codVeiculo, ' - ' , {$alias}.placa, ' / ', fkFrotaMarca.nomMarca, ' / ', fkFrotaModelo.nomModelo)) LIKE LOWER(:term)")
                        ->setParameter('term', "%{$term}%");
                },
            'label' => 'label.saidaDiversas.veiculo',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['km'] = [
            'attr' => ['class' => 'km '],
            'label' => 'label.saidaDiversas.km',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['atributosDinamicos'] = [
            'attr' => ['data-show' => 'when-has-dynamic-field'],
            'label' => false,
            'mapped' => false
        ];

        $fieldOptions['quantidadePerecivel'] = [
            'attr' => ['data-show' => 'when-has-perecivel-field'],
            'label' => false,
            'mapped' => false
        ];
        
        $formMapper
            ->with('label.entradaDiversos.codItem')
                ->add('fkAlmoxarifadoCatalogoItem', 'autocomplete', $fieldOptions['fkAlmoxarifadoCatalogoItem'])
                ->add('unidadeMedida', 'customField', $fieldOptions['unidadeMedida'])
                ->add('marca', 'entity', $fieldOptions['marca'])
                ->add('centro', 'entity', $fieldOptions['centro'])
                ->add('saldoEstoque', 'customField', $fieldOptions['saldoEstoque'])
                ->add('quantidade', 'text', $fieldOptions['quantidade'])
                ->add('desdobramento', 'entity', $fieldOptions['desdobramento'])

                ->add('veiculo', 'autocomplete', $fieldOptions['veiculo'])
                ->add('km', 'text', $fieldOptions['km'])

                ->add('atributosDinamicos', 'text', $fieldOptions['atributosDinamicos'])
                ->add('quantidadePerecivel', 'text', $fieldOptions['quantidadePerecivel'])
            ->end()
        ;

        $admin = $this;
        $formMapper
            ->getFormBuilder()
            ->addEventListener(
                FormEvents::PRE_SUBMIT,
                function (FormEvent $event) use ($admin, $fieldOptions, $formMapper) {
                    $parentAdmin = $admin->getParentFieldDescription()->getAdmin();
                    $parentData = $parentAdmin->getRequest()->get($parentAdmin->getUniqid());
                    $data = $event->getData();

                    $form = $event->getForm();

                    /** @var ModelManager $modelManager */
                    $modelManager = $admin->modelManager;

                    /** @var Almoxarifado $almoxarifado */
                    $almoxarifado = $modelManager
                        ->find(Almoxarifado::class, $parentData['almoxarifado']);

                    /** @var CatalogoItem $catalogoItem */
                    $catalogoItem = $modelManager
                        ->find(CatalogoItem::class, $data['fkAlmoxarifadoCatalogoItem']);

                    /** @var Marca $marca */
                    $marca = $modelManager
                        ->find(Marca::class, $data['marca']);

                    /** @var Usuario $usuario */
                    $usuario =
                        $admin->getCurrentUser();

                    $requisicaoItemModel =
                        new RequisicaoItemModel($modelManager->getEntityManager(LancamentoMaterial::class));

                    unset($fieldOptions['marca']['choices']);
                    $fieldOptions['marca']['auto_initialize'] = false;
                    $fieldOptions['marca']['query_builder'] = $requisicaoItemModel
                        ->searchMarcasForRequisicaoQuery($almoxarifado, $catalogoItem);

                    $marcaField = $formMapper
                        ->getFormBuilder()
                        ->getFormFactory()
                        ->createNamed('marca', 'entity', null, $fieldOptions['marca']);

                    $form->add($marcaField);

                    unset($fieldOptions['centro']['choices']);
                    $fieldOptions['centro']['auto_initialize'] = false;
                    $fieldOptions['centro']['query_builder'] = $requisicaoItemModel
                        ->searchCentrosCustoForRequisicaoQuery($almoxarifado, $catalogoItem, $marca, $usuario);

                    $centroField = $formMapper
                        ->getFormBuilder()
                        ->getFormFactory()
                        ->createNamed('centro', 'entity', null, $fieldOptions['centro']);

                    $form->add($centroField);
                }
            );
    }
}
