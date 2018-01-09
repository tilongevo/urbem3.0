<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Urbem\CoreBundle\Entity\Pessoal;

class ServidorFeriasAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_pessoal_ferias_consulta_servidor';
    protected $baseRoutePattern = 'recursos-humanos/pessoal/ferias/consulta-servidor';
    protected $exibirMensagemFiltro = false;


    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $filter = $this->getRequest()->query->get('filter');

        if (!$filter) {
            $this->exibirMensagemFiltro = true;
            $query->andWhere('1 = 0');
        } else {
            $this->exibirMensagemFiltro = false;
        }
        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'codContrato',
                'doctrine_orm_choice',
                array(
                    'label' => 'label.pessoal.servidor.matriculaSwCgm',
                    'callback' => array($this, 'getSearchFilter'),
                ),
                'autocomplete',
                array(
                    'class' => Pessoal\Contrato::class,
                    'route' => array(
                        'name' => 'carrega_contrato'
                    ),
                    'mapped' => false,
                )
            )
        ;
    }


    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {


        if (! $value['value']) {
            return;
        }

        $filter = $this->getDataGrid()->getValues();

        $queryBuilder->resetDQLPart('join');

        if (isset($filter['codContrato']) && $filter['codContrato']['value'] != '') {
            $queryBuilder->join("CoreBundle:Pessoal\ContratoServidor", "contserv", "WITH", "contserv.codContrato = {$alias}.codContrato");
            $queryBuilder->andWhere("(contserv.codContrato) = :codContrato");
            $queryBuilder->setParameter(":codContrato", strtolower($filter['codContrato']['value']));
        }
        return true;
    }



    private function getProtocoles($codServidor)
    {
        $query = 'teste';
        return $query;
    }


    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codContrato')
            ->add('registro', null, ['label' => 'label.pessoal.servidor.matricula'])
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('codContrato')
            ->add('fkPessoalServidor.fkSwCgmPessoaFisica.fkSwCgm.nomCgm')
            ->add('codNorma')
            ->add('codTipoPagamento')
            ->add('codTipoSalario')
            ->add('codTipoAdmissao')
            ->add('codCategoria')
            ->add('codVinculo')
            ->add('codCargo')
            ->add('codRegime')
            ->add('codSubDivisao')
            ->add('nrCartaoPonto')
            ->add('ativo')
            ->add('dtOpcaoFgts')
            ->add('adiantamento')
            ->add('codGrade')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codContrato')
            ->add('fkPessoalServidor.fkSwCgmPessoaFisica.fkSwCgm.nomCgm')
            ->add('codNorma')
            ->add('codTipoPagamento')
            ->add('codTipoSalario')
            ->add('codTipoAdmissao')
            ->add('codCategoria')
            ->add('codVinculo')
            ->add('codCargo')
            ->add('codRegime')
            ->add('codSubDivisao')
            ->add('nrCartaoPonto')
            ->add('ativo')
            ->add('dtOpcaoFgts')
            ->add('adiantamento')
            ->add('codGrade')
        ;
    }
}
