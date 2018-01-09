<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form\RegistroPrecos;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Urbem\CoreBundle\Entity\Orcamento\Orgao;
use Urbem\CoreBundle\Entity\Orcamento\Unidade;
use Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosOrgao;
use Urbem\CoreBundle\Form\Type\AutoCompleteType;
use Urbem\CoreBundle\Form\Type\Orcamento\OrgaoType;
use Urbem\PrestacaoContasBundle\Form\Type\DatePickerType;
use Urbem\PrestacaoContasBundle\Form\Type\SwCgmPessoaFisicaType;

class RegistroPrecosOrgaoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterRegistroPrecoOrgaos.php:50 */
        $addNumOrgao = function (FormEvent $event) use ($builder) {
            $form = $event->getForm();

            /** @var RegistroPrecosOrgao $registroPrecosOrgao */
            $registroPrecosOrgao = $event->getData();

            $exercicio = null;

            if (true === $registroPrecosOrgao instanceof RegistroPrecosOrgao) {
                $exercicio = $registroPrecosOrgao->getExercicioUnidade();
            }

            $form->add(
                $builder->create('numOrgao', OrgaoType::class, [
                    'auto_initialize' => false,
                    'label' => 'Orgão',
                    'exercicio' => $form->getConfig()->getOption('exercicio'),
                    'required' => true,
                    'attr' => ['class' => 'select2-parameters update-registro-orgao RegistroPrecosOrgaoType_numOrgao '],
                    'constraints' => [new NotNull()]

                ])->addModelTransformer(new CallbackTransformer(
                // transform
                    function ($numOrgao) use ($exercicio) {
                        $orgao = new Orgao();
                        $orgao->setNumOrgao($numOrgao);
                        $orgao->setExercicio($exercicio);

                        return $orgao;
                    },

                    // reverse
                    function ($numOrgao) use ($exercicio) {
                        if (null === $numOrgao) {
                            return null;
                        }

                        return $numOrgao->getNumOrgao();
                    }
                ))->getForm()
            );
        };

        $builder->addEventListener(FormEvents::PRE_SET_DATA, $addNumOrgao);
        $builder->addEventListener(FormEvents::PRE_SUBMIT, $addNumOrgao);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterRegistroPrecoOrgaos.php:50 */
        $builder->add('fkOrcamentoUnidade', AutoCompleteType::class, [
            'label' => 'Unidade',
            'class' => Unidade::class,
            'minimum_input_length' => 1,
            'route' => [
                'name' => AutoCompleteType::ROUTE_AUTOCOMPLETE_DEFAULT,
                'parameters' => [
                    'json_from_admin_field' => 'autocomplete_field_by_orgao', // UnidadeAdmin
                    'cascade_exercicio' => $options['exercicio']
                ]
            ],
            'json_from_admin_code' => 'core.admin.filter.orcamento_unidade',
            'cascade_fields' => [
                [
                    'search_column' => 'orgao',
                    'from_parent' => 'numOrgao',
                ],
            ],
            'attr' => ['class' => 'select2-parameters update-registro-orgao RegistroPrecosOrgaoType_fkOrcamentoUnidade '],
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterRegistroPrecoOrgaos.php:59 */
        $builder->add('gerenciador', ChoiceType::class, [
            'placeholder' => 'Selecione',
            'label' => 'Orgão Gerenciador',
            'choices' => [
                'Sim' => 1,
                'Não' => 2
            ],
            'attr' => ['class' => 'select2-parameters '],
            'required' => 'true',
            'constraints' => [new NotNull()]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterRegistroPrecoOrgaos.php:74 */
        $builder->add('participante', ChoiceType::class, [
            'placeholder' => 'Selecione',
            'label' => 'Natureza do Procedimento',
            'choices' => [
                'Órgão Participante' => 1,
                'Órgão Não Participante' => 2
            ],
            'attr' => ['class' => 'select2-parameters '],
            'required' => 'true',
            'constraints' => [new NotNull()]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterRegistroPrecoOrgaos.php:92 */
        $builder->add('fkSwCgmPessoaFisica', SwCgmPessoaFisicaType::class, [
            'label' => 'CGM do Responsável pela Aprovação',
            'required' => 'true',
            'constraints' => [new NotNull()]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterRegistroPrecoOrgaos.php:102 */
        $builder->add('numeroProcessoAdesao', TextType::class, [
            'label' => 'Nro. do Processo de Adesão',
            'required' => 'true',
            'constraints' => [new NotNull(), new Length(['min' => 1, 'max' => 12])],
            'attr' => ['class' => 'update-registro-orgao'],
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterRegistroPrecoOrgaos.php:110 */
        $builder->add('exercicioAdesao', TextType::class, [
            'label' => 'Exercício do Processo de Adesão',
            'required' => 'true',
            'constraints' => [new NotNull(), new Length(4)]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterRegistroPrecoOrgaos.php:126 */
        $builder->add('dtAdesao', DatePickerType::class, [
            'label' => 'Exercício do Processo de Adesão',
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterRegistroPrecoOrgaos.php:119 */
        $builder->add('dtPublicacaoAvisoIntencao', DatePickerType::class, [
            'label' => 'Data de Publicação do Aviso de Intenção',
        ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', RegistroPrecosOrgao::class);
        $resolver->setRequired('exercicio');
    }
}