<?php

namespace Urbem\CoreBundle\Model\Tributaria\DividaAtiva\Modalidade;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\Entity\Divida\FormaInscricao;

class ModalidadeInscricaoDividaModel extends ModalidadeModel
{
    const MODALIDADE = 1;
    const VALOR_TOTAL = 'valor_total';
    const VALOR_TOTAL_CREDITO = 'valor_total_credito';
    const PARCELA_INDIVIDUAL = 'parcela_individual';
    const PARCELA_INDIVIDUAL_CREDITO = 'parcela_individual_credito';

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
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getFormaInscricao()
    {
        $formaInscricoes = $this->repository->findAllFormaInscricao();
        return $this->helperArray($formaInscricoes, 'descricao', 'codFormaInscricao', false);
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function initAdmin()
    {
        $init = parent::initAdmin();
        $init->set('choiceFormaInscricao', $this->getFormaInscricao());
        return $init;
    }

    /**
     * @param $formMapper
     * @param $object
     * @param $label
     */
    public function formMapperDadosParaModalidade($formMapper, $object, $label)
    {
        parent::formMapperDadosParaModalidade($formMapper, $object, $label);
        $formMapper
            ->with($label)
                ->add(
                    'formaInscricao',
                    'choice',
                    [
                        'label' => 'label.dividaAtivaModalidade.formaInscricao',
                        'choices' => $this->getFormaInscricao(),
                        'required' => true,
                        'mapped' => false,
                        'placeholder' => 'Selecione',
                        'data' => parent::initAdminEditDadosModalidade($object)->get('formaInscricao')['data'],
                        'attr' => [
                            'class' => 'select2-parameters '
                        ],
                    ]
                )
            ->end()
        ;

        $formMapper
            ->with($label)
                ->reorder(['vigenciaDe', 'vigenciaAte', 'descricao', 'tipo', 'fundamentacaoLegal', 'formaInscricao', 'regraUtilizacaoModalidade'])
            ->end()
        ;
    }

    /**
     * @param $showMapper
     * @param $object
     * @param $label
     */
    public function showFieldsModalidade($showMapper, $object, $label)
    {
        parent::showFieldsModalidade($showMapper, $object, $label);
        $modalidadeVigencia = $object->getFkDividaModalidadeVigencias()->current();

        $descricao = null;
        if ($modalidadeVigencia->getFkDividaFormaInscricao() && $modalidadeVigencia->getFkDividaFormaInscricao()->getDescricao()) {
            $descricao = $modalidadeVigencia->getFkDividaFormaInscricao()->getDescricao();
        }

        $showMapper
            ->with($label)
                ->add(
                    'formaInscricao',
                    null,
                    [
                        'label' => 'label.dividaAtivaModalidade.formaInscricao',
                        'mapped' => false,
                        'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
                        'data' => $descricao
                    ]
                )
            ->end()
        ;

        $showMapper
            ->with($label)
                ->reorder(['codModalidade', 'vigenciaInicial', 'vigenciaFinal', 'descricao', 'fundamentacaoLegal', 'formaInscricao', 'regraUtilizacaoModalidade'])
            ->end()
        ;
    }

    /**
     * @param $object
     * @param $request
     * @param $childrens
     */
    public function prePersist($object, $request, $childrens)
    {
        parent::prePersistModel($object, $request, $childrens, self::MODALIDADE);
        $formaInscricao = $this->entityManager->getRepository(FormaInscricao::class)->find($childrens['formaInscricao']->getViewData());
        $object->getFkDividaModalidadeVigencias()->current()->setFkDividaFormaInscricao($formaInscricao);
    }
}
