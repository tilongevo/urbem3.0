<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Cgm;

use Sonata\AdminBundle\Form\FormMapper;

use Urbem\CoreBundle\Entity\SwCepLogradouro;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

/**
 * Class SwCepLogradouroAdmin
 *
 * @package Urbem\AdministrativoBundle\Resources\config\Sonata\Administracao
 */
class SwCepLogradouroAdmin extends AbstractAdmin
{
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $isNew = is_null($this->getAdminRequestId());

        $fieldOptions = [];
        $fieldOptions['cep'] = [
            'attr'  => ['maxlength' => 8],
            'label' => 'label.servidor.cep',
        ];

        $fieldOptions['numInicial'] = [
            'attr'     => ['maxlength' => 6],
            'label'    => 'label.numInicial',
            'required' => false
        ];

        $fieldOptions['numFinal'] = [
            'attr'     => ['maxlength' => 6],
            'label'    => 'label.numFinal',
            'required' => false
        ];

        $fieldOptions['par'] = [
            'label'    => 'label.par',
            'required' => false,
            'data'     => true
        ];

        $fieldOptions['impar'] = [
            'label'    => 'label.impar',
            'required' => false,
            'data'     => true
        ];

        $fieldOptions['numeracao'] = [
            'choices'  => [
                'todas'       => 't',
                'label.par'   => 'p',
                'label.impar' => 'i'
            ],
            'data'     => 't',
            'expanded' => true,
            'label'    => 'numeracao',
            'mapped'   => false,
            'required' => true
        ];

        if (!$isNew && $this->getRequest()->getMethod() != 'POST') {
            /** @var SwCepLogradouro $swCepLogradouro */
            $swCepLogradouro = $this->getSubject();

            if ($swCepLogradouro->getPar() && $swCepLogradouro->getImpar()) {
                $fieldOptions['numeracao']['data'] = 't';
            } elseif ($swCepLogradouro->getPar() && $swCepLogradouro->getImpar() == false) {
                $fieldOptions['numeracao']['data'] = 'p';
            } elseif ($swCepLogradouro->getPar() == false && $swCepLogradouro->getImpar()) {
                $fieldOptions['numeracao']['data'] = 'i';
            }
        }

        $formMapper
            ->add('cep', null, $fieldOptions['cep'])
            ->add('numInicial', null, $fieldOptions['numInicial'])
            ->add('numFinal', null, $fieldOptions['numFinal'])
            ->add('numeracao', 'choice', $fieldOptions['numeracao']);
    }
}
