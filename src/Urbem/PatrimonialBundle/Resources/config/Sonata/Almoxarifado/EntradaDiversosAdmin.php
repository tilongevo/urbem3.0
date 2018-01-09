<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado;

use Doctrine\ORM\EntityManager;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use Sonata\DoctrineORMAdminBundle\Model\ModelManager;
use Symfony\Component\Form\Form;

use Urbem\CoreBundle\Entity\Administracao\Cadastro;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado;
use Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoItem;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem;
use Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto;
use Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial;
use Urbem\CoreBundle\Entity\Almoxarifado\Marca;
use Urbem\CoreBundle\Entity\Almoxarifado\NaturezaLancamento;
use Urbem\CoreBundle\Entity\Compras\Fornecedor;

use Urbem\CoreBundle\Model\Administracao\AtributoDinamicoModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\AlmoxarifeModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\AtributoEstoqueMaterialValorModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CatalogoItemBarrasModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CatalogoItemMarcaModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\DoacaoEmprestimoModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\EstoqueMaterialModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\LancamentoBemModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\LancamentoPerecivelModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\NaturezaModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\NaturezaLancamentoModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\PerecivelModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\NotaFiscalFornecedorModel;

use Urbem\CoreBundle\Model\Patrimonial\Patrimonio\BemModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class EntradaDiversosAdmin
 */
class EntradaDiversosAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_almoxarifado_entrada_diversos';
    protected $baseRoutePattern = 'patrimonial/almoxarifado/entrada-diversos';

    protected $entrada = 'diversos';

    protected $includeJs = [
        '/patrimonial/javascripts/almoxarifado/entrada-diversos.js',
    ];

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept('create');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $exercicio = $this->getExercicio();
        $fieldOptions = [];

        $fieldOptions['exercicioLancamento'] = [
            'label' => 'label.entradaDiversos.exercicio',
            'data' => $exercicio,
            'attr' => ['readonly' => 'readonly']
        ];

        $fieldOptions['codAlmoxarifado'] = [
            'class' => Almoxarifado::class,
            'label' => 'label.entradaDiversos.codAlmoxarifado',
            'attr' => ['class' => 'select2-parameters '],
            'placeholder' => 'label.selecione',
            'mapped' => false
        ];

        $fieldOptions['fornecedor'] = [
            'attr' => ['class' => 'select2-parameters '],
            'class' => Fornecedor::class,
            'label' => 'label.entradaDiversos.cgmFornecedor',
            'mapped' => false,
            'placeholder' => $this->trans('label.selecione'),
            'required' => true,
            'route' => ['name' => 'urbem_core_filter_compras_fornecedor_autocomplete']
        ];

        $fieldOptions['dtNota'] = [
            'label' => 'label.entradaDiversos.dtNota',
            'format' => 'dd/MM/yyyy',
            'mapped' => false
        ];

        $fieldOptions['numeroNota'] = [
            'attr' => ['class' => 'only-number '],
            'label' => 'label.entradaDiversos.numeroNota',
            'mapped' => false
        ];

        $fieldOptions['numeroSerie'] = [
            'attr' => ['class' => 'only-number '],
            'label' => 'label.entradaDiversos.numeroSerie',
            'mapped' => false
        ];

        $fieldOptions['observacao'] = [
            'attr' => ['maxlength' => '200'],
            'label' => 'label.entradaDiversos.observacao',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['codigoBarras'] = [
            'attr' => ['class' => 'only-number '],
            'label' => 'label.entradaDiversos.codigoBarras',
            'mapped' => false
        ];

        $formMapper
            ->with('label.entradaDiversos.dadosImplantacao')
                ->add('exercicioLancamento', 'text', $fieldOptions['exercicioLancamento'])
                ->add('codAlmoxarifado', 'entity', $fieldOptions['codAlmoxarifado'])
            ->end()
            ->with('label.entradaDiversos.dadosNota')
                ->add('fornecedor', 'autocomplete', $fieldOptions['fornecedor'])
                ->add('dtNotaFiscal', 'sonata_type_date_picker', $fieldOptions['dtNota'])
                ->add('numeroNotaFiscal', 'number', $fieldOptions['numeroNota'])
                ->add('numeroSerie', 'number', $fieldOptions['numeroSerie'])
                ->add('observacaoNotaFiscal', 'textarea', $fieldOptions['observacao'])
            ->end()
        ;

        $formMapper
            ->with('label.entradaDiversos.codItem')
                ->add('fkAlmoxarifadoLancamentoMateriais', 'sonata_type_collection', [
                    'label' => false
                ], [
                    'edit' => 'inline',
                    'admin_code' => 'patrimonial.admin.entrada_diversos_item',
                ])
            ->end()
        ;
    }

    /**
     * @param NaturezaLancamento $naturezaLancamento
     */
    public function preValidate($naturezaLancamento)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $container = $this->getContainer();
        $form = $this->getForm();
        $hasError = false;
        $itensNota = 0;

        /** @var Form $fkAlmoxarifadoLancamentoMateriais */
        foreach ($form->get('fkAlmoxarifadoLancamentoMateriais') as $fkAlmoxarifadoLancamentoMaterialForm) {
            $quantidade = $fkAlmoxarifadoLancamentoMaterialForm->get('quantidade')->getData();
            $valorMercado = $fkAlmoxarifadoLancamentoMaterialForm->get('valorMercado')->getData();

            if ($quantidade > 0
                && $valorMercado > 0) {
                $itensNota++;
            }
        }

        // Valida se há itens na nota
        if (0 == $itensNota) {
            $message = $this->trans('entradaOrdem.errors.semItensNaNota', [], 'validators');
            $container->get('session')->getFlashBag()->add('error', $message);

            $hasError = true;
        }

        // Verifica se há algum erro, caso haja, retorna a página de edição
        if (true == $hasError) {
            $routeName = $this->baseRouteName . '_create';
            $this->redirectByRoute($routeName);
        }
    }

    /**
     * @param NaturezaLancamento $naturezaLancamento
     */
    public function prePersist($naturezaLancamento)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $usuario = $this->getCurrentUser();
        $form = $this->getForm();

        // Se for doação, o número será 3
        $codNatureza = 9;
        $numLancamento =
            (new NaturezaLancamentoModel($entityManager))->buildNumNaturezaLancamento($this->getExercicio());

        $natureza = (new NaturezaModel($entityManager))->getOneNaturezaByCodNaturezaAndTipoNatureza($codNatureza, 'E');
        $almoxarife = (new AlmoxarifeModel($entityManager))->findByUsuario($usuario);

        $naturezaLancamento->setNumLancamento($numLancamento);
        $naturezaLancamento->setFkAlmoxarifadoNatureza($natureza);
        $naturezaLancamento->setFkAdministracaoUsuario($usuario);
        $naturezaLancamento->setFkAlmoxarifadoAlmoxarife($almoxarife);

        /** @var Form $fkAlmoxarifadoLancamentoMaterialForm */
        foreach ($form->get('fkAlmoxarifadoLancamentoMateriais') as $fkAlmoxarifadoLancamentoMaterialForm) {
            $quantidade = $fkAlmoxarifadoLancamentoMaterialForm->get('quantidade')->getData();
            $valorMercado = $fkAlmoxarifadoLancamentoMaterialForm->get('valorMercado')->getData();
            
            /** @var Almoxarifado $almoxarifado */
            $almoxarifado = $form->get('codAlmoxarifado')->getData();

            /** @var LancamentoMaterial $lancamentoMaterial */
            $lancamentoMaterial = $fkAlmoxarifadoLancamentoMaterialForm->getNormData();
            
            if ($quantidade <= 0
                || $valorMercado <= 0) {
                $naturezaLancamento->removeFkAlmoxarifadoLancamentoMateriais($lancamentoMaterial);
            } else {
                /** @var Marca $marca */
                $marca = $fkAlmoxarifadoLancamentoMaterialForm->get('marca')->getData();

                /** @var CatalogoItem $catalogoItem */
                $catalogoItem = $fkAlmoxarifadoLancamentoMaterialForm->get('item')->getData();

                /** @var CentroCusto $centroCusto */
                $centroCusto = $fkAlmoxarifadoLancamentoMaterialForm->get('centro')->getData();

                $catalogoItemMarca = (new CatalogoItemMarcaModel($entityManager))
                    ->findOrCreateCatalogoItemMarca($catalogoItem->getCodItem(), $marca->getCodMarca());

                $codigoBarras = $fkAlmoxarifadoLancamentoMaterialForm->get('codigoBarras')->getData();
                $catalogoItemBarras = (new CatalogoItemBarrasModel($entityManager))
                    ->findOrCreateCatalogoItemBarras($catalogoItemMarca, $codigoBarras);

                $estoqueMaterial = (new EstoqueMaterialModel($entityManager))
                    ->findOrCreateEstoqueMaterial(
                        $catalogoItem->getCodItem(),
                        $marca->getCodMarca(),
                        $centroCusto->getCodCentro(),
                        $almoxarifado->getCodAlmoxarifado()
                    );

                $lancamentoMaterial->setFkAlmoxarifadoEstoqueMaterial($estoqueMaterial);
                $lancamentoMaterial->setFkAlmoxarifadoNaturezaLancamento($naturezaLancamento);
            }
        }
    }

    /**
     * @param NaturezaLancamento $naturezaLancamento
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postPersist($naturezaLancamento)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $usuario = $this->getCurrentUser();
        $form = $this->getForm();

        /** @var Fornecedor $fornecedor */
        $fornecedor = $form->get('fornecedor')->getData();
        $formData = $this->getRequest()->request->get($this->getUniqid());
        $formData['tipo'] = 'C';

        $notaFiscalFornecedor =
            (new NotaFiscalFornecedorModel($entityManager))->buildOne($fornecedor, $naturezaLancamento, $formData);

        /** @var Form $fkAlmoxarifadoLancamentoMaterialForm */
        foreach ($form->get('fkAlmoxarifadoLancamentoMateriais') as $loopIndex => $fkAlmoxarifadoLancamentoMaterialForm) {
            $quantidade = $fkAlmoxarifadoLancamentoMaterialForm->get('quantidade')->getData();
            $valorMercado = $fkAlmoxarifadoLancamentoMaterialForm->get('valorMercado')->getData();

            /** @var Almoxarifado $almoxarifado */
            $almoxarifado = $form->get('codAlmoxarifado')->getData();

            /** @var LancamentoMaterial $lancamentoMaterial */
            $lancamentoMaterial = $fkAlmoxarifadoLancamentoMaterialForm->getNormData();

            if ($quantidade > 0
                && $valorMercado > 0) {
                /** @var Marca $marca */
                $marca = $fkAlmoxarifadoLancamentoMaterialForm->get('marca')->getData();

                /** @var CatalogoItem $catalogoItem */
                $catalogoItem = $fkAlmoxarifadoLancamentoMaterialForm->get('item')->getData();

                /** @var CentroCusto $centroCusto */
                $centroCusto = $fkAlmoxarifadoLancamentoMaterialForm->get('centro')->getData();

                $tipoItemAlias = $catalogoItem->getFkAlmoxarifadoTipoItem()->getAlias();

                $estoqueMaterial = (new EstoqueMaterialModel($entityManager))
                    ->findOrCreateEstoqueMaterial(
                        $catalogoItem->getCodItem(),
                        $marca->getCodMarca(),
                        $centroCusto->getCodCentro(),
                        $almoxarifado->getCodAlmoxarifado()
                    );

                if ("perecivel" == $tipoItemAlias) {
                    $perecivelModel = new PerecivelModel($entityManager);
                    $perecivel = $perecivelModel->findOrCreatePerecivel(
                        $lancamentoMaterial->getFkAlmoxarifadoEstoqueMaterial(),
                        $fkAlmoxarifadoLancamentoMaterialForm->get('dtFabricacao'),
                        $fkAlmoxarifadoLancamentoMaterialForm->get('dtValidade'),
                        $fkAlmoxarifadoLancamentoMaterialForm->get('lote')
                    );

                    $lancamentoPerecivelModel = new LancamentoPerecivelModel($entityManager);
                    $lancamentoPerecivelModel->findOrCreateLancamentoPerecivel($lancamentoMaterial, $perecivel);
                }

                if ("patrimonial" == $tipoItemAlias) {
                    $bemModel = new BemModel($entityManager);
                    $lancamentoBem = new LancamentoBemModel($entityManager);

                    $numeroPlaca = $fkAlmoxarifadoLancamentoMaterialForm->get('numeroPlaca')->getData();
                    $placaIdentificacao =
                        (int) $fkAlmoxarifadoLancamentoMaterialForm->get('placaIdentificacao')->getData();

                    $bem = $bemModel->buildOneBemFromLancamentoMaterial(
                        $lancamentoMaterial,
                        $catalogoItem,
                        $placaIdentificacao,
                        $numeroPlaca
                    );

                    $bemModel->save($bem);
                    $lancamentoBem->findOrCreateLancamentoBem($lancamentoMaterial, $bem);
                }

                $requestAtributoDinamico = $this->getRequest()->get('atributoDinamico');
                $atributoDinamicoKey = implode('_', [$catalogoItem->getCodItem(), $loopIndex]);
                $atributosDinamicos = $requestAtributoDinamico[$atributoDinamicoKey];

                if (true == isset($atributosDinamicos)) {
                    foreach ($atributosDinamicos as $atributoCatalogoItemObjectKey => $atributoDinamico) {
                        /** @var AtributoCatalogoItem $atributoCatalogoItem */
                        $atributoCatalogoItem = $this->modelManager
                            ->find(AtributoCatalogoItem::class, implode(ModelManager::ID_SEPARATOR, [
                                $catalogoItem->getCodItem(),
                                $atributoCatalogoItemObjectKey,
                                Cadastro::CADASTRO_PATRIMONIAL_ALMOXARIFADO_ATRIBUTO_ESTOQUE_MATERIAL_VALOR,
                                Modulo::MODULO_PATRIMONIAL_ALMOXARIFADO
                            ]));

                        $valor = (new AtributoDinamicoModel($entityManager))
                            ->processaAtributoDinamicoPersist($atributoCatalogoItem, $atributoDinamico);

                        $atributoEstoqueMaterialValor = (new AtributoEstoqueMaterialValorModel($entityManager))
                            ->saveAtributoEstoqueMaterialValor($atributoCatalogoItem, $lancamentoMaterial, $valor);
                    }
                }

                if ('doacao' == $this->entrada) {
                    /** @var SwProcesso $swProcessp */
                    $swProcesso = $form->get('processo')->getData();

                    $doacaoEmprestimo = (new DoacaoEmprestimoModel($entityManager))->buildOne($lancamentoMaterial, $swProcesso);
                }
            }
        }

        $routeName = $this->baseRouteName . '_create';
        return $this->redirectByRoute($routeName);
    }
}
