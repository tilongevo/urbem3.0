<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Empenho;

use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ItemEmpenhoDiversosAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_empenho_item_empenho_diversos';
    protected $baseRoutePattern = 'financeiro/empenho/item-empenho-diversos';
    protected $includeJs = array(
        '/financeiro/javascripts/empenho/pre-empenho.js'
    );

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add(
                'numItem',
                null,
                array(
                    'label' => 'label.itemPreEmpenho.numItem',
                )
            )
            ->add(
                'codItem',
                null,
                array(
                    'label' => 'label.itemPreEmpenho.codItem',
                )
            )
            ->add(
                'nomItem',
                null,
                array(
                    'label' => 'label.itemPreEmpenho.nomItem',
                )
            )
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

        $formOptions = array();

        $formOptions['codPreEmpenho'] = array(
            'data' => $this->getRequest()->query->get('pre_empenho'),
            'mapped' => false,
        );

        $formOptions['exercicio'] = array(
            'data' => $this->getRequest()->query->get('exercicio'),
            'mapped' => false,
        );

        $formOptions['tipoItem'] = array(
            'label' => 'label.itemPreEmpenho.tipoItem',
            'choices' => array(
                'Sim' => 'Catalogo',
                'Não' => 'Descricao'
            ),
            'label_attr' => array(
                'class' => 'checkbox-sonata'
            ),
            'attr' => array(
                'class' => 'checkbox-sonata'
            ),
            'expanded' => true,
            'mapped' => false,
        );

        $formOptions['fkAlmoxarifadoCatalogoItem'] = array(
            'class' => 'CoreBundle:Almoxarifado\CatalogoItem',
            'label' => 'label.itemPreEmpenho.codItem',
            'property' => 'descricao',
            'to_string_callback' => function ($catalogoItem, $property) {
                return $catalogoItem->getCodItem() . " - " . $catalogoItem->getDescricao();
            },
            'attr' => array(
                'class' => 'select2-parameters',
            ),
            'placeholder' => 'Selecione',
        );

        $formOptions['codItem'] = array(
            'class' => 'CoreBundle:Almoxarifado\CatalogoItem',
            'label' => 'label.itemPreEmpenho.codItem',
            'property' => 'descricao',
            'to_string_callback' => function ($catalogoItem, $property) {
                return $catalogoItem->getCodItem() . " - " . $catalogoItem->getDescricao();
            },
            'attr' => array(
                'class' => 'select2-parameters',
            ),
            'disabled' => true,
            'placeholder' => 'Selecione',
        );

        $formOptions['nomItem'] = array(
            'label' => 'label.itemPreEmpenho.nomItem'
        );

        $formOptions['complemento'] = array(
            'label' => 'label.itemPreEmpenho.complemento',
            'required' => false,
        );

        $formOptions['fkAlmoxarifadoMarca'] = array(
            'class' => 'CoreBundle:Almoxarifado\Marca',
            'property' => 'descricao',
            'to_string_callback' => function ($marca) {
                return $marca->getCodMarca() . " - " . $marca->getDescricao();
            },
            'label' => 'label.itemPreEmpenho.codMarca',
            'attr' => array(
                'class' => 'select2-parameters'
            ),
            'placeholder' => 'Selecione',
        );

        $formOptions['fkAlmoxarifadoCentroCusto'] = array(
            'class' => 'CoreBundle:Almoxarifado\CentroCusto',
            'choice_label' => 'descricao',
            'label' => 'label.itemPreEmpenho.codCentro',
            'attr' => array(
                'class' => 'select2-parameters'
            ),
            'placeholder' => 'label.selecione',
        );

        $formOptions['quantidade'] = array(
            'label' => 'label.itemPreEmpenho.quantidade'
        );

        $formOptions['fkAdministracaoUnidadeMedida'] = array(
            'class' => 'CoreBundle:Administracao\UnidadeMedida',
            'choice_label' => 'nomUnidade',
            'choice_value' => function ($unidade) {
                if ($unidade) {
                    return $unidade->getCodUnidade() . "-" . $unidade->getFkAdministracaoGrandeza()->getCodGrandeza();
                }
            },
            'label' => 'label.itemPreEmpenho.codUnidade',
            'attr' => array(
                'class' => 'select2-parameters'
            ),
            'placeholder' => 'label.selecione',
            'required' => true,
        );

        $formOptions['vlUnitario'] = array(
            'label' => 'label.itemPreEmpenho.vlUnitario',
            'currency' => 'BRL',
            'mapped' => false,
        );

        $formOptions['vlTotal'] = array(
            'label' => 'label.itemPreEmpenho.vlTotal',
            'currency' => 'BRL',
            'attr' => array(
                'readonly' => 'readonly'
            ),
        );

        if ($this->id($this->getSubject())) {
            if (! $this->getSubject()->getCodItem()) {
                $formOptions['tipoItem']['data'] = 'Descricao';
            } else {
                $formOptions['tipoItem']['data'] = 'Catalogo';
            }

            $formOptions['codItem']['data'] = null;
            $formOptions['vlUnitario']['data'] = $this->getSubject()->getVlTotal() / $this->getSubject()->getQuantidade();
        } else {
            $formOptions['tipoItem']['data'] = 'Descricao';
        }

        $formMapper
            ->with('label.itemPreEmpenho.itensEmpenhoComplementar')
            ->add(
                'codPreEmpenho',
                'hidden',
                $formOptions['codPreEmpenho']
            )
            ->add(
                'exercicio',
                'hidden',
                $formOptions['exercicio']
            )
            ->add(
                'tipoItem',
                'choice',
                $formOptions['tipoItem']
            )
            ->add(
                'fkAlmoxarifadoCatalogoItem',
                'sonata_type_model_autocomplete',
                $formOptions['fkAlmoxarifadoCatalogoItem']
            )
            ->add(
                'codItem',
                'sonata_type_model_autocomplete',
                $formOptions['codItem'],
                array(
                    'admin_code' => 'patrimonial.admin.catalogo_item'
                )
            )
            ->add(
                'nomItem',
                null,
                $formOptions['nomItem']
            )
            ->add(
                'complemento',
                null,
                $formOptions['complemento']
            )
            ->add(
                'fkAlmoxarifadoMarca',
                'sonata_type_model_autocomplete',
                $formOptions['fkAlmoxarifadoMarca']
            )
            ->add(
                'fkAlmoxarifadoCentroCusto',
                null,
                $formOptions['fkAlmoxarifadoCentroCusto']
            )
            ->add(
                'quantidade',
                'number',
                $formOptions['quantidade']
            )
            ->add(
                'fkAdministracaoUnidadeMedida',
                'entity',
                $formOptions['fkAdministracaoUnidadeMedida']
            )
            ->add(
                'vlUnitario',
                'money',
                $formOptions['vlUnitario']
            )
            ->add(
                'vlTotal',
                'money',
                $formOptions['vlTotal']
            )
            ->end()
        ;
    }

    public function prePersist($object)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $codPreEmpenho = $entityManager->getRepository('CoreBundle:Empenho\PreEmpenho')
        ->findOneBy(
            array(
                'codPreEmpenho' => $this->getForm()->get('codPreEmpenho')->getData(),
                'exercicio' => $this->getForm()->get('exercicio')->getData()
            )
        );

        if (! $this->getForm()->get('nomItem')->getData()) {
            $object->setNomItem("");
        }
        
        if ($this->getForm()->get('fkAlmoxarifadoCatalogoItem')->getData()) {
            $object->setNomItem(
                $this->getForm()->get('fkAlmoxarifadoCatalogoItem')->getData()->getDescricao()
            );
        }
        
        if (! $this->getForm()->get('complemento')->getData()) {
            $object->setComplemento("");
        }

        $numItem = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
        ->getUltimoNumItem($codPreEmpenho->getCodPreEmpenho(), $this->getForm()->get('exercicio')->getData());
        
        $object->setFkEmpenhoPreEmpenho($codPreEmpenho);
        $object->setNumItem($numItem);
    }
    
    public function preUpdate($object)
    {
        if (! $this->getForm()->get('nomItem')->getData()) {
            $object->setNomItem("");
        }
        
        if ($this->getForm()->get('fkAlmoxarifadoCatalogoItem')->getData()) {
            $object->setNomItem(
                $this->getForm()->get('fkAlmoxarifadoCatalogoItem')->getData()->getDescricao()
            );
        }
        
        if (! $this->getForm()->get('complemento')->getData()) {
            $object->setComplemento("");
        }
    }

    public function postPersist($object)
    {
        $codPreEmpenhoComposite = $object->getExercicio() . "~" . $object->getCodPreEmpenho();

        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        (new \Urbem\CoreBundle\Model\Empenho\ItemPreEmpenhoModel($entityManager))
        ->afterEmpenhoDiversos($object);

        $this->redirectToUrl('/financeiro/empenho/emitir-empenho-diversos/' . $codPreEmpenhoComposite . '/show');
    }

    public function postUpdate($object)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $codPreEmpenhoComposite = $object->getExercicio() . "~" . $object->getCodPreEmpenho();
        
        (new \Urbem\CoreBundle\Model\Empenho\ItemPreEmpenhoModel($entityManager))
        ->updateEmpenhoDiversos($object);

        $this->redirectToUrl('/financeiro/empenho/emitir-empenho-diversos/' . $codPreEmpenhoComposite . '/show');
    }

    public function postRemove($object)
    {
        $codPreEmpenhoComposite = $object->getExercicio() . "~" . $object->getCodPreEmpenho();

        $this->redirectToUrl('/financeiro/empenho/emitir-empenho-diversos/' . $codPreEmpenhoComposite . '/show');
    }
}
