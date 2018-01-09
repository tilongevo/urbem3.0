<?php

namespace Urbem\CoreBundle\Form\Type\Licitacao;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade;

class VeiculosPublicidadeType extends AbstractType
{
    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('class', VeiculosPublicidade::class);
        $resolver->setDefault('label', 'Veículo de Publicação');
        $resolver->setDefault('placeholder', 'Selecione');
        $resolver->setDefault('attr', ['class' => 'select2-parameters ']);

        $resolver->setDefault('choice_label', function (VeiculosPublicidade $veiculosPublicidade) {
            return $veiculosPublicidade->getFkLicitacaoTipoVeiculosPublicidade()->getDescricao();
        });

        $resolver->setDefault('query_builder', function (EntityRepository $repository) {
            return $repository->createQueryBuilder('o')->orderBy('o.numcgm', 'ASC');
        });
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return EntityType::class;
    }
}
