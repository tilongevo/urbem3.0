<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao;

use Exception;
use Urbem\CoreBundle\Entity\Licitacao\ContratoArquivo;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\ContratoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Helper\UploadHelper;

class ContratoArquivoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_contrato_arquivo';

    protected $baseRoutePattern = 'patrimonial/licitacao/contrato-arquivo';

    protected $exibirBotaoIncluir = false;

    /**
     * @param ContratoArquivo $contratoArquivo
     * @throws Exception
     */
    public function prePersist($contratoArquivo)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $formData = $this->getRequest()->request->get($this->getUniqid());
        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());

        $contratoModel = new ContratoModel($entityManager);
        $contrato = $contratoModel->getOneContrato($formData['exercicioEntidade'], $formData['codEntidade'], $formData['numContrato']);

        $contratoArquivo->setFkLicitacaoContrato($contrato);

        try {
            if ($contratoArquivo->getArquivo() !== null) {
                $contratoarquivo = $container->getParameter("patrimonialbundle");

                $upload = new UploadHelper();
                $upload->setPath($contratoarquivo['contratoarquivo']);

                $upload->setFile($contratoArquivo->getArquivo());
                $arquivo = $upload->executeUpload();
                $contratoArquivo->setArquivo($arquivo['name']);
            }
        } catch (Exception $e) {
            $container->get('session')->getFlashBag()->add('error', self::ERROR_REMOVE_DATA);
            throw $e;
        }
    }

    /**
     * @param ContratoArquivo $contratoArquivo
     * @throws Exception
     */
    public function preUpdate($contratoArquivo)
    {
        $container = $this->getConfigurationPool()->getContainer();

        try {
            if ($contratoArquivo->getArquivo() !== null) {
                $contratoarquivo = $container->getParameter("patrimonialbundle");

                $upload = new UploadHelper();
                $upload->setPath($contratoarquivo['contratoarquivo']);

                $upload->setFile($contratoArquivo->getArquivo());
                $arquivo = $upload->executeUpload();
                $contratoArquivo->setArquivo($arquivo['name']);
            } else {
                $formData = $this->getRequest()->request->get($this->getUniqid());
                $contratoArquivo->setArquivo($formData['arquivoOld']);
            }
        } catch (Exception $e) {
            $container->get('session')->getFlashBag()->add('error', self::ERROR_REMOVE_DATA);
            throw $e;
        }
    }

    /**
     * @param ContratoArquivo $contratoArquivo
     */
    public function postPersist($contratoArquivo)
    {
        $this->redirectShow($contratoArquivo);
    }


    /**
     * @param ContratoArquivo $contratoArquivo
     */
    public function postUpdate($contratoArquivo)
    {
        $this->redirectShow($contratoArquivo);
    }


    /**
     * @param ContratoArquivo $contratoArquivo
     */
    public function postRemove($contratoArquivo)
    {
        $this->redirectShow($contratoArquivo);
    }

    /**
     * @param ContratoArquivo  $contratoArquivo
     */
    public function redirectShow(ContratoArquivo  $contratoArquivo){
        $url = '/patrimonial/compras/contrato/' . $this->getObjectKey($contratoArquivo->getFkLicitacaoContrato()).'/show';
        $this->forceRedirect($url);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('exercicio')
            ->add('arquivo')
            ->add('nomArquivo');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('exercicio')
            ->add('arquivo')
            ->add('nomArquivo', null, ['label' => 'Nome do Arquivo']);
        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        if (!$this->getRequest()->isMethod('GET')) {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $numContrato = $formData['numContrato'];
            $exercicioEntidade = $formData['exercicioEntidade'];
            $codEntidade = $formData['codEntidade'];
        } else {
            list($exercicioEntidade, $codEntidade, $numContrato) = explode("~", $id);
        }

        $fieldOptions['arquivoOld'] = [
            'mapped' => false
        ];

        $fieldOptions['arquivo'] = [];
        if ($this->id($this->getSubject())) {
            $link = $this->getSubject()->getArquivo();

            if (($link != "") && ($link != null)) {
                $container = $this->getConfigurationPool()->getContainer();
                $contratoarquivo = $container->getParameter("patrimonialbundle");

                $fullPath = $contratoarquivo['contratoarquivoDownload'] . $link;
                $fieldOptions['arquivo']['required'] = false;
                $fieldOptions['arquivo']['data_class'] = null;
                $fieldOptions['arquivo']['help'] = '<a href="' . $fullPath . '">' . $link . '</a>';
                $fieldOptions['arquivoOld']['data'] = $link;
            }
        }

        $formMapper
            ->add('arquivo', 'file', $fieldOptions['arquivo'])
            ->add('numContrato', 'hidden', ['data' => $numContrato, 'mapped' => false])
            ->add('codEntidade', 'hidden', ['data' => $codEntidade, 'mapped' => false])
            ->add('exercicioEntidade', 'hidden', ['data' => $exercicioEntidade, 'mapped' => false])
            ->add('arquivoOld', 'hidden', $fieldOptions['arquivoOld'])
            ->add('nomArquivo', null, ['label' => 'Nome do Arquivo']);
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('exercicio')
            ->add('arquivo')
            ->add('nomArquivo');
    }
}
