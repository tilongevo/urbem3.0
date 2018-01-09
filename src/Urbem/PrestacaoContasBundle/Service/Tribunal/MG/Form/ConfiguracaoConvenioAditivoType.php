<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;
use Urbem\CoreBundle\Entity\Tcemg\ConvenioAditivo;
use Urbem\CoreBundle\Form\Type\CurrencyType;
use Urbem\PrestacaoContasBundle\Form\Type\DatePickerType;

class ConfiguracaoConvenioAditivoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConvenio.php:339 */
        $builder->add('descricao', TextType::class, [
           'label' => 'Descrição da Alteração do Aditivo',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConvenio.php:348 */
        $builder->add('dataAssinatura', DatePickerType::class, [
            'label' => 'Data da Assinatura',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConvenio.php:355 */
        $builder->add('dataFinal', DatePickerType::class, [
            'label' => 'Nova Data do Final da Vigência',
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConvenio.php:363 */
        $builder->add('vlConvenio', CurrencyType::class, [
            'label' => 'Novo Valor do Convênio',
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConvenio.php:372 */
        $builder->add('vlContra', CurrencyType::class, [
            'label' => 'Novo Valor de Contra Partida',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', ConvenioAditivo::class);
    }
}