<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Entity\Tcemg\Contrato;
use Urbem\CoreBundle\Entity\Tcemg\ContratoGarantia;
use Urbem\CoreBundle\Entity\Tcemg\ContratoInstrumento;
use Urbem\CoreBundle\Entity\Tcemg\ContratoModalidadeLicitacao;
use Urbem\CoreBundle\Entity\Tcemg\ContratoObjeto;
use Urbem\CoreBundle\Entity\Tcemg\ContratoTipoProcesso;
use Urbem\CoreBundle\Form\Type\CurrencyType;
use Urbem\CoreBundle\Form\Type\EntidadeType;
use Urbem\CoreBundle\Form\Type\Licitacao\VeiculosPublicidadeType;
use Urbem\CoreBundle\Form\Type\Orcamento\OrgaoType;
use Urbem\CoreBundle\Form\Type\Orcamento\UnidadeType;
use Urbem\PrestacaoContasBundle\Form\Type\DatePickerType;
use Urbem\PrestacaoContasBundle\Form\Type\SwCgmPessoaFisicaType;

class ConfiguracaoContratoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterContrato.php:118 */
        $builder->add('nroContrato', TextType::class, [
            'label' => 'Número do Contrato',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterContrato.php:248 */
        $builder->add('dataAssinatura', DatePickerType::class, [
            'label' => 'Data da Assinatura',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterContrato.php:135 */
        $builder->add('fkOrcamentoEntidade', EntidadeType::class, [
            'exercicio' => $options['exercicio'],
            'usuario' => $options['usuario'],
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterContrato.php:152 */
        $builder->add('fkOrcamentoOrgao', OrgaoType::class, [
            'exercicio' => $options['exercicio'],
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        $this->addFkOrcamentoUnidade($builder);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterContrato.php:185 */
        $builder->add('fkTcemgContratoModalidadeLicitacao', EntityType::class, [
            'class' => ContratoModalidadeLicitacao::class,
            'label' => 'Modalidade de Licitação',
            'placeholder' => 'Selecione',
            'attr' => ['class' => 'select2-parameters '],
            'query_builder' => function (EntityRepository $repository) {
                return $repository->createQueryBuilder('o')->orderBy('o.descricao', 'ASC');
            },
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterContrato.php:195 */
        $createByFkTcemgContratoModalidadeLicitacao = function (FormEvent $event) use ($builder) {
            $form = $event->getForm();
            $codModalidadeLicitacao = $this->getCodModalidadeLicitacao($event->getData());

            if (0 === $codModalidadeLicitacao) {
                return;
            }

            /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterContrato.php:298 */
            if (5 === $codModalidadeLicitacao || 6 === $codModalidadeLicitacao) {
                $this->addCodEntidadeModalidade($form, $builder);
                $this->addNumOrgaoModalidade($form, $builder);
                $this->addNumUnidadeModalidade($form, $builder, $event->getData());
            }

            /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterContrato.php:303 */
            if (3 === $codModalidadeLicitacao || 6 === $codModalidadeLicitacao) {
                $form->add('fkTcemgContratoTipoProcesso', EntityType::class, [
                    'class' => ContratoTipoProcesso::class,
                    'label' => 'Tipo de Processo',
                    'placeholder' => 'Selecione',
                    'attr' => ['class' => 'select2-parameters '],
                    'query_builder' => function (EntityRepository $repository) {
                        return $repository->createQueryBuilder('o')->orderBy('o.descricao', 'ASC');
                    },
                    'required' => true,
                    'constraints' => [new NotNull()]
                ]);
            }

            $form->add('nroProcesso', TextType::class, [
                'label' => 'Número do Processo',
                'required' => true,
                'constraints' => [new NotNull(), new Length(['min' => 0, 'max' => 5])]
            ]);

            $form->add('exercicioProcesso', TextType::class, [
                'label' => 'Exercício Processo',
                'required' => true,
                'constraints' => [new NotNull(), new Length(['min' => 0, 'max' => 4])]
            ]);
        };

        $builder->addEventListener(FormEvents::PRE_SET_DATA, $createByFkTcemgContratoModalidadeLicitacao);
        $builder->addEventListener(FormEvents::PRE_SUBMIT, $createByFkTcemgContratoModalidadeLicitacao);

        /** gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterContrato.php:200 */
        $builder->add('fkTcemgContratoObjeto', EntityType::class, [
            'class' => ContratoObjeto::class,
            'label' => 'Natureza do Objeto',
            'placeholder' => 'Selecione',
            'attr' => ['class' => 'select2-parameters '],
            'query_builder' => function (EntityRepository $repository) {
                return $repository->createQueryBuilder('o')->orderBy('o.descricao', 'ASC');
            },
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /** gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterContrato.php:223 */
        $builder->add('objetoContrato', TextareaType::class, [
            'label' => 'Objeto do Contrato',
            'required' => true,
            'constraints' => [new NotNull(), new Length(['min' => 0, 'max' => 500])]
        ]);

        /** gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterContrato.php:212 */
        $builder->add('fkTcemgContratoInstrumento', EntityType::class, [
            'class' => ContratoInstrumento::class,
            'label' => 'Tipo de Instrumento',
            'placeholder' => 'Selecione',
            'attr' => ['class' => 'select2-parameters '],
            'query_builder' => function (EntityRepository $repository) {
                return $repository->createQueryBuilder('o')->orderBy('o.descricao', 'ASC');
            },
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /** gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterContrato.php:239 */
        $builder->add('dataInicio', DatePickerType::class, [
            'label' => 'Data Início',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /** gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterContrato.php:257 */
        $builder->add('dataFinal', DatePickerType::class, [
            'label' => 'Data Final',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /** gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterContrato.php:264 */
        $builder->add('vlContrato', CurrencyType::class, [
            'label' => 'Valor do Contrato',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterContrato.php:210 */
        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterContrato.php:990 */
        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterContrato.php:321 */
        $createByFkTcemgContratoObjeto = function (FormEvent $event) {
            $form = $event->getForm();
            $codObjeto = $this->getCodObjeto($event->getData());

            if (false === (1 <= $codObjeto && 4 > $codObjeto)) {
                return;
            }

            /** gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterContrato.php:323 */
            $form->add('fornecimento', TextType::class, [
                'label' => 'Forma de Fornecimento ou Regime de Execução',
                'required' => true,
                'constraints' => [new NotNull(), new Length(['min' => 0, 'max' => 50])]
            ]);

            /** gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterContrato.php:334 */
            $form->add('pagamento', TextType::class, [
                'label' => 'Forma de Pagamento',
                'required' => true,
                'constraints' => [new NotNull(), new Length(['min' => 0, 'max' => 100])]
            ]);

            /** gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterContrato.php:347 */
            $form->add('execucao', TextType::class, [
                'label' => 'Prazo de Execução',
                'required' => true,
                'constraints' => [new NotNull(), new Length(['min' => 0, 'max' => 100])]
            ]);

            /** gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterContrato.php:360 */
            $form->add('multa', TextType::class, [
                'label' => 'Multa Rescisória',
                'required' => true,
                'constraints' => [new NotNull(), new Length(['min' => 0, 'max' => 100])]
            ]);

            /** gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterContrato.php:387 */
            $form->add('fkTcemgContratoGarantia', EntityType::class, [
                'class' => ContratoGarantia::class,
                'label' => 'Tipo de Garantia Contratual',
                'placeholder' => 'Selecione',
                'attr' => ['class' => 'select2-parameters '],
                'query_builder' => function (EntityRepository $repository) {
                    return $repository->createQueryBuilder('o')->orderBy('o.descricao', 'ASC');
                },
                'required' => true,
                'constraints' => [new NotNull()]
            ]);
        };

        $builder->addEventListener(FormEvents::PRE_SET_DATA, $createByFkTcemgContratoObjeto);
        $builder->addEventListener(FormEvents::PRE_SUBMIT, $createByFkTcemgContratoObjeto);

        /** gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterContrato.php:281 */
        $builder->add('fkSwCgmPessoaFisica', SwCgmPessoaFisicaType::class, [
            'label' => 'CGM do signatário da contratante',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /** gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterContrato.php:292 */
        $builder->add('fkLicitacaoVeiculosPublicidade', VeiculosPublicidadeType::class);

        /** gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterContrato.php:232 */
        $builder->add('dataPublicacao', DatePickerType::class, [
            'label' => 'Data de Publicação',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterContrato.php:316 */
        $builder->add('fkTcemgContratoEmpenhos', CollectionType::class, [
            'entry_type'   => ConfiguracaoContratoEmpenhoType::class,
            'allow_add'    => true,
            'allow_delete' => true,
            'entry_options' => [
                'exercicio' => $options['exercicio']
            ],
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterContrato.php:344 */
        $builder->add('fkTcemgContratoFornecedores', CollectionType::class, [
            'entry_type'   => ConfiguracaoContratoFornecedorType::class,
            'allow_add'    => true,
            'allow_delete' => true,
        ]);
    }

    private function addNumUnidadeModalidade(FormInterface $form, FormBuilderInterface $builder, $data)
    {
        if (true === $data instanceof Contrato) {
            $orgao = $data->getNumOrgaoModalidade();

        } else {
            $orgao = true === empty($data['numOrgaoModalidade']) ? null : $data['numOrgaoModalidade'];
        }

        $orgao = (int) $orgao;

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterContrato.php:233 */
        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterContrato.php:219 */
        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterContrato.php:220 */
        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterContrato.php:449 */
        $form->add(
            $builder->create('numUnidadeModalidade', UnidadeType::class, [
                'auto_initialize' => false,
                'label' => 'Unidade Modalidade	',
                'exercicio' => $form->getConfig()->getOption('exercicio'),
                'orgao' => $orgao,
                'required' => true,
                'constraints' => [new NotNull()]

            ])->addModelTransformer(new CallbackTransformer(
                // transform
                function ($unidade) {
                    if (null === $unidade) {
                        return null;
                    }

                    return $unidade->getNumUnidadeModalidade();
                },

                // reverse
                function ($unidade) {
                    return $unidade;
                }
            ))->getForm()
        );
    }

    private function addNumOrgaoModalidade(FormInterface $form, FormBuilderInterface $builder)
    {
        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterContrato.php:207 */
        $form->add(
            $builder->create('numOrgaoModalidade', OrgaoType::class, [
                'auto_initialize' => false,
                'label' => 'Orgão Modalidade',
                'exercicio' => $form->getConfig()->getOption('exercicio'),
                'required' => true,
                'constraints' => [new NotNull()]

            ])->addModelTransformer(new CallbackTransformer(
                // transform
                function ($orgao) {
                    if (null === $orgao) {
                        return null;
                    }

                    return $orgao->getNumOrgaoModalidade();
                },

                // reverse
                function ($orgao) {
                    return $orgao;
                }
            ))->getForm()
        );
    }

    private function addCodEntidadeModalidade(FormInterface $form, FormBuilderInterface $builder)
    {
        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterContrato.php:197 */
        $form->add(
            $builder->create('codEntidadeModalidade', EntidadeType::class, [
                'auto_initialize' => false,
                'label' => 'Entidade Modalidade',
                'exercicio' => $form->getConfig()->getOption('exercicio'),
                'usuario' => $form->getConfig()->getOption('usuario'),
                'required' => true,
                'constraints' => [new NotNull()]

            ])->addModelTransformer(new CallbackTransformer(
                // transform
                function ($entidade) {
                    if (null === $entidade) {
                        return null;
                    }

                    return $entidade->getCodEntidadeModalidade();
                },

                // reverse
                function ($entidade) {
                    return $entidade;
                }
            ))->getForm()
        );
    }

    private function addFkOrcamentoUnidade(FormBuilderInterface $builder)
    {
        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterContrato.php:162 */
        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterContrato.php:158 */
        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterContrato.php:159 */
        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterContrato.php:416 */
        $addFkOrcamentoUnidade = function (FormEvent $event) {
            $form = $event->getForm();
            $data = $event->getData();

            if (true === $data instanceof Contrato) {
                $orgao = $data->getFkOrcamentoOrgao();

            } else {
                $orgao = $data['fkOrcamentoOrgao'];
            }

            $form->add('fkOrcamentoUnidade', UnidadeType::class, [
                'exercicio' => $form->getConfig()->getOption('exercicio'),
                'orgao' => $orgao,
            ]);
        };

        $builder->addEventListener(FormEvents::PRE_SET_DATA, $addFkOrcamentoUnidade);
        $builder->addEventListener(FormEvents::PRE_SUBMIT, $addFkOrcamentoUnidade);
    }

    private function getCodModalidadeLicitacao($contrato)
    {
        if (true === $contrato instanceof Contrato) {
            $codModalidadeLicitacao = $contrato->getFkTcemgContratoModalidadeLicitacao();

            if (true === $codModalidadeLicitacao instanceof ContratoModalidadeLicitacao) {
                $codModalidadeLicitacao = $codModalidadeLicitacao->getCodModalidadeLicitacao();

            } else {
                $codModalidadeLicitacao = 0;
            }

        } else {
            $codModalidadeLicitacao = $contrato['fkTcemgContratoModalidadeLicitacao'];
        }

        return (int) $codModalidadeLicitacao;
    }

    private function getCodObjeto($contrato)
    {
        if (true === $contrato instanceof Contrato) {
            $codObjeto = $contrato->getFkTcemgContratoObjeto();

            if (true === $codObjeto instanceof ContratoObjeto) {
                $codObjeto = $codObjeto->getCodObjeto();

            } else {
                $codObjeto = 0;
            }

        } else {
            $codObjeto = $contrato['fkTcemgContratoObjeto'];
        }

        return (int) $codObjeto;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', Contrato::class);
        $resolver->setRequired(['exercicio', 'usuario']);
        $resolver->setAllowedTypes('usuario', Usuario::class);
    }
}