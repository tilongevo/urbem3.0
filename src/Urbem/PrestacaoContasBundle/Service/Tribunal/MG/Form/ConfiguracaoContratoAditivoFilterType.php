<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Urbem\CoreBundle\Form\Type\EntidadeType;
use Urbem\CoreBundle\Services\SessionService;
use Urbem\PrestacaoContasBundle\Form\Type\DatePickerType;

class ConfiguracaoContratoAditivoFilterType extends AbstractType
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
        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FLManterAditivoContrato.php:68 */
        $builder->add('entidades', EntidadeType::class, [
            'label' => 'Entidade',
            'multiple' => true,
            'exercicio' => $options['exercicio'],
            'usuario' => $options['usuario'],
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FLManterAditivoContrato.php:72 */
        $builder->add('nroContrato', TextType::class, [
            'label' => 'Número do Contrato'
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FLManterAditivoContrato.php:86 */
        $builder->add('dataAssinatura', DatePickerType::class, [
            'label' => 'Data do Contrato'
        ]);

        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FLManterAditivoContrato.php:93 */
        $builder->add('nroAditivo', TextType::class, [
            'label' => 'Número do Aditivo'
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