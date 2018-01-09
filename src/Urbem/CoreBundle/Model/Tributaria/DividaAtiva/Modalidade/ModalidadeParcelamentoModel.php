<?php

namespace Urbem\CoreBundle\Model\Tributaria\DividaAtiva\Modalidade;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\Entity\Divida\ModalidadeParcela;

class ModalidadeParcelamentoModel extends ModalidadeCustomModel
{
    const MODALIDADE = 3;
    const NUM_REGRA = 1;

    /**
     * AutoridadeModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager);
    }

    /**
     * @param $codModalidade
     * @param $descricao
     * @param $queryBuilder
     * @param $alias
     */
    public function findModalidades($codModalidade, $descricao, $queryBuilder, $alias)
    {
        parent::findModalidadesBusca($codModalidade, $descricao, self::MODALIDADE, $queryBuilder, $alias);
    }

    /**
     * @param $object
     * @param $request
     * @param $childrens
     */
    public function prePersist($object, $request, $childrens)
    {
        parent::prePersistCustom($object, $request, $childrens, self::MODALIDADE);
        $parcela = new ModalidadeParcela();
        $parcela->setVlrLimiteInicial($childrens['limiteValorInicial']->getViewData());
        $parcela->setVlrLimiteFinal($childrens['limiteValorFinal']->getViewData());
        $parcela->setQtdParcela((int) $childrens['quantidadeParcelas']->getViewData());
        $parcela->setVlrMinimo($childrens['valorMinimo']->getViewData());
        $parcela->setNumRegra(self::NUM_REGRA);
        $parcela->setFkDividaModalidadeVigencia($object->getFkDividaModalidadeVigencias()->last());
        $object->getFkDividaModalidadeVigencias()->last()->addFkDividaModalidadeParcelas($parcela);
    }

    /**
     * @param $object
     * @return ModalidadeParcela
     */
    protected function initAdminEditParcelas($object)
    {
        $modalidadeVigencia = $object->getFkDividaModalidadeVigencias()->current();
        $modalidadeParcelas = new ModalidadeParcela();
        if (!empty($modalidadeVigencia)) {
            if (!$modalidadeVigencia->getFkDividaModalidadeParcelas()->isEmpty()) {
                $modalidadeParcelas = $modalidadeVigencia->getFkDividaModalidadeParcelas()->current();
            }
        }
        return $modalidadeParcelas;
    }

    /**
     * @param $formMapper
     * @param $object
     * @param $label
     */
    public function formMapperParcelas($formMapper, $object, $label)
    {
        $modalidadeParcelas = $this->initAdminEditParcelas($object);
        $formMapper
            ->with($label)
            ->add(
                'limiteValorInicial',
                'text',
                [
                    'label' => 'label.dividaAtivaModalidade.limiteValorInicial',
                    'required' => true,
                    'mapped' => false,
                    'data' => $modalidadeParcelas->getVlrLimiteInicial(),
                    'attr' => [
                        'class' => 'mask-monetaria '
                    ]
                ]
            )
            ->add(
                'limiteValorFinal',
                'text',
                [
                    'label' => 'label.dividaAtivaModalidade.limiteValorFinal',
                    'required' => true,
                    'mapped' => false,
                    'data' => $modalidadeParcelas->getVlrLimiteFinal(),
                    'attr' => [
                        'class' => 'mask-monetaria '
                    ]
                ]
            )
            ->add(
                'quantidadeParcelas',
                'text',
                [
                    'label' => 'label.dividaAtivaModalidade.quantidadeParcelas',
                    'required' => true,
                    'data' => $modalidadeParcelas->getQtdParcela(),
                    'mapped' => false
                ]
            )
            ->add(
                'valorMinimo',
                'text',
                [
                    'label' => 'label.dividaAtivaModalidade.valorMinimo',
                    'required' => true,
                    'mapped' => false,
                    'data' => $modalidadeParcelas->getVlrMinimo(),
                    'attr' => [
                        'class' => 'mask-monetaria '
                    ]
                ]
            )
            ->end()
        ;
    }

    /**
     * @param $showMapper
     * @param $object
     * @param $label
     * @param $translator
     * @return bool
     */
    public function showFieldsParcelas($showMapper, $object, $label, $translator, $title)
    {
        $modalidadeVigencia = $object->getFkDividaModalidadeVigencias()->current();
        if ($modalidadeVigencia->getFkDividaModalidadeParcelas()->isEmpty()) {
            return false;
        }

        $parcela = $modalidadeVigencia->getFkDividaModalidadeParcelas()->current();
        $parcelasArray = new ArrayCollection();
        $parcelasArray->add(
            [
                $parcela->getVlrLimiteInicial(),
                $parcela->getVlrLimiteFinal(),
                $parcela->getQtdParcela(),
                $parcela->getVlrMinimo()
            ]
        );

        $this->buildShowFieldsTable(
            $showMapper,
            'parcelas',
            $label,
            [
                $translator->transChoice('label.dividaAtivaModalidade.limiteValorInicial', 0, [], 'messages'),
                $translator->transChoice('label.dividaAtivaModalidade.limiteValorFinal', 0, [], 'messages'),
                $translator->transChoice('label.dividaAtivaModalidade.quantidadeParcelas', 0, [], 'messages'),
                $translator->transChoice('label.dividaAtivaModalidade.valorMinimo', 0, [], 'messages')
            ],
            $parcelasArray,
            $translator->transChoice($title, 0, [], 'messages')
        );
    }
}
