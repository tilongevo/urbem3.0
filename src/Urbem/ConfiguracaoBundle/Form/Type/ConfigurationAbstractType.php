<?php

namespace Urbem\ConfiguracaoBundle\Form\Type;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Urbem\CoreBundle\Entity\Administracao\Configuracao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;

abstract class ConfigurationAbstractType extends AbstractType
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(EntityManagerInterface $em, ContainerInterface $container)
    {
        $this->em = $em;
        $this->container = $container;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $this->getConfigurationFromFormEvent($event, $event->getForm()->getName())->setValor($event->getData());
        });
    }

    /**
     * @param FormEvent $event
     * @param $name
     * @return Configuracao
     */
    protected function getConfigurationFromFormEvent(FormEvent $event, $name)
    {
        $year = $event->getForm()->getConfig()->getOption('year');

        /** @var Modulo $data */
        $data = $event->getForm()->getParent()->getData();

        /** @var Configuracao $configuration */
        $configuration = $data->getFkAdministracaoConfiguracoes($name, $year, true);

        if (false === $configuration instanceof Configuracao) {
            throw new \OutOfBoundsException(sprintf('Parameter "%s" does not exists in "%s".', $name, $year));
        }

        return $configuration;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(['year', 'module']);
    }
}
