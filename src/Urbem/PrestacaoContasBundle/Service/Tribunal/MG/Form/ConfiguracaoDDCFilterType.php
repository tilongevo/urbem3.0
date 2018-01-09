<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotNull;
use Urbem\CoreBundle\Form\Type\MonthType;
use Urbem\PrestacaoContasBundle\Form\Type\EntidadeType;

class ConfiguracaoDDCFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FLManterConfiguracaoArquivoDDC.php:66 */
        $builder->add('entidade', EntidadeType::class, [
            'attr' => ['class' => 'select2-parameters '],
            'required' => true,
            'return_object_key' => false,
            'constraints' => [new NotNull()]
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FLManterConfiguracaoArquivoDDC.php:69 */
        $builder->add('exercicio', TextType::class, [
            'label' => 'Exercício',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FLManterConfiguracaoArquivoDDC.php:103 */
        $builder->add('mes', MonthType::class, [
            'label' => 'Mês',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);
    }
}