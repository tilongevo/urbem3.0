<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Validator\Constraints\NotNull;
use Urbem\CoreBundle\Form\Type\EntidadeType;
use Urbem\CoreBundle\Services\SessionService;
use Urbem\PrestacaoContasBundle\Form\Type\PeriodicidadeType;

class ConfiguracaoConvenioFilterType extends AbstractType
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
        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FLManterConvenio.php:81 */
        $builder->add('exercicio', TextType::class, [
            'label' => 'Exercício',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FLManterConvenio.php:101 */
        $builder->add('entidade', EntidadeType::class, [
            'exercicio' => $options['exercicio'],
            'usuario' => $options['usuario'],
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FLManterConvenio.php:91 */
        $builder->add('numConvenio', TextType::class, [
            'label' => 'Número do Convênio',
        ]);

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FLManterConvenio.php:106-115 */
        $builder->add('periodicidade', PeriodicidadeType::class, [
            'label' => 'Data de Início de Execução',
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