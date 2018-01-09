<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\STN\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Validator\Constraints\NotNull;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\Orcamento\Recurso;
use Urbem\CoreBundle\Entity\Orcamento\Unidade;
use Urbem\CoreBundle\Form\Transform\EntityTransform;
use Urbem\CoreBundle\Form\Type\AutoCompleteType;
use Urbem\CoreBundle\Form\Type\EntidadeType;
use Urbem\CoreBundle\Form\Type\Orcamento\OrgaoType;
use Urbem\CoreBundle\Repository\Orcamento\RecursoRepository;
use Urbem\CoreBundle\Services\SessionService;

class RecursoOperacaoCreditoMDEType extends AbstractType
{
    /**
     * @var SessionService
     */
    protected $sessionService;

    /**
     * @var TokenStorage
     */
    protected $tokenStorage;

    public function __construct(SessionService $sessionService, TokenStorage $tokenStorage)
    {
        $this->sessionService = $sessionService;
        $this->tokenStorage = $tokenStorage;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** gestaoPrestacaoContas/fontes/PHP/STN/instancias/configuracao/FMManterRecurso.php:136 */
        $builder->add('entidade', EntidadeType::class, [
            'required' => true,
            'constraints' => [new NotNull()],
            'exercicio' => $options['exercicio'],
            'usuario' => $options['usuario'],
        ]);

        /** gestaoPrestacaoContas/fontes/PHP/STN/instancias/configuracao/FMManterRecurso.php:147 */
        $builder->add('orgao', OrgaoType::class, [
            'label' => 'Orgão',
            'exercicio' => $options['exercicio'],
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /** gestaoPrestacaoContas/fontes/PHP/STN/instancias/configuracao/FMManterRecurso.php:156 */
        $builder->add('unidade', AutoCompleteType::class, [
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
                    'from_parent' => 'orgao',
                ],
            ],
            'attr' => ['class' => 'select2-parameters '],
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/STN/instancias/configuracao/FMManterRecurso.php:229 */
        /* gestaoPrestacaoContas/fontes/PHP/STN/instancias/configuracao/OCManterRecurso.php:344 */
        $addRecurso = function (FormEvent $event) use ($builder) {
            $form = $event->getForm();
            $data = $event->getData();

            $form->add('recursos', EntityType::class, [
                'class' => Recurso::class,
                'multiple' => true,
                'label' => 'Recurso',
                'attr' => ['class' => 'select2-parameters '],
                'choice_value' => function (Recurso $recurso = null) {
                    if (null == $recurso) {
                        return null;
                    }

                    return sprintf('%s%s%s', $recurso->getExercicio(), EntityTransform::COMPOSITE_KEY_SEPARATOR, $recurso->getCodRecurso());
                },
                'query_builder' => function (RecursoRepository $repository) use ($data) {
                    return $repository->getRecursoOutrasDespesasVinculoOperacoesCreditoAsQueryBuilder(
                        self::getEntidadeFromData($data['entidade']),
                        self::getUnidadeFromData($data['unidade'])
                    );
                },
                'required' => true,
                'constraints' => [new NotNull()]
            ]);
        };

        $builder->addEventListener(FormEvents::PRE_SET_DATA, $addRecurso);
        $builder->addEventListener(FormEvents::PRE_SUBMIT, $addRecurso);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('exercicio', $this->sessionService->getExercicio());
        $resolver->setDefault('usuario', $this->tokenStorage->getToken()->getUser());
    }

    /**
     * @param $data
     * @return Entidade
     */
    public static function getEntidadeFromData($data)
    {
        /** @var string|Entidade $data */
        if (true === is_string($data)) {
            $data = explode(EntityTransform::COMPOSITE_KEY_SEPARATOR, $data);

        } elseif (true === $data instanceof Entidade) {
            $_data = [];
            $_data[] = $data->getExercicio();
            $_data[] = $data->getCodEntidade();

            $data = $_data;

        } else {
            $data  = [[], []];
        }

        $entidade = new Entidade();
        $entidade->setExercicio($data[0]);
        $entidade->setCodEntidade($data[1]);

        return $entidade;
    }

    /**
     * @param $data
     * @return Unidade
     */
    public static function getUnidadeFromData($data)
    {
        /** @var string|Unidade $data */
        if (true === is_string($data)) {
            $data = explode(EntityTransform::COMPOSITE_KEY_SEPARATOR, $data);

        } elseif (true === $data instanceof Unidade) {
            $_data = [];
            $_data[] = $data->getExercicio();
            $_data[] = $data->getNumUnidade();
            $_data[] = $data->getNumOrgao();

            $data = $_data;

        } else {
            $data  = [[], [], []];
        }

        $unidade = new Unidade();
        $unidade->setExercicio($data[0]);
        $unidade->setNumUnidade($data[1]);
        $unidade->setNumOrgao($data[2]);

        return $unidade;
    }
}