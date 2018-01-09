<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Ppa;

use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Ppa\Regiao;
use Urbem\CoreBundle\Model\Ppa\RegiaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class RegiaoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_plano_plurianual_regiao';
    protected $baseRoutePattern = 'financeiro/plano-plurianual/regiao';
    protected $model = RegiaoModel::class;

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('show');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'nome',
                null,
                array(
                    'label' => 'label.regiao.nome'
                )
            )
            ->add(
                'descricao',
                null,
                array(
                    'label' => 'label.regiao.descricao'
                )
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
                'codRegiao',
                null,
                array(
                    'label' => 'label.regiao.codRegiao'
                )
            )
            ->add(
                'nome',
                null,
                array(
                    'label' => 'label.regiao.nome'
                )
            )
            ->add(
                'descricao',
                null,
                array(
                    'label' => 'label.regiao.descricao'
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

        $formMapper
            ->with('label.regiao.dadosCadastroRegioesPpa')
                ->add(
                    'nome',
                    null,
                    array(
                        'label' => 'label.regiao.nome'
                    )
                )
                ->add(
                    'descricao',
                    null,
                    array(
                        'label' => 'label.regiao.descricao'
                    )
                )
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $showMapper
            ->with('label.regiao.dadosCadastroRegioesPpa')
                ->add(
                    'nome',
                    null,
                    array(
                        'label' => 'label.regiao.nome'
                    )
                )
                ->add(
                    'descricao',
                    null,
                    array(
                        'label' => 'label.regiao.descricao'
                    )
                )
            ->end()
        ;
    }

    /**
     * @param mixed $object
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function preRemove($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $container = $this->getConfigurationPool()->getContainer();
        if (!(new RegiaoModel($em))->canRemove($object)) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('label.regiao.erroExclusao'));
            $this->getDoctrine()->clear();
            return $this->redirectToUrl($this->request->headers->get('referer'));
        }
    }

    /**
     * @param mixed $object
     * @return int|string
     */
    public function toString($object)
    {
        return $object instanceof Regiao
            ? $object->getCodRegiao()
            : $this->getTranslator()->trans('label.detalhamentoDestinacaoRecurso.modulo');
    }
}
