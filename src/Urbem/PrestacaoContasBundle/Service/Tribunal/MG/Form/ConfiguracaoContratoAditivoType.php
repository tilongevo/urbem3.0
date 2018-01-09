<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Urbem\CoreBundle\Entity\Tcemg\ContratoAditivo;
use Urbem\CoreBundle\Entity\Tcemg\ContratoAditivoTipo;
use Urbem\CoreBundle\Form\Type\CurrencyType;
use Urbem\CoreBundle\Form\Type\Licitacao\VeiculosPublicidadeType;
use Urbem\CoreBundle\Form\Type\Tcemg\AcrescimoDecrescimoType;
use Urbem\PrestacaoContasBundle\Form\Type\DatePickerType;
use Urbem\PrestacaoContasBundle\Form\Type\Tcemg\ContratoType;

class ConfiguracaoContratoAditivoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fkTcemgContrato', ContratoType::class, [
            'attr' => ['class' => 'contrato'],
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        $readOnly = null === $builder->getData()->getFkTcemgContrato() ? ['readonly' => 'readonly'] : [];

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterAditivoContrato.php:223 */
        $builder->add('nroAditivo', TextType::class, [
            'label' => 'Número do Aditivo',
            'attr' => $readOnly,
            'required' => true,
            'constraints' => [new NotNull(), new Length(['min' => 0, 'max' => 2])]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterAditivoContrato.php:235 */
        $builder->add('dataAssinatura', DatePickerType::class, [
            'label' => 'Data da Assinatura',
            'attr' => $readOnly,
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterAditivoContrato.php:247 */
        $builder->add('fkTcemgContratoAditivoTipo', EntityType::class, [
            'class' => ContratoAditivoTipo::class,
            'label' => 'Tipo de Termo de Aditivo',
            'placeholder' => 'Selecione',
            'attr' => ['class' => 'select2-parameters '] + $readOnly,
            'query_builder' => function (EntityRepository $repository) {
                return $repository->createQueryBuilder('o')->orderBy('o.descricao', 'ASC');
            },
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterAditivoContrato.php:265 */
        $builder->add('fkLicitacaoVeiculosPublicidade', VeiculosPublicidadeType::class, [
            'attr' => ['class' => 'select2-parameters '] + $readOnly,
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterAditivoContrato.php:235 */
        $builder->add('dataPublicacao', DatePickerType::class, [
            'attr' => $readOnly,
            'label' => 'Data da Publicação',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterAditivoContrato.php:258 */
        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterAditivoContrato.php:201 */
        $createByFkTcemgContratoAditivoTipo = function (FormEvent $event) {
            $form = $event->getForm();
            $codTipoAditivo = $this->getCodTipoAditivo($event->getData());

            if (0 === $codTipoAditivo) {
                return;
            }

            /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterAditivoContrato.php:246 */
            if (7 === $codTipoAditivo || 13 === $codTipoAditivo) {

                /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterAditivoContrato.php:203 */
                $form->add('dataTermino', DatePickerType::class, [
                    'label' => 'Nova Data de Término do Contrato',
                    'required' => true,
                    'constraints' => [new NotNull()]
                ]);
            }

            /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterAditivoContrato.php:250 */
            if (6 === $codTipoAditivo || 14 === $codTipoAditivo) {

                /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterAditivoContrato.php:209 */
                $form->add('descricao', TextType::class, [
                    'label' => 'Descrição do Termo Aditivo',
                    'required' => true,
                    'constraints' => [new NotNull(), new Length(['min' => 0, 'max' => 250])]
                ]);
            }

            /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterAditivoContrato.php:254 */
            /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterAditivoContrato.php:269 */
            if (9 === $codTipoAditivo || 10 === $codTipoAditivo || 11 === $codTipoAditivo || 14 === $codTipoAditivo) {

                /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterAditivoContrato.php:55 */
                $form->add('fkTcemgContratoAditivoItens', CollectionType::class, [
                    'entry_type'   => ConfiguracaoContratoAditivoItemType::class,
                    'allow_add'    => false,
                    'allow_delete' => false,
                    'entry_options' => [
                        'show_error' => $form->getConfig()->getOption('show_error'),
                        'codTipoAditivo' => $codTipoAditivo,
                    ]
                ]);
            }

            /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterAditivoContrato.php:259 */
            if (4 === $codTipoAditivo || 5 === $codTipoAditivo) {

                /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterAditivoContrato.php:219 */
                $form->add('valor', CurrencyType::class, [
                    'label' => 'Valor do Termo de Aditivo',
                ]);

                /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterAditivoContrato.php:229 */
                /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/PRManterAditivoContrato.php:199 */
                $form->add('codTipoValor', AcrescimoDecrescimoType::class, [
                    'required' => true,
                    'constraints' => [new NotNull()]
                ]);
            }
        };

        $builder->addEventListener(FormEvents::PRE_SET_DATA, $createByFkTcemgContratoAditivoTipo);
        $builder->addEventListener(FormEvents::PRE_SUBMIT, $createByFkTcemgContratoAditivoTipo);
    }

    /**
     * @param $contratoAditivo
     * @return int
     */
    private function getCodTipoAditivo($contratoAditivo)
    {
        if (true === $contratoAditivo instanceof ContratoAditivo) {
            $codTipoAditivo = $contratoAditivo->getFkTcemgContratoAditivoTipo();

            if (true === $codTipoAditivo instanceof ContratoAditivoTipo) {
                $codTipoAditivo = $codTipoAditivo->getCodTipoAditivo();

            } else {
                $codTipoAditivo = 0;
            }

        } else {
            $codTipoAditivo = true === array_key_exists('fkTcemgContratoAditivoTipo', $contratoAditivo) ? $contratoAditivo['fkTcemgContratoAditivoTipo'] : 0;
        }

        return (int) $codTipoAditivo;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', ContratoAditivo::class);
        $resolver->setRequired('fkOrcamentoEntidade');
        $resolver->setRequired('codigoModalidadeLicitacao');
        $resolver->setDefault('show_error', true);
    }
}