<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Urbem\CoreBundle\Form\Type\DynamicCollectionType;

class ConfiguracaoGestaoFiscalMedidasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('registros', DynamicCollectionType::class, [
            'dynamic_type' => ConfiguracaoGestaoFiscalMedidaType::class,
            'label' => 'Registros'
        ]);
    }
}