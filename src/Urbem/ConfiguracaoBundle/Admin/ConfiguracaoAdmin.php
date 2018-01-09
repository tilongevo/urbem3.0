<?php

namespace Urbem\ConfiguracaoBundle\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\ConfiguracaoBundle\EventDispatcher\ConfigurationUpdateEvent;
use Urbem\ConfiguracaoBundle\Service\Configuration\ConfigurationReader;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

class ConfiguracaoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'configuracao';

    protected $baseRoutePattern = 'configuracao';

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['edit']);
    }

    /**
     * @param $id
     * @return ConfigurationReader|object|\Symfony\Component\HttpFoundation\Response
     */
    protected function getConfigurationReader($id)
    {
        /* src/Urbem/ConfiguracaoBundle/DependencyInjection/ConfiguracaoExtension.php */
        $service = sprintf('configuration.%s', $id);

        if (false === $this->getContainer()->has($service)) {
            return $this->redirectByRoute('configuracao_homepage');
        }

        return $this->getContainer()->get($service);
    }

    /**
     * @param mixed $id
     * @return \Symfony\Component\HttpFoundation\Response|Modulo
     */
    public function getObject($id)
    {
        return $this->getConfigurationReader($id)->getModule();
    }

    /**
     * @param $object
     * @return string
     */
    public function getObjectKey($object)
    {
        return $this->getConfigurationReader(parent::getObjectKey($object))->getService();
    }

    public function postUpdate($object)
    {
        $module = $this->getForm()->getData();

        $this->getEntityManager()->persist($module);
        $this->getEntityManager()->flush($module);

        $id = parent::getObjectKey($object);

        $this->getContainer()
            ->get('event_dispatcher')
            ->dispatch(
                sprintf('configuracao_update_%s', $id),
                new ConfigurationUpdateEvent($module, $this->getExercicio())
            );

        return $this->redirectByRoute('configuracao_edit', [$this->getIdParameter() => $this->getConfigurationReader($id)->getService()]);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $configurationReader = $this->getConfigurationReader($this->getAdminRequestId());
        $configurationReader->build($formMapper, $this->getExercicio());

        $breadcrumb = $this->setBreadCrumb([$this->getIdParameter() => $configurationReader->getService()]);

        $this->goBackURL = $this->getContainer()->get('router')->generate('configuracao_homepage');

        if (true === $breadcrumb instanceof Breadcrumbs) {
            $breadcrumb->addItem($configurationReader->getName());
        }

        $this->setLabel($configurationReader->getName());
    }
}
