<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal\Assentamento;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Pessoal\MovSefipSaida;
use Urbem\CoreBundle\Entity\Pessoal\MovSefipSaidaMovSefipRetorno;
use Urbem\CoreBundle\Entity\Pessoal\Sefip;
use Urbem\CoreBundle\Model\Pessoal\Assentamento\MovSefipSaidaMovSefipRetornoModel;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Model\Pessoal\Assentamento\MovSefipRetornoModel;
use Urbem\CoreBundle\Model\Pessoal\Assentamento\MovSefipSaidaCategoriaModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AssentamentoSefipAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_pessoal_assentamento_sefip';

    protected $baseRoutePattern = 'recursos-humanos/pessoal/assentamento/sefip';

    protected $model = Model\Pessoal\Assentamento\AssentamentoSefipModel::class;

    protected $includeJs = [
        '/recursoshumanos/javascripts/pessoal/movimentacaosefip.js'
    ];

    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'DESC',
        '_sort_by' => 'codSefip',
    );

    /**
     * {@inheritdoc}
     */
    protected function addActionsGrid(ListMapper $listMapper)
    {
        $listMapper
            ->add('_action', 'actions', [
                'actions' => [
                    'show' => ['template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'],
                    'delete' => ['template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'],
                ]
            ])
        ;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('numSefip', null, ['label' => 'label.codigoSefip'])
            ->add('descricao', null, ['label' => 'label.descricao'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('numSefip', 'number', ['label' => 'label.codigoSefip', 'sortable' => true])
            ->add('descricao', 'text', ['label' => 'label.descricao', 'sortable' => false])
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
        $disableEdit = false;


        $object = $this->getSubject();

        $movimentacaoSEFIP = 1; // default
        $movimentacaoComRetorno = 2; //default
        $codSefipSaidaobj = '';

        if ($id) {
            $em = $this->modelManager->getEntityManager($this->getClass());
            $disableEdit = true;

            $model = new MovSefipRetornoModel($em);
            $possuiRetorno = $model->consulta($id);

            if (count($possuiRetorno)) {
                // Se for mov SEFIP retorno
                $movimentacaoSEFIP = 2;
            } else {
                // Verificar se possui retorno de um afastamento
                $mov = new MovSefipSaidaMovSefipRetornoModel($em);
                $retornoDaSefip = $mov->getRetornoBySefip($object);
                if (count($retornoDaSefip) > 0) {
                    $movimentacaoComRetorno = 1;
                }
                $codSefipObj = $em->getRepository('CoreBundle:Pessoal\MovSefipSaidaMovSefipRetorno')->findOneByCodSefipSaida($id);
                if ($codSefipObj !== null) {
                    $codSefipSaidaobj = $codSefipObj->getCodSefipRetorno();
                }
            }
        }

        $formMapper
            ->add(
                'numSefip',
                null,
                [
                    'label' => 'label.codigoSefip',
                    'disabled' => $disableEdit,
                ]
            )
            ->add(
                'descricao',
                null,
                [
                    'label' => 'label.descricao'
                ]
            )
            ->add(
                'tipo',
                'choice',
                [
                    'choices' => [
                        'label.afastamento' => 1,
                        'label.retorno' => 2
                    ],
                    'expanded' => true,
                    'multiple' => false,
                    'label' => 'label.movimentacaoSefip',
                    'mapped' => false,
                    'disabled' => $disableEdit,
                    'data' => $movimentacaoSEFIP,
                    'label_attr' => array(
                        'class' => 'checkbox-sonata'
                    ),
                    'attr' => array(
                        'class' => 'checkbox-sonata'
                    )
                ]
            )
            ->add(
                'repetirMensal',
                'choice',
                [
                    'choices' => [
                        'sim' => 1,
                        'nao' => 0,
                    ],
                    'expanded' => true,
                    'multiple' => false,
                    'label' => 'label.repetirMensalmente',
                    'label_attr' => array(
                        'class' => 'checkbox-sonata'
                    ),
                    'attr' => array(
                        'class' => 'checkbox-sonata'
                    )
                ]
            )
            ->add(
                'movimentacaoRetorno',
                'choice',
                [
                    'choices' => [
                        'sim' => 1,
                        'nao' => 2,
                    ],
                    'expanded' => true,
                    'multiple' => false,
                    'label' => 'label.movimentacaoComRetorno',
                    'mapped' => false,
                    'data' => $movimentacaoComRetorno,
                    'label_attr' => array(
                        'class' => 'checkbox-sonata',
                    ),
                    'attr' => array(
                        'class' => 'checkbox-sonata'
                    )
                ]
            )
            ->add(
                'fkPessoalMovSefipRetorno',
                'entity',
                [
                    'class' => 'CoreBundle:Pessoal\Sefip',
                    'label' => 'label.sefipRetorno',
                    'attr' => array(
                        'class' => 'select2-parameters '
                    ),
                    'mapped' => false,
                    'choice_attr' => function ($entidade, $key, $index) use ($codSefipSaidaobj) {
                        if ($index == $codSefipSaidaobj) {
                            return ['selected' => 'selected'];
                        } else {
                            return ['selected' => false];
                        }
                    },
                    'query_builder' => function ($em) {
                        $qb = $em->createQueryBuilder('o');
                        $qb->innerJoin('o.fkPessoalMovSefipRetorno', 'r');
                        return $qb;
                    },
                ]
            )
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);
        $showMapper
            ->add('numSefip', 'number', ['label' => 'label.codigoSefip'])
            ->add('descricao', 'text', ['label' => 'label.descricao'])
        ;
    }

    /**
     * @param $numSefip
     * @param $em
     * @return bool
     */
    protected function checkNumSefipExists($numSefip, $em)
    {
        $checkNumSefip = $em->getRepository('CoreBundle:Pessoal\Sefip')->findOneByNumSefip($numSefip);

        if ($checkNumSefip !== null) {
            $message = $this->trans('rh.pessoal.assentamento.sefip.existNumSefip', [], 'flashes');
            $this->sefipExistsMsg($message);
        } else {
            return true;
        }
    }

    /**
     * @param $message
     */
    protected function sefipExistsMsg($message)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $container->get('session')->getFlashBag()->add('error', $message);
        (new RedirectResponse($this->request->headers->get('referer')))->send();
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $formData = $this->getRequest()->request->get($this->getUniqid());
        $em = $this->modelManager->getEntityManager($this->getClass());

        $tipoRetorno = (int) $this->getForm()->get('tipo')->getData();
        $movSefipRetorno = (int) $formData['fkPessoalMovSefipRetorno'];
        $codSefip = $object->getNumSefip();

        $checkSefip = $this->checkNumSefipExists($codSefip, $em);

        if ($checkSefip) {
            if ($tipoRetorno === 2) {
                $model = new MovSefipSaidaMovSefipRetornoModel($em);
                $model->consulta($movSefipRetorno, true);
            }

            $em->persist($object);

            $sefipSaida = new MovSefipSaida();
            $sefipSaida->setFkPessoalSefip($object);
            $object->setFkPessoalMovSefipSaida($sefipSaida);

            $sefip = $this->getForm()->get('fkPessoalMovSefipRetorno')->getData();
            $movSefipSaidaMovSefipRetorno = new MovSefipSaidaMovSefipRetorno();
            $movSefipSaidaMovSefipRetorno->setFkPessoalMovSefipRetorno($sefip->getFkPessoalMovSefipRetorno());
            $sefipSaida->setFkPessoalMovSefipSaidaMovSefipRetorno($movSefipSaidaMovSefipRetorno);
        }
    }

    /**
     * Consulta ou deleta retorno caso já exista
     */
    private function createSefipRetorno()
    {
        $object = $this->getSubject();

        $em = $this->modelManager->getEntityManager($this->getClass());
        $model = new MovSefipRetornoModel($em);
        $model->consulta($object->getCodSefip(), true);
        $model->insere($object->getCodSefip());
    }

    /**
     * Consulta ou deleta caso já exista
     */
    private function createSefipSaidaDeRetorno()
    {
        $object = $this->getSubject();

        $codSefipRetorno = $this->getForm()->get('fkPessoalMovSefipRetorno')->getData();
        $emSaidaRetorno = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Pessoal\MovSefipSaidaMovSefipRetorno');

        $saidaRetorno = new MovSefipSaidaMovSefipRetornoModel($emSaidaRetorno);
        $saidaRetorno->consulta($object->getCodSefip(), true);
        $saidaRetorno->insere($object->getCodSefip(), $codSefipRetorno->getCodSefip());
    }

    /**
     * @param mixed $object
     */
    public function postPersist($object)
    {
        $formData = $this->getRequest()->request->get($this->getUniqid());
        $tipoRetorno = (int) $this->getForm()->get('tipo')->getData();
        $em = $this->modelManager->getEntityManager($this->getClass());
        $movComRetorno = (int) $this->getForm()->get('movimentacaoRetorno')->getData();

        if ($tipoRetorno === 2) {
            // Apenas retorno
            $this->createSefipRetorno();
        }

        if ($movComRetorno === 2) {
            $saidaRetorno = new MovSefipSaidaMovSefipRetornoModel($em);
            $saidaRetorno->consulta($object->getCodSefip(), true);
        } else {
            $this->createSefipSaidaDeRetorno();
        }
    }

    /**
     * @param Sefip $object
     */
    public function preUpdate($object)
    {
        $formData = $this->getRequest()->request->get($this->getUniqid());
        $tipo = $this->getForm()->get('tipo')->getData();
        $em = $this->modelManager->getEntityManager($this->getClass());

        $movComRetorno = (int) $this->getForm()->get('movimentacaoRetorno')->getData();

        /**
         * Se tipo = afastamento, remove dados da tabela mov_sefip_saida_retorno
         */
        if ($tipo == 1) {
            $model = new MovSefipRetornoModel($em);
            $model->consulta($object->getCodSefip(), true);

            if ($movComRetorno === 2) {
                $saidaRetorno = new MovSefipSaidaMovSefipRetornoModel($em);
                $saidaRetorno->consulta($object->getCodSefip(), true);
            } else {
                $this->createSefipSaidaDeRetorno();
                $model = new MovSefipSaidaCategoriaModel($em);
                $model->consulta($object->getCodSefip(), true);
            }
        } else {
            /**
             * Se tipo = retorno, remove dados da tabela mov_sefip_saida_categoria
             */
            $model = new MovSefipSaidaCategoriaModel($em);
            $model->consulta($object->getCodSefip(), true);

            $model = new MovSefipRetornoModel($em);
            $model->consulta($object->getCodSefip(), true);
            $model->insere($object->getCodSefip());

            if ($movComRetorno === 2) {
                $saidaRetorno = new MovSefipSaidaMovSefipRetornoModel($em);
                $saidaRetorno->consulta($object->getCodSefip(), true);
            }
        }
    }
}
