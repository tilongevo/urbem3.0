<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Imobiliario;

use Symfony\Component\Validator\Constraints as Assert;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;

class ImovelFotoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_tributario_imobiliario_imovel_foto';
    protected $baseRoutePattern = 'tributario/cadastro-imobiliario/imovel-foto';

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $fieldOptions = array();

        $availableTypes = ['image/jpeg', 'image/pjpeg', 'image/png'];
        $imageRules = [
            'mimeTypes' => $availableTypes,
            'maxSize' => '2000k',
            'mimeTypesMessage' => $this->trans('label.imobiliarioImovelFoto.tipoArquivoInvalido', ['%file_types%' => implode(', ', $availableTypes)]),
            'maxSizeMessage' => $this->trans('label.imobiliarioImovelFoto.tamanhoArquivoNaoSuportado', ['%size%' => '2MB']),
        ];

        $fieldOptions['foto'] = [
            'mapped' => false,
            'label' => 'label.imobiliarioImovelFoto.foto',
            'required' => false,
            'constraints' => [new Assert\Image($imageRules)]
        ];

        $formMapper
            ->add('foto', 'file', $fieldOptions['foto'])
            ->add('descricao', 'text', ['label' => 'label.imobiliarioImovelFoto.descricao'])
        ;
    }
}
