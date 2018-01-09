<?php

namespace Urbem\ConfiguracaoBundle\Form\Type;

use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Urbem\CoreBundle\Entity\Administracao\Configuracao;
use Urbem\CoreBundle\Helper\StringHelper;

/**
 * Class ConfigurationLogoTipoType
 * @package Urbem\ConfiguracaoBundle\Form\Type
 */
class ConfigurationLogoTipoType extends ConfigurationAbstractType
{
    const SIZE_WIDTH = 60;
    const SIZE_HEIGHT = 55;
    const SIZE_MAX_FILE = 512000;

    /**
     * @var array
     */
    protected static $availableTypes = ['image/jpeg', 'image/pjpeg'];

    /**
     * @var array
     */
    private $error = [];

    /**
     * @return string
     */
    public function getParent()
    {
        return FileType::class;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) use ($options) {
            $uploadedFile = $event->getData();
            $form = $event->getForm();

            $logotipoBanco = $this->em->getRepository(Configuracao::class)->findLogotipo($options["year"], $options['module']->getCodModulo());
            if (!empty(StringHelper::removeAllSpace($logotipoBanco->getValor())) && false === $uploadedFile instanceof UploadedFile) {
                return;
            }

            if (!$this->isValid($uploadedFile, $logotipoBanco)) {
                $form->addError(new FormError(implode(", ", $this->error)));
                return;
            }

            $this->uploadPicture($uploadedFile, $form);

            $this->container->get('urbem.session.service')->setLogoTipo(sprintf('%s/%s', $this->getPictureUploadDir(), $uploadedFile->getClientOriginalName()));

            $this->getConfigurationFromFormEvent($event, $event->getForm()->getName())->setValor(sprintf('%s/%s', $this->getPictureUploadDir(), $uploadedFile->getClientOriginalName()));
        });
    }

    /**
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $uploadedFile
     * @return bool
     */
    private function isValid(UploadedFile $uploadedFile = null, Configuracao $logotipoBanco)
    {
        $valid = true;
        if (empty($uploadedFile) && empty(StringHelper::removeAllSpace($logotipoBanco->getValor()))) {
            $this->error[] = $this->container->get('translator')->trans('configuracao.errors.emptyLogoTipo', array(), 'validators');
            return $valid = false;
        }

        if (!in_array($uploadedFile->getMimeType(), self::$availableTypes)) {
            $this->error[] = $this->container->get('translator')->trans('configuracao.errors.invalidFileType', ['%file_types%' => implode(', ', self::$availableTypes)], 'validators');
            $valid = false;
        }

        /*500K*/
        if ($uploadedFile->getSize() > self::SIZE_MAX_FILE) {
            $this->error[] = $this->container->get('translator')->trans('configuracao.errors.uploadedFileSizeNotAllowed', ['%size%' => '500Kb'], 'validators');
            $valid = false;
        }

        list($width, $height) = getimagesize($uploadedFile->getPathname());
        if ($width != self::SIZE_WIDTH) {
            $this->error[] = $this->container->get('translator')->trans('configuracao.errors.widthPicSizeExceeded', ['%width_size%' => '60px'], 'validators');
            $valid = false;
        }

        if ($height != self::SIZE_HEIGHT) {
            $this->error[] = $this->container->get('translator')->trans('configuracao.errors.heightPicSizeExceeded', ['%height_size%' => '55px'], 'validators');
            $valid = false;
        }

        return $valid;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'data_class' => null,
            'class' => UploadedFile::class,
        ));
    }

    /**
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $uploadedFile
     * @param \Symfony\Component\Form\Form $form
     * @return bool
     */
    private function uploadPicture(UploadedFile $uploadedFile, Form $form)
    {
        try {
            $uploadedFile->move($this->getPictureUploadDir(), $uploadedFile->getClientOriginalName());
        } catch (IOException $IOException) {
            $form->addError(new FormError($IOException->getMessage()));
            return false;
        }

        return true;
    }

    /**
     * @return mixed
     */
    private function getPictureUploadDir()
    {
        $foldersBundle = $this->container->getParameter('administrativobundle');
        return $foldersBundle['logoTipo'];
    }
}
