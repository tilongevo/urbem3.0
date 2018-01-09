<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form\RegistroPrecos;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Urbem\CoreBundle\Entity\Tcemg\ItemRegistroPrecos;
use Urbem\CoreBundle\Entity\Tcemg\LoteRegistroPrecos;
use Urbem\CoreBundle\Entity\Tcemg\RegistroPrecos;
use Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosOrgao;
use Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosOrgaoItem;
use Urbem\PrestacaoContasBundle\Form\Type\SwCgmType;

class RegistroPrecosOrgaoItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('quantidade', TextType::class, [
            'required' => 'true',
            'constraints' => [new NotNull(), new Length(['min' => 1])]
        ]);

        $builder->add(
            $builder->create('fkTcemgItemRegistroPrecos', ChoiceType::class, [
                'label' => 'Item',
                'choices' => $this->getItemRegistroPrecosFromRegistroPrecos($options['registroPrecos']),
                'choice_value' => function(ItemRegistroPrecos $item = null) {
                    if (null === $item) {
                        return null;
                    }

                    return sprintf(
                        '~%s~%s~%s~%s~%s~%s~%s~%s',
                        $item->getCodEntidade(),
                        $item->getNumeroRegistroPrecos(),
                        $item->getExercicio(),
                        $item->getCodLote(),
                        $item->getCodItem(),
                        $item->getCgmFornecedor(),
                        $item->getInterno(),
                        $item->getNumcgmGerenciador()
                    );
                },
                'choice_label' => function(ItemRegistroPrecos $item) {
                    return sprintf('ITEM %s', $item->getCodItem());
                },
                'required' => 'true',
                'attr' => ['class' => 'select2-parameters append-item-registro-preco '],
                'constraints' => [new NotNull()]

            ])->addModelTransformer(
                new CallbackTransformer(
                    function ($data) {
                        return $data;
                    },

                    function ($data) {
                        $data = true === is_string($data) ? explode('~', $data) : [];

                        if (true === empty($data)) {
                            return null;
                        }

                        list(
                            $codEntidade,
                            $numeroRegistroPrecos,
                            $exercicio,
                            $codLote,
                            $codItem,
                            $cgmFornecedor,
                            $interno,
                            $numcgmGerenciador,
                        ) = $data;

                        $itemRegistroPreco = new ItemRegistroPrecos();
                        $itemRegistroPreco->setCodEntidade($codEntidade);
                        $itemRegistroPreco->setNumeroRegistroPrecos($numeroRegistroPrecos);
                        $itemRegistroPreco->setExercicio($exercicio);
                        $itemRegistroPreco->setCodLote($codLote);
                        $itemRegistroPreco->setCodItem($codItem);
                        $itemRegistroPreco->setCgmFornecedor($cgmFornecedor);
                        $itemRegistroPreco->setInterno($interno);
                        $itemRegistroPreco->setNumcgmGerenciador($numcgmGerenciador);

                        return $itemRegistroPreco;
                    }
                )
            )
        );

        $builder->add(
            $builder->create('fkTcemgRegistroPrecosOrgao', ChoiceType::class, [
                'label' => 'Orgão',
                'choices' => $this->getRegistroPrecosOrgaoFromRegistroPrecos($options['registroPrecos']),
                'choice_value' => function(RegistroPrecosOrgao $orgao = null) {
                    if (null === $orgao) {
                        return null;
                    }

                    return sprintf(
                        '~%s~%s~%s~%s~%s~%s~%s~%s',
                        $orgao->getCodEntidade(),
                        $orgao->getNumeroRegistroPrecos(),
                        $orgao->getExercicioRegistroPrecos(),
                        $orgao->getInterno(),
                        $orgao->getNumcgmGerenciador(),
                        $orgao->getExercicioUnidade(),
                        $orgao->getNumUnidade(),
                        $orgao->getNumOrgao()
                    );
                },
                'choice_label' => function(RegistroPrecosOrgao $orgao) {
                    return sprintf('Orgão %s (%s)', $orgao->getNumOrgao(), $orgao->getNumOrgao());
                },
                'required' => 'true',
                'attr' => ['class' => 'select2-parameters append-registo-preco-orgao '],
                'constraints' => [new NotNull()]

            ])->addModelTransformer(
                new CallbackTransformer(
                    function ($data) {
                        return $data;
                    },

                    function ($data) {
                        $data = true === is_string($data) ? explode('~', $data) : [];

                        if (true === empty($data)) {
                            return null;
                        }

                        list(
                            $codEntidade,
                            $numeroRegistroPrecos,
                            $exercicioRegistroPrecos,
                            $interno,
                            $numcgmGerenciador,
                            $exercicioUnidade,
                            $numUnidade,
                            $numOrgao
                        ) = $data;

                        $registroPrecosOrgao = new RegistroPrecosOrgao();
                        $registroPrecosOrgao->setCodEntidade($codEntidade);
                        $registroPrecosOrgao->setNumeroRegistroPrecos($numeroRegistroPrecos);
                        $registroPrecosOrgao->setExercicioRegistroPrecos($exercicioRegistroPrecos);
                        $registroPrecosOrgao->setInterno($interno);
                        $registroPrecosOrgao->setNumcgmGerenciador($numcgmGerenciador);
                        $registroPrecosOrgao->setExercicioUnidade($exercicioUnidade);
                        $registroPrecosOrgao->setNumUnidade($numUnidade);
                        $registroPrecosOrgao->setNumOrgao($numOrgao);

                        return $registroPrecosOrgao;
                    }
                )
            )
        );

        $builder->get('fkTcemgItemRegistroPrecos')->resetViewTransformers();
        $builder->get('fkTcemgRegistroPrecosOrgao')->resetViewTransformers();
    }

    /**
     * @param $registroPrecos
     * @return array
     */
    private function getItemRegistroPrecosFromRegistroPrecos($registroPrecos)
    {
        $loteRegistroPrecos = new LoteRegistroPrecos();

        /** @var $registroPrecos RegistroPrecos|array */
        if (true === is_array($registroPrecos)) {
            if (true === empty($registroPrecos['fkTcemgItemRegistroPrecos'])) {
                $registroPrecos['fkTcemgLoteRegistroPrecos'] = [];
            }

            foreach ($registroPrecos['fkTcemgLoteRegistroPrecos'] as $fkTcemgLoteRegistroPrecos) {
                foreach ($fkTcemgLoteRegistroPrecos['fkTcemgItemRegistroPrecos'] as $fkTcemgItemRegistroPrecos) {
                    $fkOrcamentoEntidade = explode('~', $registroPrecos['fkOrcamentoEntidade']);

                    $codEntidade = 2 === count($fkOrcamentoEntidade) ? $fkOrcamentoEntidade[1] : null;
                    $exercicio = 2 === count($fkOrcamentoEntidade) ? $fkOrcamentoEntidade[0] : null;

                    $itemRegistroPreco = new ItemRegistroPrecos();
                    $itemRegistroPreco->setCodEntidade($codEntidade);
                    $itemRegistroPreco->setNumeroRegistroPrecos($registroPrecos['numeroRegistroPrecos']);
                    $itemRegistroPreco->setExercicio($exercicio);
                    $itemRegistroPreco->setCodLote($fkTcemgLoteRegistroPrecos['codLote']);
                    $itemRegistroPreco->setCodItem($fkTcemgItemRegistroPrecos['codItem']);
                    $itemRegistroPreco->setCgmFornecedor($fkTcemgItemRegistroPrecos['fkSwCgm']);
                    $itemRegistroPreco->setInterno($registroPrecos['interno']);
                    $itemRegistroPreco->setNumcgmGerenciador($registroPrecos['numcgmGerenciador']);

                    $loteRegistroPrecos->addFkTcemgItemRegistroPrecos($itemRegistroPreco);
                }
            }

        } else {
            $loteRegistroPrecos = null === $registroPrecos ? null : $registroPrecos->getFkTcemgLoteRegistroPrecos()->first();
            $loteRegistroPrecos = null === $loteRegistroPrecos ? new LoteRegistroPrecos() : $loteRegistroPrecos;
        }

        return $loteRegistroPrecos->getFkTcemgItemRegistroPrecos()->toArray();
    }

    /**
     * @param $registroPrecos
     * @return array
     */
    private function getRegistroPrecosOrgaoFromRegistroPrecos($registroPrecos)
    {
        $registroPrecosOrgaos = [];

        /** @var $registroPrecos RegistroPrecos|array */
        if (true === is_array($registroPrecos)) {
            if (true === empty($registroPrecos['fkTcemgRegistroPrecosOrgoes'])) {
                $registroPrecos['fkTcemgRegistroPrecosOrgoes'] = [];
            }

            foreach ($registroPrecos['fkTcemgRegistroPrecosOrgoes'] as $fkTcemgRegistroPrecosOrgoes) {
                $fkOrcamentoEntidade = explode('~', $registroPrecos['fkOrcamentoEntidade']);

                $codEntidade = 2 === count($fkOrcamentoEntidade) ? $fkOrcamentoEntidade[1] : null;
                $exercicio = 2 === count($fkOrcamentoEntidade) ? $fkOrcamentoEntidade[0] : null;

                $fkOrcamentoUnidade = explode('~', $fkTcemgRegistroPrecosOrgoes['fkOrcamentoUnidade']);
                $exercicioUnidade = 3 === count($fkOrcamentoUnidade) ? $fkOrcamentoUnidade[0] : null;
                $numUnidade = 3 === count($fkOrcamentoUnidade) ? $fkOrcamentoUnidade[1] : null;
                $numOrgao = 3 === count($fkOrcamentoUnidade) ? $fkOrcamentoUnidade[2] : null;

                $registroPrecosOrgao = new RegistroPrecosOrgao();
                $registroPrecosOrgao->setCodEntidade($codEntidade);
                $registroPrecosOrgao->setNumeroRegistroPrecos($registroPrecos['numeroRegistroPrecos']);
                $registroPrecosOrgao->setExercicioRegistroPrecos($exercicio);
                $registroPrecosOrgao->setInterno($registroPrecos['interno']);
                $registroPrecosOrgao->setNumcgmGerenciador($registroPrecos['fkSwCgm']);
                $registroPrecosOrgao->setExercicioUnidade($exercicioUnidade);
                $registroPrecosOrgao->setNumUnidade($numUnidade);
                $registroPrecosOrgao->setNumOrgao($numOrgao);

                $registroPrecosOrgaos[] = $registroPrecosOrgao;
            }

        } else {
            $registroPrecosOrgaos = null === $registroPrecos ? null : $registroPrecos->getFkTcemgRegistroPrecosOrgoes();
            $registroPrecosOrgaos = null === $registroPrecosOrgaos ? [] : $registroPrecosOrgaos->toArray();
        }

        return $registroPrecosOrgaos;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', RegistroPrecosOrgaoItem::class);
        $resolver->setRequired('registroPrecos');
    }
}