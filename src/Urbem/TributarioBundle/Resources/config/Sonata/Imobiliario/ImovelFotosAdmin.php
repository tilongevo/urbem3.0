<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Imobiliario;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Urbem\CoreBundle\Entity\Imobiliario\Imovel;
use Urbem\CoreBundle\Entity\Imobiliario\ImovelFoto;
use Urbem\CoreBundle\Model\Imobiliario\ImovelFotoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;

class ImovelFotosAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_tributario_imobiliario_imovel_fotos';
    protected $baseRoutePattern = 'tributario/cadastro-imobiliario/imovel-fotos';
    protected $legendButtonSave = array('icon' => 'add_a_photo', 'text' => 'Salvar');

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
            'inscricaoMunicipal' => $this->getRequest()->get('inscricaoMunicipal'),
        );
    }

    /**
     * @return null|Imovel
     */
    public function getImovel()
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $imovel = null;
        if ($this->getPersistentParameter('inscricaoMunicipal')) {
            /** @var Imovel $imovel */
            $imovel = $em->getRepository(Imovel::class)->find($this->getPersistentParameter('inscricaoMunicipal'));
        }
        return $imovel;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions['dadosImovel'] = array(
            'label' => false,
            'mapped' => false,
            'template' => 'TributarioBundle::Imobiliario/Imovel/dadosImovel.html.twig',
            'data' => array(
                'imovel' => $this->getImovel()
            )
        );

        $fieldOptions['fotos'] = array(
            'label' => false,
            'mapped' => false,
            'template' => 'TributarioBundle::Imobiliario/Imovel/fotos.html.twig',
            'data' => array(
                'imovel' => $this->getImovel()
            )
        );

        $formMapper->with('label.imobiliarioImovel.dados');
        $formMapper->add('dadosImovel', 'customField', $fieldOptions['dadosImovel']);
        $formMapper->end();
        $formMapper->with('label.imobiliarioImovelFoto.fotosImovel');
        $formMapper->add('fotos', 'customField', $fieldOptions['fotos']);
        $formMapper->add(
            'fkImobiliarioImovelFotos',
            'sonata_type_collection',
            [
                'label' => false
            ],
            [
                'edit' => 'inline',
                'inline' => 'table',
                'sortable' => 'position'
            ]
        );
        $formMapper->end();
    }

    /**
     * @return string
     */
    public function getPictureUploadDir()
    {
        $foldersBundle = $this->getContainer()->getParameter('tributariobundle');
        return $foldersBundle['imovelFoto'];
    }

    /**
     * @return string
     */
    public function getPictureShowDir()
    {
        $foldersBundle = $this->getContainer()->getParameter('tributariobundle');
        return $foldersBundle['imovelFotoShow'];
    }

    /**
     * @return string
     */
    public function getPictureDownloadDir()
    {
        $foldersBundle = $this->getContainer()->getParameter('tributariobundle');
        return $foldersBundle['imovelFotoDownload'];
    }

    /**
     * @param ImovelFoto $imovelFoto
     * @param UploadedFile $uploadedFile
     */
    private function uploadPicture(ImovelFoto $imovelFoto, UploadedFile $uploadedFile)
    {
        try {
            $uploadedFile->move($this->getPictureUploadDir(), $imovelFoto->getFoto());
        } catch (IOException $IOException) {
            $message = $this->trans('label.imobiliarioImovelFoto.falhaArmazenar');

            $container = $this->getContainer();
            $container->get('session')->getFlashBag()->add('error', $message);

            (new RedirectResponse($this->request->headers->get('referer')))->send();
        }
    }

    /**
     * @param ImovelFoto $imovelFoto
     */
    private function removeUploadedPicture(ImovelFoto $imovelFoto)
    {
        $filePath = sprintf('%s/%s', $this->getPictureUploadDir(), $imovelFoto->getFoto());

        $fileSystem = new Filesystem();
        if ($fileSystem->exists($filePath) && !empty($imovelFoto->getFoto())) {
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
     * @param Imovel $object
     */
    public function prePersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();

        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $imovel = $this->getImovel();

        $remover = ($this->request->request->get('remover'))
            ? $this->request->request->get('remover')
            : array();

        foreach ($remover as $codFoto) {
            $imovelFoto = $em->getRepository(ImovelFoto::class)
                ->findOneBy(
                    array(
                        'inscricaoMunicipal' => $imovel->getInscricaoMunicipal(),
                        'codFoto' => $codFoto
                    )
                );
            if ($imovelFoto) {
                $this->removeUploadedPicture($imovelFoto);
                $imovel->getFkImobiliarioImovelFotos()->removeElement($imovelFoto);
            }
        }

        $imovelFotos = $this->getForm()->get('fkImobiliarioImovelFotos')->getData();

        if ($imovelFotos->count()) {
            $arquivos = $this->request->files->get($this->uniqid)['fkImobiliarioImovelFotos'];
            $descricoes = $this->request->request->get($this->uniqid)['fkImobiliarioImovelFotos'];

            $codFoto = (new ImovelFotoModel($em))->getNextVal($imovel->getInscricaoMunicipal());

            foreach ($arquivos as $key => $arquivo) {
                if ($imovelFotos->get($key)) {
                    /** @var UploadedFile $uploadedFile */
                    $uploadedFile = $arquivo['foto'];
                    if (!is_null($uploadedFile)) {
                        $imovelFoto = new ImovelFoto();
                        $imovelFoto->setCodFoto($codFoto);
                        $imovelFoto->setDescricao($descricoes[$key]['descricao']);

                        $pictureFileName = md5(date('dmyhis') . $key);
                        $pictureFileName = sprintf('%s.%s', $pictureFileName, $uploadedFile->getClientOriginalExtension());

                        $imovelFoto->setFoto($pictureFileName);

                        $this->uploadPicture($imovelFoto, $uploadedFile);
                        $imovel->addFkImobiliarioImovelFotos($imovelFoto);
                    }
                    $codFoto++;
                }
            }
        }

        try {
            $em->persist($imovel);
            $em->flush();

            $container->get('session')->getFlashBag()->add('success', $this->getTranslator()->trans('label.imobiliarioImovelFoto.msgSucesso', array('%inscricaoMunicipal%' => $imovel->getInscricaoMunicipal())));
            $this->forceRedirect('/tributario/cadastro-imobiliario/imovel/list');
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
            $container->get('session')->getFlashBag()->add('error', $e->getMessage());
            $this->forceRedirect('/tributario/cadastro-imobiliario/imovel/list');
        }
    }

    /**
     * @param Imovel $object
     * @return string
     */
    public function toString($object)
    {
        return ($object->getInscricaoMunicipal())
            ? (string) $object
            : $this->getTranslator()->trans('label.imobiliarioImovelFoto.modulo');
    }
}
