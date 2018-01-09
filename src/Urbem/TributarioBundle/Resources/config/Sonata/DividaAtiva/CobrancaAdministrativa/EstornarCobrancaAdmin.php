<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\DividaAtiva\CobrancaAdministrativa;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Administracao\TipoDocumento;
use Urbem\CoreBundle\Entity\Divida\DividaCgm;
use Urbem\CoreBundle\Entity\Divida\DividaParcelamento;
use Urbem\CoreBundle\Entity\Divida\Documento;
use Urbem\CoreBundle\Entity\Divida\Parcela;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class EstornarCobrancaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_divida_ativa_cobranca_administrativa_estornar_cobranca';
    protected $baseRoutePattern = 'tributario/divida-ativa/cobranca-administrativa/estornar-cobranca';
    protected $exibirBotaoIncluir = false;
    protected $estornos;

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);

        $em = $this->modelManager->getEntityManager($this->getClass());

        $filter = $this->getRequest()->query->get('filter');

        if (!$filter) {
            $query->andWhere('1 = 0');
            return $query;
        };

        $params = [];

        $diasAtraso = false;
        if ($filter['numeroDiasAtraso']['value']) {
            $diasAtraso = $filter['numeroDiasAtraso']['value'];
        }

        $estornarCobrancaList = $em->getRepository('CoreBundle:Divida\DividaAtiva')->getEstornarCobrancaList(false, $diasAtraso);

        $numParcelamento = [0];
        foreach ($estornarCobrancaList as $item) {
            $numParcelamento[] = $item->num_parcelamento;
        }

        if ($filter['cobrancaAno']['value']) {
            $pieces = explode('/', $filter['cobrancaAno']['value']);
            $query->andWhere($query->expr()->eq('o.numeroParcelamento', (int) $pieces[0]));
            $query->andWhere('o.exercicio = :exercicio');
            $params['exercicio'] = $pieces[1];
        }

        $query->andWhere($query->expr()->in('o.numParcelamento', (array) $numParcelamento));
        $query->setParameters($params);
        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'cobrancaAno',
                'doctrine_orm_number',
                [
                    'label' => 'label.tributarioEstornarCobranca.cobrancaAno',
                    'mapped' => false,
                ]
            )
            ->add(
                'termoParcelamento',
                'doctrine_orm_callback',
                [
                    'label' => 'label.tributarioEstornarCobranca.termoParcelamento',
                    'mapped' => false,
                    'callback' => [$this, 'getTermoParcelamentoSearchFilter']
                ],
                'entity',
                [
                    'class' => TipoDocumento::class
                ]
            )
            ->add(
                'fkSwCgm',
                'doctrine_orm_callback',
                [
                    'mapped' => false,
                    'label' => 'label.tributarioEstornarCobranca.contribuinte',
                    'callback' => [$this, 'getContribuinteSearchFilter']
                ],
                'autocomplete',
                [
                    'class' => SwCgm::class,
                    'route' => array(
                        'name' => 'api-search-swcgm-pessoa-fisica-numcgm-nomecgm'
                    )
                ]
            )
            ->add(
                'valorParcelamento',
                'doctrine_orm_callback',
                [
                    'label' => 'label.tributarioEstornarCobranca.valorParcelamento',
                    'mapped' => false,
                    'callback' => [$this, 'getValorParcelamentoSearchFilter'],
                ]
            )
            ->add(
                'numeroParcelas',
                'doctrine_orm_callback',
                [
                    'label' => 'label.tributarioEstornarCobranca.numeroParcelas',
                    'mapped' => false,
                    'callback' => [$this, 'getNumeroParcelasSearchFilter'],
                ]
            )
            ->add(
                'numeroParcelasAtraso',
                'doctrine_orm_callback',
                [
                    'label' => 'label.tributarioEstornarCobranca.numeroParcelasAtraso',
                    'mapped' => false,
                    'callback' => [$this, 'getNumeroParcelasAtrasoSearchFilter'],
                ]
            )
            ->add(
                'numeroDiasAtraso',
                'doctrine_orm_callback',
                [
                    'label' => 'label.tributarioEstornarCobranca.numeroDiasAtraso',
                    'mapped' => false,
                    'callback' => [$this, 'getSearchFilter'],
                ]
            )
        ;
    }

    /**
     * @return array
     */
    public function getBatchActions()
    {
        $actions = parent::getBatchActions();

        $actions['motivo'] = [
            'label'            => $this->trans('label.tributarioEstornarCobranca.motivoEstorno', [], 'CoreBundle'),
            'ask_confirmation' => true
        ];

        return $actions;
    }

    /**
     * @param $qb
     * @param $alias
     * @param $field
     * @param $value
     * @return bool|void
     */
    public function getContribuinteSearchFilter($qb, $alias, $field, $value)
    {
        if (!$value['value']) {
            return;
        }

        $qb->innerJoin('CoreBundle:Divida\DividaParcelamento', 'ddp', 'WITH', 'ddp.numParcelamento = o.numParcelamento');
        $qb->innerJoin('CoreBundle:Divida\DividaAtiva', 'da', 'WITH', 'da.codInscricao = ddp.codInscricao AND da.exercicio = ddp.exercicio');
        $qb->innerJoin('CoreBundle:Divida\DividaCgm', 'ddc', 'WITH', 'ddc.codInscricao = da.codInscricao AND ddc.exercicio = da.exercicio');
        $qb->andWhere('ddc.numcgm = :numcgm');
        $qb->setParameter('numcgm', $value['value']);

        return true;
    }

    /**
     * @param $qb
     * @param $alias
     * @param $field
     * @param $value
     * @return bool|void
     */
    public function getValorParcelamentoSearchFilter($qb, $alias, $field, $value)
    {
        if (!$value['value']) {
            return;
        }

        $qb->innerJoin('CoreBundle:Divida\Parcela', 'vp', 'WITH', 'vp.numParcelamento = o.numParcelamento');
        $qb->andWhere('vp.vlrParcela = :valor');
        $qb->setParameter('valor', (float) $value['value']);

        return true;
    }

    /**
     * @param $qb
     * @param $alias
     * @param $field
     * @param $value
     * @return bool|void
     */
    public function getTermoParcelamentoSearchFilter($qb, $alias, $field, $value)
    {
        if (!$value['value']) {
            return;
        }

        $qb->innerJoin('CoreBundle:Divida\Documento', 'dd', 'WITH', 'dd.numParcelamento = o.numParcelamento');
        $qb->andWhere('dd.codTipoDocumento = :codTipoDocumento');
        $qb->setParameter('codTipoDocumento', $value['value']);

        return true;
    }

    /**
     * @param $qb
     * @param $alias
     * @param $field
     * @param $value
     * @return bool|void
     */
    public function getNumeroParcelasSearchFilter($qb, $alias, $field, $value)
    {
        if (!$value['value']) {
            return;
        }

        $em = $this->modelManager->getEntityManager($this->getClass());
        $qb2 = $em->getRepository(Parcela::class)->createQueryBuilder('p');
        $qb2->select('COUNT(p.numParcela) as parcela, p.numParcelamento');
        $qb2->andWhere('p.paga = false');
        $qb2->andWhere('p.cancelada = false');
        $qb2->groupBy('p.numParcelamento');

        $result2 = $qb2->getQuery()->getScalarResult();

        $parcelamentosFiltered = [];
        foreach ($result2 as $parcela) {
            if ($value['value'] == $parcela['parcela']) {
                $parcelamentosFiltered[] = $parcela['numParcelamento'];
            }
        }

        $qb->andWhere($qb->expr()->in('o.numParcelamento', (array) $parcelamentosFiltered));

        return true;
    }

    /**
     * @param $qb
     * @param $alias
     * @param $field
     * @param $value
     * @return bool|void
     */
    public function getNumeroParcelasAtrasoSearchFilter($qb, $alias, $field, $value)
    {
        if (!$value['value']) {
            return;
        }

        $em = $this->modelManager->getEntityManager($this->getClass());
        $qb2 = $em->getRepository(Parcela::class)->createQueryBuilder('p');
        $qb2->select('COUNT(p.numParcela) as parcela, p.numParcelamento');
        $qb2->andWhere('p.paga = false');
        $qb2->andWhere('p.cancelada = false');
        $qb2->andWhere('p.dtVencimentoParcela < CURRENT_DATE()');
        $qb2->groupBy('p.numParcelamento');

        $result2 = $qb2->getQuery()->getScalarResult();

        $parcelamentosFiltered = [];
        foreach ($result2 as $parcela) {
            if ($value['value'] == $parcela['parcela']) {
                $parcelamentosFiltered[] = $parcela['numParcelamento'];
            }
        }

        $qb->andWhere($qb->expr()->in('o.numParcelamento', (array) $parcelamentosFiltered));

        return true;
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
        if (empty($value['value'])) {
            return;
        }

        $filter = $this->getDataGrid()->getValues();
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        return true;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add(
                'termoParcelamento',
                'customField',
                [
                    'label' => 'label.tributarioEstornarCobranca.termoParcelamento',
                    'template' => 'TributarioBundle::DividaAtiva/CobrancaAdministrativa/EstornarCobranca/termoParcelamento.html.twig'
                ]
            )
            ->add(
                'inscricao',
                'customField',
                [
                    'label' => 'label.tributarioEstornarCobranca.inscricao',
                    'template' => 'TributarioBundle::DividaAtiva/CobrancaAdministrativa/EstornarCobranca/inscricao.html.twig'
                ]
            )
            ->add(
                'cobranca',
                'customField',
                [
                    'label' => 'label.tributarioEstornarCobranca.cobranca',
                    'template' => 'TributarioBundle::DividaAtiva/CobrancaAdministrativa/EstornarCobranca/cobranca.html.twig'
                ]
            )
            ->add(
                'parcelas',
                'customField',
                [
                    'label' => 'label.tributarioEstornarCobranca.parcelas',
                    'template' => 'TributarioBundle::DividaAtiva/CobrancaAdministrativa/EstornarCobranca/parcelas.html.twig'
                ]
            )
            ->add(
                'parcelasAtraso',
                'customField',
                [
                    'label' => 'label.tributarioEstornarCobranca.parcelasAtraso',
                    'template' => 'TributarioBundle::DividaAtiva/CobrancaAdministrativa/EstornarCobranca/parcelasAtraso.html.twig'
                ]
            )
            ->add(
                'diasAtraso',
                'customField',
                [
                    'label' => 'label.tributarioEstornarCobranca.diasAtraso',
                    'template' => 'TributarioBundle::DividaAtiva/CobrancaAdministrativa/EstornarCobranca/diasAtraso.html.twig'
                ]
            )
            ->add(
                'fkDividaParcelas',
                'customField',
                [
                    'label' => 'label.tributarioEstornarCobranca.valor',
                    'template' => 'TributarioBundle::DividaAtiva/CobrancaAdministrativa/EstornarCobranca/vlrParcela.html.twig'
                ]
            )
        ;
    }

    /**
     *  @param  Parcelamento $object
     *  @return array
     */
    public function getEstornarCobrancaList($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $repository = $em->getRepository('CoreBundle:Divida\DividaAtiva');
        $estornarArray = $repository->getEstornarCobrancaList($object->getNumParcelamento());
        $this->estornos = $estornarArray;

        return $this->estornos;
    }

    /**
     *  @return array
     */
    public function getEstornos()
    {
        return $this->estornos;
    }

    /**
     *  @return array
     */
    public function getInscricoes()
    {
        $estornos = $this->getEstornos();
        $estorno = end($estornos);
        $inscricoes = explode('<br>', (string) $estorno->inscricao);

        return $inscricoes;
    }

    /**
     *  @return string
     */
    public function getNumeroParcelamento()
    {
        $estornos = $this->getEstornos();
        $estorno = end($estornos);
        return (string) $estorno->qtd_parcelas;
    }

    /**
     *  @return string
     */
    public function getParcelasAtraso()
    {
        $estornos = $this->getEstornos();
        $estorno = end($estornos);

        return (string) $estorno->qtd_parcelas_vencidas;
    }

    /**
     *  @return integer
     */
    public function getNumDiasAtraso()
    {
        $estornos = $this->getEstornos();
        $estorno = end($estornos);

        return (int) $estorno->dias_atraso;
    }

    /**
     *  @return float
     */
    public function getVlrParcela()
    {
        $estornos = $this->getEstornos();
        $estorno = end($estornos);

        return (float) $estorno->valor_parcelamento;
    }

    /**
     *  @return string
     */
    public function getCobranca()
    {
        $estornos = $this->getEstornos();
        $estorno = end($estornos);
        $cobranca = sprintf('%d/%d', $estorno->numero_parcelamento, $estorno->exercicio_cobranca);

        return (string) $cobranca;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $formMapper
            ->add('exercicio')
            ->add('codInscricao')
            ->add('numParcelamento')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('exercicio')
            ->add('codInscricao')
            ->add('numParcelamento')
        ;
    }
}
