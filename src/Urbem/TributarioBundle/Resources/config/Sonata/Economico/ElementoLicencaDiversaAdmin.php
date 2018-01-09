<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Economico;

use Exception;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Economico\ElementoLicencaDiversa;
use Urbem\CoreBundle\Entity\Economico\ElementoTipoLicencaDiversa;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ElementoLicencaDiversaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_economico_elemento_licenca_diversa';
    protected $baseRoutePattern = 'tributario/cadastro-economico/licenca/licenca-diversa/elementos';

    /**
    * @return string
    */
    public function getGoBackURL()
    {
        return '/tributario/cadastro-economico/licenca/licenca-diversa/list';
    }

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $routes)
    {
        $routes->add('alterar', sprintf('alterar/%s', $this->getRouterIdParameter()));

        $routes->clearExcept(['alterar', 'edit']);
    }

    /**
     * @param mixed $object
     */
    public function preUpdate($object)
    {
        $this->populateObject($object);

        $this->saveObject($object);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $em = $this->modelManager->getEntityManager($this->getClass());

        $licencaDiversa = $this->getSubject();

        $elementoTipoLicencaDiversa = null;
        foreach ($licencaDiversa->getFkEconomicoElementoLicencaDiversas() as $elementoLicencaDiversa) {
            $elementoTipoLicencaDiversa = $elementoLicencaDiversa->getFkEconomicoElementoTipoLicencaDiversa();
        }

        $fieldOptions = [];
        $fieldOptions['fkEconomicoElementoTipoLicencaDiversa'] = [
            'class' => ElementoTipoLicencaDiversa::class,
            'mapped' => false,
            'query_builder' => function ($em) use ($licencaDiversa) {
                $qb = $em->createQueryBuilder('o');

                $qb->join('o.fkEconomicoElemento', 'e');

                $qb->where('o.codTipo = :codTipo');
                $qb->setParameter(':codTipo', $licencaDiversa->getCodTipo());

                $qb->orderBy('e.nomElemento', 'ASC');
            },
            'choice_label' => function (ElementoTipoLicencaDiversa $elementoTipoLicencaDiversa) {
                return (string) $elementoTipoLicencaDiversa->getFkEconomicoElemento()->getNomElemento();
            },
            'placeholder' => 'label.selecione',
            'attr' => [
                'class' => 'select2-parameters ',
            ],
            'label' => 'label.ElementoAtividadeCadastroEconomicoAdmin.elemento',
        ];

        if ($elementoTipoLicencaDiversa) {
            $fieldOptions['fkEconomicoElementoTipoLicencaDiversa']['data'] = $elementoTipoLicencaDiversa;
        }

        $formMapper
            ->with('label.economico.licenca.dadosLicenca')
                ->add(
                    'numLicenca',
                    'text',
                    [
                        'mapped' => false,
                        'disabled' => true,
                        'data' => sprintf('%s - %s', $licencaDiversa->getCodLicenca(), $licencaDiversa->getFkEconomicoTipoLicencaDiversa()->getNomTipo()),
                        'label' => 'label.economico.licenca.numLicenca',
                    ]
                )
                ->add(
                    'cgm',
                    'text',
                    [
                        'mapped' => false,
                        'disabled' => true,
                        'data' => $licencaDiversa->getFkSwCgm(),
                        'label' => 'label.economicoBaixaLicenca.cgm',
                    ]
                )
            ->end()
            ->with('label.economico.outrasLicencas.elementoBaseCalculo')
                ->add(
                    'fkEconomicoElementoTipoLicencaDiversa',
                    'entity',
                    $fieldOptions['fkEconomicoElementoTipoLicencaDiversa']
                )
            ->end();
    }

    /**
    * @param Licenca $object
    */
    protected function populateObject($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        foreach ($object->getFkEconomicoElementoLicencaDiversas() as $elementoLicencaDiversa) {
            $object->removeFkEconomicoElementoLicencaDiversas($elementoLicencaDiversa);
        }

        $em->flush();

        if ($elementoTipoLicencaDiversa = $this->getForm()->get('fkEconomicoElementoTipoLicencaDiversa')->getData()) {
            $elementoLicencaDiversa = new ElementoLicencaDiversa();
            $elementoLicencaDiversa->setFkEconomicoElementoTipoLicencaDiversa($elementoTipoLicencaDiversa);
            $elementoLicencaDiversa->setOcorrencia(1);

            $object->addFkEconomicoElementoLicencaDiversas($elementoLicencaDiversa);
        }
    }

    /**
    * @param Licenca $object
    */
    protected function saveObject($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $container = $this->getConfigurationPool()->getContainer();
        $em->getConnection()->beginTransaction();

        try {
            $em->merge($object);
            $em->flush();
            $em->getConnection()->commit();

            $container->get('session')
                ->getFlashBag()
                ->add(
                    'success',
                    $this->getTranslator()->trans('label.economicoElementoLicencaDiversa.alterar.msgAlterar')
                );
        } catch (Exception $e) {
            $em->getConnection()->rollBack();
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
        } finally {
            $this->forceRedirect('/tributario/cadastro-economico/licenca/licenca-diversa/list');
        }
    }
}
