<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Urbem\PrestacaoContasBundle\Form\Type\DatePickerType;
use Urbem\PrestacaoContasBundle\Form\Type\PeriodicidadeType;

class ConfiguracaoContratoRescisaoFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FLRescindirContrato.php:70 */
        $builder->add('nroContrato', TextType::class, [
            'label' => 'Número do Contrato'
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FLRescindirContrato.php:78 */
        $builder->add('dataPublicacao', DatePickerType::class, [
            'label' => 'Data de Publicação'
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FLRescindirContrato.php:85 */
        $builder->add('periodicidade', PeriodicidadeType::class, [
            'label' => 'Período do Contrato'
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FLRescindirContrato.php:100 */
        $builder->add('objetoContrato', TextType::class, [
            'label' => 'Objeto do Contrato'
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FLRescindirContrato.php:108 */
        $builder->add('dataRescisao', DatePickerType::class, [
            'label' => 'Data da Rescisão'
        ]);
    }
}