<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Urbem\CoreBundle\Entity\Empenho\Empenho;
use Urbem\CoreBundle\Entity\Licitacao\Licitacao;
use Urbem\CoreBundle\Form\Type\AutoCompleteType;
use Urbem\CoreBundle\Form\Type\EntidadeType;
use Urbem\CoreBundle\Services\SessionService;
use Urbem\PrestacaoContasBundle\Form\Type\ModalidadeType;

class ConfiguracaoRegistroPrecosFilterType extends AbstractType
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
        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FLManterRegistroPreco.php:73 */
        $builder->add('entidade', EntidadeType::class, [
            'exercicio' => $options['exercicio'],
            'usuario' => $options['usuario'],
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FLManterRegistroPreco.php:73 */
        $builder->add('numeroRegistroPrecos', TextType::class, [
            'label' => 'Nro. do Processo de Registro de Preços'
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FLManterRegistroPreco.php:96 */
        $builder->add('modalidade', ModalidadeType::class, [
            /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FLManterRegistroPreco.php:91 */
            'field_in' => [
                [
                    'column' => 'codModalidade',
                    'value' => [3, 6, 7]
                ]
            ]
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FLManterRegistroPreco.php:109 */
        $builder->add('licitacao', AutoCompleteType::class, [
            'label' => 'Licitação',
            'class' => Licitacao::class,
            'route' => [
                'name' => AutoCompleteType::ROUTE_AUTOCOMPLETE_DEFAULT,
                'parameters' => [
                    'json_from_admin_field' => 'autocomplete_field', // LicitacaoAdmin
                    'cascade_exercicio' => $this->sessionService->getExercicio()
                ]
            ],
            'cascade_fields' => [
                [
                    'search_column' => 'entidade',
                    'from_field' => 'prestacao_contas_mg_registro_precos_filter_entidade',
                ],
                [
                    'search_column' => 'modalidade',
                    'from_field' => 'prestacao_contas_mg_registro_precos_filter_modalidade',
                ],
            ],
            'json_from_admin_code' => 'core.admin.filter.licitacao_licitacao',
            'attr' => ['class' => 'select2-parameters '],
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FLManterRegistroPreco.php:129 */
        $builder->add('empenho', AutoCompleteType::class, [
            'label' => 'Número do Empenho',
            'class' => Empenho::class,
            'route' => [
                'name' => AutoCompleteType::ROUTE_AUTOCOMPLETE_DEFAULT,
                'parameters' => [
                    'json_from_admin_field' => 'autocomplete_registro_precos_empenho_field', // EmpenhoAdmin
                    'cascade_exercicio' => $this->sessionService->getExercicio()
                ]
            ],
            'cascade_fields' => [
                [
                    'search_column' => 'entidade',
                    'from_field' => 'prestacao_contas_mg_registro_precos_filter_entidade',
                ],
            ],
            'json_from_admin_code' => 'core.admin.filter.empenho_empenho',
            'attr' => ['class' => 'select2-parameters '],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('exercicio', $this->sessionService->getExercicio());
        $resolver->setDefault('usuario', $this->tokenStorage->getToken()->getUser());
    }
}