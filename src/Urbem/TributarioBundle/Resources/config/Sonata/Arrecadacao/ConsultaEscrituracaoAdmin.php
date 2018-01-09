<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Arrecadacao;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomico;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ConsultaEscrituracaoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_arrecadacao_consulta_escrituracao';
    protected $baseRoutePattern = 'tributario/arrecadacao/consulta-escrituracao';
    protected $exibirMensagemFiltro = true;
    protected $exibirBotaoIncluir = false;

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $this->setBreadCrumb();

        $datagridMapper
            ->add(
                'inscricaoEconomica',
                'doctrine_orm_callback',
                array(
                    'label' => 'label.arrecadacaoConsultaEscrituracao.inscricaoEconomica',
                    'callback' => array($this, 'getSearchFilter')
                )
            )
            ->add(
                'fkSwCgm',
                'doctrine_orm_callback',
                array(
                    'label' => 'label.arrecadacaoConsultaEscrituracao.contribuinte',
                    'callback' => array($this, 'getSearchFilter')
                ),
                'autocomplete',
                array(
                    'class' => SwCgm::class,
                    'route' => array(
                        'name' => 'api-search-swcgm-pessoa-fisica-numcgm-nomecgm'
                    )
                )
            );
    }

    /**
     * @param RouteCollection $routes
     */
    public function configureRoutes(RouteCollection $routes)
    {
        $routes->add(
            'atividade',
            sprintf('atividade/%s', $this->getRouterIdParameter())
        );
        $routes->add('calcula_valores', 'calcula-valores', array(), array(), array(), '', array(), array('GET'));
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        if (!$this->getRequest()->query->get('filter')) {
            $query->andWhere('1 = 0');
        }
        return $query;
    }

    /**
     * @param $queryBuilder
     * @param $alias
     * @param $field
     * @param $value
     * @return bool
     */
    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        $filter = $this->getDataGrid()->getValues();

        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $inscricaoEconomicaList = (new \Urbem\CoreBundle\Model\Arrecadacao\ConsultaEscrituracaoModel($entityManager))
            ->filterEscrituracao($filter);

        $ids = array();

        foreach ($inscricaoEconomicaList as $inscricaoEconomica) {
            $ids[] = $inscricaoEconomica->inscricao_economica;
        }

        if (count($inscricaoEconomicaList) > 0) {
            $queryBuilder->andWhere($queryBuilder->expr()->in("{$alias}.inscricaoEconomica", $ids));
        } else {
            $queryBuilder->andWhere('1 = 0');
        }
        return true;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();
        $listMapper
            ->add('Registros', 'customField', array(
                'template' => 'TributarioBundle::Arrecadacao/ConsultaEscrituracao/list__action_detalhe.html.twig',
            ));
    }
}
