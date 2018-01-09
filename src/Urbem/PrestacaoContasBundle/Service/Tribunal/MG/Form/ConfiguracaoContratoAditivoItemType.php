<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;
use Urbem\CoreBundle\Entity\Tcemg\ContratoAditivoItem;
use Urbem\CoreBundle\Form\Type\Tcemg\AcrescimoDecrescimoType;

class ConfiguracaoContratoAditivoItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterAditivoContrato.php:149 */
        $builder->add('quantidade', TextType::class, [
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterAditivoContrato.php:165 */
        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterAditivoContrato.php:174 */
        if (14 === $options['codTipoAditivo'] || 11 === $options['codTipoAditivo']) {
            $builder->add('tipoAcrescDecresc', AcrescimoDecrescimoType::class, [
                'required' => true,
                'constraints' => [new NotNull()]
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', ContratoAditivoItem::class);
        $resolver->setRequired('codTipoAditivo');
        $resolver->setDefault('show_error', true);
    }
}