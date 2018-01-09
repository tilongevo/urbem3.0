<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem;
use Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto;
use Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial;
use Urbem\CoreBundle\Entity\Almoxarifado\Marca;
use Urbem\CoreBundle\Entity\Almoxarifado\NaturezaLancamento;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\EstoqueMaterialModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\LancamentoMaterialEstornoModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\LancamentoMaterialModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\NaturezaLancamentoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

/**
 * Class SaidaEstornoEntradaItemAdmin
 */
class SaidaEstornoEntradaItemAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_almoxarifado_saida_estorno_item';
    protected $baseRoutePattern = 'patrimonial/almoxarifado/saida-estorno/item';

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
        $this->setBreadCrumb([]);

        $request = $this->getRequest();
        $modelManager = $this->getModelManager();

        /** @var EntityManager $entityManager */
        $entityManager = $modelManager->getEntityManager($this->getClass());

        $naturezaLancamentoObjKey = null;
        $catalogoItemObjKey = null;

        if (false == $request->isMethod('GET')) {
            $formData = $request->get($this->getUniqid());

            $naturezaLancamentoObjKey = $formData['naturezaLancamento'];
            $catalogoItemObjKey = $formData['catalogoItem'];
        } else {
            $naturezaLancamentoObjKey = $request->get('naturezaLancamento');
            $catalogoItemObjKey = $request->get('catalogoItem');
        }

        /** @var NaturezaLancamento $naturezaLancamento */
        $naturezaLancamento = $modelManager->find(NaturezaLancamento::class, $naturezaLancamentoObjKey);

        /** @var CatalogoItem $catalogoItem */
        $catalogoItem = $modelManager->find(CatalogoItem::class, $catalogoItemObjKey);

        $naturezaLancamento->itemEntrada = (new NaturezaLancamentoModel($entityManager))
            ->getItemEntrada($catalogoItem, $naturezaLancamento);

        /** @var Marca $marca */
        $marca = $naturezaLancamento->itemEntrada['cod_marca'];

        /** @var CentroCusto $centroCusto */
        $centroCusto = $naturezaLancamento->itemEntrada['cod_centro'];

        /** @var Almoxarifado $almoxarifado */
        $almoxarifado = $naturezaLancamento->itemEntrada['cod_almoxarifado'];

        $fieldOptions = [];
        $fieldOptions['dadosItem'] = [
            'data' => [
                'item' => $naturezaLancamento->itemEntrada
            ],
            'label' => false,
            'mapped' => false,
            'template' => 'PatrimonialBundle:Sonata/Almoxarifado/SaidaEstorno/CRUD:field__dadosItem.html.twig'
        ];

        $fieldOptions['naturezaLancamento'] = [
            'data' => $naturezaLancamentoObjKey,
            'mapped' => false
        ];

        $fieldOptions['catalogoItem'] = [
            'data' => $catalogoItemObjKey,
            'mapped' => false
        ];

        $fieldOptions['marca'] = [
            'attr' => ['class' => 'select2-parameters '],
            'class' => Marca::class,
            'data' => $marca,
            'label' => 'label.saidaEstorno.item.marca',
            'mapped' => false,
            'placeholder' => 'label.selecione',
            'query_builder' => function (EntityRepository $repository) use ($marca) {
                return $repository->createQueryBuilder('marca')
                    ->where('marca.codMarca = :cod_marca')
                    ->setParameter('cod_marca', $marca->getCodMarca());
            }
        ];

        $fieldOptions['centroCusto'] = [
            'attr' => ['class' => 'select2-parameters '],
            'class' => CentroCusto::class,
            'data' => $centroCusto,
            'label' => 'label.saidaEstorno.item.centroCusto',
            'mapped' => false,
            'placeholder' => 'label.selecione',
            'query_builder' => function (EntityRepository $repository) use ($centroCusto) {
                return $repository->createQueryBuilder('centroCusto')
                    ->where('centroCusto.codCentro = :cod_centro')
                    ->setParameter('cod_centro', $centroCusto->getCodCentro());
            }
        ];

        $fieldOptions['justificativa'] = [
            'label' => 'label.saidaEstorno.item.justificativa',
            'mapped' => false
        ];

        $fieldOptions['quantidade'] = [
            'attr' => ['class' => 'quantity '],
            'label' => 'label.saidaEstorno.item.quantidade',
            'mapped' => false
        ];

        $this->label = $this->trans('label.saidaEstorno.detalhe', ['%tem%' => $catalogoItem]);

        $formMapper
            ->add('dadosItem', 'customField', $fieldOptions['dadosItem'])
            ->add('naturezaLancamento', 'hidden', $fieldOptions['naturezaLancamento'])
            ->add('catalogoItem', 'hidden', $fieldOptions['catalogoItem'])
            ->add('marca', 'entity', $fieldOptions['marca'])
            ->add('centroCusto', 'entity', $fieldOptions['centroCusto'])
            ->add('justificativa', 'textarea', $fieldOptions['justificativa'])
            ->add('quantidade', 'text', $fieldOptions['quantidade'])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function validate(ErrorElement $errorElement, $lancamentoMaterial)
    {
        $form = $this->getForm();
        $modelManager = $this->getModelManager();

        /** @var EntityManager $entityManager */
        $entityManager = $modelManager->getEntityManager($this->getClass());

        $catalogoItemObjKey = $form->get('catalogoItem')->getData();
        $naturezaLancamentoObjKey = $form->get('naturezaLancamento')->getData();

        /** @var CatalogoItem $catalogoItem */
        $catalogoItem = $modelManager->find(CatalogoItem::class, $catalogoItemObjKey);

        /** @var NaturezaLancamento $naturezaLancamento */
        $naturezaLancamento = $modelManager->find(NaturezaLancamento::class, $naturezaLancamentoObjKey);

        $itemEntrada = (new NaturezaLancamentoModel($entityManager))
            ->getItemEntrada($catalogoItem, $naturezaLancamento);

        $quantidadeDisponivelParaEstorno = abs($itemEntrada['quantidade']) - abs($itemEntrada['quantidade_estornada']);
        $quantidadeASerEstornada = $form->get('quantidade')->getData();
        $quantidadeASerEstornada = abs($quantidadeASerEstornada);

        if ($quantidadeASerEstornada > $quantidadeDisponivelParaEstorno) {
            $message = $this->trans('estorno.errors.quantidadeSuperiorSaldo', [], 'validators');
            $errorElement->with('quantidade')->addViolation($message)->end();
        }
    }


    /**
     * @param LancamentoMaterial $lancamentoMaterial
     */
    public function prePersist($lancamentoMaterial)
    {
        $form = $this->getForm();
        $modelManager = $this->getModelManager();

        $currentUser = $this->getCurrentUser();

        $exercicio = $this->getExercicio();

        /** @var EntityManager $entityManager */
        $entityManager = $modelManager->getEntityManager($this->getClass());

        $catalogoItemObjKey = $form->get('catalogoItem')->getData();
        $naturezaLancamentoObjKey = $form->get('naturezaLancamento')->getData();

        /** @var NaturezaLancamento $naturezaLancamentoEntrada */
        $naturezaLancamentoEntrada = $modelManager->find(NaturezaLancamento::class, $naturezaLancamentoObjKey);

        /** @var CatalogoItem $catalogoItem */
        $catalogoItem = $modelManager->find(CatalogoItem::class, $catalogoItemObjKey);

        $naturezaLancamentoEntrada->itemEntrada = (new NaturezaLancamentoModel($entityManager))
            ->getItemEntrada($catalogoItem, $naturezaLancamentoEntrada);

        $justificativa = $form->get('justificativa')->getData();
        $quantidade = $form->get('quantidade')->getData();
        $quantidade = $quantidade * (-1);

        $valorMercado = $naturezaLancamentoEntrada->itemEntrada['valor_unitario'] * $quantidade;

        $lancamentoMaterial->setComplemento($justificativa);
        $lancamentoMaterial->setQuantidade($quantidade);
        $lancamentoMaterial->setValorMercado($valorMercado);

        $estoqueMaterial = (new EstoqueMaterialModel($entityManager))
            ->findOrCreateEstoqueMaterial(
                $naturezaLancamentoEntrada->itemEntrada['cod_item']->getCodItem(),
                $naturezaLancamentoEntrada->itemEntrada['cod_marca']->getCodMarca(),
                $naturezaLancamentoEntrada->itemEntrada['cod_centro']->getCodCentro(),
                $naturezaLancamentoEntrada->itemEntrada['cod_almoxarifado']->getCodAlmoxarifado()
            );

        $naturezaLancamentoModel = new NaturezaLancamentoModel($entityManager);
        $naturezaLancamentoSaida = $naturezaLancamentoModel
            ->buildOne($currentUser->getFkSwCgm(), $exercicio, 'S', 10);

        $naturezaLancamentoModel->save($naturezaLancamentoSaida);

        $lancamentoMaterial->setFkAlmoxarifadoEstoqueMaterial($estoqueMaterial);
        $lancamentoMaterial->setFkAlmoxarifadoNaturezaLancamento($naturezaLancamentoSaida);
    }

    /**
     * @param LancamentoMaterial $lancamentoMaterial
     */
    public function postPersist($lancamentoMaterial)
    {
        $form = $this->getForm();
        $modelManager = $this->getModelManager();

        /** @var EntityManager $entityManager */
        $entityManager = $modelManager->getEntityManager($this->getClass());

        $naturezaLancamentoObjKey = $form->get('naturezaLancamento')->getData();

        /** @var NaturezaLancamento $naturezaLancamento */
        $naturezaLancamento = $modelManager->find(NaturezaLancamento::class, $naturezaLancamentoObjKey);

        $lancamentoMaterialEstornar = (new LancamentoMaterialModel($entityManager))
            ->findLancamentoMaterial(
                $lancamentoMaterial->getFkAlmoxarifadoEstoqueMaterial(),
                $naturezaLancamento,
                $lancamentoMaterial
            );

        (new LancamentoMaterialEstornoModel($entityManager))
            ->buildOneLancamentoMaterialEstorno($lancamentoMaterial, $lancamentoMaterialEstornar);

        $this->redirectByRoute('urbem_patrimonial_almoxarifado_saida_estorno_show', [
            'id' => $this->id($naturezaLancamento)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    function toString($lancamentoMaterial)
    {
        return 'Estorno';
    }


}
