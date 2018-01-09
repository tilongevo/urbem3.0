<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;
use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Entity\Tcemg\Convenio;
use Urbem\CoreBundle\Form\Type\CurrencyType;
use Urbem\CoreBundle\Form\Type\EntidadeType;
use Urbem\PrestacaoContasBundle\Form\Type\DatePickerType;
use Urbem\PrestacaoContasBundle\Form\Type\ObjetoType;

class ConfiguracaoConvenioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConvenio.php:85 */
        $builder->add('fkOrcamentoEntidade', EntidadeType::class, [
            'exercicio' => $options['exercicio'],
            'usuario' => $options['usuario'],
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConvenio.php:85 */
        $builder->add('fkComprasObjeto', ObjetoType::class, [
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConvenio.php:135 */
        $builder->add('dataAssinatura', DatePickerType::class, [
            'label' => 'Data da Assinatura',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConvenio.php:175 */
        $builder->add('dataInicio', DatePickerType::class, [
            'label' => 'Data de Início de Execução',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConvenio.php:146 */
        $builder->add('dataFinal', DatePickerType::class, [
            'label' => 'Data do Final da Vigência',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConvenio.php:156 */
        $builder->add('vlConvenio', CurrencyType::class, [
            'label' => 'Valor do Convênio',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConvenio.php:166 */
        $builder->add('vlContraPartida', CurrencyType::class, [
            'label' => 'Valor de Contra Partida',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        $builder->add('fkTcemgConvenioParticipantes', CollectionType::class, [
            'entry_type'   => ConfiguracaoConvenioParticipanteType::class,
            'allow_add'    => true,
            'allow_delete' => true,
        ]);

        $builder->add('fkTcemgConvenioEmpenhos', CollectionType::class, [
            'entry_type'   => ConfiguracaoConvenioEmpenhoType::class,
            'allow_add'    => true,
            'allow_delete' => true,
        ]);

        $builder->add('fkTcemgConvenioAditivos', CollectionType::class, [
            'entry_type'   => ConfiguracaoConvenioAditivoType::class,
            'allow_add'    => true,
            'allow_delete' => true,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', Convenio::class);
        $resolver->setRequired(['exercicio', 'usuario']);
        $resolver->setAllowedTypes('usuario', Usuario::class);
    }
}