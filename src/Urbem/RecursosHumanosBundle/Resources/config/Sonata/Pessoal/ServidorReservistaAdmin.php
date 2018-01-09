<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\RecursosHumanosBundle\Helper\Constants\Pessoal\ServidorReservista as ServidorReservistaConstants;

class ServidorReservistaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_pessoal_servidor_reservista';
    protected $baseRoutePattern = 'recursos-humanos/pessoal/servidor-reservista';

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['create','edit']);
    }

    /**
     * Retorna a lista de opções para o campo Categoria do Certificado
     * @return array
     */
    public function getCatReservistaChoices()
    {
        $choices = [];
        foreach (ServidorReservistaConstants::CATRESERVISTA as $label => $value) {
            $choices['label.servidor.choices.catReservista.' . $label] = $value;
        }

        return $choices;
    }

    /**
     * Retorna a lista de opções para o campo Órgão Expedidor do Certificado
     * @return array
     */
    public function getOrigemReservistaChoices()
    {
        $choices = [];
        foreach (ServidorReservistaConstants::ORIGEMRESERVISTA as $label => $value) {
            $choices['label.servidor.choices.origemReservista.' . $label] = $value;
        }

        return $choices;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nrCarteiraRes', null, ['label' => 'label.servidor.nrCarteiraRes'])
            ->add(
                'catReservista',
                'choice',
                [
                    'choices' => $this->getCatReservistaChoices(),
                    'label' => 'label.servidor.catReservista',
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                    'placeholder' => 'label.selecione'
                ]
            )
            ->add(
                'origemReservista',
                'choice',
                [
                    'choices' => $this->getOrigemReservistaChoices(),
                    'label' => 'label.servidor.origemReservista',
                    'placeholder' => 'label.selecione',
                    'attr' => [
                        'class' => 'select2-parameters '
                    ]
                ]
            )
        ;
    }
}
