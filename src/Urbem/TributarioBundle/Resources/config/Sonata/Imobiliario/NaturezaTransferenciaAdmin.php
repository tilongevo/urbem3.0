<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Imobiliario;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Imobiliario\NaturezaTransferencia;
use Urbem\CoreBundle\Entity\Imobiliario\DocumentoNatureza;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class NaturezaTransferenciaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_imobiliario_natureza_transferencia';
    protected $baseRoutePattern = 'tributario/cadastro-imobiliario/natureza';
    protected $includeJs = ['/tributario/javascripts/imobiliario/natureza-transferencia.js'];
    protected $automaticaArray = ['sim' => true , 'nao' => false];
    public static $obrigatorioArray = [
        'nao' => [
            'label' => 'nao' ,
            'value' => 1
        ],
        'cadastro' => [
            'label' => 'label.cadastro',
            'value' => 2
        ],
        'transferencia' => [
            'label' => 'label.ImobiliarioNaturezaTransferencia.efetivacao',
            'value' => 3
        ],
    ];

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codNatureza', null, ['label' => 'label.codigo'])
            ->add('descricao', null, ['label' => 'label.descricao'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codNatureza', null, ['label' => 'label.codigo'])
            ->add('descricao', null, ['label' => 'label.descricao'])
        ;
        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $automaticaSelected = true;
        $documentoNatureza = false;
        $documentoNaturezaValue = 1;

        $naturezaTransferencia = $this->getSubject();

        $fieldOptions['documentoNatureza'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::Imobiliario/NaturezaTransferencia/documentos_edit.html.twig',
            'data' => [
                'documentos' => null,
                'obrigatorios' => self::$obrigatorioArray,
                'obrigatorioSelected' => 0,
                'itens' => null,
            ],
        ];

        if ($id) {
            $automaticaSelected = $naturezaTransferencia->getAutomatica();

            if ($documentoNaturezas = $naturezaTransferencia->getFkImobiliarioDocumentoNaturezas()) {
                foreach ($documentoNaturezas as $key => $documentoNatureza) {
                    $fieldOptions['documentoNatureza']['data']['documentos'][$key]['nomDocumento'] = $documentoNatureza->getNomDocumento();
                    $fieldOptions['documentoNatureza']['data']['documentos'][$key]['obrigatorioSelected'] = ($documentoNatureza->getCadastro()) ? 2 : (($documentoNatureza->getTransferencia()) ? 3 : 1);
                }
            }
        }

        $formMapper
            ->with('label.ImobiliarioNaturezaTransferencia.dados')
                ->add(
                    'descricao',
                    'textarea',
                    [
                        'label' => 'label.descricao',
                        'required' => true,

                    ]
                )
                ->add(
                    'automatica',
                    ChoiceType::class,
                    [
                        'label' => 'label.automatico',
                        'required' => true,
                        'mapped' => false,
                        'choices' => $this->automaticaArray,
                        'expanded' => true,
                        'multiple' => false,
                        'data' => ($automaticaSelected) ? true : false,
                         'label_attr' => array(
                            'class' => 'checkbox-sonata'
                        ),
                        'attr' => array(
                            'class' => 'checkbox-sonata'
                        )
                    ]
                )
            ->end()
            ->with('label.documentos')
                ->add('documentoNatureza', 'customField', $fieldOptions['documentoNatureza'])
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $naturezaTransferencia = $this->getSubject();

        $fieldOptions['documentoNatureza'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::Imobiliario/NaturezaTransferencia/documentos_show.html.twig',
        ];

        $this->documentoNaturezas = null;
        if ($naturezaTransferencia->getCodNatureza() && $documentoNaturezas = $naturezaTransferencia->getFkImobiliarioDocumentoNaturezas()) {
            $this->documentoNaturezas = $documentoNaturezas;
        }

        $showMapper
            ->with('label.ImobiliarioNaturezaTransferencia.modulo')
                ->add('codNatureza', null, ['label' => 'label.codigo'])
                ->add('descricao', null, ['label' => 'label.descricao'])
                ->add('automatica', null, ['label' => 'label.automatico'])
                ->add('contaCorrente', 'customField', $fieldOptions['documentoNatureza'])
            ->end()
        ;
    }

     /**
     * @param NaturezaTransferencia $object
     */
    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $object->setAutomatica(true);
        if (!$this->getForm()->get('automatica')->getData()) {
            $object->setAutomatica(false);
        }

        $em->persist($object);

        $this->persistDocumentoNatureza($object);
    }

    /**
     * @param NaturezaTransferencia $object
     */
    protected function persistDocumentoNatureza(NaturezaTransferencia $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass())->getRepository(DocumentoNatureza::class);
        $documentosNaturezas = [];
        foreach ((array) $this->getRequest()->get('documentoNatureza') as $requestDocumentoNatureza) {
            $documentoNatureza = new DocumentoNatureza();
            $documentoNatureza->setCodNatureza($object->getCodNatureza());
            $documentoNatureza->setNomDocumento($requestDocumentoNatureza['nomDocumento']);
            ($requestDocumentoNatureza['obrigatorio'] == 2) ? $documentoNatureza->setCadastro(true) : $documentoNatureza->setCadastro(false);
            ($requestDocumentoNatureza['obrigatorio'] == 3) ? $documentoNatureza->setTransferencia(true) : $documentoNatureza->setTransferencia(false);

            $documentosNaturezas[] = $documentoNatureza;
        }

        // Remove all
        foreach ($object->getFkImobiliarioDocumentoNaturezas() as $documentoNatureza) {
            $object->removeFkImobiliarioDocumentoNaturezas($documentoNatureza);
        }

        // Add again
        foreach ($documentosNaturezas as $documentoNatureza) {
            $object->addFkImobiliarioDocumentoNaturezas($documentoNatureza);
        }
    }

    /**
     * @param NaturezaTransferencia $object
     */
    public function preUpdate($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $object->setAutomatica(false);
        if ($this->getForm()->get('automatica')->getData() == $this->automaticaArray['sim']) {
            $object->setAutomatica(true);
        }

        $this->persistDocumentoNatureza($object);
    }

    /**
    * @param mixed $object
    * @return string
    */
    public function toString($object)
    {
        return ($object->getDescricao())
            ? (string) $object
            : $this->getTranslator()->trans('label.ImobiliarioNaturezaTransferencia.modulo');
    }
}
