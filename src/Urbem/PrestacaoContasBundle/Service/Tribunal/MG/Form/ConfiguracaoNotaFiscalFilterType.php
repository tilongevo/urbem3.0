<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Validator\Constraints\NotNull;
use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Entity\Empenho\Empenho;
use Urbem\CoreBundle\Form\Type\AutoCompleteType;
use Urbem\CoreBundle\Form\Type\EntidadeType;
use Urbem\CoreBundle\Services\SessionService;
use Urbem\PrestacaoContasBundle\Form\Type\DatePickerType;

class ConfiguracaoNotaFiscalFilterType extends AbstractType
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
        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FLManterNotasFiscais.php:72 */
        $builder->add('numNota', TextType::class, [
            'label' => 'Número da Nota',
            'required' => false
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FLManterNotasFiscais.php:79 */
        $builder->add('numSerie', TextType::class, [
            'label' => 'Série da Nota Fiscal',
            'required' => false
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FLManterNotasFiscais.php:85 */
        $builder->add('dtEmissao', DatePickerType::class, [
            'label' => 'Data de Emissão',
            'required' => false
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FLManterNotasFiscais.php:91 */
        $builder->add('exercicioNota', TextType::class, [
            'label' => 'Exercício Nota Fiscal',
            'required' => false,
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FLManterNotasFiscais.php:102 */
        $builder->add('exercicioEmpenho', TextType::class, [
            'label' => 'Exercício Empenho',
            'required' => false,
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FLManterNotasFiscais.php:113 */
        $builder->add('entidade', EntidadeType::class, [
            'exercicio' => $options['exercicio'],
            'usuario' => $options['usuario'],
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FLManterNotasFiscais.php:116 */
        $builder->add('empenho', AutoCompleteType::class, [
            'label' => 'Número do Empenho',
            'class' => Empenho::class,
            'route' => [
                'name' => AutoCompleteType::ROUTE_AUTOCOMPLETE_DEFAULT,
                'parameters' => [
                    'json_from_admin_field' => 'autocomplete_nota_fiscal_empenho_field' // EmpenhoAdmin
                ]
            ],
            'cascade_fields' => [
                [
                    'search_column' => 'exercicio',
                    'from_field' => 'prestacao_contas_mg_nota_fiscal_filter_exercicioEmpenho',
                ],
                [
                    'search_column' => 'entidade',
                    'from_field' => 'prestacao_contas_mg_nota_fiscal_filter_entidade',
                ],
            ],
            'json_from_admin_code' => 'core.admin.filter.empenho_empenho',
            'attr' => ['class' => 'select2-parameters '],
            'required' => true,
            'constraints' => [new NotNull()]
        ]);
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('exercicio', $this->sessionService->getExercicio());
        $resolver->setDefault('usuario', $this->tokenStorage->getToken()->getUser());
    }
}