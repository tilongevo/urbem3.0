<?php

namespace Urbem\PortalServicosBundle\Resources\config\Sonata;

use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\TributarioBundle\Controller\Imobiliario\ConsultaCadastroImobiliarioAdminController;
use Urbem\TributarioBundle\Resources\config\Sonata\Imobiliario\ConsultaCadastroImobiliarioAdmin;

class ConsultaImovelAdmin extends ConsultaCadastroImobiliarioAdmin
{
    protected $baseRouteName = 'urbem_portalservicos_consulta_imovel';
    protected $baseRoutePattern = 'portal-cidadao/consulta-imovel';

    /**
     * @param string $name
     * @return mixed|null|string
     */
    public function getTemplate($name)
    {
        switch ($name) {
            case 'list':
                return 'PortalServicosBundle:ConsultaImovel:list.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['list', 'export']);
        $collection->add('relatorio', $this->getRouterIdParameter() . '/relatorio', ['_controller' => ConsultaCadastroImobiliarioAdminController::class . '::relatorioAction']);
    }

    /**
     * @param string  $action
     * @param Usuario $usuario
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function checkAccess($action, $usuario = null)
    {
        if (!in_array('ROLE_MUNICIPE', $this->getCurrentUser()->getRoles())) {
            return (new RedirectResponse('/acesso-negado'))->send();
        }
    }

    /**
     * @param string $context
     * @return QueryBuilder
     */
    public function createQuery($context = 'list')
    {
        /** @var QueryBuilder $query */
        $query = parent::createQuery($context);
        $query->leftJoin('o.fkImobiliarioProprietarios', 'p');
        $query->where('p.numcgm = :numcgm');
        $query->setParameter('numcgm', $this->getCurrentUser()->getNumcgm());
        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    public function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('inscricaoMunicipal', 'text', ['label' => 'label.imobiliarioConsulta.inscricaoImobiliaria', 'sortable' => false])
            ->add('logradouro', 'text', ['label' => 'label.imobiliarioConsulta.endereco'])
            ->add('localizacao', 'text', ['label' => 'label.imobiliarioConsulta.localizacao'])
            ->add('lote', 'text', ['label' => 'label.imobiliarioConsulta.lote'])
            ->add(
                'situacao',
                'customField',
                [
                    'label' => 'label.imobiliarioConsulta.situacao',
                    'mapped' => false,
                    'template' => 'TributarioBundle:Sonata/Imobiliario/Consulta/CRUD:list__situacao.html.twig',
                ]
            )
            ->add('_action', 'actions', [
                'actions' => [
                    'relatorio' => ['template' => 'PortalServicosBundle:ConsultaImovel:list__action_relatorio.html.twig']
                ],
            ])
        ;
    }
}
