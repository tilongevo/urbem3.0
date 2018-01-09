<?php

namespace Urbem\ComprasGovernamentaisBundle\Resources\config\Sonata\Requisicao;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem;
use Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto;
use Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial;
use Urbem\CoreBundle\Entity\Almoxarifado\Marca;
use Urbem\CoreBundle\Entity\Almoxarifado\Requisicao;
use Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoItem;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\RequisicaoItemModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

/**
 * Class RequisicaoAdmin
 * @package Urbem\ComprasGovernamentaisBundle\Resources\config\Sonata\Requisicao
 */

class RequisicaoItemAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_compras_governamentais_requisicao_item';
    protected $baseRoutePattern = 'compras-governamentais/requisicao-item';

    /**
     * @param $code
     * @param $class
     * @param $baseControllerName
     */
    public function __construct($code, $class, $baseControllerName)
    {
        parent::__construct($code, RequisicaoItem::class, $baseControllerName);
    }

    /**
     * @param mixed $object
     */
    public function preUpdate($object)
    {
        $this->populateObject($object);
    }

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->add('api_marcas', 'api/marcas');
        $collection->add('api_centros_custo', 'api/centros-custo');
        $collection->add('api_saldo_estoque', 'api/saldo-estoque');
    }

    /**
     * @param array $params
     * @return array
     */
    public function getMarcas(array $params = [])
    {
        if (empty($params['codItem'])) {
            return [];
        }

        $em = $this->modelManager->getEntityManager($this->getClass());

        $qb = $em->getRepository(Marca::class)->createQueryBuilder('m');

        $qb->join('m.fkAlmoxarifadoCatalogoItemMarcas', 'cim');

        $qb->where('cim.codItem = :codItem');
        $qb->setParameter('codItem', $params['codItem']);

        $qb->orderBy('m.descricao', 'ASC');

        return $qb->getQuery()->getResult();
    }

    /**
     * @param array $params
     * @return array
     */
    public function getCentrosCusto(array $params = [])
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $qb = $em->getRepository(CentroCusto::class)->createQueryBuilder('cc');

        $qb->join('cc.fkAlmoxarifadoEstoqueMateriais', 'em');
        $qb->join('em.fkAlmoxarifadoLancamentoMateriais', 'lm');

        if (!empty($params['codAlmoxarifado'])) {
            $qb->andWhere('lm.codAlmoxarifado = :codAlmoxarifado');
            $qb->setParameter('codAlmoxarifado', $params['codAlmoxarifado']);
        }

        if (!empty($params['codItem'])) {
            $qb->andWhere('lm.codItem = :codItem');
            $qb->setParameter('codItem', $params['codItem']);
        }

        if (!empty($params['codMarca'])) {
            $qb->andWhere('lm.codMarca = :codMarca');
            $qb->setParameter('codMarca', $params['codMarca']);
        }

        $qb->orderBy('cc.descricao', 'ASC');

        return $qb->getQuery()->getResult();
    }

    /**
     * @param array $params
     * @return int
     */
    public function getSaldoEstoque(array $params = [])
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        return (new RequisicaoItemModel($em))->getSaldoEstoqueByParams($params);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $requisicaoItem = $this->getSubject();
        $requisicaoItemExists = $requisicaoItem && $requisicaoItem->getCodItem();

        $catalogoItem = null;
        $marca = null;
        $centroCusto = null;
        $saldoEstoque = 0;
        $quantidade = 1;

        if ($requisicaoItemExists) {
            $catalogoItem = $em->getRepository(CatalogoItem::class)->find($requisicaoItem->getCodItem());
            $marca = $em->getRepository(Marca::class)->find($requisicaoItem->getCodMarca());
            $centroCusto = $em->getRepository(CentroCusto::class)->find($requisicaoItem->getCodCentro());
            $saldoEstoque = (new RequisicaoItemModel($em))->getSaldoEstoqueByRequisicaoItem($requisicaoItem);
            $quantidade = $requisicaoItem->getQuantidade();
        }

        $fieldOptions = [];
        $fieldOptions['item'] = [
            'class' => CatalogoItem::class ,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');

                $qb->andWhere('(o.codItem = :codItem OR LOWER(o.descricaoResumida) LIKE :descricaoResumida)');
                $qb->setParameter('codItem', (int) $term);
                $qb->setParameter('descricaoResumida', sprintf('%%%s%%', strtolower($term)));

                $qb->orderBy('o.codItem', 'ASC');

                return $qb;
            },
            'placeholder' => $this->trans('label.selecione'),
            'data' => $catalogoItem,
            'attr' => [
                'class' => 'select2-parameters ',
                'type' => 'autocomplete',
            ],
            'label' => 'label.comprasGovernamentaisRequisicao.item',
        ];

        $fieldOptions['marca'] = [
            'class' => Marca::class ,
            'mapped' => false,
            'placeholder' => $this->trans('label.selecione'),
            'data' => $marca,
            'attr' => [
                'class' => 'select2-parameters ',
                'type' => 'entity',
            ],
            'label' => 'label.almoxarifado.marca',
        ];

        $fieldOptions['centroCusto'] = [
            'class' => CentroCusto::class ,
            'mapped' => false,
            'placeholder' => $this->trans('label.selecione'),
            'data' => $centroCusto,
            'attr' => [
                'class' => 'select2-parameters ',
                'type' => 'entity',
            ],
            'label' => 'label.almoxarifado.codCentro',
        ];

        $fieldOptions['saldoEstoque'] = [
            'mapped' => false,
            'required' => false,
            'data' => $saldoEstoque,
            'attr' => [
                'disabled' => 'disabled',
                'class' => 'quantity ',
            ],
            'label' => 'label.almoxarifado.requisicao.saldo',
        ];

        $fieldOptions['quantidade'] = [
            'data' => $quantidade,
            'attr' => [
                'class' => 'quantity ',
                'min' => 1,
            ],
        ];

        if ($requisicaoItemExists) {
            $fieldOptions['item'] = [
                'mapped' => false,
                'data' => $catalogoItem ? sprintf('%d - %s', $catalogoItem->getCodItem(), $catalogoItem->getDescricao()) : 0,
                'attr' => [
                    'readonly' => 'readonly',
                    'type' => 'text',
                ],
                'label' => 'label.comprasGovernamentaisRequisicao.item',
            ];

            $fieldOptions['marca'] = [
                'mapped' => false,
                'data' => $marca ? sprintf('%d - %s', $marca->getCodMarca(), $marca->getDescricao()) : 0,
                'attr' => [
                    'readonly' => 'readonly',
                    'type' => 'text',
                ],
                'label' => 'label.almoxarifado.marca',
            ];

            $fieldOptions['centroCusto'] = [
                'mapped' => false,
                'data' => $centroCusto ? sprintf('%d - %s', $centroCusto->getCodCentro(), $centroCusto->getDescricao()) : 0,
                'attr' => [
                    'readonly' => 'readonly',
                    'type' => 'text',
                ],
                'label' => 'label.almoxarifado.codCentro',
            ];
        }

        if ($requisicaoItemExists
            && $requisicaoItem->getFkAlmoxarifadoRequisicao()->getStatus()
            && $requisicaoItem->getFkAlmoxarifadoRequisicao()->getStatus() != Requisicao::STATUS_PENDENTE_HOMOLOGACAO) {
            $fieldOptions['item']['disabled'] = true;
            $fieldOptions['marca']['disabled'] = true;
            $fieldOptions['centroCusto']['disabled'] = true;
            $fieldOptions['quantidade']['disabled'] = true;
        }

        $formMapper
            ->with('Item da Requisição')
                ->add('item', $fieldOptions['item']['attr']['type'], $fieldOptions['item'])
                ->add('marca', $fieldOptions['marca']['attr']['type'], $fieldOptions['marca'])
                ->add('centroCusto', $fieldOptions['centroCusto']['attr']['type'], $fieldOptions['centroCusto'])
                ->add('saldoEstoque', 'text', $fieldOptions['saldoEstoque'])
                ->add('quantidade', 'integer', $fieldOptions['quantidade'])
            ->end();
    }
}
