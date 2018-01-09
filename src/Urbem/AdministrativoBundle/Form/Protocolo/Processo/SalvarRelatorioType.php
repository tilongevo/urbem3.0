<?php

namespace Urbem\AdministrativoBundle\Form\Protocolo\Processo;

use Doctrine\ORM\EntityRepository;

use Sonata\DoctrineORMAdminBundle\Admin\FieldDescription;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;

use Urbem\CoreBundle\Entity\Administracao\Assinatura;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Repository\Orcamento\EntidadeRepository;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class SalvarRelatorioType
 *
 * @package Urbem\AdministrativoBundle\Form\Protocolo\Processo
 */
class SalvarRelatorioType extends AbstractType
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

        $exercicio = $admin->getExercicio();

        $builder
            ->add('entidade', EntityType::class, [
                'attr'          => ['class' => 'select2-parameters '],
                'class'         => Entidade::class,
                'choice_value'  => function (Entidade $entidade = null) use ($admin) {
                    return $admin->id($entidade);
                },
                'label'         => 'label.processo.relatorios.entidade',
                'multiple'      => false,
                'expanded'      => false,
                'placeholder'   => 'label.selecione',
                'query_builder' => function (EntidadeRepository $repository) use ($exercicio) {
                    return $repository
                        ->createQueryBuilder('e')
                        ->andWhere('e.exercicio = :exercicio')
                        ->setParameter('exercicio', $exercicio)
                        ->orderBy('e.codEntidade', 'ASC');
                },
                'required'      => false
            ])
            ->add('assinaturas', EntityType::class, [
                'attr'          => ['class' => 'select2-parameters '],
                'class'         => Assinatura::class,
                'choice_label'  => function (Assinatura $assinatura) {
                    return sprintf(
                        '%s - %s',
                        strtoupper($assinatura->getFkSwCgmPessoaFisica()->getFkSwCgm()->getNomCgm()),
                        $assinatura->getCargo()
                    );
                },
                'choice_value'  => function (Assinatura $assinatura = null) use ($admin) {
                    return $admin->id($assinatura);
                },
                'label'         => 'label.processo.relatorios.assinaturas',
                'multiple'      => true,
                'expanded'      => false,
                'placeholder'   => 'label.selecione',
                'query_builder' => function (EntityRepository $repository) use ($exercicio) {
                    return $repository
                        ->createQueryBuilder('a')
                        ->where('a.exercicio = :exercicio')
                        ->setParameter('exercicio', $exercicio);
                },
                'required'      => false
            ])
            ->add('modulo', HiddenType::class, ['data' => Modulo::MODULO_PROCESSO]);
    }
}
