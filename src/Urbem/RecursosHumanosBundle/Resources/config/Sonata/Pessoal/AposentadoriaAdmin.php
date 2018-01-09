<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Faker\Provider\DateTime;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Normas\Norma;
use Urbem\CoreBundle\Entity\Pessoal;
use Urbem\CoreBundle\Entity\Pessoal\Contrato;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Model\Pessoal\ContratoServidorModel;
use Urbem\CoreBundle\Model\Pessoal\ServidorModel;
use Urbem\CoreBundle\Model\Pessoal\AposentadoriaModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\RecursosHumanosBundle\Helper\Constants\Pessoal\ContratoServidor;

class AposentadoriaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_pessoal_aposentadoria';

    protected $baseRoutePattern = 'recursos-humanos/pessoal/aposentadoria';
    protected $exibirBotaoEditar = true;
    protected $exibirMensagemFiltro = true;

    protected $includeJs = [
        '/recursoshumanos/javascripts/pessoal/aposentadoria.js'
    ];


    /**
     * @param ErrorElement          $errorElement
     * @param Pessoal\Aposentadoria $aposentadoria
     */
    public function validate(ErrorElement $errorElement, $aposentadoria)
    {
        $percent = (float) (str_replace(',', '.', $aposentadoria->getPercentual()));
        if ($percent > 100) {
            $message = $this->trans('rh.pessoal.aposentadoria.errors.percentual', [], 'validators');
            $errorElement->with('percentual')->addViolation($message)->end();
        }
    }

    /**
     * @param string $context
     *
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $aposentadoriaModel = new AposentadoriaModel($entityManager);

        $query = parent::createQuery($context);
        $aposentadorias = $aposentadoriaModel->getMaxAposentadorias();

        /** @var Pessoal\Aposentadoria $aposentadoria */
        foreach ($aposentadorias as $aposentadoria) {
            $timestamps[] = $aposentadoria->timestamp;
        }

        $query->andWhere($query->expr()->in("o.timestamp", $timestamps));

        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'fkPessoalContratoServidor',
                'doctrine_orm_callback',
                array(
                    'label' => 'Servidor',
                    'callback' => array($this, 'getMatriculaFilter')
                ),
                'autocomplete',
                array(
                    'class' => Pessoal\Aposentadoria::class,
                    'route' => array(
                        'name' => 'pessoal_aposentadoria_consulta_servidor'
                    ),
                    'json_choice_label' => function ($aposentadoria) {
                        return $aposentadoria->getFkPessoalContratoServidor()->getFkPessoalServidorContratoServidores()->last()->getFkPessoalServidor()->getFkSwCgmPessoaFisica();
                    },
                    'mapped' => true,
                ),
                [
                    'admin_code' => 'recursos_humanos.admin.contrato_servidor'
                ]
            );
    }

    public function getMatriculaFilter($queryBuilder, $alias, $field, $value)
    {
        $filter = $this->getDataGrid()->getValues();

        if (!$value['value']) {
            return;
        }
        list($codContrato, $timestamp) = explode("~", $filter['fkPessoalContratoServidor']['value']);

        $queryBuilder->andWhere("o.codContrato = $codContrato");
        $queryBuilder->andWhere("o.timestamp = '" . $timestamp . "'");

        return true;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add(
                'codContrato',
                null,
                [
                    'label' => 'label.matricula',
                ]
            )
            ->add(
                'nomCgm',
                'customField',
                [
                    'label' => 'Servidor',
                    'mapped' => false,
                    'template' => 'RecursosHumanosBundle:Pessoal\Contrato:contratoServidor.html.twig',
                ]
            )
            ->add(
                'dtConcessao',
                'date',
                [
                    'label' => 'label.aposentadoria.dtConcessao'
                ]
            )
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                    'edit' => array('template' => 'RecursosHumanosBundle:Sonata/Pessoal/Aposentadoria/CRUD:edit.html.twig'),
                    'delete' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'),
                )
            ));
    }


    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {

        $dtPublicacao = $dtConcessao = $dtRequirimento = new \DateTime();
        $motivoEncerramento = '';
        $disabled = true;
        $rota = $dtEncerramento = $codClassificacao = $timestamp = $codContrato = $contratoGravado = null;

        /** @var Pessoal\Aposentadoria $aposentadoria */
        $aposentadoria = $this->getSubject();
        $id = $this->getAdminRequestId();
        $modelManager = $this->modelManager;
        /** @var EntityManager $entityManager */
        $entityManager = $modelManager->getEntityManager($this->getClass());

        $now = new \DateTime();

        $codEnquadramento = '';

        if (!$this->getRequest()->isMethod('GET')) {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $codContrato = $formData['codContrato'];
            $timestamp = $formData['timestampx'];

            if ($codContrato != '' && $timestamp != '') {
                $aposentadoria = $entityManager->getRepository(Pessoal\Aposentadoria::class)->findOneBy(['codContrato' => $codContrato, 'timestamp' => $timestamp]);
                if (!is_null($aposentadoria->getFkPessoalAposentadoriaEncerramento())) {
                    $dtEncerramento = $aposentadoria->getFkPessoalAposentadoriaEncerramento()->getDtEncerramento();
                    $motivoEncerramento = $aposentadoria->getFkPessoalAposentadoriaEncerramento()->getMotivo();
                }
                $codClassificacao = $aposentadoria->getFkPessoalClassificacaoEnquadramento()->getFkPessoalClassificacao();
                $dtConcessao = $aposentadoria->getDtConcessao();
                $dtPublicacao = $aposentadoria->getDtPublicacao();
                $dtRequirimento = $aposentadoria->getDtRequirimento();
            }
        }
        if (null != $id) {
            $disabled = false;
            list($codContrato, $timestamp) = explode('~', $id);
            /** @var Pessoal\Aposentadoria $aposentadoria */
            $aposentadoria = $entityManager->getRepository(Pessoal\Aposentadoria::class)->findOneBy(['codContrato' => $codContrato, 'timestamp' => $timestamp]);

            if (!is_null($aposentadoria->getFkPessoalAposentadoriaEncerramento())) {
                $dtEncerramento = $aposentadoria->getFkPessoalAposentadoriaEncerramento()->getDtEncerramento();
                $motivoEncerramento = $aposentadoria->getFkPessoalAposentadoriaEncerramento()->getMotivo();
            }
            $codClassificacao = $aposentadoria->getFkPessoalClassificacaoEnquadramento()->getFkPessoalClassificacao();
            $dtConcessao = $aposentadoria->getDtConcessao();
            $dtPublicacao = $aposentadoria->getDtPublicacao();
            $dtRequirimento = $aposentadoria->getDtRequirimento();

            $rota = 'urbem_recursos_humanos_pessoal_aposentadoria_edit';
            $codEnquadramento = $codClassificacao->getFkPessoalClassificacaoEnquadramentos()->last()->getCodEnquadramento();
        }

        $this->setBreadCrumb($id ? ['id' => $id] : [], $rota);

        $formOptions['codClassificacao'] = [
            'class' => 'CoreBundle:Pessoal\Classificacao',
            'query_builder' => function ($classificacao) {
                return $classificacao->createQueryBuilder('c')
                    ->orderBy('c.descricao', 'ASC');
            },
            'label' => 'label.aposentadoria.classificacao',
            'attr' => [
                'class' => 'select2-parameters rh-cod-classificacao'
            ],
            'placeholder' => 'label.selecione',
            'choice_value' => 'codClassificacao',
            'choice_label' => 'nomeClassificacao',
            'choice_attr' => function (Pessoal\Classificacao $classificacao, $key, $index) use ($codClassificacao) {
                if (!empty($codClassificacao)) {
                    if ($classificacao->getCodClassificacao() == $codClassificacao->getCodClassificacao()) {
                        return ['selected' => 'selected'];
                    }
                }

                return ['selected' => false];
            }
        ];

        $fieldOptions['fkPessoalClassificacaoEnquadramento'] = [
            'choices' => $this->preSetPostToChoice('fkPessoalClassificacaoEnquadramento', []),
            'label' => 'label.aposentadoria.enquadramento',
            'attr' => [
                'class' => 'select2-parameters',
            ],
            'mapped' => false,
        ];

        $fieldOptions['fkPessoalContratoServidor'] = [
            'label' => 'label.cgmmatricula',
            'class' => Contrato::class,
            'route' => [
                'name' => 'carrega_contrato_aposentadoria'
            ],
            'multiple' => false,
            'json_choice_label' => function ($contrato) use ($entityManager) {
                if (!is_null($contrato->getFkPessoalContratoServidor())) {
                    $nomcgm = $contrato->getFkPessoalContratoServidor()
                        ->getFkPessoalServidorContratoServidores()->last()
                        ->getFkPessoalServidor()
                        ->getFkSwCgmPessoaFisica()
                        ->getFkSwCgm()
                        ->getNomcgm();
                } else {
                    $nomcgm = "Não localizado";
                }

                return $nomcgm;
            },
            'attr' => ['class' => 'select2-parameters '],
            'mapped' => false,
            'required' => true
        ];

        $tipo = 'autocomplete';

        if (null != $id) {
            list($contrato, $timestamp) = explode('~', $id);
            $tipo = 'entity';
            $fieldOptions['fkPessoalContratoServidor'] = [
                'label' => 'label.matricula',
                'multiple' => false,
                'attr' => ['class' => 'select2-parameters '],
                'class' => Pessoal\ContratoServidor::class,
                'required' => true,
                'choice_label' => function ($fkPessoalContratoServidor) {
                    return $fkPessoalContratoServidor->getFkPessoalServidorContratoServidores()->last()->getFkPessoalServidor()->getFkSwCgmPessoaFisica()->getFkSwCgm();
                },
                'query_builder' => function (\Doctrine\ORM\EntityRepository $repository) use ($contrato, $entityManager) {
                    return $repository->createQueryBuilder('u')->where("u.codContrato = $contrato");
                },
                'mapped' => false
            ];
        }

        $formMapper
            ->with('label.aposentadoria.modulo')
            ->add('codContrato', 'hidden', ['mapped' => false, 'data' => $codContrato])
            ->add('timestampx', 'hidden', ['mapped' => false, 'data' => $timestamp])
            ->add(
                'pessoalContratoServidor',
                $tipo,
                $fieldOptions['fkPessoalContratoServidor']
            )
            ->add('codEnquadramento', 'hidden', ['data' => $codEnquadramento])
            ->add(
                'dtRequirimento',
                'sonata_type_date_picker',
                [
                    'dp_default_date' => $now->format('d/m/Y'),
                    'format' => 'dd/MM/yyyy',
                    'data' => $dtRequirimento,
                    'label' => 'label.aposentadoria.dtRequerimento'
                ]
            )
            ->add(
                'numProcessoTce',
                null,
                [
                    'label' => 'label.aposentadoria.numProcessoTce',
                    'data' => (is_null($aposentadoria) ? '' : $aposentadoria->getNumProcessoTce()),
                ]
            )
            ->add(
                'dtConcessao',
                'sonata_type_date_picker',
                [
                    'dp_default_date' => $now->format('d/m/Y'),
                    'format' => 'dd/MM/yyyy',
                    'data' => $dtConcessao,
                    'label' => 'label.aposentadoria.dtConcessao'

                ]
            )
            ->add(
                'codClassificacao',
                'entity',
                $formOptions['codClassificacao']
            )
            ->add(
                'fkPessoalClassificacaoEnquadramento',
                'choice',
                $fieldOptions['fkPessoalClassificacaoEnquadramento']
            )
            ->add(
                'reajuste',
                'text',
                [
                    'required' => false,
                    'label' => 'label.aposentadoria.reajuste',
                    'attr' => [
                        'readonly' => true
                    ],
                    'mapped' => false
                ]
            )
            ->add(
                'percentual',
                'text',
                [
                    'label' => 'label.aposentadoria.percentual',
                    'attr' => [
                        'class' => 'percent ',
                        'maxlength' => '6'
                    ],
                    'data' => (is_null($aposentadoria) ? '' : $aposentadoria->getPercentual()),
                ]
            )
            ->add(
                'dtPublicacao',
                'sonata_type_date_picker',
                [
                    'dp_default_date' => $now->format('d/m/Y'),
                    'format' => 'dd/MM/yyyy',
                    'data' => $dtPublicacao,
                    'label' => 'label.dtPublicacao'
                ]
            )
            ->add(
                'dtEncerramento',
                'sonata_type_date_picker',
                [
                    'mapped' => false,
                    'format' => 'dd/MM/yyyy',
                    'label' => 'label.aposentadoria.dtEncerramento',
                    'required' => false,
                    'data' => $dtEncerramento,
                    'disabled' => $disabled
                ]
            )
            ->add(
                'motivoEncerramento',
                'textarea',
                [
                    'mapped' => false,
                    'label' => 'label.aposentadoria.motivo',
                    'required' => false,
                    'data' => $motivoEncerramento,
                    'disabled' => $disabled
                ]
            );
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);
        $showMapper
            ->with('label.aposentadoria.modulo')
            ->add('fkPessoalContratoServidor.fkPessoalServidorContratoServidores', null, ['label' => 'label.matricula'])
            ->add('dtRequirimento', null, ['label' => 'label.aposentadoria.dtRequerimento'])
            ->add('dtConcessao', null, ['label' => 'label.aposentadoria.dtConcessao'])
            ->add('numProcessoTce', null, ['label' => 'label.aposentadoria.numProcessoTce'])
            ->add('fkPessoalClassificacaoEnquadramento.fkPessoalClassificacao', null, ['label' => 'label.aposentadoria.classificacao'])
            ->add('fkPessoalClassificacaoEnquadramento.fkPessoalEnquadramento.descricao', null, ['label' => 'label.aposentadoria.enquadramento'])
            ->add('fkPessoalClassificacaoEnquadramento.fkPessoalEnquadramento.descricao.reajuste', null, ['label' => 'Tipo de Reajuste'])
            ->add('percentual', null, ['label' => 'label.aposentadoria.percentual'])
            ->add('dtPublicacao', null, ['label' => 'label.dtPublicacao'])
            ->add('fkPessoalAposentadoriaEncerramento.dtEncerramento', null, ['label' => 'label.aposentadoria.dtEncerramento'])
            ->add('fkPessoalAposentadoriaEncerramento.motivo', null, ['label' => 'label.aposentadoria.motivo']);
    }

    /**
     * @param Pessoal\Aposentadoria $aposentadoria
     */
    public function prePersist($aposentadoria)
    {
        $aposentadoria->setTimestamp(new DateTimeMicrosecondPK());
        $codContrato = $this->getForm()->get('pessoalContratoServidor')->getData();
        $aposentadoria->setCodContrato($codContrato->getCodContrato());
        $this->saveRelationships($aposentadoria);
    }

    /**
     * @param Pessoal\Aposentadoria $aposentadoria
     */
    public function postPersist($aposentadoria)
    {

        $formData = $this->getRequest()->request->get($this->getUniqid());

        if ((isset($formData['dtEncerramento']) && (!empty($formData['dtEncerramento']))) && (isset($formData['motivoEncerramento']) && (!empty($formData['motivoEncerramento'])))) {
            $getDtEncerramento = $formData['dtEncerramento'];
            $dateExplode = explode('/', $getDtEncerramento);
            $dtEncerramento = new \DateTime($dateExplode[2] . '-' . $dateExplode[1] . '-' . $dateExplode[0]);
            $motivoEncerramento = $formData['motivoEncerramento'];
            if ($dtEncerramento != '' && $motivoEncerramento != '') {
                $em = $this->modelManager->getEntityManager($this->getClass());
                $aposentadoriaModel = new AposentadoriaModel($em);
                /** @var Pessoal\AposentadoriaEncerramento $aposentadoriaEncerramento */
                $aposentadoriaEncerramento = new Pessoal\AposentadoriaEncerramento();
                $aposentadoriaEncerramento->setFkPessoalAposentadoria($aposentadoria);
                $aposentadoriaEncerramento->setDtEncerramento($dtEncerramento);
                $aposentadoriaEncerramento->setMotivo($motivoEncerramento);
                $aposentadoria->setFkPessoalAposentadoriaEncerramento($aposentadoriaEncerramento);
                $aposentadoriaModel->save($aposentadoriaEncerramento);
            }
        }
    }

    /**
     * @param Pessoal\Aposentadoria $aposentadoria
     */
    public function preRemove($aposentadoria)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        /** @var AposentadoriaModel $aposentadoriaModel */
        $aposentadoriaModel = new AposentadoriaModel($em);

        /** @var Pessoal\AposentadoriaExcluida $aposentadoriaEcluida */
        $aposentadoriaExcluida = new Pessoal\AposentadoriaExcluida();
        $aposentadoriaExcluida->setFkPessoalAposentadoria($aposentadoria);

        /** @var ContratoServidorModel $contratoServidorModel */
        $contratoServidorModel = new ContratoServidorModel($em);
        $contratoServidor = $contratoServidorModel->findOneByCodContrato($aposentadoria->getCodContrato());

        $contratoServidor->setAtivo(true);

        $em->persist($aposentadoriaExcluida);
        $em->persist($contratoServidor);

        $em->flush();

        $message = $this->trans('rh.pessoal.aposentadoria.delete', [], 'flashes');
        $container = $this->getConfigurationPool()->getContainer();
        $container->get('session')->getFlashBag()->add('success', $message);
        $this->modelManager->getEntityManager($this->getClass())->clear();
        (new RedirectResponse("/recursos-humanos/pessoal/aposentadoria/list"))->send();
    }

    /**
     * @param $aposentadoria
     */
    public function saveRelationships($aposentadoria)
    {
        /** @var Pessoal\Aposentadoria $aposentadoria */
        $aposentadoria = $aposentadoria;
        $percent = (float) (str_replace(',', '.', $aposentadoria->getPercentual()));
        $aposentadoria->setPercentual($percent);
        $codEnquad = $this->getForm()->get('fkPessoalClassificacaoEnquadramento')->getData();
        $codClassificacao = $this->getForm()->get('codClassificacao')->getData();

        $em = $this->modelManager->getEntityManager($this->getClass());

        $classificacaoEnquadramento = $em->getRepository('CoreBundle:Pessoal\ClassificacaoEnquadramento')->findOneByCodClassificacao(
            $codClassificacao
        );

        $aposentadoria->setCodClassificacao($classificacaoEnquadramento->getCodClassificacao());
        $aposentadoria->setCodEnquadramento($codEnquad);
    }

    /**
     * @param Pessoal\Aposentadoria $aposentadoria
     */
    public function preUpdate($aposentadoria)
    {
        $this->saveRelationships($aposentadoria);
    }

    /**
     * @param Pessoal\Aposentadoria $aposentadoria
     */
    public function postUpdate($aposentadoria)
    {
        $this->postPersist($aposentadoria);
    }

    /**
     * @param Pessoal\Aposentadoria $aposentadoria
     *
     * @return string
     */
    public function getServidor($aposentadoria)
    {
        if (is_null($aposentadoria)) {
            return '';
        }

        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $contratoServidor = (new ContratoServidorModel($entityManager))->findOneByCodContrato($aposentadoria->getFkPessoalContratoServidor()->getCodContrato());

        if (is_null($aposentadoria->getFkPessoalContratoServidor())) {
            return '';
        }

        return $aposentadoria->getFkPessoalContratoServidor()->getFkPessoalServidorContratoServidores()->last()
                ->getFkPessoalServidor()->getFkSwCgmPessoaFisica()->getFkSwCgm()->getNumcgm()
            . " - "
            . $aposentadoria->getFkPessoalContratoServidor()->getFkPessoalServidorContratoServidores()->last()
                ->getFkPessoalServidor()->getFkSwCgmPessoaFisica()->getFkSwCgm()->getNomcgm();
    }
}
