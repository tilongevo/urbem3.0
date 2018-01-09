<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Compras;

use Doctrine\ORM\EntityRepository;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

use Urbem\CoreBundle\Model\Patrimonial\Compras\CompraDiretaModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\CompraDiretaProcessoModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\MapaModel;
use Urbem\CoreBundle\Model\SwProcessoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\Entity;

class ComprasHomologacaoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_compras_homologacao';
    protected $baseRoutePattern = 'patrimonial/compras/compra-homologacao';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('numHomologacao')
            ->add('codCompraDireta')
            ->add('codModalidade')
            ->add('codEntidade')
            ->add('exercicioCompraDireta')
            ->add('lote')
            ->add('codCotacao')
            ->add('codItem')
            ->add('exercicioCotacao')
            ->add('cgmFornecedor')
            ->add('exercicio')
            ->add('homologado')
            ->add('timestamp')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('numHomologacao')
            ->add('codCompraDireta')
            ->add('codModalidade')
            ->add('codEntidade')
            ->add('exercicioCompraDireta')
            ->add('lote')
            ->add('codCotacao')
            ->add('codItem')
            ->add('exercicioCotacao')
            ->add('cgmFornecedor')
            ->add('exercicio')
            ->add('homologado')
            ->add('timestamp')
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
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $mapaModel = new MapaModel($entityManager);
        $swProcessoModel = new SwProcessoModel($entityManager);

        $codProcessoChoices = [];

        $exercicio = $this->getExercicio();

        foreach ($swProcessoModel->getProcessosAdministrativos() as $processo) {
            $processoCompleto = $processo['swProcesso']->getCodProcesso() . "/" . $processo['swProcesso']->getAnoExercicio();
            $processoCgm = " | " . $processo['swCgm']->getNomCgm();
            $processoAssunto = " | " . $processo['swProcesso']->getCodAssunto()->getNomAssunto();

            $choiceKey = $processoCompleto . $processoAssunto . $processoCgm;
            $choiceValue = $processo['swProcesso']->getCodProcesso();

            $codProcessoChoices[$choiceKey] = $choiceValue;
        }

        $now = new \DateTime();

        $defaultDate = [
            'widget' => 'single_text',
            'dp_default_date' =>  $now->format('d/m/Y'),
            'format' => 'dd/MM/yyyy',
            'required' => true
        ];

        $fieldOptions = [];
        $fieldOptions['codEntidade'] = [
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'label' => 'label.comprasDireta.codEntidade',
            'choice_label' => 'numCgm.nomCgm',
            'placeholder' => 'label.selecione',
            'required' => true,
            'query_builder' => function (EntityRepository $entityManager) use ($exercicio) {
                $qb = $entityManager->createQueryBuilder('entidade');
                $result = $qb->where('entidade.exercicio = :exercicio')
                    ->setParameter(':exercicio', $exercicio);

                return $result;
            }
        ]
        ;

        $fieldOptions['codProcesso'] = [
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'label' => 'label.comprasDireta.codProcesso',
            'mapped' => false,
            'choices' => $codProcessoChoices,
            'required' => false,
            'placeholder' => 'label.selecione'
        ];

        $fieldOptions['codMapa'] = [
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'label' => 'label.comprasDireta.codMapa',
            'choice_label' => function (Compras\Mapa $mapa) {
                $exercicio = $mapa->getExercicio();

                return "{$exercicio} | {$mapa->getCodMapa()}";
            },
            'placeholder' => 'label.selecione',
            'required' => true,
            'choice_attr' => function (Compras\Mapa $mapa, $key, $index) use ($mapaModel, $exercicio) {
                foreach ($mapaModel->getMapasDisponiveis($exercicio)->getQuery()->getResult() as $mapaDisponivel) {
                    if ($mapa->getCodMapa() == $mapaDisponivel->getCodMapa()) {
                        return ['disabled' => false];
                    }
                }

                return ['disabled' => true];
            }
        ];

        $fieldOptions['dtEntregaProposta'] = $defaultDate;
        $fieldOptions['dtEntregaProposta']['label'] = 'label.comprasDireta.dtEntregaProposta';

        $fieldOptions['dtValidadeProposta'] = $defaultDate;
        $fieldOptions['dtValidadeProposta']['label'] = 'label.comprasDireta.dtValidadeProposta';

        $fieldOptions['timestamp'] = $defaultDate;
        $fieldOptions['timestamp']['label'] = 'label.comprasDireta.timestamp';

        $fieldOptions['codModalidade'] = [
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'label' => 'label.comprasDireta.codModalidade',
            'choice_label' => 'descricao',
            'placeholder' => 'label.selecione',
            'required' => true
        ];

        $fieldOptions['codTipoObjeto'] = $fieldOptions['codModalidade'];
        $fieldOptions['codTipoObjeto']['label'] = 'label.comprasDireta.codTipoObjeto';

        $fieldOptions['codObjeto'] = $fieldOptions['codModalidade'];
        $fieldOptions['codObjeto']['label'] = 'label.comprasDireta.codObjeto';
        $fieldOptions['codObjeto']['attr']['data-value-from'] = '_codMapa';

        $fieldOptions['condicoesPagamento'] = [
            'required' => true,
            'label' => 'label.comprasDireta.condicoesPagamento'
        ];
        $fieldOptions['prazoEntrega'] = [
            'required' => true,
            'label' => 'label.comprasDireta.prazoEntrega'
        ];

        if (!is_null($id)) {
            $compraDireta = $entityManager->getRepository(Compras\CompraDireta::class)->find($id);

            $fieldOptions['codMapa']['choice_attr'] = function (Compras\Mapa $mapa, $key, $index)
 use ($mapaModel, $exercicio, $compraDireta) {

                foreach ($mapaModel->getMapasDisponiveis($exercicio)->getQuery()->getResult() as $mapaDisponivel) {
                    if ($mapa->getCodMapa() == $mapaDisponivel->getCodMapa()) {
                        return ['disabled' => false];
                    } elseif ($compraDireta->getCodMapa()->getCodMapa() == $mapa->getCodMapa()) {
                        return ['disabled' => false, 'selected' => 'selected'];
                    }
                }

                return ['disabled' => true];
            };

            $compraDiretaProcessoCollection = $compraDireta->getCompraDiretaProcessoCollection();

            if ($compraDiretaProcessoCollection->count() > 0) {
                $swProcesso = $compraDiretaProcessoCollection->get(0)->getCodProcesso();
                $fieldOptions['codProcesso']['data'] = $swProcesso->getCodProcesso();
            }

            // Desabilita campos que não podem ser alterados durante a edição
            $fieldOptions['codModalidade']['disabled'] = true;
            $fieldOptions['codEntidade']['disabled'] = true;
            $fieldOptions['timestamp']['disabled'] = true;
            $fieldOptions['codObjeto']['disabled'] = true;
        }
        $formMapper
            ->with('label.comprasDireta.compraDireta')
            ->add('codEntidade', null, $fieldOptions['codEntidade'], ['admin_code' => 'financeiro.admin.entidade'])
            ->add('codProcesso', 'choice', $fieldOptions['codProcesso'])
            ->add('timestamp', 'sonata_type_date_picker', $fieldOptions['timestamp'])
            ->end()

            ->with('label.comprasDireta.codObjeto')
            ->add('codModalidade', null, $fieldOptions['codModalidade'])
            ->end()

            ->with('label.comprasDireta.proposta')
            ->add('dtEntregaProposta', 'sonata_type_date_picker', $fieldOptions['dtEntregaProposta'])
            ->add('dtValidadeProposta', 'sonata_type_date_picker', $fieldOptions['dtValidadeProposta'])
            ->end()
            ->with('label.comprasDireta.items', [
                'class' => 'col s12 comprasdireta-items'
            ])
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('numHomologacao')
            ->add('codCompraDireta')
            ->add('codModalidade')
            ->add('codEntidade')
            ->add('exercicioCompraDireta')
            ->add('lote')
            ->add('codCotacao')
            ->add('codItem')
            ->add('exercicioCotacao')
            ->add('cgmFornecedor')
            ->add('exercicio')
            ->add('homologado')
            ->add('timestamp')
        ;
    }
}
