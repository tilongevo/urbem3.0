<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Urbem\PrestacaoContasBundle\Form\Type\DatePickerType;
use Urbem\PrestacaoContasBundle\Form\Type\PeriodicidadeType;

class ConfiguracaoContratoFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FLManterContrato.php:72 */
        $builder->add('nroContrato', TextType::class, [
            'label' => 'Número do Contrato'
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FLManterContrato.php:79 */
        $builder->add('dataPublicacao', DatePickerType::class, [
            'label' => 'Data de Publicação'
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FLManterContrato.php:86 */
        $builder->add('periodicidade', PeriodicidadeType::class, [
            'label' => 'Período do Contrato'
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConvenio.php:101 */
        $builder->add('objetoContrato', TextType::class, [
            'label' => 'Objeto do Contrato'
        ]);
    }
}