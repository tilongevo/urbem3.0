<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;
use Urbem\CoreBundle\Entity\Compras\Fornecedor;
use Urbem\CoreBundle\Entity\Licitacao\TipoParticipante;
use Urbem\CoreBundle\Entity\Tcemg\ConvenioParticipante;
use Urbem\CoreBundle\Form\Type\AutoCompleteType;
use Urbem\CoreBundle\Form\Type\Compras\FornecedorType;
use Urbem\CoreBundle\Form\Type\CurrencyType;
use Urbem\CoreBundle\Form\Type\PercentType;

class ConfiguracaoConvenioParticipanteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConvenio.php:186 */
        $builder->add('fkComprasFornecedor', FornecedorType::class, [
            'label' => 'CGM',
            'attr' => ['class' => 'select2-parameters select-empenho'],
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConvenio.php:211 */
        $builder->add('fkLicitacaoTipoParticipante', EntityType::class, [
            'label' => 'Tipo de Participação',
            'class' => TipoParticipante::class,
            'query_builder' => function (EntityRepository $repository) {
                return $repository->createQueryBuilder('TipoParticipante');
            },
            'attr' => ['class' => 'select2-parameters '],
            'required' => true,
            'constraints' => [new NotNull()],
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConvenio.php:222 */
        $builder->add('vlConcedido', CurrencyType::class, [
            'label' => 'Valor de Participação',
            'required' => true,
            'constraints' => [new NotNull()],
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConvenio.php:233 */
        $builder->add('esfera', ChoiceType::class, [
            'label' => 'Esfera do Concedente',
            'choices' => [
                'Federal' => 'Federal',
                'Estadual' => 'Estadual',
                'Municipal' => 'Municipal',
            ],
            'required' => true,
            'constraints' => [new NotNull()],
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConvenio.php:251 */
        $builder->add('percentual', PercentType::class, [
            'label' => 'Percentual de Participação',
            'data' => '0.00',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', ConvenioParticipante::class);
    }
}