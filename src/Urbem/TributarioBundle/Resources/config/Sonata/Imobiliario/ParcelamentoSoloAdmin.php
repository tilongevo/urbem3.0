<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Imobiliario;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Imobiliario\ParcelamentoSolo;
use Urbem\CoreBundle\Entity\Imobiliario\TipoParcelamento;
use Urbem\CoreBundle\Model\Imobiliario\LoteModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;

class ParcelamentoSoloAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_tributario_imobiliario_cancelar_desmembramento';
    protected $baseRoutePattern = 'tributario/cadastro-imobiliario/lote/cancelar-desmembramento';
    protected $exibirBotaoIncluir = false;
    protected $customMessageDelete = 'Confirma cancelar desmembramento do lote %object%?';

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('list', 'create', 'delete'));
    }

    public function createQuery($context = 'list')
    {
        /** @var QueryBuilder $qb */
        $qb = parent::createQuery($context);
        $qb->innerJoin('o.fkImobiliarioLoteParcelados', 'lp');
        $qb->where('o.codTipo = :codTipo');
        $qb->andWhere('lp.validado = false');
        $qb->setParameter('codTipo', TipoParcelamento::TIPO_PARCELAMENTO_DESMEMBRAMENTO);
        return $qb;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add(
                'fkImobiliarioLote.fkImobiliarioLoteLocalizacao.fkImobiliarioLocalizacao',
                'text',
                array(
                    'label' => 'label.imobiliarioLote.localizacao'
                )
            )
            ->add(
                'fkImobiliarioLote',
                'text',
                array(
                    'label' => 'label.imobiliarioLote.lote',
                    'admin_code' => 'tributario.admin.lote'
                )
            )
            ->add('_action', 'actions', array(
                'actions' => array(
                    'delete' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig')
                ),
            ))
        ;
    }

    /**
     * @param ParcelamentoSolo $object
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function preRemove($object)
    {
        $container = $this->getConfigurationPool()->getContainer();

        try {
            /** @var EntityManager $em */
            $em = $this->modelManager->getEntityManager($this->getClass());

            (new LoteModel($em))->cancelarDesmembramento($object);

            $container->get('session')->getFlashBag()->add('success', $this->getTranslator()->trans('label.imobiliarioLote.msgCancelamento'));
            $this->getDoctrine()->clear();
            return $this->redirectToUrl($this->generateUrl('list'));
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
            $this->getDoctrine()->clear();
            return $this->redirectToUrl($this->generateUrl('list'));
        }
    }
}
