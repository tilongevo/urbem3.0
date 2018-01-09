<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Compras;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Administracao\Assinatura;
use Urbem\CoreBundle\Entity\Beneficio\Fornecedor;
use Urbem\CoreBundle\Entity\Compras\CompraDireta;
use Urbem\CoreBundle\Entity\Compras\CotacaoFornecedorItemDesclassificacao;
use Urbem\CoreBundle\Entity\Compras\CotacaoItem;
use Urbem\CoreBundle\Entity\Compras\Julgamento;
use Urbem\CoreBundle\Entity\Compras\JulgamentoItem;
use Urbem\CoreBundle\Entity\Compras\MapaItem;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class JulgamentoPropostaItemAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_compras_julgamento_proposta_item';
    protected $customHeader = 'PatrimonialBundle:Compras\JulgamentoPropostaCompraDireta:header.html.twig';
    protected $baseRoutePattern = 'patrimonial/compras/julgamento-proposta/item';
    protected $includeJs = [
        '/patrimonial/javascripts/compras/julgamento-proposta.js',
    ];

    protected $exibirBotaoIncluir = false;
    protected $exibirBotaoExcluir = false;
    protected $exibirBotaoEditar = false;

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        /**
         * @TODO: Some mandatory parameters are missing to generate a URL fo route
         * O erro a cima acontece  caso o parametro não é passado. Isso pode ser
         * uma falta de tratamento ou um erro de responsabilidade quanto a rota.
         */
        $this->setBreadCrumb($id ? ['id' => $id] : []);
        $compraDiretaId = $this->getRequest()->get('compra-direta');
        if(!$compraDiretaId) {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $compraDiretaId = $formData['compra-direta'];
        }
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $cd = $em->getRepository('CoreBundle:Compras\CompraDireta')->findOneBy(
            $this->explodeId($compraDiretaId)
        );

        $formMapperOptions['status'] = [
            'attr' => ['class' => 'select2-parameters '],
            'choices' => [
                'Classificado' => '1',
                'Desclassificado' => '2'
            ],
            'label' => 'label.julgamentoProposta.status',
            'mapped' => false
        ];

        $formMapperOptions['observacao'] = [
            'label' => 'label.julgamentoProposta.observacao',
            'mapped' => false
        ];

        $formMapper
            ->with('label.julgamentoProposta.julgamentoPropostasParticipantes')
            ->add(
                'compra-direta',
                'hidden',
                [
                    'data' => $compraDiretaId,
                    'mapped' => false,
                ]
            )
            ->add(
                'dtJulgamento',
                'sonata_type_date_picker',
                [
                    'label' => 'Data do Julgamento',
                    'format' => 'dd/MM/yyyy',
                    'mapped' => false,
                ]
            )
            ->add(
                'hrJulgamento',
                'time',
                [
                    'label' => 'Hora do Julgamento',
                    'mapped' => false,
                    'widget' => 'single_text',
                    'attr' => [
                        'class' => 'hora'
                    ]
                ]
            )
            ->end()
            ->with('label.julgamentoProposta.participante')
            ->add('status', 'choice', $formMapperOptions['status'])
            ->add('observacao', 'textarea', $formMapperOptions['observacao'])
        ;
    }

    /**
     * @param ErrorElement $errorElement
     * @param MapaItem $mapaItem
     */
    public function validate(ErrorElement $errorElement, $mapaItem)
    {
        $formData = $this->getRequest()->request->get($this->getUniqid());
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $cd = $em->getRepository('CoreBundle:Compras\CompraDireta')->findOneBy(
            $this->explodeId($formData['compra-direta'])
        );

        $hasAdjudicacao = $em->getRepository('CoreBundle:Compras\Mapa')
            ->hasAdjudicacao($this->getExercicio(), $cd->getCodMapa()->getCodMapa());
        if($hasAdjudicacao) {
            $errorElement->addViolation('julgamento_proposta.errors.has_Adjudicacao');
        }

        $hasFornecedoresInativos = $em->getRepository('CoreBundle:Compras\Fornecedor')
            ->hasFornecedoresInativos(
                $this->getExercicio(),
                $cd->getCodMapa()->getCodMapa(),
                $mapaItem->getCodItem()->getCodItem(),
                $mapaItem->getLote()
            );
        if($hasFornecedoresInativos) {
            $fornecedoresInativos = $em->getRepository('CoreBundle:Compras\Fornecedor')->getFornecedoresInativos(
                $this->getExercicio(),
                $cd->getCodMapa()->getCodMapa(),
                $mapaItem->getCodItem()->getCodItem(),
                $mapaItem->getLote()
            )[0];
            $errorElement->addViolation(
                'julgamento_proposta.errors.has_fornecedor_inativo',
                "{$fornecedoresInativos['nom_cgm']}"
            );
        }

        $itensEmpatados = [];
        $fornecedores = $em->getRepository('CoreBundle:Compras\Fornecedor')->getFornecedores(
            $this->getExercicio(),
            $cd->getCodMapa()->getCodMapa(),
            $mapaItem->getCodItem()->getCodItem(),
            $mapaItem->getLote()
        );
        /** @var Fornecedor $fornecedor */
        foreach ($fornecedores as $fornecedor) {
            if(3 == $cd->getCodMapa()->getCodTipoLicitacao()->getCodTipoLicitacao()) {
                if (!$fornecedor['lote']) {
                    continue;
                }
            }
            $fornecedoresCompare = $fornecedores;
            foreach ($fornecedoresCompare as $fornecedorCompare) {
                if ($fornecedor['vl_total'] == $fornecedorCompare['vl_total']
                    && $fornecedor['vl_total'] == 0
                    && $fornecedor['status'] == "empatado"
                ) {
                    if(1 == $cd->getCodMapa()->getCodTipoLicitacao()->getCodTipoLicitacao()) {
                        $itensEmpatados[] = $fornecedor['item'];
                    } else {
                        $itensEmpatados[] = $fornecedor['lote'];
                    }
                }
            }
        }

        /** Regra 1.4 */
        $itensEmpatados = array_unique($itensEmpatados);
        if(count($itensEmpatados)) {
            $itemTipo = 'Lote(s)';
            if(1 == $cd->getCodMapa()->getCodTipoLicitacao()->getCodTipoLicitacao()) {
                $itemTipo = 'Item(ns)';
            }
            $errorElement->addViolation(
                'julgamento_proposta.errors.empatados',
                [$itemTipo, implode(',', $itensEmpatados)]
            );
        }

    }

    /**
     * @param MapaItem $mapaItem
     */
    public function preUpdate($mapaItem)
    {
        $formData = $this->getRequest()->request->get($this->getUniqid());
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $cd = $em->getRepository('CoreBundle:Compras\CompraDireta')->findOneBy(
            $this->explodeId($formData['compra-direta'])
        );
        $cotacao = $cd->getCotacao();

        /** Regra 2 */
        $julgamento = $em->getRepository('CoreBundle:Compras\Julgamento')->findOneBy([
            'codCotacao' => $cotacao->getCodCotacao(),
            'exercicio' => $cotacao->getExercicio(),
        ]);
        if(!$julgamento) {
            $julgamento = new Julgamento();
        }
        $julgamento
            ->setCodCotacao($cotacao)
            ->setExercicio($cotacao->getExercicio())
            ->setTimestamp(\DateTime::createFromFormat(
                'd/m/Y h:i',
                "{$formData['dtJulgamento']} {$formData['hrJulgamento']}"
            ))
            ->setObservacao('')
        ;
        $em->persist($julgamento);

        /** Regra 3 */
        $cfids = $em->getRepository('CoreBundle:Compras\CotacaoFornecedorItemDesclassificacao')->findBy([
            'codCotacao' => $cotacao->getCodCotacao(),
            'exercicio' => $cotacao->getExercicio(),
        ]);
        foreach ($cfids as $cfid) {
            $em->remove($cfid);
        }

        /** Rega 4 */
        $julgamentoItens = $em->getRepository('CoreBundle:Compras\JulgamentoItem')->findBy([
            'codCotacao' => $cotacao->getCodCotacao(),
            'exercicio' => $cotacao->getExercicio(),
        ]);
        foreach ($julgamentoItens as $julgamentoItem) {
            $em->remove($julgamentoItem);
        }

        switch($cd->getCodMapa()->getCodTipoLicitacao()->getCodTipoLicitacao()) {
            case 1:
                $fornecedores = $em->getRepository('CoreBundle:Compras\Fornecedor')->getFornecedores(
                    $this->getExercicio(),
                    $cd->getCodMapa()->getCodMapa(),
                    $mapaItem->getCodItem()->getCodItem(),
                    $mapaItem->getLote()
                );
                foreach ($fornecedores as $fornecedor) {
                    if('classificado' == $fornecedor['status']) {
                        $cotacaoFornecedorItem = $em->getRepository('CoreBundle:Compras\CotacaoFornecedorItem')->findOneBy([
                            'exercicio' => $cd->getCotacao()->getExercicio(),
                            'codCotacao' => $cd->getCotacao()->getCodCotacao(),
                            'lote' => $fornecedor['lote'],
                            'codItem' => $mapaItem->getCodItem()->getCodItem(),
                            'cgmFornecedor' => $fornecedor['cgm_fornecedor']
                        ]);
                        $julgamentoItem = new JulgamentoItem();
                        $julgamentoItem
                            ->setFkComprasJulgamentoItem($cotacaoFornecedorItem)
                            ->setCodCotacao($cd->getCotacao()->getCodCotacao())
                            ->setExercicio($cd->getCotacao()->getExercicio())
                            ->setCodItem($mapaItem->getCodItem()->getCodItem())
                            ->setCgmFornecedor($fornecedor['cgm_fornecedor'])
                            ->setOrdem($fornecedor['ordem'])
                            ->setLote($fornecedor['lote'])
                            ->setJustificativa($fornecedor['justificativa']);
                        $em->persist($julgamentoItem);
                    } else {
                        $cfid = new CotacaoFornecedorItemDesclassificacao();
                        $cfid
                            ->setCodCotacao($cd->getCotacao()->getCodCotacao())
                            ->setExercicio($cd->getCotacao()->getExercicio())
                            ->setCodItem($mapaItem->getCodItem()->getCodItem())
                            ->setCgmFornecedor($fornecedor['cgm_fornecedor'])
                            ->setLote($fornecedor['lote'])
                            ->setJustificativa($fornecedor['justificativa']);
                        $em->persist($cfid);
                    }
                }
                break;
            case 2:
            case 3:
                $fornecedores = $em->getRepository('CoreBundle:Compras\Fornecedor')->getFornecedores(
                    $this->getExercicio(),
                    $cd->getCodMapa()->getCodMapa(),
                    $mapaItem->getCodItem()->getCodItem(),
                    $mapaItem->getLote()
                );
                foreach ($fornecedores as $fornecedor) {
                    $cotacaoFornecedoresItens = $em->getRepository('CoreBundle:Compras\CotacaoFornecedorItem')->findBy([
                        'exercicio' => $this->getExercicio(),
                        'codCotacao' => $cd->getCotacao()->getCodCotacao(),
                        'cgmFornecedor' => $fornecedor['cgm_fornecedor'],
                        'lote' => $mapaItem->getLote(),
                    ]);
                    foreach ($cotacaoFornecedoresItens as $cotacaoFornecedorItem) {
                        if('classificado' == $fornecedor['status']) {
                            $cfi = $em->getRepository('CoreBundle:Compras\CotacaoFornecedorItem')->findOneBy([
                                'exercicio' => $cotacaoFornecedorItem->getExercicio(),
                                'codCotacao' => $cotacaoFornecedorItem->getCodCotacao(),
                                'lote' => $cotacaoFornecedorItem->getLote(),
                                'codItem' => $cotacaoFornecedorItem->getCodItem(),
                                'cgmFornecedor' => $cotacaoFornecedorItem->getCgmFornecedor(),
                            ]);
                            $julgamentoItem = new JulgamentoItem();
                            $julgamentoItem->setCodCotacao($cotacaoFornecedorItem->getCodCotacao())
                                ->setExercicio($cotacaoFornecedorItem->getExercicio())
                                ->setCodItem($cotacaoFornecedorItem->getCodItem())
                                ->setCgmFornecedor($cotacaoFornecedorItem->getCgmFornecedor())
                                ->setLote($cotacaoFornecedorItem->getLote())
                                ->setOrdem($fornecedor['ordem'])
                                ->setJustificativa($fornecedor['justificativa'])
                                ->setFkComprasJulgamentoItem($cfi)
                            ;
                            $em->persist($julgamentoItem);
                        } else {
                            $cfid = new CotacaoFornecedorItemDesclassificacao();
                            $cfid->setCodCotacao($cotacaoFornecedorItem->getCodCotacao())
                                ->setExercicio($cotacaoFornecedorItem->getExercicio())
                                ->setCodItem($cotacaoFornecedorItem->getCodItem())
                                ->setCgmFornecedor($cotacaoFornecedorItem->getCgmFornecedor())
                                ->setLote($cotacaoFornecedorItem->getLote())
                                ->setJustificativa($fornecedor['justificativa']);
                            $em->persist($cfid);
                        }
                    }
                }
                break;
        }
    }

    public function postUpdate($object)
    {
        $this->forceRedirect('/patrimonial/compras/julgamento-proposta/list');
    }

    protected function getAssinaturas(CompraDireta $cd)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $qb = $em->getRepository('CoreBundle:Administracao\AssinaturaModulo')
            ->createQueryBuilder('am');
        $subQuery = $qb
            ->select('am.numcgm')
            ->where('am.exercicio = :exercicio')
            ->andWhere('am.codEntidade = :entidade')
            ->andWhere('am.timestamp = (SELECT MAX(am1.timestamp) FROM CoreBundle:Administracao\AssinaturaModulo am1 WHERE am1.exercicio = :exercicio)')
            ->setParameter('exercicio', $this->getExercicio())
            ->setParameter('entidade', $cd->getCodEntidade()->getCodEntidade())
            ->getDQL();

        $qb = $em->getRepository('CoreBundle:Administracao\Assinatura')
            ->createQueryBuilder('a');
        $assinaturas = $qb
            ->select('a')
            ->where('a.exercicio = :exercicio')
            ->andWhere('a.codEntidade = :entidade')
            ->andWhere('a.timestamp = (SELECT MAX(a1.timestamp) FROM CoreBundle:Administracao\Assinatura a1 WHERE a1.exercicio = :exercicio)')
            ->andWhere('a.numcgm IN (' . $subQuery . ')')
            ->setParameter('exercicio', $this->getExercicio())
            ->setParameter('entidade', $cd->getCodEntidade()->getCodEntidade())
            ->getQuery()
            ->getResult();

        return $assinaturas;
    }

    protected function explodeId($id)
    {
        $id = explode('~', $id);
        return [
            'codCompraDireta' => $id[0],
            'codEntidade' => $id[1],
            'exercicioEntidade' => $id[2],
            'codModalidade' => $id[3],
        ];
    }

    protected function getItem($id, EntityManager $em)
    {
        $id = explode('~', $id);
        return $em->getRepository('CoreBundle:Compras\MapaItem')->findOneBy([
            'codMapa' => $id[0],
            'codEntidade' => $id[1],
            'codSolicitacao' => $id[2],
            'codCentro' => $id[3],
            'codItem' => $id[4],
        ]);
    }
}
