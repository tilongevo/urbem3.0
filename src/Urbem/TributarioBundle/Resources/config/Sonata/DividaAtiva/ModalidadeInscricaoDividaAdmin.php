<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\DividaAtiva;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Model\Tributaria\DividaAtiva\Modalidade\ModalidadeInscricaoDividaModel;

class ModalidadeInscricaoDividaAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_tributario_divida_ativa_modalidade_inscricao_divida';
    protected $baseRoutePattern = 'tributario/divida-ativa/modalidade/inscricao-divida';
    protected $includeJs = ['/tributario/javascripts/dividaAtiva/modalidade/config.js'];

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'codModalidade',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.dividaAtivaModalidade.codigo',
                )
            )
            ->add(
                'descricao',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.dividaAtivaModalidade.descricao',
                )
            )
        ;
    }

    /**
     * @param $queryBuilder
     * @param $alias
     * @param $field
     * @param $value
     * @return bool|void
     */
    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        if (! $value['value']) {
            return;
        }

        $filter = $this->getDataGrid()->getValues();
        $modalidade = new ModalidadeInscricaoDividaModel($this->getDoctrine());
        $modalidade->findModalidades(
            $filter['codModalidade']['value'],
            $filter['descricao']['value'],
            $queryBuilder,
            $alias
        );

        return true;
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $queryBuilder = parent::createQuery($context);
        $modalidade = new ModalidadeInscricaoDividaModel($this->getDoctrine());
        $modalidade->findModalidades(
            null,
            null,
            $queryBuilder,
            'o'
        );
        return $queryBuilder;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();
        $listMapper
            ->add('codModalidade', null, ['label' => "label.dividaAtivaModalidade.codigo"])
            ->add('descricao', null, ['label' => "label.dividaAtivaModalidade.descricao"])
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {

        $this->includeJs[] = '/tributario/javascripts/dividaAtiva/modalidade/modalidadeAddLine.js';

        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $model = new ModalidadeInscricaoDividaModel($this->getDoctrine());
        $model->formMapperDadosParaModalidade(
            $formMapper,
            $this->getSubject(),
            sprintf('%s - %s', $this->getContainer()->get('translator')->transChoice('label.dividaAtivaModalidade.dadosParaModalidade', 0, [], 'messages'), $this->getContainer()->get('translator')->transChoice('label.dividaAtivaModalidade.inscricaoDivida', 0, [], 'messages'))
        );
        $model->formMapperCreditos($formMapper, 'label.dividaAtivaModalidade.creditosCom');
        $model->formMapperAcrescimosLegais($formMapper, 'label.dividaAtivaModalidade.acrescimosLegais');
        $model->formMapperDocumentos($formMapper, 'label.dividaAtivaModalidade.documentosCom');


        if ($this->id($this->getSubject())) {
            $model->initAdminEdit($formMapper, $this->getSubject(), 'label.dividaAtivaModalidade.documentosCom', $this->getContainer()->get('translator'));
        }
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $this->pre($object);
    }

    /**
     * @param mixed $object
     */
    public function preUpdate($object)
    {
        $this->pre($object);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $label = sprintf('%s - %s', $this->getContainer()->get('translator')->transChoice('label.dividaAtivaModalidade.dadosParaModalidade', 0, [], 'messages'), $this->getContainer()->get('translator')->transChoice('label.dividaAtivaModalidade.inscricaoDivida', 0, [], 'messages'));
        $model = new ModalidadeInscricaoDividaModel($this->getDoctrine());
        $model->showFieldsModalidade(
            $showMapper,
            $this->getSubject(),
            $label
        );

        $model->showFieldsCreditos(
            $showMapper,
            $this->getSubject(),
            $label,
            $this->getContainer()->get('translator'),
            'label.dividaAtivaModalidade.creditos'
        );

        $model->showFieldsAcrescimosLegais(
            $showMapper,
            $this->getSubject(),
            $label,
            $this->getContainer()->get('translator'),
            'label.dividaAtivaModalidade.acrescimosLegais'
        );

        $model->showFieldsDocumentos(
            $showMapper,
            $this->getSubject(),
            $label,
            $this->getContainer()->get('translator'),
            'label.dividaAtivaModalidade.documentos'
        );
    }

    /**
     * @param $object
     */
    private function pre($object)
    {
        $model = new ModalidadeInscricaoDividaModel($this->getDoctrine());
        $model->prePersist($object, $this->getRequest()->request, $this->getForm()->all());
    }

    /**
     * @param Modalidade $object
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function preRemove($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $modalidadeModel = new ModalidadeInscricaoDividaModel($this->getDoctrine());

        $parcelamentoHasModalidade = $em->getRepository(\Urbem\CoreBundle\Entity\Divida\Parcelamento::class)->findOneBy(
            array(
                'codModalidade' => $object->getCodModalidade(),
            )
        );

        $container = $this->getConfigurationPool()->getContainer();

        if ($parcelamentoHasModalidade) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('label.dividaAtivaModalidade.erroExcluir'));
            $this->getDoctrine()->clear();
            return $this->redirectToUrl($this->generateUrl('list'));
        }
    }
}
