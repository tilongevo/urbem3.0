<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Empenho;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Urbem\CoreBundle\Entity\Administracao\UnidadeMedida;
use Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto;
use Urbem\CoreBundle\Entity\Almoxarifado\Marca;
use Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho;
use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Empenho\PreEmpenho;
use Urbem\CoreBundle\Entity\Orcamento\ReservaSaldos;
use Urbem\CoreBundle\Model\Empenho\ItemPreEmpenhoModel;
use Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

class ItemPreEmpenhoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_empenho_item_pre_empenho';
    protected $baseRoutePattern = 'financeiro/empenho/item-pre-empenho';
    protected $includeJs = array(
        '/financeiro/javascripts/empenho/pre-empenho-itens.js'
    );

    const COD_UNIDADE_PADRAO = 1;
    const COD_GRANDEZA_PADRAO = 7;

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $preEmpenhoModel = new PreEmpenhoModel($em);

        $subtrair = 0;
        if ($this->id($this->getSubject())) {
            /** @var ItemPreEmpenho $itemPreEmpenho */
            $itemPreEmpenho = $this->getSubject();
            $codPreEmpenho = $itemPreEmpenho->getCodPreEmpenho();
            $exercicio = $itemPreEmpenho->getExercicio();
            $subtrair = $itemPreEmpenho->getVlTotal();
        } else {
            $codPreEmpenho = $this->getRequest()->query->get('pre_empenho');
            $exercicio = $this->getRequest()->query->get('exercicio');
        }

        /** @var PreEmpenho $preEmpenho */
        $preEmpenho = $em->getRepository(PreEmpenho::class)->findOneBy([
            'codPreEmpenho' => $codPreEmpenho,
            'exercicio' => $exercicio
        ]);

        $dotacao = false;
        $saldoDotacao = 0.00;
        if (($preEmpenho) && ($preEmpenho->getFkEmpenhoPreEmpenhoDespesa())) {
            $dotacao = true;
            $despesa = $preEmpenho->getFkEmpenhoPreEmpenhoDespesa()->getFkOrcamentoDespesa();
            $saldoDotacao = $preEmpenhoModel->getSaldoDotacaoDataAtual(
                $despesa->getExercicio(),
                $despesa->getCodDespesa(),
                $preEmpenho->getDtAutorizacao(),
                $despesa->getCodEntidade()
            );
            $saldoDotacao -= $subtrair;
        }

        $formOptions = array();

        $formOptions['codPreEmpenho'] = array(
            'data' => $codPreEmpenho,
            'mapped' => false,
        );

        $formOptions['exercicio'] = array(
            'data' => $exercicio,
            'mapped' => false,
        );

        $formOptions['dotacao'] = array(
            'data' => $dotacao,
            'mapped' => false,
        );

        $formOptions['saldoDotacao'] = array(
            'data' => $saldoDotacao,
            'mapped' => false,
        );

        $formOptions['tipoItem'] = array(
            'label' => 'label.itemPreEmpenho.tipoItem',
            'choices' => array(
                'Não' => 'Descricao',
                'Sim' => 'Catalogo'
            ),
            'label_attr' => array(
                'class' => 'checkbox-sonata'
            ),
            'attr' => array(
                'class' => 'checkbox-sonata'
            ),
            'expanded' => true,
            'mapped' => false,
            'data' => 'Descricao'
        );

        if (($preEmpenho) && ($preEmpenho->getFkEmpenhoItemPreEmpenhos()->count())) {
            $formOptions['tipoItem']['disabled'] = true;
            $formOptions['tipoItem']['data'] = ($preEmpenho->getFkEmpenhoItemPreEmpenhos()->last()->getFkAlmoxarifadoCatalogoItem()) ? 'Catalogo' : 'Descricao';
        }

        $formOptions['fkAlmoxarifadoCatalogoItem'] = array(
            'class' => 'CoreBundle:Almoxarifado\CatalogoItem',
            'label' => 'label.itemPreEmpenho.codItem',
            'property' => 'descricao',
            'to_string_callback' => function ($catalogoItem, $property) {
                return $catalogoItem->getCodItem() . " - " . $catalogoItem->getDescricao();
            },
            'attr' => array(
                'class' => 'select2-parameters',
            ),
            'placeholder' => 'Selecione',
        );

        $formOptions['nomItem'] = array(
            'label' => 'label.itemPreEmpenho.nomItem'
        );

        $formOptions['complemento'] = array(
            'label' => 'label.itemPreEmpenho.complemento',
            'required' => false,
        );

        $formOptions['fkAlmoxarifadoMarca'] = array(
            'class' => Marca::class,
            'label' => 'label.itemPreEmpenho.codMarca',
            'callback' => function (AbstractAdmin $admin, $property, $value) {
                $datagrid = $admin->getDatagrid();
                $qb = $datagrid->getQuery();
                $qb->andWhere($qb->expr()->orX(
                    $qb->expr()->eq("{$qb->getRootAlias()}.codMarca", ':codMarca'),
                    $qb->expr()->like("LOWER({$qb->getRootAlias()}.descricao)", ':descricao')
                ));
                $qb->setParameter('descricao', sprintf('%%%s%%', strtolower($value)));
                $qb->setParameter('codMarca', (integer) $value);
            },
            'property' => 'descricao',
            'required' => false,
            'attr' => array(
                'class' => 'select2-parameters'
            )
        );

        $formOptions['fkAlmoxarifadoCentroCusto'] = array(
            'class' => CentroCusto::class,
            'label' => 'label.itemPreEmpenho.codCentro',
            'placeholder' => 'label.selecione',
            'attr' => array(
                'class' => 'select2-parameters'
            )
        );

        $formOptions['quantidade'] = array(
            'label' => 'label.itemPreEmpenho.quantidade',
            'attr' => array(
                'class' => 'quantity '
            )
        );

        /** @var UnidadeMedida $unidadeMedidaPadrao */
        $unidadeMedidaPadrao = $em->getRepository(UnidadeMedida::class)->findOneBy([
            'codUnidade' => self::COD_UNIDADE_PADRAO,
            'codGrandeza' => self::COD_GRANDEZA_PADRAO
        ]);

        $formOptions['fkAdministracaoUnidadeMedida'] = array(
            'class' => UnidadeMedida::class,
            'choice_value' => 'codigoComposto',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('o')
                    ->orderBy('o.codGrandeza', 'ASC')
                    ->addOrderBy('o.codUnidade', 'ASC');
            },
            'label' => 'label.itemPreEmpenho.codUnidade',
            'attr' => array(
                'class' => 'select2-parameters'
            ),
            'placeholder' => 'label.selecione'
        );

        $formOptions['vlUnitario'] = array(
            'label' => 'label.itemPreEmpenho.vlUnitario',
            'currency' => 'BRL',
            'mapped' => false,
            'attr' => array(
                'class' => 'money '
            ),
        );

        $formOptions['vlTotal'] = array(
            'label' => 'label.itemPreEmpenho.vlTotal',
            'currency' => 'BRL',
            'attr' => array(
                'readonly' => 'readonly',
                'class' => 'money '
            ),
        );

        if ($this->id($this->getSubject())) {
            $formOptions['vlTotal']['mapped'] = false;
            $formOptions['vlTotal']['data'] = $this->getSubject()->getVlTotal();

            if (! $this->getSubject()->getCodItem()) {
                $formOptions['tipoItem']['data'] = 'Descricao';
            } else {
                $formOptions['tipoItem']['data'] = 'Catalogo';
            }
            $formOptions['tipoItem']['disabled'] = true;
        } else {
            $formOptions['fkAdministracaoUnidadeMedida']['data'] = $unidadeMedidaPadrao;
        }

        $formMapper
            ->with('label.itemPreEmpenho.itensAutorizacao')
                ->add(
                    'codPreEmpenho',
                    'hidden',
                    $formOptions['codPreEmpenho']
                )
                ->add(
                    'exercicio',
                    'hidden',
                    $formOptions['exercicio']
                )
                ->add(
                    'dotacao',
                    'hidden',
                    $formOptions['dotacao']
                )
                ->add(
                    'saldoDotacao',
                    'hidden',
                    $formOptions['saldoDotacao']
                )
                ->add(
                    'tipoItem',
                    'choice',
                    $formOptions['tipoItem']
                )
                ->add(
                    'fkAlmoxarifadoCatalogoItem',
                    'sonata_type_model_autocomplete',
                    $formOptions['fkAlmoxarifadoCatalogoItem']
                )
                ->add(
                    'nomItem',
                    null,
                    $formOptions['nomItem']
                )
                ->add(
                    'complemento',
                    null,
                    $formOptions['complemento']
                )
                ->add(
                    'fkAlmoxarifadoMarca',
                    'sonata_type_model_autocomplete',
                    $formOptions['fkAlmoxarifadoMarca']
                )
                ->add(
                    'fkAlmoxarifadoCentroCusto',
                    null,
                    $formOptions['fkAlmoxarifadoCentroCusto']
                )
                ->add(
                    'quantidade',
                    'number',
                    $formOptions['quantidade']
                )
                ->add(
                    'fkAdministracaoUnidadeMedida',
                    null,
                    $formOptions['fkAdministracaoUnidadeMedida']
                )
                ->add(
                    'vlUnitario',
                    'money',
                    $formOptions['vlUnitario']
                )
                ->add(
                    'vlTotal',
                    'money',
                    $formOptions['vlTotal']
                )
            ->end()
        ;
    }

    /**
     * @param ItemPreEmpenho $itemPreEmpenho
     */
    public function prePersist($itemPreEmpenho)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        /** @var PreEmpenho $preEmpenho */
        $preEmpenho = $em->getRepository(PreEmpenho::class)
            ->findOneBy([
                'codPreEmpenho' => $this->getForm()->get('codPreEmpenho')->getData(),
                'exercicio' => $this->getForm()->get('exercicio')->getData()
            ]);

        if (! $this->getForm()->get('nomItem')->getData()) {
            $itemPreEmpenho->setNomItem("");
        }

        if (! $this->getForm()->get('complemento')->getData()) {
            $itemPreEmpenho->setComplemento("");
        }

        $numItem = (new ItemPreEmpenhoModel($em))->getProximoNumItem($preEmpenho->getCodPreEmpenho(), $preEmpenho->getExercicio());
        $itemPreEmpenho->setNumItem($numItem);

        if ($itemPreEmpenho->getFkAlmoxarifadoCatalogoItem()) {
            $itemPreEmpenho->setFkAdministracaoUnidadeMedida($itemPreEmpenho->getFkAlmoxarifadoCatalogoItem()->getFkAdministracaoUnidadeMedida());
        }

        if (!empty($itemPreEmpenho->getFkAdministracaoUnidadeMedida())) {
            $itemPreEmpenho->setNomUnidade($itemPreEmpenho->getFkAdministracaoUnidadeMedida()->getNomUnidade());
            $itemPreEmpenho->setSiglaUnidade($itemPreEmpenho->getFkAdministracaoUnidadeMedida()->getSimbolo());
        }

        $itemPreEmpenho->setFkEmpenhoPreEmpenho($preEmpenho);

        if ($this->getForm()->get('dotacao')->getData()) {
            /** @var ReservaSaldos $reservaSaldos */
            $reservaSaldos = $preEmpenho->getFkEmpenhoAutorizacaoEmpenhos()->last()->getFkEmpenhoAutorizacaoReserva()->getFkOrcamentoReservaSaldos();
            $reservaSaldos->setVlReserva($reservaSaldos->getVlReserva() + $itemPreEmpenho->getVlTotal());
        }
    }

    /**
     * @param ItemPreEmpenho $itemPreEmpenho
     */
    public function preUpdate($itemPreEmpenho)
    {
        /** @var PreEmpenho $preEmpenho */
        $preEmpenho = $itemPreEmpenho->getFkEmpenhoPreEmpenho();

        if (! $this->getForm()->get('nomItem')->getData()) {
            $itemPreEmpenho->setNomItem("");
        }

        if (! $this->getForm()->get('complemento')->getData()) {
            $itemPreEmpenho->setComplemento("");
        }

        if ($itemPreEmpenho->getFkAlmoxarifadoCatalogoItem()) {
            $itemPreEmpenho->setFkAdministracaoUnidadeMedida($itemPreEmpenho->getFkAlmoxarifadoCatalogoItem()->getFkAdministracaoUnidadeMedida());
        }

        if (!empty($itemPreEmpenho->getFkAdministracaoUnidadeMedida())) {
            $itemPreEmpenho->setNomUnidade($itemPreEmpenho->getFkAdministracaoUnidadeMedida()->getNomUnidade());
            $itemPreEmpenho->setSiglaUnidade($itemPreEmpenho->getFkAdministracaoUnidadeMedida()->getSimbolo());
        }

        if ($this->getForm()->get('dotacao')->getData()) {
            /** @var ReservaSaldos $reservaSaldos */
            $reservaSaldos = $preEmpenho->getFkEmpenhoAutorizacaoEmpenhos()->last()->getFkEmpenhoAutorizacaoReserva()->getFkOrcamentoReservaSaldos();
            $reservaSaldos->setVlReserva(($reservaSaldos->getVlReserva() - $itemPreEmpenho->getVlTotal()) + $this->getForm()->get('vlTotal')->getData());
        }

        $itemPreEmpenho->setVlTotal($this->getForm()->get('vlTotal')->getData());
    }

    /**
     * @param ItemPreEmpenho $itemPreEmpenho
     */
    public function postPersist($itemPreEmpenho)
    {
        $this->redirectAutorizacao($itemPreEmpenho);
    }

    /**
     * @param ItemPreEmpenho $itemPreEmpenho
     */
    public function postUpdate($itemPreEmpenho)
    {
        $this->redirectAutorizacao($itemPreEmpenho);
    }

    /**
     * @param ItemPreEmpenho $itemPreEmpenho
     */
    public function postRemove($itemPreEmpenho)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        /** @var PreEmpenho $preEmpenho */
        $preEmpenho = $itemPreEmpenho->getFkEmpenhoPreEmpenho();

        if ($preEmpenho->getFkEmpenhoAutorizacaoEmpenhos()->last()->getFkEmpenhoAutorizacaoReserva()) {
            /** @var ReservaSaldos $reservaSaldos */
            $reservaSaldos = $preEmpenho->getFkEmpenhoAutorizacaoEmpenhos()->last()->getFkEmpenhoAutorizacaoReserva()->getFkOrcamentoReservaSaldos();
            $reservaSaldos->setVlReserva($reservaSaldos->getVlReserva() - $itemPreEmpenho->getVlTotal());
            $em->persist($reservaSaldos);
            $em->flush();
        }

        $this->redirectAutorizacao($itemPreEmpenho);
    }

    /**
     * @param $itemPreEmpenho
     */
    protected function redirectAutorizacao($itemPreEmpenho)
    {
        $this->forceRedirect('/financeiro/empenho/autorizacao/' . $this->getObjectKey($itemPreEmpenho->getFkEmpenhoPreEmpenho()) . '/show');
    }
}
