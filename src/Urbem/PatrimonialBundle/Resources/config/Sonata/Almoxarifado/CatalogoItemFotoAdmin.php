<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Validator\Constraints as Assert;

class CatalogoItemFotoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_almoxarifado_catalogo_item_foto';
    protected $baseRoutePattern = 'patrimonial/almoxarifado/catalogo-item-foto';
    protected $legendButtonSave = array('icon' => 'add_a_photo', 'text' => 'Salvar');
    protected $includeJs = array(
        '/patrimonial/javascripts/almoxarifado/catalogoItemFoto.js'
    );

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('create'));
    }

    /**
     * @return array
     */
    public function getPersistentParameters()
    {
        if (!$this->getRequest()) {
            return array();
        }

        return array(
            'item' => $this->getRequest()->get('item'),
        );
    }

    /**
     * @return null|object
     */
    public function getItem()
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $item = null;
        if ($this->getPersistentParameter('item')) {
            $item = $em->getRepository(CatalogoItem::class)->find($this->getRequest()->get('item'));
        }

        return $item;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);
        $item = $this->getItem();

        $fieldOptions['dadosItem'] = array(
            'label' => false,
            'mapped' => false,
            'template' => 'PatrimonialBundle::Almoxarifado/CatalogoItem/dadosItem.html.twig',
            'data' => array(
                'item' => $item
            )
        );

        $fieldOptions['fotoShow'] = array(
            'label' => false,
            'mapped' => false,
            'template' => 'PatrimonialBundle::Almoxarifado/CatalogoItem/foto.html.twig',
            'data' => array(
                'item' => $item
            )
        );

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

        $fieldOptions['descricao'] = [
            'mapped' => false,
            'label' => 'label.imobiliarioImovelFoto.descricao',
            'required' => true,
        ];

        $formMapper->with('label.catalogoItem.cabecalhoItem');
        $formMapper->add('dadosItem', 'customField', $fieldOptions['dadosItem']);
        $formMapper->end();
        $formMapper->with('label.catalogoItem.fotoItem');
        $formMapper->add('fotoShow', 'customField', $fieldOptions['fotoShow']);
        $formMapper->end();
        $formMapper->with(' ', ['class' => 'fotoInclusao']);
        $formMapper->add('foto', 'file', $fieldOptions['foto']);
        $formMapper->add('descricao', 'text', $fieldOptions['descricao']);
        $formMapper->end();
    }

    /**
     * @return string
     */
    public function getPictureUploadDir()
    {
        $foldersBundle = $this->getContainer()->getParameter('patrimonialbundle');

        return $foldersBundle['catalogoItemFoto'];
    }

    /**
     * @param CatalogoItem $catalogoItem
     * @param UploadedFile $uploadedFile
     */
    private function uploadPicture(CatalogoItem $catalogoItem, UploadedFile $uploadedFile)
    {
        try {
            $uploadedFile->move($this->getPictureUploadDir(), $catalogoItem->getFoto());
        } catch (IOException $IOException) {
            $message = $this->trans('label.imobiliarioImovelFoto.falhaArmazenar');

            $container = $this->getContainer();
            $container->get('session')->getFlashBag()->add('error', $message);

            (new RedirectResponse($this->request->headers->get('referer')))->send();
        }
    }

    /**
     * @param CatalogoItem $catalogoItem
     */
    private function removeUploadedPicture(CatalogoItem $catalogoItem)
    {
        $filePath = sprintf('%s/%s', $this->getPictureUploadDir(), $catalogoItem->getFoto());

        $fileSystem = new Filesystem();
        if ($fileSystem->exists($filePath) && !empty($catalogoItem->getFoto())) {
            try {
                $fileSystem->remove($filePath);
            } catch (IOException $IOException) {
                $message = $this->trans('label.imobiliarioImovelFoto.falhaRemover');

                $container = $this->getContainer();
                $container->get('session')->getFlashBag()->add('error', $message);

                (new RedirectResponse($this->request->headers->get('referer')))->send();
            }
        }
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $em = $this->modelManager->getEntityManager($this->getClass());

        $remover = ($this->request->request->get('remover')) ? $this->request->request->get('remover') : array();
        $foto = $this->getForm()->get('foto')->getData();
        $descricao = $this->getForm()->get('descricao')->getData();

        if (is_null($foto) && empty($remover)) {
            $this->forceRedirect('/patrimonial/almoxarifado/catalogo-item/list');
        }

        $item = $this->getItem();
        $catalogoItem = $em->getRepository(CatalogoItem::class)->findOneBy(['codItem' => $item->getCodItem()]);

        if ($catalogoItem) {
            $this->removeUploadedPicture($catalogoItem);
            $catalogoItem->setFoto(null);
            $catalogoItem->setDescricaoFoto(null);
        }

        if (!is_null($foto)) {
            $pictureFileName = md5(date('dmyhis') . $item);
            $pictureFileName = sprintf('%s.%s', $pictureFileName, $foto->getClientOriginalExtension());
            $catalogoItem->setFoto($pictureFileName);
            $catalogoItem->setDescricaoFoto($descricao);
            $this->uploadPicture($catalogoItem, $foto);
        }

        try {
            $em->persist($catalogoItem);
            $em->flush();

            if (empty($remover)) {
                $container->get('session')->getFlashBag()->add('success', $this->getTranslator()->trans('label.catalogoItem.msgSalvar'));
            } else {
                $container->get('session')->getFlashBag()->add('success', $this->getTranslator()->trans('label.catalogoItem.msgExcluir'));
            }

            $this->forceRedirect('/patrimonial/almoxarifado/catalogo-item/list');
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
            $container->get('session')->getFlashBag()->add('error', $e->getMessage());
            $this->forceRedirect('/patrimonial/almoxarifado/catalogo-item/list');
        }
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function toString($object)
    {
        return ($object)
            ? (string) $object
            : $this->getTranslator()->trans('label.catalogoItem.catalogoItemFoto');
    }
}
