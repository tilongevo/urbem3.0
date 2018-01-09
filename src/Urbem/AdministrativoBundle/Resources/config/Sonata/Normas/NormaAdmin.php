<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Normas;

use Doctrine\ORM\EntityManager;

use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Urbem\AdministrativoBundle\Helper\Constants\TipoAtributo;
use Urbem\CoreBundle\Entity\Administracao\AtributoDinamico;
use Urbem\CoreBundle\Entity\Administracao\AtributoValorPadrao;
use Urbem\CoreBundle\Entity\Administracao\Cadastro;
use Urbem\CoreBundle\Entity\Normas\AtributoNormaValor;
use Urbem\CoreBundle\Entity\Normas\AtributoTipoNorma;
use Urbem\CoreBundle\Entity\Normas\Norma;
use Urbem\CoreBundle\Model\Administracao\AtributoDinamicoModel;
use Urbem\CoreBundle\Model\Normas\AtributoNormaValorModel;
use Urbem\CoreBundle\Model\Normas\NormaDataTerminoModel;
use Urbem\CoreBundle\Model\Normas\NormaModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Urbem\CoreBundle\Entity\Normas;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Sonata\DoctrineORMAdminBundle\Model\ModelManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class NormaAdmin
 *
 * @package Urbem\AdministrativoBundle\Resources\config\Sonata\Normas
 */
class NormaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_administrativo_normas_norma';
    protected $baseRoutePattern = 'administrativo/normas/norma';

    protected $model = NormaModel::class;

    protected $includeJs = [
        '/administrativo/javascripts/administracao/atributo-dinamico-component.js',
        '/administrativo/javascripts/normas/norma.js'
    ];

    protected $datagridValues = [
        '_sort_order' => 'DESC',
        '_sort_by'    => 'codNorma',
    ];

    const MODULO = 'Normas';
    const CADASTRO = 'Tipo Norma';
    const COD_MODULO = 15;
    const COD_CADASTRO = 1;

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('fkNormasTipoNorma', null, ['label' => 'label.norma.codTipoNorma'])
            ->add('numNorma', null, ['label' => 'label.norma.numNorma'])
            ->add('exercicio', null, ['label' => 'label.norma.exercicio'])
            ->add('nomNorma', null, ['label' => 'label.norma.nomNorma'])
            ->add('descricao', null, ['label' => 'label.norma.descricao']);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('numNorma', null, ['label' => 'label.norma.numNorma'])
            ->add('exercicio', null, ['label' => 'label.norma.exercicio'])
            ->add('nomNorma', null, ['label' => 'label.norma.nomNorma'])
            ->add('descricao', null, ['label' => 'label.norma.descricao']);

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param integer $length
     *
     * @return Assert\Length
     */
    private function addConstraintLength($length)
    {
        return new Assert\Length([
            'max'        => $length,
            'maxMessage' => $this->trans('default.errors.lengthExceeded', ['%number%' => $length], 'validators')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        /** @var ModelManager $modelManager */
        $modelManager = $this->modelManager;

        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        /** @var Norma $norma */
        $norma = $this->getSubject();

        /** @var boolean $editMode */
        $editMode = $this->id($this->getSubject());

        /** @var Cadastro $cadastro */
        $cadastro = $modelManager->findOneBy(Cadastro::class, [
            'codModulo'   => self::COD_MODULO,
            'codCadastro' => self::COD_CADASTRO,
        ]);

        $fieldOptions = [];
        $fieldOptions['numNorma'] = [
            'attr'        => ['maxlength' => 6],
            'constraints' => [$this->addConstraintLength(6)],
            'label'       => 'label.norma.numNorma',
        ];

        $fieldOptions['exercicio'] = [
            'attr'        => ['maxlength' => 4],
            'constraints' => [$this->addConstraintLength(4)],
            'label'       => 'label.norma.exercicio',
        ];

        $fieldOptions['nomNorma'] = [
            'attr'        => ['maxlength' => 80],
            'constraints' => [$this->addConstraintLength(80)],
            'label'       => 'label.norma.nomNorma'
        ];

        $fieldOptions['link'] = [
            'attr'        => ['maxlength' => 80],
            'constraints' => [
                new Assert\File([
                    'maxSize'          => '10M',
                    'maxSizeMessage'   => $this->trans('default.errors.maxFileSizeExeeded', [], 'validators'),
                    'mimeTypes'        => [
                        'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'application/pdf',
                        'application/vnd.oasis.opendocument.text'
                    ],
                    'mimeTypesMessage' => $this->trans('default.errors.invalidMimeType', [], 'validators')
                ])
            ],
            'label'       => 'label.norma.link',
            'mapped'      => false,
            'required'    => false
        ];

        $fieldOptions['dtPublicacao'] = [
            'format' => 'dd/MM/yyyy',
            'label'  => 'label.norma.dtPublicacao'
        ];

        $fieldOptions['dtAssinatura'] = [
            'format' => 'dd/MM/yyyy',
            'label'  => 'label.norma.dtAssinatura'
        ];

        $fieldOptions['dtTermino'] = [
            'format'   => 'dd/MM/yyyy',
            'label'    => 'label.norma.dtTermino',
            'required' => false,
            'mapped'   => false
        ];

        $fieldOptions['codModulo'] = [
            'data'   => $cadastro->getCodModulo(),
            'mapped' => false
        ];

        $fieldOptions['codCadastro'] = [
            'data'   => $cadastro->getCodCadastro(),
            'mapped' => false
        ];

        $fieldOptions['codNorma'] = [
            'data'   => $id,
            'mapped' => false
        ];

        $fieldOptions['descricao'] = [
            'attr'     => [
                'class'       => 'mensagem-inicial textarea-custom ',
                'placeholder' => 'Digite aquí a descrição da norma.'
            ],
            'label'    => 'label.norma.descricao',
            'required' => false
        ];

        $fieldOptions['atributosDinamicos'] = [
            'mapped'   => false,
            'required' => false
        ];

        if ($editMode) {
            $link = $norma->getLink();

            if (($link != "") && ($link != null)) {
                $container = $this->getConfigurationPool()->getContainer();
                $normasPath = $container->getParameter("administrativobundle");

                $fullPath = $normasPath['normaDownload'] . $link;

                $fieldOptions['link']['help'] = '<a href="' . $fullPath . '">' . $link . '</a>';
            }

            $normaDataTermino = $entityManager->getRepository("CoreBundle:Normas\NormaDataTermino")->findOneByCodNorma($id);

            $dtTermino = null;
            if ($normaDataTermino) {
                $dtTermino = $normaDataTermino->getDtTermino();
            }

            $fieldOptions['dtTermino']['data'] = $dtTermino;
        }

        $formMapper->with('label.norma.dadosNorma');

        if ($editMode) {
            $fieldOptions['fkNormasTipoNorma'] = [
                'data'     => [
                    'label' => 'label.norma.codTipoNorma',
                    'value' => $norma->getFkNormasTipoNorma()
                ],
                'label'    => false,
                'mapped'   => false,
                'template' => 'CoreBundle:Sonata\CRUD:edit_generic.html.twig'
            ];

            $formMapper->add('fkNormasTipoNorma', 'customField', $fieldOptions['fkNormasTipoNorma']);
        } else {
            $fieldOptions['fkNormasTipoNorma'] = [
                'label'       => 'label.norma.codTipoNorma',
                'placeholder' => 'label.selecione',
                'required'    => true,
                'attr'        => ['class' => 'select2-parameters ']
            ];

            $formMapper->add('fkNormasTipoNorma', null, $fieldOptions['fkNormasTipoNorma']);
        }

        $formMapper->add('numNorma', null, $fieldOptions['numNorma'])
            ->add('exercicio', null, $fieldOptions['exercicio'])
            ->add('nomNorma', null, $fieldOptions['nomNorma'])
            ->add('dtPublicacao', 'sonata_type_date_picker', $fieldOptions['dtPublicacao'])
            ->add('dtAssinatura', 'sonata_type_date_picker', $fieldOptions['dtAssinatura'])
            ->add('dtTermino', 'sonata_type_date_picker', $fieldOptions['dtTermino'])
            ->add('link', 'file', $fieldOptions['link'])
            ->add('codModulo', 'hidden', $fieldOptions['codModulo'])
            ->add('codCadastro', 'hidden', $fieldOptions['codCadastro']);

        if ($this->id($this->getSubject())) {
            $formMapper->add('codNorma', 'hidden', $fieldOptions['codNorma']);
        }

        $formMapper
            ->add('descricao', 'textarea', $fieldOptions['descricao'])
            ->end();

        $formMapper->with('Atributos');

        /**
         * Se for uma edição ele reenderiza nativamente os atributos dinamicos,
         * sem a necessidade do uso do javascript.
         */
        if ($editMode) {
            /** @var Normas\AtributoTipoNorma $atributoTipoNorma */
            foreach ($norma->getFkNormasTipoNorma()->getFkNormasAtributoTipoNormas() as $atributoTipoNorma) {

                /** @var AtributoNormaValor $atributoNormaValor */
                $atributoNormaValor = $modelManager->findOneBy(AtributoNormaValor::class, [
                    'fkNormasNorma'             => $norma,
                    'fkNormasAtributoTipoNorma' => $atributoTipoNorma
                ]);

                $data = true === empty($atributoNormaValor) ? null : $atributoNormaValor->getValor();
                $data = true === empty($data) ? null : $data;

                $options = [
                    'data' => $data
                ];

                $this->configureFormFieldsAtributoDinamico($formMapper, $atributoTipoNorma->getFkAdministracaoAtributoDinamico(), $options);
            }
        } else {
            $formMapper->add('atributosDinamicos', 'text', [
                'mapped'   => false,
                'required' => false
            ]);
        }

        $formMapper->end();
    }

    /**
     * Constrói campos de atributo dinamico para edição.
     *
     * @param FormMapper       $formMapper
     * @param AtributoDinamico $atributoDinamico
     * @param array            $options
     */
    public function configureFormFieldsAtributoDinamico(FormMapper $formMapper, AtributoDinamico $atributoDinamico, array $options = [])
    {
        $baseFieldOptions = [
            'label'    => $atributoDinamico->getNomAtributo(),
            'mapped'   => false,
            'required' => false
        ];

        $fieldName = sprintf('atributoDinamico_%s_%s', $atributoDinamico->getCodAtributo(), TipoAtributo::getNomeAtributo($atributoDinamico->getCodTipo()));

        switch ($atributoDinamico->getCodTipo()) {
            case TipoAtributo::NUMERICO:
                $options = array_merge($options, $baseFieldOptions);

                if (isset($options['data'])) {
                    $options['data'] = abs($options['data']);
                }

                $formMapper->add($fieldName, 'number', $options);
                break;
            case TipoAtributo::TEXTO:
                $options = array_merge($options, $baseFieldOptions);

                $formMapper->add($fieldName, 'text', $options);
                break;
            case TipoAtributo::LISTA:
            case TipoAtributo::LISTA_MULTIPLA:
                $choices = [];

                /** @var AtributoValorPadrao $atributoValorPadrao */
                foreach ($atributoDinamico->getFkAdministracaoAtributoValorPadroes() as $atributoValorPadrao) {
                    $optionLabel = $atributoValorPadrao->getValorPadrao();
                    $optionValue = $atributoValorPadrao->getCodValor();

                    $choices[$optionLabel] = $optionValue;
                }

                $data = null;

                if (false === empty($options['data'])) {
                    $data = $options['data'];
                }

                if (TipoAtributo::LISTA_MULTIPLA === $atributoDinamico->getCodTipo()) {
                    $data = true === empty($data) ? '' : $data;
                    $data = true === is_array($data) ? $data : explode(',', $data);
                }

                $options['data'] = $data;

                $baseFieldOptions['choices'] = $choices;
                $baseFieldOptions['multiple'] = ($atributoDinamico->getCodTipo() == TipoAtributo::LISTA_MULTIPLA);

                $options = array_merge($options, $baseFieldOptions);

                $formMapper->add($fieldName, 'choice', $options);
                break;
            case TipoAtributo::DATA:
                $baseFieldOptions['format'] = 'dd/MM/yyyy';

                $options = array_merge($options, $baseFieldOptions);

                if (false === empty($options['data'])) {
                    $options['data'] = \DateTime::createFromFormat('d/m/Y', $options['data']);
                }

                $formMapper->add($fieldName, 'sonata_type_date_picker', $options);
                break;
            case TipoAtributo::NUMERICO_2:
                $options = array_merge($options, $baseFieldOptions);

                if (isset($options['data'])) {
                    $options['data'] = abs($options['data']);
                }

                $formMapper->add($fieldName, 'text', $options);
                break;
            case TipoAtributo::TEXTO_LONGO:
                $baseFieldOptions['attr']['class'] = 'money ';

                $options = array_merge($options, $baseFieldOptions);

                $formMapper->add($fieldName, 'textarea', $options);
                break;
        }
    }

    /**
     * @return string|null
     */
    private function getFileLink()
    {
        /** @var Norma $norma */
        $norma = $this->getSubject();

        $fileSystem = new Filesystem();

        $foldersAdminBundle = $this->getContainer()->getParameter('administrativobundle');
        $fileName = $norma->getLink();

        $filePath = sprintf('%s/%s', $foldersAdminBundle['norma'], $fileName);

        if ($fileSystem->exists($filePath) && !empty($fileName)) {
            return $filePath;
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb(['id' => $id]);

        /** @var Norma $norma */
        $norma = $this->getSubject();

        $customTemplate = 'CoreBundle:Sonata/CRUD:show_custom_html.html.twig';

        $showMapper
            ->add('codNorma', null, ['label' => 'label.norma.codNorma'])
            ->add('numNorma', null, [
                'label'    => 'label.norma.numNorma',
                'data'     => sprintf('%06s/%s', $norma->getNumNorma(), $norma->getExercicio()),
                'template' => $customTemplate,
            ])
            ->add('fkNormasTipoNorma', null, ['label' => 'label.norma.codTipoNorma'])
            ->add('nomNorma', null, ['label' => 'label.norma.nomNorma'])
            ->add('descricao', null, ['label' => 'label.norma.descricao'])
            ->add('dtPublicacao', null, ['label' => 'label.norma.dtPublicacao'])
            ->add('dtAssinatura', null, ['label' => 'label.norma.dtAssinatura'])
            ->add('fkNormasNormaDataTermino', null, ['label' => 'label.norma.dtTermino']);

        $atributoNormaValores = $norma->getFkNormasAtributoNormaValores();

        /** @var AtributoNormaValor $atributoNormaValor */
        foreach ($atributoNormaValores as $index => $atributoNormaValor) {
            $showInfoKey = sprintf('%s_atributo', $index + 1);
            $showInfoLabel = $atributoNormaValor->getFkNormasAtributoTipoNorma()->getFkAdministracaoAtributoDinamico()->getNomAtributo();

            $showMapper->add($showInfoKey, null, [
                'data'     => $atributoNormaValor,
                'label'    => $showInfoLabel,
                'mapped'   => false,
                'template' => $customTemplate
            ]);
        }

        $fileLink = $this->getFileLink();
        if (!is_null($fileLink)) {
            $showMapper->add('link', null, [
                'data'     => sprintf('<a href="/%s" target="_blank">%s</a>', $fileLink, $norma->getLink()),
                'label'    => 'label.norma.link',
                'mapped'   => false,
                'template' => $customTemplate,
            ]);
        }
    }

    /**
     * @param Norma $norma
     */
    private function persistFkNormasNormaDataTermino(Norma $norma)
    {
        /** @var \DateTime $dtTermino */
        $dtTermino = $this->getForm()->get('dtTermino')->getData();

        if (!is_null($dtTermino)) {
            /** @var EntityManager $entityManager */
            $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

            $normaDataTermino = (new NormaDataTerminoModel($entityManager))->buildOne($norma, $dtTermino);
        }
    }

    /**
     * @param Norma $norma
     */
    private function updateFkNormasNormaDataTermino(Norma $norma)
    {
        /** @var \DateTime $dtTermino */
        $dtTermino = $this->getForm()->get('dtTermino')->getData();


        /** @var EntityManager $entityManager */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $normaDataTerminoModel = new NormaDataTerminoModel($entityManager);
        $normaDataTermino = $norma->getFkNormasNormaDataTermino();

        if (!is_null($dtTermino) && !is_null($normaDataTermino)) {
            /** @var EntityManager $entityManager */
            $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

            $normaDataTerminoModel->updateOne($normaDataTermino, $dtTermino);
        } elseif (!is_null($dtTermino)) {
            $this->persistFkNormasNormaDataTermino($norma);
        }
    }

    /**
     * @param Norma        $norma
     * @param UploadedFile $uploadedFile
     */
    private function uploadFile(Norma $norma, UploadedFile $uploadedFile)
    {
        $foldersAdminBundle = $this->getContainer()->getParameter('administrativobundle');

        try {
            $uploadedFile->move($foldersAdminBundle['norma'], $norma->getLink());
        } catch (IOException $IOException) {
            $message = $this->trans('default.errors.failedUploadFile', [], 'validators');

            $container = $this->getContainer();
            $container
                ->get('session')
                ->getFlashBag()
                ->add('error', $message);

            (new RedirectResponse($this->request->headers->get('referer')))->send();
        }
    }

    /**
     * @param Norma $norma
     */
    private function persistUploadedFileLink(Norma $norma)
    {
        /** @var UploadedFile|null $uploadedFile */
        $uploadedFile = $this->getForm()->get('link')->getData();

        if (!is_null($uploadedFile)) {
            $norma->setLink($uploadedFile->getClientOriginalName());

            $this->uploadFile($norma, $uploadedFile);
        } else {
            $norma->setLink("");
        }
    }

    /**
     * @param Norma $norma
     */
    private function removeUploadedFileLink(Norma $norma)
    {
        $foldersAdminBundle = $this->getContainer()->getParameter('administrativobundle');

        $filePath = sprintf('%s/%s', $foldersAdminBundle['norma'], $norma->getLink());

        $fileSystem = new Filesystem();
        if ($fileSystem->exists($filePath) && !empty($norma->getLink())) {
            try {
                $fileSystem->remove($filePath);
            } catch (IOException $IOException) {
                $message = $this->trans('default.errors.failedRemoveFile', [], 'validators');

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
     * @param Norma $norma
     */
    private function updateUploadedFileLink(Norma $norma)
    {
        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $this->getForm()->get('link')->getData();

        if (!is_null($uploadedFile)) {
            $this->removeUploadedFileLink($norma);
            $this->persistUploadedFileLink($norma);
        }
    }

    /**
     * @param Norma $norma
     */
    public function prePersist($norma)
    {
        $this->persistUploadedFileLink($norma);
    }

    /**
     * @param Norma $norma
     */
    public function postPersist($norma)
    {
        $this->persistFkNormasNormaDataTermino($norma);

        /** @var EntityManager $entityManager */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $atributoDinamicoModel = new AtributoDinamicoModel($entityManager);

        $atributosDinamicos = $this->getRequest()->get('atributoDinamico');

        /** @var AtributoTipoNorma $atributoTipoNorma */
        foreach ($norma->getFkNormasTipoNorma()->getFkNormasAtributoTipoNormas() as $atributoTipoNorma) {
            $codAtributo = $atributoTipoNorma->getCodAtributo();

            $valor = $atributoDinamicoModel->processaAtributoDinamicoPersist($atributoTipoNorma, $atributosDinamicos[$codAtributo]);

            $atributoNormaValor = (new AtributoNormaValorModel($entityManager))
                ->buildOne($norma, $atributoTipoNorma, $valor);

            $norma->addFkNormasAtributoNormaValores($atributoNormaValor);
            $atributoTipoNorma->addFkNormasAtributoNormaValores($atributoNormaValor);
        }
    }

    /**
     * @param Norma $norma
     */
    public function preUpdate($norma)
    {
        $this->updateUploadedFileLink($norma);
        $this->updateFkNormasNormaDataTermino($norma);

        /** @var EntityManager $entityManager */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $atributoDinamicoModel = new AtributoDinamicoModel($entityManager);

        $atributosDinamicos = [];

        foreach ($this->getRequest()->get($this->getUniqid()) as $name => $data) {
            if (false === strpos($name, 'atributoDinamico')) {
                continue;
            }

            $name = explode('_', $name);
            array_shift($name);

            $codAtributo = array_shift($name);
            $name = array_shift($name);

            $atributosDinamicos[$codAtributo] = [$name => $data];
        }

        /** @var Norma $norma */
        /** @var AtributoNormaValor $atributoNormaValor */
        foreach ($norma->getFkNormasAtributoNormaValores() as $atributoNormaValor) {
            $codAtributo = $atributoNormaValor->getCodAtributo();

            $valor = $atributoDinamicoModel
                ->processaAtributoDinamicoPersist($atributoNormaValor->getFkNormasAtributoTipoNorma(), $atributosDinamicos[$codAtributo]);

            (new AtributoNormaValorModel($entityManager))
                ->updateOne($atributoNormaValor, $valor);
        }
    }

    /**
     * @param Norma $norma
     */
    public function postRemove($norma)
    {
        $this->removeUploadedFileLink($norma);
    }
}
