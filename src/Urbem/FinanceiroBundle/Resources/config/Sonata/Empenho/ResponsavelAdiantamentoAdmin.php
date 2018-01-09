<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Empenho;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Route\RouteCollection;

class ResponsavelAdiantamentoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_financeiro_empenho_adiantamento_responsavel';

    protected $baseRoutePattern = 'financeiro/empenho/adiantamento/responsavel';

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept('create');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('exercicio')
            ->add('contaContrapartida')
            ->add('contaLancamento')
            ->add('ativo')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('exercicio')
            ->add('contaContrapartida')
            ->add('contaLancamento')
            ->add('ativo')
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $exercicio = $this->getExercicio();

        $formMapper
            ->add('fkSwCgm', 'sonata_type_model_autocomplete', [
                'label' => 'label.contrapartida.credor',
                'callback' => function ($admin, $property, $value) {
                    $datagrid = $admin->getDatagrid();
                    $query = $datagrid->getQuery();

                    $fkSwCgmPessoaFisica = sprintf('%s.fkSwCgmPessoaFisica', $query->getRootAlias());
                    $query
                        ->innerJoin($fkSwCgmPessoaFisica, 'cgmpf')
                        ->andWhere("LOWER({$query->getRootAlias()}.nomCgm) LIKE :nomCgm")
                        ->setParameter('nomCgm', sprintf('%%%s%%', strtolower($value)));

                    $datagrid->setValue($property, null, $value);
                },
                'property' => 'nomCgm',
                'to_string_callback' => function (SwCgm $pessoaFisica, $property) {
                    return sprintf('%s - %s', $pessoaFisica->getNumcgm(), strtoupper($pessoaFisica->getNomCgm()));
                },
                'required' => true
            ])
            ->add(
                'fkContabilidadePlanoAnalitica',
                null,
                [
                'label' => 'label.contrapartida.contaContrapartida',
                'attr' => array(
                    'class' => 'select2-parameters '
                ),
                'placeholder' => 'label.selecione',
                'required' => true,
                'query_builder' => function ($em) use ($exercicio) {
                    $qb = $em->createQueryBuilder('pa');
                    $qb->innerJoin('CoreBundle:Contabilidade\PlanoConta', 'pc', 'WITH', 'pc.codConta = pa.codConta and pc.exercicio = pa.exercicio');
                    $qb->andWhere('pc.exercicio = :exercicio');
                    $qb->andWhere($qb->expr()->like('pc.codEstrutural', ':codEstrutural'));
                    $qb->setParameters([
                        'exercicio' => $exercicio,
                        'codEstrutural' => '7.1.1.1.%'
                    ]);
                    $qb->orderBy('pc.codEstrutural', 'ASC');
                    return $qb;
                }],
                ['admin_code' => 'core.admin.plano_analitica']
            )
            ->add('ativo', 'choice', [
                'label' => 'label.contrapartida.situacao',
                'choices' => ['Ativo' => true, 'Inativo' => false],
                'expanded' => true
            ])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('exercicio')
            ->add('contaContrapartida')
            ->add('contaLancamento')
            ->add('ativo')
        ;
    }
}
