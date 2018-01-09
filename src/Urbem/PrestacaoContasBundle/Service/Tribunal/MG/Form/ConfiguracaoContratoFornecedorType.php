<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;
use Urbem\CoreBundle\Entity\Tcemg\ContratoFornecedor;
use Urbem\CoreBundle\Form\Type\Compras\FornecedorType;
use Urbem\PrestacaoContasBundle\Form\Type\SwCgmPessoaFisicaType;

class ConfiguracaoContratoFornecedorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fkComprasFornecedor', FornecedorType::class, [
            'label' => 'Fornecedor',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        $builder->add('cgmFornecedor', SwCgmPessoaFisicaType::class, [
            'label' => 'CGM do Representante Legal',
            'required' => true,
            'constraints' => [new NotNull()]

        ])->addModelTransformer(new CallbackTransformer(
            // transform
            function ($swCgm) {
                if (null === $swCgm) {
                    return null;
                }

                return $swCgm->getCgmRepresentante();
            },

            // reverse
            function ($swCgm) {
                return $swCgm;
            }
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', ContratoFornecedor::class);
    }
}