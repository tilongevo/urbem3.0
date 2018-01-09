<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;
use Urbem\CoreBundle\Entity\Administracao\Mes;
use Urbem\CoreBundle\Entity\Administracao\PoderPublico;
use Urbem\CoreBundle\Entity\Tcemg\Medidas;
use Urbem\CoreBundle\Form\Type\YesNoType;
use Urbem\CoreBundle\Repository\Administracao\MesRepository;
use Urbem\CoreBundle\Repository\Administracao\PoderPublicoRepository;

class ConfiguracaoGestaoFiscalMedidaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FLGestaoFiscalMedidas.php:81
        $builder->add('fkAdministracaoPoderPublico', EntityType::class, [
            'class' => PoderPublico::class,
            'query_builder' => function (PoderPublicoRepository $repository) {
                return $repository->getAsQueryBuilder();
            },
            'attr' => ['class' => 'select2-parameters '],
            'constraints' => [new NotNull()],
            'label' => 'Tipo Poder',
        ]);

        // gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FLGestaoFiscalMedidas.php:91
        $builder->add('fkAdministracaoMes', EntityType::class, [
            'class' => Mes::class,
            'query_builder' => function (MesRepository $repository) {
                return $repository->getAsQueryBuilder();
            },
            'attr' => ['class' => 'select2-parameters '],
            'constraints' => [new NotNull()],
            'label' => 'Mês'
        ]);

        // gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMGestaoFiscalMedidas.php:127
        $builder->add('riscosFiscais', YesNoType::class, [
            'label' => 'Nada a declarar s/ Riscos Fiscais',
            'required' => false,
        ]);

        // gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMGestaoFiscalMedidas.php:140
        $builder->add('metasFiscais', YesNoType::class, [
            'label' => 'Nada a declarar s/ Metas Fiscais',
            'required' => false,
        ]);

        // gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMGestaoFiscalMedidas.php:153
        $builder->add('contratacaoAro', YesNoType::class, [
            'label' => 'Contratação ARO',
            'required' => false,
        ]);

        // gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMGestaoFiscalMedidas.php:166
        $builder->add('descricao', TextareaType::class, [
            'label' => 'Medidas',
            'constraints' => [new NotNull()]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', Medidas::class);
    }
}