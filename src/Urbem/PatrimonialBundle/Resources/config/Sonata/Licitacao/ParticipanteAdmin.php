<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Urbem\CoreBundle\Model\Patrimonial\Compras\JulgamentoItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\ParticipanteModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Compras;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Entity\Licitacao;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\ParticipanteConsorcioModel;

class ParticipanteAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_licitacao_participante';
    protected $baseRoutePattern = 'patrimonial/licitacao/participante';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('exercicio')
            ->add('dtInclusao')
            ->add('renunciaRecurso')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('exercicio')
            ->add('dtInclusao')
            ->add('renunciaRecurso')
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
     * @param Licitacao\Participante $object
     */
    public function preValidate($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $formData = $this->getRequest()->request->get($this->getUniqid());

        if ($formData['edicao'] == 0) {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $codLicitacao = explode("~", $formData['codHLicitacao']);

            $licitacao = $entityManager
                ->getRepository('CoreBundle:Licitacao\Licitacao')
                ->findOneBy(
                    [
                        'codLicitacao' => $codLicitacao[0],
                        'codModalidade' => $codLicitacao[1],
                        'codEntidade' => $codLicitacao[2],
                        'exercicio' => $codLicitacao[3],
                    ]
                );


            $participanteCadastrado = $entityManager
                ->getRepository(Licitacao\Participante::class)
                ->findOneBy([
                    'fkLicitacaoLicitacao' => $licitacao,
                    'cgmFornecedor' =>  $object->getCgmFornecedor(),
                    'numcgmRepresentante' =>  $object->getNumCgmRepresentante()
                ]);

            if (!is_null($participanteCadastrado)) {
                $message = $this->trans('licitacao.errors.participante_cadastrado', [], 'validators');

                $container->get('session')
                    ->getFlashBag()
                    ->add('error', $message);

                (new RedirectResponse($this->request->headers->get('referer')))->send();
            }
        }
    }

    /**
     * @param Licitacao\Participante $object
     */
    public function prePersist($object)
    {
        $object->setFkComprasFornecedor($this->getForm()->get('fkComprasFornecedor')->getData());

        foreach ($object->getFkLicitacaoParticipanteDocumentos() as $partDoc) {
            $partDoc->setFkLicitacaoParticipante($object);
            $this->getParticipanteDocumentosAdmin()->prePersist($partDoc);
        }

        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $formData = $this->getRequest()->request->get($this->getUniqid());
        $codLicitacao = explode("~", $formData['codHLicitacao']);

        $licitacao = $entityManager
            ->getRepository('CoreBundle:Licitacao\Licitacao')
            ->findOneBy(
                [
                    'codLicitacao' => $codLicitacao[0],
                    'codModalidade' => $codLicitacao[1],
                    'codEntidade' => $codLicitacao[2],
                    'exercicio' => $codLicitacao[3],
                ]
            );

        $object->setFkLicitacaoLicitacao($licitacao);

        if ($formData['participacao'] == 'consorcio') {
//            Inserir na tabela Participante Consorcio
            $participanteConsorcio = new ParticipanteConsorcioModel($entityManager);
            $participanteConsorcio->insertParticipanteConsorcio($object);
        }
    }

    /**
     * @param Licitacao\Participante $object
     */
    public function preRemove($object)
    {
        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());

        $participanteDocumentos = $entityManager
            ->getRepository('CoreBundle:Licitacao\ParticipanteDocumentos')
            ->findBy([
                'cgmFornecedor' => $object->getCgmFornecedor(),
                'codLicitacao' => $object->getCodLicitacao()
            ]);

        foreach ($participanteDocumentos as $participante) {
            $entityManager->remove($participante);
            $entityManager->flush();
        }
    }

    /**
     * @param Licitacao\Participante $object
     */
    public function postPersist($object)
    {
        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());

        $formData = $this->getRequest()->request->get($this->getUniqid());
        $codLicitacao = explode("~", $formData['codHLicitacao']);
        $licitacao = $entityManager
            ->getRepository('CoreBundle:Licitacao\Licitacao')
            ->findOneBy(
                [
                    'codLicitacao' => $codLicitacao[0],
                    'codModalidade' => $codLicitacao[1],
                    'codEntidade' => $codLicitacao[2],
                    'exercicio' => $codLicitacao[3],
                ]
            );

        $message = $this->trans('patrimonial.licitacao.licitacaoParticipante.create', [], 'flashes');
        $this->redirect($licitacao, $message, 'success');
    }

    /**
     * @param Licitacao\Participante $object
     */
    public function postRemove($object)
    {
        $message = $this->trans('patrimonial.licitacao.licitacaoParticipante.delete', [], 'flashes');
        $this->redirect($object->getFkLicitacaoLicitacao(), $message, 'success');
    }

    /**
     * @param Licitacao\Licitacao $licitacao
     * @param string $message
     * @param string $type
     */
    public function redirect($licitacao, $message, $type = 'success')
    {
        if ($type != 'success') {
            $this->getConfigurationPool()
                ->getContainer()
                ->get('session')
                ->getFlashBag()
                ->add($type, $this->trans($message));
        }
        $this->forceRedirect("/patrimonial/licitacao/licitacao/" . $this->getObjectKey($licitacao) . "/show");
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);
        $dataEdicao = 0;
        $dataParticipacao = '';

        $formData = $this->getRequest()->request->get($this->getUniqid());
        if (!$this->getRequest()->isMethod('GET')) {
            $ids = $formData['codHLicitacao'];
            $codLicitacao = explode("~", $formData['codHLicitacao']);
        } else {
            $ids = (!is_null($id) ? $id : $this->getRequest()->query->get('param'));
            $codLicitacao = explode('~', $ids);
        }

        /** @var EntityManager $em */
        $em = $this->modelManager
            ->getEntityManager($this->getClass());



        $route = $this->getRequest()->get('_sonata_name');
        if (!is_null($route)) {
            $licitacao = $em
                ->getRepository('CoreBundle:Licitacao\Licitacao')
                ->findOneBy([
                    'codLicitacao' => $codLicitacao[0],
                    'codModalidade' => $codLicitacao[1],
                    'codEntidade' => $codLicitacao[2],
                    'exercicio' => $codLicitacao[3],
                ]);

            $participanteModel = new ParticipanteModel($em);
//            $query = $participanteModel->getPartcipantes($licitacao);
//            $fieldOptions['cgmFornecedor']['query_builder'] = $query;
            $fieldOptions['codHLicitacao']['data'] = $ids;

            if ($licitacao->getFkLicitacaoLicitacaoDocumentos()->count() === 0) {
                $this->redirect($licitacao, 'label.patrimonial.licitacao.faltamDocumentos', 'error');
            }
        }

        if ($this->baseRouteName . "_edit" == $route) {
            $participanteConsorcio = $em
                ->getRepository('CoreBundle:Licitacao\ParticipanteConsorcio')
                ->findOneBy([
                    'codLicitacao' => $this->getSubject()->getCodLicitacao(),
                    'numcgm' => $this->getSubject()->getNumCgmRepresentante()
                ]);

            $codLicitacao =  $this->getObjectKey($licitacao);
            $dataEdicao = 1;
            $dataParticipacao = (is_null($participanteConsorcio) ? 'isolado' : 'consorcio');
        }

        $fieldOptions['codHLicitacao']['mapped'] = false;
        $fieldOptions['cgmFornecedor'] = [
            'attr' => ['class' => 'select2-parameters '],
            'class' => Compras\Fornecedor::class,
            'label' => 'label.patrimonial.licitacao.cgmFornecedor',
            'mapped' => false,
            'placeholder' => $this->trans('label.selecione'),
            'required' => true,
            'route' => ['name' => 'urbem_core_filter_compras_fornecedor_autocomplete']
        ];
        $participacao = ['Consórcio' => 'consorcio', 'Isolado' => 'isolado'];
        $fieldOptions['participacao'] = [
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'mapped' => false,
            'choices' => $participacao,
            'required' => true,
            'data' => $dataParticipacao,
            'label' => 'label.patrimonial.licitacao.comissao'
        ];

        $fieldOptions['numcgmRepresentante'] = [
            'required' => true,
            'label' => 'label.patrimonial.licitacao.numcgmRepresentante',
            'property' => 'nomCgm',
        ];

        $formMapper
            ->add('codHLicitacao', 'hidden', $fieldOptions['codHLicitacao'])
            ->add('edicao', 'hidden', ['data' => $dataEdicao, 'mapped' => false])
            ->add('participacao', 'choice', $fieldOptions['participacao'])
            ->add(
                'fkComprasFornecedor',
                'autocomplete',
                $fieldOptions['cgmFornecedor'],
                ['admin_code' => 'patrimonial.admin.fornecedor']
            )
            ->add(
                'fkSwCgm',
                'sonata_type_model_autocomplete',
                $fieldOptions['numcgmRepresentante'],
                [
                    'admin_code' => 'core.admin.filter.sw_cgm',
                ]
            )
            ->end()
            ->with('label.patrimonial.licitacao.ParticipanteDocumentos')
            ->add(
                'fkLicitacaoParticipanteDocumentos',
                'sonata_type_collection',
                [
                    'label' => false,
                ],
                [
                    'edit' => 'inline',
                    'inline' => 'table',
                    'sortable' => 'position',
                    'link_parameters' => [
                        'param' => $ids
                    ],
                ]
            )
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('exercicio')
            ->add('dtInclusao')
            ->add('renunciaRecurso')
        ;
    }

    /**
     * @return ParticipanteDocumentosAdmin
     */
    private function getParticipanteDocumentosAdmin()
    {
        $admin = $this->getConfigurationPool()
            ->getAdminByAdminCode('patrimonial.admin.participante_documentos');
        $admin->setRequest($this->getRequest());
        $admin->setUniqid($this->getUniqid());
        return $admin;
    }
}
