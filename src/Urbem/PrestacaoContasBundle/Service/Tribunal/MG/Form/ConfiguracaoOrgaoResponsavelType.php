<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotNull;
use Urbem\CoreBundle\Entity\SwUf;
use Urbem\CoreBundle\Form\Type\AutoCompleteType;

class ConfiguracaoOrgaoResponsavelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConfiguracaoOrgao.php:193 */
        $builder->add('inNumCGM', AutoCompleteType::class, [
            'label' => 'CGM Responsável',
            'json_from_admin_code' => 'core.admin.filter.sw_cgm',
            'attr' => ['class' => 'select2-parameters '],
            'route' => [
                'name' => AutoCompleteType::ROUTE_AUTOCOMPLETE_DEFAULT,
                'parameters' => [
                    'json_from_admin_field' => 'autocomplete_field'
                ]
            ],
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConfiguracaoOrgao.php:201 */
        $builder->add('inTipoResponsavel', ChoiceType::class, [
            'label' => 'Tipo Responsável',
            'attr' => ['class' => 'select2-parameters '],
            /* nao ha local para cadastrar esta informacao */
            /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConfiguracaoOrgao.php:204 */
            'choices' => [
                'Gestor' => 1,
                'Contador' => 2,
                'Controle Interno' => 3,
                'Ordernador de Despesa por Delação' => 4,
                'Informações - Folha de Pagamento' => 5
            ],
            'placeholder' => 'Selecione',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConfiguracaoOrgao.php:214 */
        $builder->add('stCargoGestor', TextType::class, [
            'label' => 'Cargo',
            'required' => false,
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterConfiguracaoOrgao.php:151 */
        $builder->add('stCRCContador', TextType::class, [
            'label' => 'CRC',
            'required' => false,
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterConfiguracaoOrgao.php:162 */
        $builder->add('stSiglaUF', EntityType::class, [
            'label' => 'UF CRC',
            'class' => SwUf::class,

            /* @see src/Urbem/PrestacaoContasBundle/Service/Tribunal/MG/Configuracao/ConfiguracaoOrgao.php::buildServiceProvider */
            'choice_value' => function (SwUf $swUf = null) {
                return null === $swUf ? null : $swUf->getSiglaUf();
            },
            'required' => false,
            'attr' => ['class' => 'select2-parameters '],
            'query_builder' => function (EntityRepository $repo) {
                return $repo->createQueryBuilder('swUf')
                    ->andWhere('swUf.codPais = 1')
                    ->orderBy('swUf.nomUf');
            }
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterConfiguracaoOrgao.php:220 */
        $builder->add('dtInicio', 'prestacao_contas_date_picker', [
            'label' => 'Data de Início',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterConfiguracaoOrgao.php:225 */
        $builder->add('dtFim', 'prestacao_contas_date_picker', [
            'label' => 'Data de Término',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterConfiguracaoOrgao.php:231 */
        $builder->add('stEMail', TextType::class, [
            'label' => 'E-mail',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);
    }
}