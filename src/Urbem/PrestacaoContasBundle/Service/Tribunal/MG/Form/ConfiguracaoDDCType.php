<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;
use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Form\Type\CurrencyType;
use Urbem\CoreBundle\Form\Type\EntidadeType;
use Urbem\CoreBundle\Form\Type\MonthType;
use Urbem\CoreBundle\Form\Type\YesNoType;
use Urbem\CoreBundle\Helper\ArrayHelper;
use Urbem\CoreBundle\Helper\MonthsHelper;
use Urbem\PrestacaoContasBundle\Form\Type\DatePickerType;
use Urbem\PrestacaoContasBundle\Form\Type\NormaType;
use Urbem\PrestacaoContasBundle\Form\Type\SwCgmType;

class ConfiguracaoDDCType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConfiguracaoArquivoDDC.php:145 */
        $builder->add('fkOrcamentoEntidade', EntidadeType::class, [
            'exercicio' => $options['exercicio'],
            'usuario' => $options['usuario'],
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConfiguracaoArquivoDDC.php:145 */
        $builder->add('mesReferencia', MonthType::class, [
            'label' => 'Mês de configurações para Dados da Dívida Consolidada',
            'required' => true,
            'choices' => ArrayHelper::parseInvertArrayToChoice(MonthsHelper::$monthList, true, true),
            'constraints' => [new NotNull()]
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConfiguracaoArquivoDDC.php:159 */
        $builder->add('fkNormasNorma', NormaType::class, [
            'label' => 'Lei de Autorização',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConfiguracaoArquivoDDC.php:168 */
        $builder->add('nroContratoDivida', TextType::class, [
            'label' => 'Número do Contrato',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConfiguracaoArquivoDDC.php:189 */
        $builder->add('dtAssinatura', DatePickerType::class, [
            'label' => 'Data de Assinatura',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConfiguracaoArquivoDDC.php:201 */
        $builder->add('contratoDecLei', YesNoType::class, [
            'label' => 'Contrato decorrente de Lei de Autorização',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConfiguracaoArquivoDDC.php:215 */
        $builder->add('objetoContratoDivida', TextareaType::class, [
            'label' => 'Objeto do contrato',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConfiguracaoArquivoDDC.php:224 */
        $builder->add('especificacaoContratoDivida', TextareaType::class, [
            'label' => 'Descrição da dívida consolidada',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConfiguracaoArquivoDDC.php:233 */
        $builder->add('tipoLancamento', ChoiceType::class, [
            'label' => 'Tipo de Lançamento',
            'placeholder' => 'Selecione',
            'attr' => ['class' => 'select2-parameters '],
            'choices' => [
                'Dívida Mobiliária' => 1,
                'Dívida Contratual de PPP' => 2,
                'Demais Dívidas Contratuais Internas' => 3,
                'Dívidas Contratuais Externas' => 4,
                'Precatórios Posteriores a 05/05/2000 (inclusive) - Vencidos e não Pagos' => 5,
                'Parcelamento de Dívidas de Tributos' => 6,
                'Parcelamento de Dívidas Previdenciárias' => 7,
                'Parcelamento de Dívidas das Demais Contribuições Sociais' => 8,
                'Parcelamento de Dívidas do FGTS' => 9,
                'Outras Dívidas' => 10,
                'Passivos Reconhecidos' => 11,
            ],
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConfiguracaoArquivoDDC.php:253 */
        $builder->add('fkSwCgm', SwCgmType::class, [
            'label' => 'Credor',
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConfiguracaoArquivoDDC.php:265 */
        $builder->add('justificativaCancelamento', TextareaType::class, [
            'label' => 'Justificativa para o cancelamento da dívida',
            'required' => false
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConfiguracaoArquivoDDC.php:273 */
        $builder->add('valorSaldoAnterior', CurrencyType::class, [
            'label' => 'Valor do Saldo Anterior',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConfiguracaoArquivoDDC.php:284 */
        $builder->add('valorContratacao', CurrencyType::class, [
            'label' => 'Valor de Contratação',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConfiguracaoArquivoDDC.php:295 */
        $builder->add('valorAmortizacao', CurrencyType::class, [
            'label' => 'Valor de Amortização',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConfiguracaoArquivoDDC.php:306 */
        $builder->add('valorCancelamento', CurrencyType::class, [
            'label' => 'Valor de Cancelamento',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConfiguracaoArquivoDDC.php:317 */
        $builder->add('valorEncampacao', CurrencyType::class, [
            'label' => 'Valor de Encampação',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConfiguracaoArquivoDDC.php:328 */
        $builder->add('valorAtualizacao', CurrencyType::class, [
            'label' => 'Valor de Atualização',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConfiguracaoArquivoDDC.php:339 */
        $builder->add('valorSaldoAtual', CurrencyType::class, [
            'label' => 'Valor de Saldo Atual',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(['exercicio', 'usuario']);
        $resolver->setAllowedTypes('usuario', Usuario::class);
    }
}