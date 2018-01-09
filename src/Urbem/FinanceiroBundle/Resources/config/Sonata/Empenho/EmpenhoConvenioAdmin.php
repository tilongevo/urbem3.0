<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Empenho;

use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Empenho\Empenho;
use Urbem\CoreBundle\Entity\Empenho\EmpenhoConvenio;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class EmpenhoConvenioAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_empenho_empenho_convenio';
    protected $baseRoutePattern = 'financeiro/empenho/vincular-convenio';
    protected $exibirBotaoIncluir = false;
    protected $includeJs = array('/financeiro/javascripts/empenho/vincular-empenho-convenio.js');

    /**
     * @param string $name
     * @return mixed|null|string
     */
    public function getTemplate($name)
    {
        if ($name === 'outer_list_rows_list') {
            // CoreBundle:Sonata/CRUD:list_inner_row.html.twig
            return 'CoreBundle:Sonata/CRUD:hidden_outer_list_rows_list.html.twig';
        }

        if ($name === 'hidden_inner_list_row') {
            return 'FinanceiroBundle:Empenho/Empenho/Convenio:hidden_inner_list_row.html.twig';
        }

        return parent::getTemplate($name);
    }

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('list', 'edit'));
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $em = $this->modelManager->getEntityManager(EmpenhoConvenio::class);
        $vinculos = $em->getRepository(EmpenhoConvenio::class)
            ->findBy([
                'exercicio' => $this->getSubject()->getExercicio(),
                'numConvenio' => $this->getSubject()->getNumConvenio()
            ]);

        $formMapper->with('empenhoConvenio.dados');
            $formMapper->add(
                'detalhe',
                'customField',
                [
                    'label' => false,
                    'mapped' => false,
                    'data' => array(
                        'convenio' => $this->getSubject()
                    ),
                    'template' => 'FinanceiroBundle:Empenho\Empenho\Convenio:detalhe_dados_convenio.html.twig',
                ]
            );
        $formMapper->end();

        $formMapper->with('empenhoConvenio.participantes');
            $formMapper->add(
                'participantes',
                'customField',
                [
                    'label' => false,
                    'mapped' => false,
                    'data' => array(
                        'convenio' => $this->getSubject()
                    ),
                    'template' => 'FinanceiroBundle:Empenho\Empenho\Convenio:detalhe_participantes_convenio.html.twig',
                ]
            );
        $formMapper->end();

        $fieldOptions['entidade'] = [
            'class' => Entidade::class,
            'label' => 'entidade',
            'choice_label' => 'fkSwCgm.nomCgm',
            'mapped' => false,
            'query_builder' => function ($entityManager) {
                return $entityManager
                    ->createQueryBuilder('entidade')
                    ->where('entidade.exercicio = :exercicio')
                    ->setParameter(':exercicio', $this->getExercicio());
            },
            'choice_value' => 'cod_entidade',
            'attr' => [
                'class' => 'select2-parameters '
            ],
        ];

        $fieldOptions['empenho'] = [
            'label' => 'label.ordemPagamento.codEmpenho',
            'mapped' => false,
            'route' => ['name' => 'carrega_empenho_exercicio'],
            'req_params' => [
                'exercicio' => $this->getExercicio()
            ]
        ];

        $formMapper->with('empenhoConvenio.empenhosVinculados');
            $formMapper->add('entidade', 'entity', $fieldOptions['entidade']);
            $formMapper->add('empenho', 'autocomplete', $fieldOptions['empenho']);
            $formMapper->add(
                'btnAdd',
                'customField',
                [
                    'label' => false,
                    'mapped' => false,
                    'data' => array(),
                    'template' => 'FinanceiroBundle:Empenho\Empenho\Convenio:botao.html.twig',
                ]
            );
        $formMapper->end();

        $formMapper->with('label.registros');
        $formMapper->add(
            'empenhosVinculados',
            'customField',
            [
                'label' => false,
                'mapped' => false,
                'data' => array(
                    'empenhoConvenios' => $vinculos
                ),
                'template' => 'FinanceiroBundle:Empenho\Empenho\Convenio:empenhos_vinculados.html.twig',
            ]
        );
        $formMapper->end();
    }

    /**
     * @param DatagridMapper $filter
     */
    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $this->setBreadCrumb();

        $filter->add('exercicio', null, [
            'label' => 'label.exercicio'
        ]);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper->add('convenio', 'string', [
            'label' => 'label.convenio',
            'template' => 'CoreBundle:Sonata/CRUD:list_concat_value.html.twig',
            'data' => [
                'property' => [
                    'numConvenio',
                    'exercicio'
                ],
                'glue' => '/'
            ]
        ]);

        $listMapper->add('fundamentacao', 'string', [
            'label' => 'label.fundamentacao'
        ]);

        $listMapper->add('dtVigencia', 'datetime', [
            'label' => 'label.dtVigencia',
            'pattern' => 'dd/MM/yyyy',
        ]);

        $listMapper
            ->add(
                '_action',
                'actions',
                array(
                    'actions' => array(
                        'edit' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'),
                        '' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show_hidden_table.html.twig'),
                    )
                )
            );
    }

    /**
     * @param string $context
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function createQuery($context = 'list')
    {
        /** @var $query \Doctrine\ORM\QueryBuilder */
        $query = parent::createQuery($context);

        $group = [
            'subselect.numConvenio', 'subselect.exercicio',
            'subselect.cgmResponsavel', 'subselect.codObjeto', 'subselect.codTipoConvenio',
            'subselect.codTipoDocumento', 'subselect.codDocumento', 'subselect.observacao',
            'subselect.dtAssinatura', 'subselect.dtVigencia', 'subselect.valor',
            'subselect.inicioExecucao', 'subselect.fundamentacao'
        ];

        $subselect = clone $query;
        $subselect->resetDQLPart('select');
        $subselect->resetDQLPart('from');
        $subselect->from($query->getDQLPart('from')[0]->getFrom(), 'subselect');
        $subselect->select('subselect');
        $subselect->groupBy(implode(', ', $group));

        $query->where('EXISTS (' . $subselect->getDQL() . ')');
        $query->orderBy('o.numConvenio');

        return $query;
    }

    /**
     * @param mixed $object
     */
    public function preUpdate($object)
    {
        $container = $this->getConfigurationPool()->getContainer();

        $empenhos = $this->getRequest()->request->get('empenhos');
        $em = $this->modelManager->getEntityManager(EmpenhoConvenio::class);
        $vinculos = $em->getRepository(EmpenhoConvenio::class)
            ->findBy([
                'exercicio' => $this->getSubject()->getExercicio(),
                'numConvenio' => $this->getSubject()->getNumConvenio()
            ]);

        foreach ($empenhos as $empenho) {
            list($codEntidade, $codEmpenho) = explode('__', $empenho);

            $entidade = $em->getRepository(Entidade::class)
                ->findOneBy([
                    'exercicio' => $this->getExercicio(),
                    'codEntidade' => $codEntidade
                ]);

            list($empenho, $exercicio) = explode('/', $codEmpenho);

            $empenhoResult = $em->getRepository(Empenho::class)
                ->findOneBy([
                    'exercicio' => $exercicio,
                    'codEmpenho' => $empenho,
                    'codEntidade' => $codEntidade
                ]);

            if (!$vinculos) {
                $empenhoConvenio = new EmpenhoConvenio();
                $empenhoConvenio->setFkOrcamentoEntidade($entidade);
                $empenhoConvenio->setNumConvenio($object->getNumConvenio());
                $empenhoConvenio->setFkEmpenhoEmpenho($empenhoResult);

                $object->addFkEmpenhoEmpenhoConvenios($empenhoConvenio);
            } else {
                $empenhoConvenioResult = $em->getRepository(EmpenhoConvenio::class)
                    ->findBy([
                        'exercicio' => $this->getSubject()->getExercicio(),
                        'codEntidade' => $codEntidade,
                        'codEmpenho' => $empenho,
                        'numConvenio' => $this->getSubject()->getNumConvenio()
                    ]);

                foreach ($vinculos as $vinculo) {
                    $em->remove($vinculo);
                }
                $em->flush();

                foreach ($empenhoConvenioResult as $empConv) {
                    $empConv->setFkOrcamentoEntidade($entidade);
                    $empConv->setNumConvenio($object->getNumConvenio());
                    $empConv->setFkEmpenhoEmpenho($empenhoResult);

                    $object->addFkEmpenhoEmpenhoConvenios($empConv);
                }
            }
        }
    }
}
