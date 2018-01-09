<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Urbem\CoreBundle\Entity\Pessoal\Servidor;
use Urbem\CoreBundle\Entity\Pessoal\ServidorDocumentoDigital;
use Urbem\CoreBundle\Entity\Pessoal\TipoDocumentoDigital;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

class ServidorDocumentoDigitalAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_pessoal_servidor_documento_digital';
    protected $baseRoutePattern = 'recursos-humanos/pessoal/servidor/documento-digital';

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['create','edit','delete']);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions = [];

        $fieldOptions['codServidor'] = [
            'data' => $this->getRequest()->query->get('id'),
            'mapped' => false,
        ];

        $fieldOptions['fkPessoalTipoDocumentoDigital'] = [
            'label' => 'label.tipoDocumento',
            'class' => TipoDocumentoDigital::class,
            'choice_label' => 'descricao',
            'placeholder' => 'label.selecione',
            'attr' => [
                'class' => 'select2-parameters '
            ]
        ];

        $availableTypes = [
            'image/jpeg',
            'image/pjpeg',
            'image/gif',
            'image/png',
            'application/vnd.oasis.opendocument.text',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ];

        $arquivoDigitalRules = [
            'mimeTypes'       => $availableTypes,
            'mimeTypesMessage'=> $this->trans(
                'usuario.errors.invalidFileType',
                ['%file_types%' => implode(', ', $availableTypes)],
                'validators'
            ),
        ];

        $fieldOptions['arquivoDigital'] = [
            'label' => 'label.norma.link',
            'constraints' => [new Assert\Image($arquivoDigitalRules)]
        ];

        $formMapper
            ->with('label.servidor.copiasDigitaisDocumentos')
                ->add(
                    'codServidor',
                    'hidden',
                    $fieldOptions['codServidor']
                )
                ->add(
                    'fkPessoalTipoDocumentoDigital',
                    'entity',
                    $fieldOptions['fkPessoalTipoDocumentoDigital']
                )
                ->add(
                    'arquivoDigital',
                    'file',
                    $fieldOptions['arquivoDigital']
                )
            ->end()
        ;
    }

    /**
     * @param ErrorElement     $errorElement
     * @param AtributoDinamico $atributoDinamico
     */
    public function validate(ErrorElement $errorElement, $servidorDocumentoDigital)
    {
        $form = $this->getForm();

        $codServidor = $form->get('codServidor')->getData();
        $codTipo = $form->get('fkPessoalTipoDocumentoDigital')->getData()->getCodTipo();

        $servidorDocumentoDigitalExistente = $this->modelManager->find(
            ServidorDocumentoDigital::class,
            $codServidor . "~" . $codTipo
        );

        if ($servidorDocumentoDigitalExistente) {
            $message = $this->trans('servidorDocumentoDigital.errors.tipoExistente');

            $errorElement->with('fkPessoalTipoDocumentoDigital')->addViolation($message)->end();
        }
    }

    /**
     * Faz o upload da imagem
     *
     * @param Servidor     $servidor
     * @param UploadedFile $uploadedFile
     */
    private function uploadArquivoDigital(ServidorDocumentoDigital $servidorDocumentoDigital, UploadedFile $uploadedFile)
    {
        $foldersBundle = $this->getContainer()->getParameter('recursoshumanosbundle');

        try {
            $uploadedFile->move($foldersBundle['servidorDocumentoDigital'], $servidorDocumentoDigital->getArquivoDigital());
        } catch (IOException $IOException) {
            $message = $this->trans('usuario.errors.failedMoveArquivoDigital', [], 'validators');

            $container = $this->getContainer();
            $container
                ->get('session')
                ->getFlashBag()
                ->add('error', $message);

            (new RedirectResponse($this->request->headers->get('referer')))->send();
        }
    }

    /**
     * Persiste a imagem no perfil do usuário
     *
     * @param ServidorDocumentoDigital $servidorDocumentoDigital
     */
    private function persistArquivoDigital(ServidorDocumentoDigital $servidorDocumentoDigital)
    {
        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $this->getForm()->get('arquivoDigital')->getData();

        if (!is_null($uploadedFile)) {
            $profilePictureFileName = md5(date('dmyhis'));
            $profilePictureFileName = sprintf('%s.%s', $profilePictureFileName, $uploadedFile->getClientOriginalExtension());

            $servidorDocumentoDigital->setArquivoDigital($profilePictureFileName);

            $this->uploadArquivoDigital($servidorDocumentoDigital, $uploadedFile);
        }
    }

    /**
     * Remove a foto do perfil.
     *
     * @param ServidorDocumentoDigital $servidorDocumentoDigital
     */
    private function removeArquivoDigital(ServidorDocumentoDigital $servidorDocumentoDigital)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $foldersBundle = $this->getContainer()->getParameter('recursoshumanosbundle');

        $filePath = sprintf('%s/%s', $foldersBundle['servidorDocumentoDigital'], $servidorDocumentoDigital->getArquivoDigital());

        $fileSystem = new Filesystem();
        if ($fileSystem->exists($filePath)) {
            try {
                $fileSystem->remove($filePath);
            } catch (IOException $IOException) {
                $message = $this->trans('usuario.errors.failedRemoveArquivoDigital', [], 'validators');

                $container = $this->getContainer();
                $container
                    ->get('session')
                    ->getFlashBag()
                    ->add('error', $message);

                (new RedirectResponse($this->request->headers->get('referer')))->send();
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function prePersist($servidorDocumentoDigital)
    {
        $entityManager = $this->getDoctrine();

        $fkPessoalServidor = $this->getModelManager()->find(
            Servidor::class,
            $this->getForm()->get('codServidor')->getData()
        );

        $servidorDocumentoDigital->setFkPessoalServidor($fkPessoalServidor);
        $servidorDocumentoDigital->setNomeArquivo(
            $this->getForm()->get('arquivoDigital')->getData()->getClientOriginalName()
        );

        $this->persistArquivoDigital($servidorDocumentoDigital);
    }

    /**
     * {@inheritDoc}
     */
    public function redirect(Servidor $servidor)
    {
        $servidor = $servidor->getCodServidor();
        $this->forceRedirect('/recursos-humanos/pessoal/servidor/' . $servidor .'/show');
    }

    /**
     * {@inheritDoc}
     */
    public function postPersist($servidorDocumentoDigital)
    {
        $this->redirect($servidorDocumentoDigital->getFkPessoalServidor());
    }

    /**
     * {@inheritDoc}
     */
    public function postUpdate($servidorDocumentoDigital)
    {
        $this->redirect($servidorDocumentoDigital->getFkPessoalServidor());
    }

    /**
     * {@inheritDoc}
     */
    public function postRemove($servidorDocumentoDigital)
    {
        $this->removeArquivoDigital($servidorDocumentoDigital);
        $this->redirect($servidorDocumentoDigital->getFkPessoalServidor());
    }

    /**
     * {@inheritDoc}
     */
    public function toString($servidorDocumentoDigital)
    {
        if ($servidorDocumentoDigital->getNomeArquivo()) {
            return $servidorDocumentoDigital->getNomeArquivo();
        }

        return $this->getForm()->get('arquivoDigital')->getData()->getClientOriginalName();
    }
}
