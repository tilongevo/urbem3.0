<?php

namespace Urbem\RecursosHumanosBundle\Form\FolhaPagamento;

use Doctrine\ORM\EntityManager;
use Sonata\DoctrineORMAdminBundle\Admin\FieldDescription;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;
use Urbem\CoreBundle\Entity\Administracao\Configuracao;
use Urbem\CoreBundle\Entity\Folhapagamento\ConcessaoDecimo;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ConcessaoDecimoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $options['em'];
        $configuracaoModel = new ConfiguracaoModel($entityManager);
        $inMesCalculoDecimo = (int) $configuracaoModel->getConfiguracao(
            'mes_calculo_decimo',
            27,
            true
        );

        $valorPercentagem = 0;

        /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
        $periodoMovimentacao = new PeriodoMovimentacaoModel($entityManager);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);
        $inMesCompetencia = (int) $periodoFinal->getDtFinal()->format('m');

        $rsConcessaoDecimo = $entityManager->getRepository(ConcessaoDecimo::class)->findOneBy(
            ['desdobramento' => 'D']
        );

        $desdobramentoArray = [];

        if ($inMesCompetencia == $inMesCalculoDecimo) {
            $desdobramentoArray = ['D'];
        }
        if ($inMesCompetencia >= 1 and $inMesCompetencia < $inMesCalculoDecimo) {
//            $stJs .= gerarSpanPercentualAdiantamento();
            $desdobramentoArray = ['A'];
            $valorPercentagem = 50;
        }
        if ($inMesCompetencia == 12 and (!empty($rsConcessaoDecimo))) {
            $desdobramentoArray = ['C'];
        }

        $builder
            ->add(
                'desdobramento',
                ChoiceType::class,
                array(
                    'choices' => array(
                        'Complementação de 13º Salário' => 'C',
                        'Saldo de 13º Salário ' => 'D',
                        'Adiantamento de 13º Salário' => 'A',
                    ),
                    'choice_attr' => function ($desdobramento, $key, $index) use ($desdobramentoArray) {
                        if ($index == $desdobramentoArray[0]) {
                            return [
                                'disabled' => false
                            ];
                        } else {
                            return [
                                'disabled' => true
                            ];
                        }
                    },
                    'expanded' => false,
                    'multiple' => false,
                    "label" => "Desdobramento",
                    'placeholder' => 'label.selecione',
                )
            )
            ->add(
                'percentual',
                Type\PercentType::class,
                [
                    'attr' => [
                        'class' => 'percent ',
                        'maxlength' => 6
                    ],
                    'data' => $valorPercentagem,
                    'label' => "Percentual para Pagamento"
                ]
            )
            ->add(
                'vantagens_fixas',
                ChoiceType::class,
                array(
                    'choices' => array(
                        'Não' => false,
                        'Sim ' => true,
                    ),
                    'expanded' => true,
                    'multiple' => false,
                    "label" => "Gerar Somente Vantagens Fixas",
                    'placeholder' => 'label.selecione',
                    'label_attr' => [
                        'class' => 'checkbox-sonata'
                    ],
                    'attr' => [
                        'class' => 'checkbox-sonata'
                    ]
                )
            )
            ->add(
                'folha_salario',
                ChoiceType::class,
                array(
                    'choices' => array(
                        '13º Salário ' => true,
                        'Salário' => true,
                    ),
                    'expanded' => true,
                    'multiple' => false,
                    "label" => "Pagamento na Folha",
                    'placeholder' => 'label.selecione',
                    'label_attr' => [
                        'class' => 'checkbox-sonata'
                    ],
                    'attr' => [
                        'class' => 'checkbox-sonata'
                    ]
                )
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Urbem\CoreBundle\Entity\Folhapagamento\ConcessaoDecimo',
            'em' => null,
            'type' => null,
        ));
    }
}
