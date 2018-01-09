<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Protocolo;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Config\Definition\Exception\Exception;
use Urbem\CoreBundle\Entity\SwDocumentoProcesso;
use Urbem\CoreBundle\Helper\UploadHelper;
use Urbem\CoreBundle\Model\SwDocumentoProcessoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Symfony\Component\Validator\Constraints as Assert;

class ProcessoDocumentoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_administrativo_protocolo_processo_documento';
    protected $baseRoutePattern = 'administrativo/protocolo/processo-documento';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codProcesso')
            ->add('anoExercicio')
            ->add('codUsuario')
            ->add('timestamp')
            ->add('observacoes')
            ->add('confidencial')
            ->add('resumoAssunto')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('codProcesso')
            ->add('anoExercicio')
            ->add('codUsuario')
            ->add('timestamp')
            ->add('observacoes')
            ->add('confidencial')
            ->add('resumoAssunto')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        # documentos path
        $container = $this->getConfigurationPool()->getContainer();
        $servidorPath = $container->getParameter("administrativobundle");

        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\SwProcesso');
        $processo = $em->getRepository('CoreBundle:SwProcesso')->findOneByCodProcesso($id);

        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\SwDocumentoProcesso');
        $documentoProcessoModel = new SwDocumentoProcessoModel($em);
        $documentos = $documentoProcessoModel->getDocumentosPorCodAssuntoECodClassificacao($processo->getCodAssunto(), $processo->getCodClassificacao());

        foreach ($documentos as $key => $documento) {
            $help = '';
            if (! is_null($documento['id'])) {
                $processoDocumentoPath = $container->getParameter("administrativobundle");

                $finder = new \Symfony\Component\Finder\Finder();
                $finder->files()->in($container->get('kernel')->getRootDir() . "/../var/datafiles/" . $processoDocumentoPath['documentoProcesso'] . "/");
                foreach ($finder as $file) {
                    $fileName = explode('.', $file->getFilename());
                    if ($fileName[0] == $documento['id']) {
                        $fullPath = $processoDocumentoPath['documentoProcessoDownload'] . $file->getFilename();
                    }
                }

                $help = '<a href="' . $fullPath . '">' . $documento['nom_documento'] . '</a>';
            }

            $formMapper->add(
                'documento_' . $documento['cod_documento'],
                'file',
                [
                    'mapped' => false,
                    'label' => $documento['nom_documento'],
                    'required' => false,
                    'constraints' => array(
                        new Assert\File(array(
                            'mimeTypes' => array('image/png', 'image/jpg', 'application/pdf'),
                            'mimeTypesMessage' => 'Somente arquivos no formato PNG, JPG ou PDF'
                        ))
                    ),
                    'help' => $help
                ]
            );
        }
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codProcesso')
            ->add('anoExercicio')
            ->add('codUsuario')
            ->add('timestamp')
            ->add('observacoes')
            ->add('confidencial')
            ->add('resumoAssunto')
        ;
    }

    public function preUpdate($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\SwDocumentoProcesso');

            $childrens = $this->getForm()->all();

            $i = 0;
            foreach ($childrens as $key => $children) {
                $info = explode('_', $key);
                $cod_documento = $info[1];
                $file = $children->getViewData();
                if (empty($file)) {
                    $i++;
                    continue;
                }
                $swDocumento = $em->getRepository('CoreBundle:SwDocumento')->findOneByCodDocumento($cod_documento);

                $swDocumentoProcessoModel = new SwDocumentoProcessoModel($em);
                $documentoProcesso = new SwDocumentoProcesso();
                $documentoProcesso->setExercicio($object->getAnoExercicio());
                $documentoProcesso->setCodProcesso($object);
                $documentoProcesso->setCodDocumento($swDocumento);

                $swDocumentoProcessoModel->save($documentoProcesso);

                $documento = $container->getParameter("administrativobundle");
                $documentoPath = $documento['documentoProcesso'];

                $upload = new UploadHelper();
                $upload->setPath($documentoPath);
                $upload->setFile($file);

                $upload->executeUpload($documentoProcesso->getId());
                $i++;
            }
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            $container->get('session')->getFlashBag()->add('error', self::ERROR_REMOVE_DATA);
            throw $e;
        }

        $this->forceRedirect("/administrativo/protocolo/processo/perfil?id=" . $object);
    }
}
