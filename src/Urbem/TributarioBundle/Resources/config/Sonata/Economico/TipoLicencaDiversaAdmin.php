<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Economico;

use Doctrine\ORM\EntityRepository;
use Urbem\CoreBundle\Entity\Administracao\ModeloDocumento;
use Urbem\CoreBundle\Entity\Administracao\TipoDocumento;
use Urbem\CoreBundle\Entity\Economico\AtributoTipoLicencaDiversa;
use Urbem\CoreBundle\Entity\Economico\Elemento;
use Urbem\CoreBundle\Entity\Economico\ElementoTipoLicencaDiversa;
use Urbem\CoreBundle\Entity\Economico\TipoLicencaDiversa;
use Urbem\CoreBundle\Entity\Economico\TipoLicencaModeloDocumento;
use Urbem\CoreBundle\Entity\Economico\Utilizacao;
use Urbem\CoreBundle\Entity\Administracao\Cadastro;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Administracao\AtributoDinamico;
use Urbem\CoreBundle\Model\Economico\AtributoTipoLicencaDiversaModel;
use Urbem\CoreBundle\Model\Economico\ElementoModel;
use Urbem\CoreBundle\Model\Economico\ElementoTipoLicencaDiversasModel;
use Urbem\CoreBundle\Model\Economico\TipoLicencaModeloDocumentosModel;
use Urbem\CoreBundle\Model\Economico\UtilizacaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Class TipoLicencaDiversaAdmin
 * @package Urbem\TributarioBundle\Resources\config\Sonata\Economico
 */
class TipoLicencaDiversaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_economico_tipo_licenca_diversa';
    protected $baseRoutePattern = 'tributario/cadastro-economico/tipo-licenca-diversa';
    const MODELO_DOCUMENTO_TIPO_ALVARA = 1;

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'nomTipo',
                null,
                [
                    'label' => 'label.economico.tipoLicencaDiversa.nomTipo'
                ]
            )
            ->add(
                'fkEconomicoUtilizacao',
                null,
                [
                    'label' => 'label.economico.tipoLicencaDiversa.codUtilizacao'
                ]
            )
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add(
                'codTipo',
                null,
                [
                    'label' => 'label.economico.tipoLicencaDiversa.codTipo'
                ]
            )
            ->add(
                'nomTipo',
                null,
                [
                    'label' => 'label.economico.tipoLicencaDiversa.nomTipo'
                ]
            )
            ->add(
                'fkEconomicoUtilizacao',
                null,
                [
                    'label' => 'label.economico.tipoLicencaDiversa.codUtilizacao'
                ]
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

        $fieldOptions['utilizacao'] = [
            'class' => Utilizacao::class,
            'mapped' => false,
            'placeholder' => 'label.selecione',
            'label' => 'label.economico.tipoLicencaDiversa.codUtilizacao',
            'attr' => [
                'class' => 'select2-parameters '
            ]
        ];

        $fieldOptions['atributos'] = [
            'class' => AtributoDinamico::class,
            'mapped' => false,
            'multiple' => true,
            'required' => false,
            'label' => 'label.economico.tipoLicencaDiversa.atributos',
            'query_builder' => function (EntityRepository $er) {
                return $er
                    ->createQueryBuilder('o')
                    ->where('o.codModulo = :codModulo')
                    ->andWhere('o.codCadastro = :codCadastro')
                    ->andWhere('o.ativo = true')
                    ->setParameters(
                        array(
                            'codModulo' => Modulo::MODULO_CADASTRO_ECONOMICO,
                            'codCadastro' => Cadastro::CADASTRO_TIPO_LICENCA_DIVERSA
                        )
                    );
            },
            'attr' => [
                'class' => 'select2-parameters '
            ]
        ];

        $fieldOptions['elemento'] = [
            'class' => Elemento::class,
            'mapped' => false,
            'multiple' => true,
            'required' => false,
            'choice_label' => function ($elemento) {
                return $elemento->getNomElemento();
            },
            'placeholder' => 'label.selecione',
            'label' => 'label.economico.tipoLicencaDiversa.elemento',
            'attr' => [
                'class' => 'select2-parameters '
            ]
        ];

        $fieldOptions['modelo'] = [
            'class' => ModeloDocumento::class,
            'label' => 'label.economico.tipoLicencaDiversa.modeloAlvara',
            'query_builder' => function (EntityRepository $em) {
                $q = $em->createQueryBuilder('m');
                $q->where('m.codTipoDocumento = '.self::MODELO_DOCUMENTO_TIPO_ALVARA);
                $q->orderBy('m.codDocumento', 'ASC');
                return $q;
            },
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters '
            ]
        ];

        if ($this->id($this->getSubject())) {
            $em = $this->modelManager->getEntityManager($this->getClass());
            $elementoTipoLicencaDiversas = $this->getSubject()->getFkEconomicoElementoTipoLicencaDiversas();
            $elemento = array();
            foreach ($elementoTipoLicencaDiversas as $elm) {
                $codElemento = $elm->getCodElemento();
                $elementoResult = (new ElementoModel($em))
                    ->getElemento($codElemento);
                if ($elementoResult) {
                    array_push($elemento, $elementoResult);
                }
            }
            $fieldOptions['elemento']['choice_attr'] = function ($elme, $key, $index) use ($elemento) {
                foreach ($elemento as $e) {
                    if ($elme->getCodElemento() == array_shift($e)->getCodElemento()) {
                        return ['selected' => 'selected'];
                    }
                }
                return ['selected' => false];
            };
            $utilizacao = (new UtilizacaoModel($em))
                ->getUtilizacao($this->getSubject()->getCodUtilizacao());
            $fieldOptions['utilizacao']['data'] = $utilizacao;

            $codDocumento = null;
            foreach ($this->getSubject()->getFkEconomicoTipoLicencaModeloDocumentos() as $tipo) {
                $codDocumento = $tipo->getCodDocumento();
            }
            if ($codDocumento) {
                $modelo = $em->getRepository('CoreBundle:Administracao\ModeloDocumento')
                    ->findOneByCodDocumento($codDocumento);
                $fieldOptions['modelo']['data'] = $modelo;
            }

            $atributoTipoLicencaDiversas = $this->getSubject()->getFkEconomicoAtributoTipoLicencaDiversas();
            $atributo = array();
            foreach ($atributoTipoLicencaDiversas as $attr) {
                $codAtributo = $attr->getCodAtributo();
                $atributoResult = $em->getRepository('CoreBundle:Administracao\AtributoDinamico')
                    ->findOneByCodAtributo($codAtributo);
                if ($atributoResult) {
                    array_push($atributo, $atributoResult);
                }
            }
            $fieldOptions['atributos']['choice_attr'] = function ($entity, $key, $index) use ($atributo) {
                foreach ($atributo as $a) {
                    if ($entity->getCodAtributo() == $a->getCodAtributo() && $entity->getCodCadastro() == $a->getCodCadastro() && $entity->getCodModulo() == $a->getCodModulo()) {
                        return ['selected' => 'selected'];
                    }
                }
                return ['selected' => false];
            };
            $fieldOptions['utilizacao']['disabled'] = true;
        }

        $formMapper
            ->with('label.economico.tipoLicencaDiversa.dadosTipoLicencaDiversa')
            ->add(
                'nomTipo',
                null,
                [
                    'label' => 'label.economico.tipoLicencaDiversa.nomTipo'
                ]
            )
            ->add(
                'codUtilizacao',
                'entity',
                $fieldOptions['utilizacao']
            )
            ->add(
                'fkEconomicoAtributoTipoLicencaDiversas.fkAdministracaoAtributoDinamico.codAtributo',
                'entity',
                $fieldOptions['atributos']
            )
            ->add(
                'fkEconomicoTipoLicencaModeloDocumentos.fkAdministracaoModeloDocumento.fkAdministracaoTipoDocumento.fkAdministracaoModeloDocumentos',
                'entity',
                $fieldOptions['modelo']
            )
            ->end()
            ->with('label.economico.tipoLicencaDiversa.dadosElemento')
            ->add(
                'fkEconomicoElementoTipoLicencaDiversas.fkEconomicoElemento',
                'entity',
                $fieldOptions['elemento']
            )
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $em = $this->modelManager->getEntityManager($this->getClass());
        $tipoElemento = (new ElementoTipoLicencaDiversasModel($em))
            ->getElementoTipoLicencaDiversasByTipo($id);
        $tipoAtributo = (new AtributoTipoLicencaDiversaModel($em))
            ->getAtributoTipoLicencaDiversaByTipo($id);
        $tipoModelo = (new TipoLicencaModeloDocumentosModel($em))
            ->getTipoLicencaModeloDocumentoByCodTipo($id);

        $modelo = null;
        if ($tipoModelo) {
            $modelo = $em->getRepository('CoreBundle:Administracao\ModeloDocumento')
                ->findOneByCodDocumento($tipoModelo->getCodDocumento());
            $modelo = $modelo->getNomeDocumento();
        }

        $elementos = null;
        if ($tipoElemento) {
            foreach ($tipoElemento as $elemento) {
                $result = (new ElementoModel($em))
                    ->getOneElemento($elemento->getCodElemento());
                (!$elementos ? $elementos .= $result : $elementos .= ', '.$result);
            }
        }
        $atributos = null;
        if ($tipoAtributo) {
            foreach ($tipoAtributo as $atributo) {
                $result =  $em->getRepository('CoreBundle:Administracao\AtributoDinamico')
                    ->findOneByCodAtributo($atributo->getCodAtributo());
                (!$atributos ? $atributos .= $result : $atributos .= ', '.$result);
            }
        }

        $showMapper
            ->with('label.economico.tipoLicencaDiversa.dadosTipoLicencaDiversa')
            ->add(
                'codTipo',
                null,
                [
                    'label' => 'label.economico.tipoLicencaDiversa.codTipo'
                ]
            )
            ->add(
                'nomTipo',
                null,
                [
                    'label' => 'label.economico.tipoLicencaDiversa.nomTipo'
                ]
            )
            ->add(
                'fkEconomicoUtilizacao',
                null,
                [
                    'label' => 'label.economico.tipoLicencaDiversa.codUtilizacao'
                ]
            )
            ->add(
                'fkEconomicoAtributoTipoLicencaDiversas.fkAdministracaoAtributoDinamico.codAtributo',
                null,
                [
                    'label' => 'label.economico.tipoLicencaDiversa.atributos',
                    'mapped' => false,
                    'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
                    'data' => $atributos
                ]
            )
            ->add(
                'fkEconomicoTipoLicencaModeloDocumentos.fkAdministracaoModeloDocumento.fkAdministracaoTipoDocumento.fkAdministracaoModeloDocumentos',
                null,
                [
                    'label' => 'label.economico.tipoLicencaDiversa.modeloAlvara',
                    'mapped' => false,
                    'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
                    'data' => $modelo
                ]
            )
            ->add(
                'fkEconomicoElementoTipoLicencaDiversas.fkEconomicoElemento',
                null,
                [
                    'label' => 'label.economico.tipoLicencaDiversa.elemento',
                    'mapped' => false,
                    'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
                    'data' => $elementos
                ]
            )
        ;
    }

    /**
     * @param mixed $object
     */
    public function preUpdate($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $utlizacao = $this->getForm()->get('codUtilizacao')->getData();
        $object->setFkEconomicoUtilizacao($utlizacao);

        $modeloDocumento = $this->getForm()->get('fkEconomicoTipoLicencaModeloDocumentos__fkAdministracaoModeloDocumento__fkAdministracaoTipoDocumento__fkAdministracaoModeloDocumentos')->getData();
        $tipoLicencaModeloDocumentosModel = new TipoLicencaModeloDocumentosModel($em);
        $tipoLicencaModeloDocumento = $tipoLicencaModeloDocumentosModel->getTipoLicencaModeloDocumento($modeloDocumento->getCodTipoDocumento());
        $tipoLicencaModeloDocumento->setFkAdministracaoModeloDocumento($modeloDocumento);
        $tipoLicencaModeloDocumentosModel->save($tipoLicencaModeloDocumento);

        $elementoList = $this->getForm()->get('fkEconomicoElementoTipoLicencaDiversas__fkEconomicoElemento')->getData();
        if ($elementoList) {
            $elementoTipoLicencaDiversaModel = new ElementoTipoLicencaDiversasModel($em);
            $resultByTipo = $elementoTipoLicencaDiversaModel
                ->getElementoTipoLicencaDiversasByTipo($object->getCodTipo());
            if ($resultByTipo) {
                foreach ($resultByTipo as $elementoTipoLicencaDiversa) {
                    $elementoTipoLicencaDiversaModel->remove($elementoTipoLicencaDiversa);
                }
            }
            foreach ($elementoList as $elemento) {
                $elementoTipoLicencaDiversa = new ElementoTipoLicencaDiversa();
                $elementoTipoLicencaDiversa->setFkEconomicoElemento($elemento);
                $elementoTipoLicencaDiversa->setFkEconomicoTipoLicencaDiversa($object);
                $elementoTipoLicencaDiversaModel->save($elementoTipoLicencaDiversa);
            }
        }

        $atributosList = $this->getForm()->get('fkEconomicoAtributoTipoLicencaDiversas__fkAdministracaoAtributoDinamico__codAtributo')->getData();
        if ($atributosList) {
            $atributoTipoLicencaDiversaModel = new AtributoTipoLicencaDiversaModel($em);
            $resultByTipo = $atributoTipoLicencaDiversaModel
                ->getAtributoTipoLicencaDiversaByTipo($object->getCodTipo());
            if ($resultByTipo) {
                foreach ($resultByTipo as $atributoTipoLicencaDiversa) {
                    $atributoTipoLicencaDiversaModel->remove($atributoTipoLicencaDiversa);
                }
            }
            foreach ($atributosList as $atributoDinamico) {
                $atributoTipoLicencaDiversa = new AtributoTipoLicencaDiversa();
                $atributoTipoLicencaDiversa->setFkEconomicoTipoLicencaDiversa($object);
                $atributoTipoLicencaDiversa->setFkAdministracaoAtributoDinamico($atributoDinamico);
                $atributoTipoLicencaDiversaModel->save($atributoTipoLicencaDiversa);
            }
        }
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $utlizacao = $this->getForm()->get('codUtilizacao')->getData();
        $object->setFkEconomicoUtilizacao($utlizacao);
    }

    /**
     * @param mixed $object
     */
    public function postPersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $elementoList = $this->getForm()->get('fkEconomicoElementoTipoLicencaDiversas__fkEconomicoElemento')->getData();
        if ($elementoList) {
            $elementoTipoLicencaDiversaModel = new ElementoTipoLicencaDiversasModel($em);
            foreach ($elementoList as $elemento) {
                $elementoTipoLicencaDiversa = new ElementoTipoLicencaDiversa();
                $elementoTipoLicencaDiversa->setFkEconomicoElemento($elemento);
                $elementoTipoLicencaDiversa->setFkEconomicoTipoLicencaDiversa($object);
                $elementoTipoLicencaDiversaModel->save($elementoTipoLicencaDiversa);
            }
        }

        $atributosList = $this->getForm()->get('fkEconomicoAtributoTipoLicencaDiversas__fkAdministracaoAtributoDinamico__codAtributo')->getData();
        if ($atributosList) {
            $atributoTipoLicencaDiversaModel = new AtributoTipoLicencaDiversaModel($em);
            foreach ($atributosList as $atributoDinamico) {
                $atributoTipoLicencaDiversa = new AtributoTipoLicencaDiversa();
                $atributoTipoLicencaDiversa->setFkEconomicoTipoLicencaDiversa($object);
                $atributoTipoLicencaDiversa->setFkAdministracaoAtributoDinamico($atributoDinamico);
                $atributoTipoLicencaDiversaModel->save($atributoTipoLicencaDiversa);
            }
        }

        $modeloDocumento = $this->getForm()->get('fkEconomicoTipoLicencaModeloDocumentos__fkAdministracaoModeloDocumento__fkAdministracaoTipoDocumento__fkAdministracaoModeloDocumentos')->getData();
        $tipoLicencaModeloDocumento = new TipoLicencaModeloDocumento();
        $tipoLicencaModeloDocumento->setFkEconomicoTipoLicencaDiversa($object);
        $tipoLicencaModeloDocumento->setFkAdministracaoModeloDocumento($modeloDocumento);

        $TipoLicencaModeloDocumentosModel = new TipoLicencaModeloDocumentosModel($em);
        $TipoLicencaModeloDocumentosModel->save($tipoLicencaModeloDocumento);
    }
}
