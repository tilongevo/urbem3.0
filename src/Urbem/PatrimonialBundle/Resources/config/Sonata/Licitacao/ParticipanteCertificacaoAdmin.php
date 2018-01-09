<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Divida\Modalidade;
use Urbem\CoreBundle\Entity\Licitacao\Licitacao;
use Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacao;
use Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacaoLicitacao;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Exception\Error;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\ParticipanteCertificacaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

/**
 * Class ParticipanteCertificacaoAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao
 */
class ParticipanteCertificacaoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_licitacao_participante_certificacao';
    protected $baseRoutePattern = 'patrimonial/licitacao/participante-certificacao';
    protected $includeJs = [
        '/patrimonial/javascripts/licitacao/participante_certificacao.js',
    ];

    /**
     * @param RouteCollection $collection
     */
    // Retirar após teste
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('perfil', '{id}/perfil', array('_controller' => 'PatrimonialBundle:Licitacao/ParticipanteCertificacao:perfil'), array('id' => $this->getRouterIdParameter()));
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        /** @var ProxyQueryInterface $query */
        $query = parent::createQuery($context);

        if (!$this->getRequest()->query->get('filter')['exercicio']['value']) {
            $query
                ->andWhere("{$query->getRootAliases()[0]}.exercicio = :exercicio")
                ->setParameters(['exercicio' => $this->getExercicio()]);
        }

        return $query;
    }

    /**
     * @param ParticipanteCertificacao $participanteCertificacao
     */
    public function saveRelationships($participanteCertificacao)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());

        $formData = $this->getRequest()->request->get($this->getUniqid());

        $cgmFornecedor = '';
        if (strstr($formData['cgmFornecedor'], '-')) {
            $cgmFornecedor = explode(' - ', $formData['cgmFornecedor']);
            $cgmFornecedor = $cgmFornecedor[0];
        } else {
            $cgmFornecedor = $formData['cgmFornecedor'];
        }

        /** @var SwCgm $fornecedor */
        $fornecedor = $entityManager
            ->getRepository(SwCgm::class)
            ->findOneBy([
                'numcgm' => $cgmFornecedor
            ]);

        $participanteCertificacao->setFkSwCgm($fornecedor);

        if (strstr($formData['licitacao'], '~')) {
            list($codLicitacao, $codModalidade, $codEntidade, $exercicio) = explode('~', $formData['licitacao']);
        } else {
            list($codLicitacao, $exercicio) = explode('/', $formData['licitacao']);
            $codEntidade = $this->getForm()->get('codEntidade')->getData()->getCodEntidade();
            $codModalidade = $this->getForm()->get('modalidade')->getData()->getCodModalidade();
        }

        /** @var Licitacao $licitacao */
        $licitacao = $entityManager
            ->getRepository('CoreBundle:Licitacao\Licitacao')
            ->findOneBy([
                'codLicitacao' => $codLicitacao,
                'codModalidade' => $codModalidade,
                'codEntidade' => $codEntidade,
                'exercicio' => $exercicio
            ]);

        $participanteCertificacaoModel = new ParticipanteCertificacaoModel($entityManager);
        if (!$participanteCertificacao->getNumCertificacao()) {
            $numCertificacao = $participanteCertificacaoModel->getAvailableIdentifier(
                $exercicio,
                $cgmFornecedor
            );
            $participanteCertificacao->setNumCertificacao($numCertificacao);
        }

        $pcLicitacao = new ParticipanteCertificacaoLicitacao();
        $pcLicitacao->setFkLicitacaoLicitacao($licitacao);
        $pcLicitacao->setFkLicitacaoParticipanteCertificacao($participanteCertificacao);

        $participanteCertificacao->addFkLicitacaoParticipanteCertificacaoLicitacoes($pcLicitacao);

        $entityManager->persist($participanteCertificacao);
        $entityManager->flush();
    }

    /**
     * @param ParticipanteCertificacao $participanteCertificacao
     */
    public function prePersist($participanteCertificacao)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $this->saveRelationships($participanteCertificacao);
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_PERSIST_DATA);
            $this->forceRedirect("/patrimonial/licitacao/participante-certificacao/create");
        }
    }

    /**
     * @param ParticipanteCertificacao $participanteCertificacao
     */
    public function postPersist($participanteCertificacao)
    {
        $this->forceRedirect("/patrimonial/licitacao/participante-certificacao/{$this->getObjectKey($participanteCertificacao)}/show");
    }

    /**
     * @param ParticipanteCertificacao $participanteCertificacao
     */
    public function preUpdate($participanteCertificacao)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            /** @var EntityManager $entityManager */
            $entityManager = $this->modelManager
                ->getEntityManager($this->getClass());

            if (!empty($participanteCertificacao->getParticipanteCertificacaoLicitacao())) {
                $entityManager->remove($participanteCertificacao->getParticipanteCertificacaoLicitacao());
                $entityManager->flush();
            }

            $this->saveRelationships($participanteCertificacao);
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_PERSIST_DATA);
            $this->forceRedirect("/patrimonial/licitacao/participante-certificacao/{$this->getAdminRequestId()}/edit");
        }
    }

    /**
     * @param ParticipanteCertificacao $participanteCertificacao
     */
    public function postUpdate($participanteCertificacao)
    {
        $this->forceRedirect("/patrimonial/licitacao/participante-certificacao/{$this->getObjectKey($participanteCertificacao)}/show");
    }


    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        list($numCertificado, $exercicio, $cgmFornecedor) = explode('~', $id);
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        /** @var ParticipanteCertificaca $certificacao */
        $certificacao = $this->getSubject();
        $certificacao->certificacao = $certificacao;
        // Documentos
        $certificacao->documentos = $this->getDoctrine()
            ->getRepository('CoreBundle:Licitacao\CertificacaoDocumentos')
            ->findBy([
                'numCertificacao' => $numCertificado,
                'exercicio' => $exercicio,
                'cgmFornecedor' => $cgmFornecedor
            ]);
        // Penalidades
        $certificacao->penalidades = $this->getDoctrine()
            ->getRepository('CoreBundle:Licitacao\PenalidadesCertificacao')
            ->findBy([
                'numCertificacao' => $numCertificado,
                'exercicio' => $exercicio,
                'cgmFornecedor' => $cgmFornecedor
            ]);
    }
    
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('numCertificacao', null, ['label' => 'label.patrimonial.participante_certificacao.numCertificacao'])
            ->add('exercicio', null, ['label' => 'label.patrimonial.participante_certificacao.exercicio'])
            ->add(
                'cgmFornecedor',
                null,
                [
                    'label' => 'label.patrimonial.participante_certificacao.fornecedor',
                ],
                'autocomplete',
                [
                    'route' => ['name' => 'carrega_sw_cgm_pessoa_juridica'],
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                    'placeholder' => 'Selecione'
                ]
            )
            ->add(
                'dtRegistro',
                'doctrine_orm_callback',
                [
                    'callback' => function ($queryBuilder, $alias, $field, $value) {
                        if (!$value['value']) {
                            return;
                        }

                        $date = $value['value']->format('Y-m-d');

                        $queryBuilder
                            ->andWhere("DATE({$alias}.dtRegistro) = :dtRegistro")
                            ->setParameter('dtRegistro', $date);

                        return true;
                    },
                    'label' => 'label.patrimonial.participante_certificacao.dtRegistro'
                ],
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy',
                ]
            )
            ->add(
                'finalVigencia',
                'doctrine_orm_callback',
                [
                    'callback' => function ($queryBuilder, $alias, $field, $value) {
                        if (!$value['value']) {
                            return;
                        }

                        $date = $value['value']->format('Y-m-d');

                        $queryBuilder
                            ->andWhere("DATE({$alias}.dtRegistro) = :dtRegistro")
                            ->setParameter('dtRegistro', $date);

                        return true;
                    },
                    'label' => 'label.patrimonial.participante_certificacao.finalVigencia'
                ],
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy',
                ]
            );
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $listMapper
            ->add('numCertificacao', null, ['label' => 'label.patrimonial.participante_certificacao.numCertificacao'])
            ->add('exercicio', null, ['label' => 'label.patrimonial.participante_certificacao.exercicio'])
            ->add('fkSwCgm', null, ['label' => 'label.patrimonial.participante_certificacao.fornecedor'])
            ->add('dtRegistro', null, ['label' => 'label.patrimonial.participante_certificacao.dtRegistro'])
            ->add('finalVigencia', null, ['label' => 'label.patrimonial.participante_certificacao.finalVigencia'])
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => ['template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'],
                    'delete' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'),
                )
            ));
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $exercicio = $this->getExercicio();

        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());

        $fieldOptions['codEntidade'] = [
            'class' => 'CoreBundle:Orcamento\Entidade',
            'label' => 'label.patrimonial.participante_certificacao.entidade',
            'mapped' => false,
            'choice_label' => 'fkSwCgm.nomCgm',
            'query_builder' => function ($entityManager) use ($exercicio) {
                return $entityManager
                    ->createQueryBuilder('entidade')
                    ->where('entidade.exercicio = :exercicio')
                    ->setParameter(':exercicio', $exercicio);
            },
            'choice_value' => 'cod_entidade',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione'
        ];

        $fieldOptions['modalidade'] = [
            'class' => 'CoreBundle:Compras\Modalidade',
            'choice_label' => 'descricao',
            'required' => true,
            'mapped' => false,
            'label' => 'label.patrimonial.participante_certificacao.modalidade',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione'
        ];

        $fieldOptions['licitacao'] = [
            'route' => ['name' => 'carrega_licitacao'],
            'req_params' => [
                'codEntidade' => 'varJsCodEntidade',
                'codModalidade' => 'varJsCodModalidade',
            ],
            'required' => true,
            'mapped' => false,
            'label' => 'label.patrimonial.participante_certificacao.licitacao',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'Selecione'
        ];

        $fieldOptions['cgmFornecedor'] = [
            'route' => ['name' => 'carrega_sw_cgm_pessoa_juridica'],
            'required' => true,
            'mapped' => false,
            'label' => 'label.patrimonial.participante_certificacao.fornecedor',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'Selecione'
        ];


        $route = $this->getRequest()->get('_sonata_name');
        if ($this->baseRouteName . "_edit" == $route) {
            list($numCertificado, $exercicio, $cgmFornecedor) = explode('~', $id);
            /** @var ParticipanteCertificacaoLicitacao $pCertificacao */
            $pCertificacao = $this->getSubject()->getParticipanteCertificacaoLicitacao();

            if (!empty($pCertificacao)) {
                $fieldOptions['codEntidade']['data'] = $pCertificacao->getFkLicitacaoLicitacao()->getFkOrcamentoEntidade();
                $fieldOptions['modalidade']['data'] = $pCertificacao->getFkLicitacaoLicitacao()->getFkComprasModalidade();
                $fieldOptions['licitacao']['data'] = $pCertificacao->getFkLicitacaoLicitacao();
            }
            $fieldOptions['cgmFornecedor']['data'] = $this->getSubject()->getFkSwCgm();
        }


        $formMapper
            ->add('exercicio', null, ['label' => 'label.patrimonial.participante_certificacao.exercicio', 'data' => $exercicio])
            ->add(
                'codEntidade',
                'entity',
                $fieldOptions['codEntidade']
            )
            ->add(
                'modalidade',
                'entity',
                $fieldOptions['modalidade']
            )
            ->add(
                'licitacao',
                'autocomplete',
                $fieldOptions['licitacao']
            )
            ->add(
                'cgmFornecedor',
                'autocomplete',
                $fieldOptions['cgmFornecedor']
            )
            ->add(
                'dtRegistro',
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy',
                    'required' => true,
                    'label' => 'Data do Registro'
                ]
            )
            ->add(
                'finalVigencia',
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy',
                    'required' => true,
                    'label' => 'label.patrimonial.participante_certificacao.finalVigencia'
                ]
            )
            ->add('observacao', null, ['label' => 'label.patrimonial.participante_certificacao.observacao']);
    }
}
