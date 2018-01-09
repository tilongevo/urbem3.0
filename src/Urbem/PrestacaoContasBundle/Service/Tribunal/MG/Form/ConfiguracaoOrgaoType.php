<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotNull;
use Urbem\CoreBundle\Entity\Tcemg\Orgao;
use Urbem\CoreBundle\Form\Type\DynamicCollectionType;
use Urbem\PrestacaoContasBundle\Form\Type\EntidadeType;

class ConfiguracaoOrgaoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConfiguracaoOrgao.php:86 */
        $builder->add('inCodEntidade', EntidadeType::class, [
            'placeholder' => 'Selecione',
            'label' => 'Entidade',
            'fix_option_value' => true,
            'attr' => ['class' => 'select2-parameters '],
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConfiguracaoOrgao.php:163 */
        $builder->add('inCodigo', TextType::class, ['label' => 'Orgão']);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConfiguracaoOrgao.php:179 */
        $builder->add('inNumUnidade', EntityType::class, [
            'label' => 'Tipo Orgão',
            'class' => Orgao::class,
            'placeholder' => 'Selecione',
            'required' => false
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConfiguracaoOrgao.php:188 */
        $builder->add('responsaveis', DynamicCollectionType::class, [
            'dynamic_type' => ConfiguracaoOrgaoResponsavelType::class,
            'label' => 'Responsáveis'
        ]);
    }
}