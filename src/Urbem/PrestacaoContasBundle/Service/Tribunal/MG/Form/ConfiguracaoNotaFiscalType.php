<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Entity\Tcemg\NotaFiscal;
use Urbem\CoreBundle\Entity\Tcemg\TipoNotaFiscal;
use Urbem\CoreBundle\Form\Type\CurrencyType;
use Urbem\CoreBundle\Form\Type\EntidadeType;
use Urbem\PrestacaoContasBundle\Form\Type\DatePickerType;

class ConfiguracaoNotaFiscalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterNotasFiscais.php:122 */
        $builder->add('fkTcemgTipoNotaFiscal', EntityType::class, [
            'label' => 'Tipo Docto Fiscal',
            'placeholder' => 'Selecione',
            'class' => TipoNotaFiscal::class,
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterNotasFiscais.php:110 */
        $builder->add('fkOrcamentoEntidade', EntidadeType::class, [
            'exercicio' => $options['exercicio'],
            'usuario' => $options['usuario'],
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterNotasFiscais.php:181 */
        $builder->add('inscricaoMunicipal', TextType::class, [
            'label' => 'Inscrição Municipal',
            'required' => false,
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterNotasFiscais.php:192 */
        $builder->add('inscricaoEstadual', TextType::class, [
            'label' => 'Inscrição Estadual',
            'required' => false,
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterNotasFiscais.php:147 */
        $builder->add('aidf', TextType::class, [
            'label' => 'Número da AIDF',
            'required' => false,
            'constraints' => [new Length(['min' => 0, 'max' => 15])]
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterNotasFiscais.php:158 */
        $builder->add('dataEmissao', DatePickerType::class, [
            'label' => 'Data de Emissão',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterNotasFiscais.php:135 */
        $builder->add('nroNota', TextType::class, [
            'label' => 'Número do Docto Fiscal',
            'required' => false
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterNotasFiscais.php:135 */
        $builder->add('nroSerie', TextType::class, [
            'label' => 'Série do Docto Fiscal',
            'required' => false
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterNotasFiscais.php:135 */
        $builder->add('chaveAcesso', TextType::class, [
            'label' => 'Chave de Acesso',
            'required' => false
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterNotasFiscais.php:135 */
        $builder->add('chaveAcessoMunicipal', TextType::class, [
            'label' => 'Chave de Acesso Municipal',
            'required' => false
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterNotasFiscais.php:253 */
        $builder->add('vlTotal', CurrencyType::class, [
            'label' => 'Valor Total Docto Fiscal',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterNotasFiscais.php:264 */
        $builder->add('vlDesconto', CurrencyType::class, [
            'label' => 'Valor Desconto Docto Fiscal',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterNotasFiscais.php:275 */
        $builder->add('vlTotalLiquido', CurrencyType::class, [
            'label' => 'Valor Liquido Docto Fiscal',
            'attr' => ['disabled' => 'disabled']
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterNotasFiscais.php:703 */
        $builder->add('fkTcemgNotaFiscalEmpenhoLiquidacoes', CollectionType::class, [
            'entry_type'   => ConfiguracaoNotaFiscalEmpenhoLiquidacaoType::class,
            'allow_add'    => true,
            'allow_delete' => true,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', NotaFiscal::class);
        $resolver->setRequired(['exercicio', 'usuario']);
        $resolver->setAllowedTypes('usuario', Usuario::class);
    }
}