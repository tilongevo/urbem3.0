<?php

namespace Urbem\AdministrativoBundle\Form\Protocolo\Processo;

use Doctrine\ORM\EntityManager;

use Sonata\CoreBundle\Form\Type\DatePickerType;
use Sonata\DoctrineORMAdminBundle\Admin\FieldDescription;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Urbem\CoreBundle\Entity\Administracao\Configuracao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Form\Type\AutoCompleteType;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class SalvarRelatorioType
 *
 * @package Urbem\AdministrativoBundle\Form\Protocolo\Processo
 */
class EtiquetasRelatorioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var FieldDescription $fieldDescription */
        $fieldDescription = $options['sonata_field_description'];

        /** @var AbstractSonataAdmin $admin */
        $admin = $fieldDescription->getAdmin();

        /** @var EntityManager $entityManager */
        $entityManager = $admin->getModelManager()->getEntityManager(Configuracao::class);

        try {
            $mascaraProcesso = (new ConfiguracaoModel($entityManager))
                ->getConfiguracaoOuAnterior('mascara_processo', Modulo::MODULO_PROCESSO, $admin->getExercicio());
        } catch (\Exception $exception) {
            $mascaraProcesso = '99999/9999';
        }

        $builder
            ->add('processoInicial', TextType::class, [
                'attr' => [
                    'data-mask'         => $mascaraProcesso,
                    'placeholder'       => str_replace('9', '_', $mascaraProcesso)
                ],
                'label'    => 'label.processo.relatorios.processoInicial',
                'required' => false
            ])
            ->add('processoFinal', TextType::class, [
                'attr'     => [
                    'data-mask'         => $mascaraProcesso,
                    'placeholder'       => str_replace('9', '_', $mascaraProcesso)
                ],
                'label'    => 'label.processo.relatorios.processoFinal',
                'required' => false
            ])
            ->add('dataInicial', DatePickerType::class, [
                'format'   => 'd/M/y',
                'label'    => 'label.processo.prmDataIni',
                'required' => false
            ])
            ->add('dataFinal', DatePickerType::class, [
                'format'   => 'd/M/y',
                'label'    => 'label.processo.prmDataFim',
                'required' => false
            ])
            ->add('interessado', AutoCompleteType::class, [
                'attr'        => ['class' => 'select2-parameters '],
                'label'       => 'label.processo.interessado',
                'multiple'    => false,
                'required'    => false,
                'route'       => ['name' => 'carrega_sw_cgm'],
                'placeholder' => $admin->trans('label.selecione')
            ]);
    }
}
