<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Arrecadacao;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Imobiliario\Proprietario;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Model\Arrecadacao\LancamentoModel;
use Urbem\CoreBundle\Model\Imobiliario\ImovelModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ConsultaFinanceiraImovelAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_arrecadacao_consultas_consulta_financeira_imovel';
    protected $baseRoutePattern = 'tributario/arrecadacao/consultas/consulta-financeira-imovel';
    protected $exibirBotaoIncluir = false;
    protected $exibirBotaoEditar = false;
    protected $exibirBotaoExcluir = false;

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $qb = parent::createQuery($context);

        $em = $this->getModelManager()->getEntityManager($this->getClass());

        $filter = $this->getRequest()->query->get('filter');

        if (!$filter) {
            $qb->andWhere('1 = 0');
            return $qb;
        }

        $numcgm = $filter['fkImobiliarioProprietarios']['value'] ?: false;
        $inscricaoMunicipal = $filter['inscricaoMunicipal']['value'] ?: false;
        $exercicio = $filter['fkArrecadacaoImovelVVenais__exercicio']['value'] ?: false;

        $imovelList = $em->getRepository('CoreBundle:Imobiliario\Imovel')
            ->getConsultaFinanceiraImovel(
                $numcgm,
                $inscricaoMunicipal,
                $exercicio
            );

        $ids = [];

        foreach ((array) $imovelList as $imovel) {
            if ($imovel['inscricao_municipal']) {
                $ids[] = $imovel['inscricao_municipal'];
            }
        }

        // se nenhum resultado atende o filtro
        if (empty($ids)) {
            $qb->andWhere('1 = 0');
            return $qb;
        }

        $qb->innerJoin('o.fkImobiliarioProprietarios', 'pr');
        $aliases = $qb->getRootAliases();

        $qb->andWhere(
            $qb->expr()->in("{$aliases[0]}.inscricaoMunicipal", $ids)
        );

        return $qb;
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
        return true;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'fkImobiliarioProprietarios',
                'doctrine_orm_callback',
                [
                    'label' => 'label.arrecadacaoConsultaFinanceira.contribuinte',
                ],
                'autocomplete',
                [
                    'class' => SwCgm::class,
                    'route' => [
                        'name' => 'api-search-swcgm-pessoa-fisica-numcgm-nomecgm'
                    ],
                    'mapped' => false
                ]
            )
            ->add(
                'inscricaoMunicipal',
                'doctrine_orm_callback',
                array(
                    'label' => 'label.arrecadacaoConsultaFinanceira.inscricaoImobiliaria',
                    'callback' => array($this, 'getSearchFilter')
                )
            )
            ->add(
                'fkArrecadacaoImovelVVenais.exercicio',
                null,
                [
                    'label' => 'label.arrecadacaoConsultaFinanceira.exercicio',
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
                'contribuinte',
                'customField',
                [
                    'label' => 'label.arrecadacaoConsultaFinanceira.contribuinte',
                    'template' => 'TributarioBundle::Arrecadacao/Consultas/ConsultaFinanceiraImovel/contribuinte.html.twig'
                ]
            )
            ->add(
                'inscricaoMunicipal',
                null,
                [
                    'label' => 'label.arrecadacaoConsultaFinanceira.inscricao'
                ]
            )
            ->add(
                'complemento',
                'customField',
                [
                    'label' => 'label.arrecadacaoConsultaFinanceira.endereco',
                    'template' => 'TributarioBundle:Arrecadacao\Consultas\ConsultaFinanceiraImovel:complemento.html.twig',
                ]
            )
            ->add(
                '_action',
                'actions',
                [
                    'actions' => [
                        'show' => ['template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'],
                    ],
                    'header_style' => 'width: 20%'
                ]
            )
        ;
    }

    /**
     * @param   $inscricao
     * @param   $type
     * @return  string
     */
    public function getEndereco($object, $type = 'Municipal')
    {
        if (!$object->getInscricaoMunicipal() || !$type) {
            return;
        }

        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $endereco = (new \Urbem\CoreBundle\Model\Arrecadacao\LancamentoModel($entityManager))
            ->getEndereco($object->getInscricaoMunicipal(), $type);

        return ($endereco) ?: '-';
    }

    /**
     * @param   $object
     * @return  string
     */
    public function getContribuinte($object)
    {
        return ($object->getFkImobiliarioProprietarios()->last()->getFkSwCgm()->getNomCgm()) ?: '-';
    }

    /**
     * @param   $object
     * @return  string
     */
    public function getCotaProprietario($object)
    {
        return ($object->getFkImobiliarioProprietarios()->last()->getCota()) ?: '0';
    }

    /**
     * @param   $object
     * @return  string
     */
    public function getNumcgmProprietario($object)
    {
        return ($object->getFkImobiliarioProprietarios()->last()->getNumcgm()) ?: '-';
    }

    /**
     * @param   $inscricaoMunicipal
     * @return  string
     */
    public function getSituacaoImovel($inscricaoMunicipal)
    {
        if (!$inscricaoMunicipal) {
            return;
        }

        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $imovel = (new \Urbem\CoreBundle\Model\Imobiliario\ImovelModel($entityManager))
            ->consultaSituacaoImovel($inscricaoMunicipal);

        return ($imovel['0']['valor']) ?: '-';
    }

    /**
     * @param   $object
     * @return  array
     */
    public function getListaValorVenal($object)
    {
        if (!$object->getInscricaoMunicipal()) {
            return;
        }

        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $lista = (new \Urbem\CoreBundle\Model\Imobiliario\ImovelModel($entityManager))
            ->getListaValorVenal($object->getInscricaoMunicipal());

        return $lista;
    }

    /**
     * @param   $object
     * @return  array
     */
    public function getListaLancamentos($object)
    {
        if (!$object->getInscricaoMunicipal()) {
            return;
        }

        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $lista = (new \Urbem\CoreBundle\Model\Imobiliario\ImovelModel($entityManager))
            ->getListaLancamentos($object->getInscricaoMunicipal());

        return $lista;
    }

    /**
     * @param   $object
     * @return  array
     */
    public function getListaCalculosNaoLancados($object)
    {
        if (!$object->getInscricaoMunicipal()) {
            return;
        }

        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $lista = (new \Urbem\CoreBundle\Model\Imobiliario\ImovelModel($entityManager))
            ->getListaCalculosNaoLancados($object->getInscricaoMunicipal());

        return $lista;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('inscricaoMunicipal')
            ->add('codSublote')
            ->add('timestamp')
            ->add('dtCadastro', 'sonata_type_date_picker', [])
            ->add('numero')
            ->add('complemento')
            ->add('cep')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $imovel = $this->getSubject();

        $showMapper
            ->with('label.arrecadacaoConsultaFinanceira.dadosImovel')
                ->add(
                    'contribuinte',
                    'customField',
                    [
                        'label' => 'label.arrecadacaoConsultaFinanceira.contribuinte',
                        'template' => 'TributarioBundle::Arrecadacao/Consultas/ConsultaFinanceiraImovel/contribuinte_show.html.twig',
                    ]
                )
                ->add(
                    'inscricaoMunicipal',
                    'customField',
                    [
                        'label' => 'label.arrecadacaoConsultaFinanceira.inscricaoImobiliaria',
                        'template' => 'TributarioBundle::Arrecadacao/Consultas/ConsultaFinanceiraImovel/inscricao_show.html.twig',
                    ]
                )
                ->add(
                    'situacao',
                    'customField',
                    [
                        'label' => '',
                        'template' => 'TributarioBundle::Arrecadacao/Consultas/ConsultaFinanceiraImovel/situacao_show.html.twig',
                    ]
                )
            ->end()
            ->with('label.arrecadacaoConsultaFinanceira.listaValoresVenais')
                ->add(
                    'listaValorVenal',
                    'customField',
                    [
                        'template' => 'TributarioBundle::Arrecadacao/Consultas/ConsultaFinanceiraImovel/lista_valor_venal_show.html.twig'
                    ]
                )
            ->end()
            ->with('label.arrecadacaoConsultaFinanceira.listaLancamentos')
                ->add(
                    'listaLancamento',
                    'customField',
                    [
                        'template' => 'TributarioBundle::Arrecadacao/Consultas/ConsultaFinanceiraImovel/lista_lancamento_show.html.twig'
                    ]
                )
            ->end()
            ->with('label.arrecadacaoConsultaFinanceira.listaCalculos')
                ->add(
                    'listaCalculos',
                    'customField',
                    [
                        'template' => 'TributarioBundle::Arrecadacao/Consultas/ConsultaFinanceiraImovel/lista_calculos_nao_lancados_show.html.twig'
                    ]
                )
            ->end()
        ;
    }
}
