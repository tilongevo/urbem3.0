<?php
namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Patrimonio;

use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ExcluirManutencaoPagaAdmin extends AbstractSonataAdmin
{

    protected $baseRouteName = 'urbem_patrimonial_patrimonio_excluir_manutencao_paga';

    protected $baseRoutePattern = 'patrimonial/patrimonio/excluir-manutencao-paga';

    protected $exibirBotaoIncluir = false;

    protected $customMessageDelete = "Você tem certeza que deseja remover a manutenção do objeto \"%object%\" selecionado?";

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codBem', null, ['label' => 'label.manutencaoPaga.codBem'], null, ['attr' => ['class' => 'numeric ']])
            ->add(
                'dtAgendamento',
                'doctrine_orm_callback',
                [
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.manutencaoPaga.dtAgendamento',
                ],
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy',
                ]
            );
    }

    /**
     * @param QueryBuilder $queryBuilder
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

        if ($filter['dtAgendamento']['value'] != '') {
            $queryBuilder->join("{$alias}.fkPatrimonioManutencao", "manutencao");
            $queryBuilder->andWhere("manutencao.dtAgendamento = :dtAgendamento");
            $queryBuilder->setParameter("dtAgendamento", $filter['dtAgendamento']['value']);
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
            ->add('fkPatrimonioManutencao.fkPatrimonioBem.fkPatrimonioEspecie', null, ['label' => 'label.manutencaoPaga.classificacao'])
            ->add('codBem', null, ['label' => 'label.manutencaoPaga.codBem'])
            ->add('fkPatrimonioManutencao.fkPatrimonioBem.numPlaca', null, ['label' => 'label.manutencaoPaga.numPlaca'])
            ->add('dtAgendamento', 'date', ['label' => 'label.manutencaoPaga.dtAgendamento'])
            ->add('exercicio', null, ['label' => 'label.manutencaoPaga.exercicio'])
            ->add('fkPatrimonioManutencao', null, ['label' => 'label.manutencaoPaga.manutencao'])
            ->add('_action', 'actions', array(
                'actions' => array(
                    'delete' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'),
                )
            ));
    }
}
