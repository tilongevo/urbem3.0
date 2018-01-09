<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Orcamento;

use Doctrine\Common\Collections\ArrayCollection;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Config\Definition\Exception\Exception;
use Urbem\CoreBundle\Entity\Orcamento\ClassificacaoDespesa;
use Urbem\CoreBundle\Entity\Orcamento\ContaDespesa;
use Urbem\CoreBundle\Helper\MascaraHelper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ContaDespesaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_financeiro_orcamento_classificacao_economica_rubrica_despesa';
    protected $baseRoutePattern = 'financeiro/orcamento/classificacao-economica/rubrica-despesa';

    protected $includeJs = array(
        '/financeiro/javascripts/orcamento/classificacaoeconomica/rubrica_despesa.js',
    );

    public function createQuery($context = 'list')
    {
        $filter = $this->getRequest()->query->get('filter');

        $query = parent::createQuery($context);
        $query->where('o.exercicio = :exercicio');
        $query->setParameter('exercicio', $this->getExercicio());

        if (!empty($filter['codEstrutural']['value'])) {
            $query->andWhere(
                $query->expr()->like('o.codEstrutural', ':codEstrutural')
            );
            $query->setParameter("codEstrutural", $filter['codEstrutural']['value'] . '%');
        }

        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $pager = $this->getDataGrid()->getPager();
        $pager->setCountColumn(array('codConta'));

        $datagridMapper
            ->add('codEstrutural', null, ['label' => 'label.codigo', 'sortable' => false])
            ->add('descricao', null, ['label' => 'label.descricao', 'sortable' => false])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codEstrutural', null, ['label' => 'label.codigo', 'sortable' => false])
            ->add('descricao', null, ['label' => 'label.descricao', 'sortable' => false])
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions['codEstrutural'] = [
            'label' => 'label.codigo'
        ];

        if ($this->id($this->getSubject())) {
            $fieldOptions['codEstrutural'] = [
                'label' => 'label.codigo',
                'disabled' => true
            ];
        }

        // Máscara de Classificação da Despesa
        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Orcamento\ContaDespesa');
        $posicaoDespesaRepository = $em->getRepository('CoreBundle:Orcamento\PosicaoDespesa');
        $posicaoDespesas = $posicaoDespesaRepository->findBy(array('exercicio' => $this->getExercicio()), array('codPosicao' => 'ASC'));

        $mascara = MascaraHelper::parseMascara($posicaoDespesas);
        $formMapper
            ->with('label.rubricaDespesa.dadosRubricaDespesa')
            ->add(
                'mascara',
                'hidden',
                [
                    'data' => $mascara,
                    'mapped' => false
                ]
            )
            ->add(
                'codEstrutural',
                'text',
                $fieldOptions['codEstrutural']
            )
            ->add('descricao', 'text', ['label' => 'label.descricao'])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->with('label.rubricaDespesa.dadosRubricaDespesa')
            ->add('codEstrutural', null, ['label' => 'label.codigo'])
            ->add('descricao', null, ['label' => 'label.descricao'])
        ;
    }

    public function prePersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        try {
            $maxCodConta = $entityManager->getRepository('CoreBundle:Orcamento\ContaDespesa')->getMaxCodConta();
            $maxCodConta = array_shift($maxCodConta);
            $object->setCodConta($maxCodConta['max'] + 1);

            $object->setExercicio($this->getExercicio());
            $codigos = explode('.', $object->getCodEstrutural());
            $i = 1;
            foreach ($codigos as $codigo) {
                $posicao = $entityManager->getRepository('CoreBundle:Orcamento\PosicaoDespesa')
                    ->findOneBy(['codPosicao' => $i, 'exercicio' => $this->getExercicio()]);

                $classificacaoDespesa = new ClassificacaoDespesa();
                $classificacaoDespesa->setCodClassificacao($codigo);
                $classificacaoDespesa->setExercicio($this->getExercicio());
                $classificacaoDespesa->setCodConta($object);
                $classificacaoDespesa->setCodPosicao($posicao->getCodPosicao());
                $classificacaoDespesa->setFkOrcamentoPosicaoDespesa($posicao);
                $classificacaoDespesa->setFkOrcamentoContaDespesa($object);

                $entityManager->persist($classificacaoDespesa);

                $i++;
            }
            $entityManager->flush();
        } catch (Exception $e) {
            $entityManager->getConnection()->rollback();
            $container->get('session')->getFlashBag()->add('error', 'Erro ao salvar rúbrica de despesa.');
            throw $e;
        }
    }

    public function preRemove($object)
    {
        if ($this->canRemove($object)->contains(true)) {
            $container = $this->getConfigurationPool()->getContainer();
            $container->get('session')->getFlashBag()->add('error', self::ERROR_REMOVE_DATA);
            $this->getDoctrine()->clear();
            $this->redirectToUrl($this->request->headers->get('referer'));
        } else {
            $entityManager = $this->modelManager->getEntityManager($this->getClass());
            $classificacaoDespesa = $entityManager->getRepository('CoreBundle:Orcamento\ClassificacaoDespesa')
                ->findBy(['exercicio' => $this->getExercicio(), 'codConta' => $object->getCodConta()]);

            foreach ($classificacaoDespesa as $classificacao) {
                $entityManager->remove($classificacao);
            }
            $entityManager->flush();
        }
    }

    /**
     * Verifica se as entidades relacionadas tem valores
     *
     * @param $object
     * @param array  $ignoreAssociations
     * @return ArrayCollection
     */
    protected function canRemove($object, array $ignoreAssociations = [])
    {
        $collection = new ArrayCollection();
        $collection->add($object->getFkContabilidadeConfiguracaoLancamentoContaDespesaItens());
        $collection->add($object->getFkContabilidadeConfiguracaoLancamentoCreditos());
        $collection->add($object->getFkContabilidadeConfiguracaoLancamentoDebitos());
        $collection->add($object->getFkDiariasTipoDiariaDespesas());
        $collection->add($object->getFkEmpenhoPreEmpenhoDespesas());
        $collection->add($object->getFkFolhapagamentoConfiguracaoEmpenhoContaDespesas());
        $collection->add($object->getFkImaConfiguracaoDirfPrestadores());
        $collection->add($object->getFkTcepbElementoDeParas());
        $collection->add($object->getFkOrcamentoDespesas());
        $collection->add($object->getFkComprasSolicitacaoItemDotacoes());
        $collection->add($object->getFkFolhapagamentoConfiguracaoEventoDespesas());

        return $collection->map(function ($object) {
            if (!$object->isEmpty()) {
                return true;
            }
        });
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function toString($object)
    {
        return $object instanceof ContaDespesa
            ? $object->getDescricao()
            : 'Rúbrica de Despesa';
    }
}
