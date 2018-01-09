<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form\RegistroPrecos;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\Tcemg\ItemRegistroPrecos;
use Urbem\CoreBundle\Entity\Tcemg\LoteRegistroPrecos;
use Urbem\CoreBundle\Entity\Tcemg\RegistroPrecos;
use Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosLicitacao;
use Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosOrgao;
use Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosOrgaoItem;
use Urbem\CoreBundle\Form\Type\EntidadeType;
use Urbem\PrestacaoContasBundle\Form\Type\DatePickerType;
use Urbem\PrestacaoContasBundle\Form\Type\SwCgmPessoaFisicaType;
use Urbem\PrestacaoContasBundle\Form\Type\SwCgmType;

class RegistroPrecosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterRegistroPreco.php:323 */
        $builder->add('fkOrcamentoEntidade', EntidadeType::class, [
            'exercicio' => $options['exercicio'],
            'usuario' => $options['usuario'],
            'required' => true,
            'attr' => ['class' => 'select2-parameters update-registro-orgao RegistroPrecosType_fkOrcamentoEntidade '],
            'constraints' => [new NotNull()]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterRegistroPreco.php:350 */
        $builder->add('numeroRegistroPrecos', TextType::class, [
            'label' => 'Nro. do Processo de Registro de Preços',
            'required' => true,
            'attr' => ['class' => 'update-registro-orgao RegistroPrecosType_numeroRegistroPrecos '],
            'constraints' => [new NotNull(), new Length(['min' => 1, 'max' => 12])]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterRegistroPreco.php:364 */
        $builder->add('interno', ChoiceType::class, [
            'placeholder' => 'Selecione',
            'label' => 'Tipo de Registro de Preço',
            'choices' => [
                'Interno' => 1,
                'Externo' => 2,
            ],
            'attr' => ['class' => 'select2-parameters update-registro-orgao RegistroPrecosType_interno '],
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterRegistroPreco.php:390 */
        $builder->add('dataAberturaRegistroPrecos', DatePickerType::class, [
            'label' => 'Data de abertura do processo',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterRegistroPreco.php:398 */
        $builder->add('fkSwCgm', SwCgmType::class, [
            'label' => 'CGM do Orgão Gerenciador',
            'attr' => ['class' => 'select2-parameters update-registro-orgao RegistroPrecosType_fkSwCgm '],
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterRegistroPreco.php:425 */
        $builder->add('exercicioLicitacao', TextType::class, [
            'label' => 'Exercício do Processo de Licitação',
            'required' => true,
            'constraints' => [new NotNull(), new Length(4)]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterRegistroPreco.php:435 */
        $builder->add('codigoModalidadeLicitacao', ChoiceType::class, [
            'placeholder' => 'Selecione',
            'label' => 'Modalidade da Licitação',
            'choices' => [
                'Concorrência' => 1,
                'Pregão' => 2,
            ],
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterRegistroPreco.php:462 */
        $builder->add('numeroModalidade', TextType::class, [
            'label' => 'Nro. da Modalidade',
            'required' => true,
            'constraints' => [new NotNull(), new Length(['min' => 1, 'max' => 10])]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterRegistroPreco.php:415 */
        $builder->add('numeroProcessoLicitacao', TextType::class, [
            'label' => 'Nro. do Processo de Licitação',
            'required' => true,
            'constraints' => [new NotNull(), new Length(['min' => 1, 'max' => 12])]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterRegistroPreco.php:471 */
        $builder->add('dataAtaRegistroPreco', DatePickerType::class, [
            'label' => 'Data da Ata',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterRegistroPreco.php:479 */
        $builder->add('dataAtaRegistroPrecoValidade', DatePickerType::class, [
            'label' => 'Data de Validade da Ata',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterRegistroPreco.php:487 */
        $builder->add('objeto', TextType::class, [
            'label' => 'Objeto',
            'required' => true,
            'constraints' => [new NotNull(), new Length(['min' => 1, 'max' => 500])]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterRegistroPreco.php:496 */
        $builder->add('fkSwCgmPessoaFisica', SwCgmPessoaFisicaType::class, [
            'label' => 'CGM Responsável pelo Detalhamento',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterRegistroPreco.php:509 */
        $builder->add('descontoTabela', ChoiceType::class, [
            'placeholder' => 'Selecione',
            'label' => 'Desconto Tabela',
            'choices' => [
                'Sim' => 1,
                'Não' => 2,
            ],
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterRegistroPreco.php:533 */
        $builder->add('processoLote', ChoiceType::class, [
            'placeholder' => 'Selecione',
            'label' => 'Processo por Lote',
            'choices' => [
                'Sim' => RegistroPrecos::PROCESSO_LOTE_SIM,
                'Não' => RegistroPrecos::PROCESSO_LOTE_NAO,
            ],
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        $addFkTcemgRegistroPrecosLicitacoes = function (FormEvent $event) {
            $form = $event->getForm();

            /** @var RegistroPrecos $registroPrecos */
            $registroPrecos = $event->getData();

            /* necessário ao menos 1 item */
            if (true === $registroPrecos instanceof RegistroPrecos && 0 === $registroPrecos->getFkTcemgRegistroPrecosLicitacoes()->count()) {
                $registroPrecos->addFkTcemgRegistroPrecosLicitacoes(new RegistroPrecosLicitacao());
            }

            $form->add('fkTcemgRegistroPrecosLicitacoes', CollectionType::class, [
                'entry_type' => RegistroPrecosLicitacaoType::class,
                'prototype' => false,
                'allow_add' => false,
                'allow_delete' => false,
            ]);
        };

        $builder->addEventListener(FormEvents::PRE_SET_DATA, $addFkTcemgRegistroPrecosLicitacoes);
        $builder->addEventListener(FormEvents::PRE_SUBMIT, $addFkTcemgRegistroPrecosLicitacoes);

        $builder->add('fkTcemgRegistroPrecosOrgoes', CollectionType::class, [
            'entry_type' => RegistroPrecosOrgaoType::class,
            'allow_add' => true,
            'allow_delete' => true,
            'entry_options' => [
                'exercicio' => $options['exercicio']
            ]
        ]);

        $builder->add('fkTcemgEmpenhoRegistroPrecos', CollectionType::class, [
            'entry_type' => EmpenhoRegistroPrecosType::class,
            'allow_add' => true,
            'allow_delete' => true,
            'entry_options' => [
                'exercicio' => $options['exercicio'],
            ]
        ]);

        $addFkTcemgLoteRegistroPrecos = function (FormEvent $event) {
            $form = $event->getForm();

            /** @var RegistroPrecos $registroPrecos */
            $registroPrecos = $event->getData();

            /* necessário ao menos 1 item */
            if (true === $registroPrecos instanceof RegistroPrecos && 0 === $registroPrecos->getFkTcemgLoteRegistroPrecos()->count()) {
                $registroPrecos->addFkTcemgLoteRegistroPrecos(new LoteRegistroPrecos());
            }

            $form->add('fkTcemgLoteRegistroPrecos', CollectionType::class, [
                'entry_type' => LoteRegistroPrecosType::class,
                'prototype' => false,
                'allow_add' => false,
                'allow_delete' => false,
                'entry_options' => [
                    'registroPrecos' => $event->getData()
                ]
            ]);
        };

        $builder->addEventListener(FormEvents::PRE_SET_DATA, $addFkTcemgLoteRegistroPrecos);
        $builder->addEventListener(FormEvents::PRE_SUBMIT, $addFkTcemgLoteRegistroPrecos);

        /* Quantitativos por Orgão */
        $addRegistroPrecosOrgaoItemType = function (FormEvent $event) {
            $form = $event->getForm();

            $registroPrecos = $event->getData();

            $form->add('fkTcemgRegistroPrecosOrgaoItens', CollectionType::class, [
                'mapped' => false,
                'entry_type' => RegistroPrecosOrgaoItemType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'entry_options' => [
                    'registroPrecos' => $registroPrecos
                ]
            ]);
        };

        $builder->addEventListener(FormEvents::PRE_SET_DATA, $addRegistroPrecosOrgaoItemType);
        $builder->addEventListener(FormEvents::PRE_SUBMIT, $addRegistroPrecosOrgaoItemType);

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            /** @var RegistroPrecos $registroPrecos */
            $registroPrecos = $event->getData();

            /* fix foreign key */
            $fkTcemgRegistroPrecosLicitacao = $registroPrecos->getFkTcemgRegistroPrecosLicitacoes()->first();
            if (null !== $fkTcemgRegistroPrecosLicitacao) {
                $registroPrecos->removeFkTcemgRegistroPrecosLicitacoes($fkTcemgRegistroPrecosLicitacao);
                $registroPrecos->addFkTcemgRegistroPrecosLicitacoes($fkTcemgRegistroPrecosLicitacao);
            }

            /* fix foreign key */
            $fkTcemgEmpenhoRegistroPreco = $registroPrecos->getFkTcemgEmpenhoRegistroPrecos()->first();
            if (null !== $fkTcemgEmpenhoRegistroPreco) {
                $registroPrecos->removeFkTcemgEmpenhoRegistroPrecos($fkTcemgEmpenhoRegistroPreco);
                $registroPrecos->addFkTcemgEmpenhoRegistroPrecos($fkTcemgEmpenhoRegistroPreco);
            }

            /** @var LoteRegistroPrecos $fkTcemgLoteRegistroPrecos */
            $fkTcemgLoteRegistroPrecos = $registroPrecos->getFkTcemgLoteRegistroPrecos()->first();

            /* fix foreign key */
            $registroPrecos->removeFkTcemgLoteRegistroPrecos($fkTcemgLoteRegistroPrecos);
            $registroPrecos->addFkTcemgLoteRegistroPrecos($fkTcemgLoteRegistroPrecos);

            /** @var RegistroPrecosOrgaoItem $fkTcemgRegistroPrecosOrgaoItem */
            foreach ($event->getForm()
                         ->get('fkTcemgRegistroPrecosOrgaoItens')
                         ->getData() as $fkTcemgRegistroPrecosOrgaoItem) {

                /** @var RegistroPrecosOrgao $registroPrecosOrgao */
                foreach ($registroPrecos->getFkTcemgRegistroPrecosOrgoes() as $registroPrecosOrgao) {
                    /* fix foreign key */
                    $registroPrecos->removeFkTcemgRegistroPrecosOrgoes($registroPrecosOrgao);
                    $registroPrecos->addFkTcemgRegistroPrecosOrgoes($registroPrecosOrgao);

                    foreach ($registroPrecosOrgao->getFkTcemgRegistroPrecosOrgaoItens() as $item) {
                        $registroPrecosOrgao->removeFkTcemgRegistroPrecosOrgaoItens($item);
                    }

                    if ((int) $registroPrecosOrgao->getNumOrgao() === (int) $fkTcemgRegistroPrecosOrgaoItem->getNumOrgao() &&
                        (int) $registroPrecosOrgao->getNumUnidade() === (int) $fkTcemgRegistroPrecosOrgaoItem->getNumUnidade()) {

                        /** @var ItemRegistroPrecos $itemRegistroPreco */
                        foreach ($fkTcemgLoteRegistroPrecos->getFkTcemgItemRegistroPrecos() as $itemRegistroPreco) {

                            /* fix foreign key */
                            $fkTcemgLoteRegistroPrecos->removeFkTcemgItemRegistroPrecos($itemRegistroPreco);
                            $fkTcemgLoteRegistroPrecos->addFkTcemgItemRegistroPrecos($itemRegistroPreco);

                            if ((int) $itemRegistroPreco->getCodItem() === (int) $fkTcemgRegistroPrecosOrgaoItem->getCodItem() &&
                                (int) $itemRegistroPreco->getCgmFornecedor() === (int) $fkTcemgRegistroPrecosOrgaoItem->getCgmFornecedor()) {

                                $fkTcemgRegistroPrecosOrgaoItem->setFkTcemgItemRegistroPrecos($itemRegistroPreco);
                                break;
                            }
                        }

                        $registroPrecosOrgao->addFkTcemgRegistroPrecosOrgaoItens($fkTcemgRegistroPrecosOrgaoItem);
                    }
                }
            }
        });
    }

    /**
     * @param $registroPrecos
     * @return Entidade
     */
    private function getFkOrcamentoEntidade($registroPrecos)
    {
        /** @var $registroPrecos RegistroPrecos|array */
        if (true === $registroPrecos instanceof RegistroPrecos) {
            $fkOrcamentoEntidade = $registroPrecos->getFkOrcamentoEntidade();

        } else {
            $fkOrcamentoEntidade = true === is_array($registroPrecos) && true === array_key_exists('fkOrcamentoEntidade', $registroPrecos) ? $registroPrecos['fkOrcamentoEntidade'] : new Entidade();
        }

        if (false === $fkOrcamentoEntidade instanceof Entidade) {
            $fkOrcamentoEntidade = new Entidade();
        }

        return $fkOrcamentoEntidade;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', RegistroPrecos::class);
        $resolver->setRequired('usuario');
        $resolver->setRequired('exercicio');
    }
}