<?php

namespace Urbem\TributarioBundle\Form\Economico;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type;

/**
 * Class ServicoType
 * @package Urbem\TributarioBundle\Form\Economico
 */
class ServicoType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $dtVigencia = null;
        $valor = null;
        if (array_key_exists('data', $options)) {
            $aliquota = $options['data'];
            $dtVigencia = $aliquota->getDtVigencia();
            $valor = $aliquota->getValor();
        }
        $builder
            ->add(
                'dtVigencia',
                Type\DateType::class,
                [
                    'label' => 'label.economico.servico.dataVigencia',
                    'widget' => 'single_text',
                    'attr' => [
                        'class' => 'datepicker',
                        'data-provide' => 'datepicker',
                        'data-date-format' => 'dd/mm/yyyy'
                    ],
                    'format' => 'dd/MM/yyyy',
                    'data' => $dtVigencia
                ]
            )
            ->add(
                'valor',
                Type\NumberType::class,
                [
                    'label' => 'label.economico.servico.aliquota',
                    'data' => $valor
                ]
            )
        ;
    }
}
