<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Normas\Norma;
use Urbem\CoreBundle\Entity\Normas\TipoNorma;
use Urbem\CoreBundle\Entity\Pessoal\CasoCausa;
use Urbem\CoreBundle\Entity\Pessoal\CausaRescisao;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidor;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidorCasoCausaNorma;
use Urbem\CoreBundle\Entity\Pessoal\Servidor;
use Urbem\CoreBundle\Model\Pessoal\ContratoServidorCasoCausaModel;
use Urbem\CoreBundle\Resources\config\Sonata\Filter\Pessoal\GeneralFilterAdmin;

class ContratoServidorCasoCausaAdmin extends GeneralFilterAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_pessoal_rescisao';
    protected $baseRoutePattern = 'recursos-humanos/rescisao-contrato';
    protected $includeJs = ['/recursoshumanos/javascripts/pessoal/rescisaocontrato.js'];
    protected $customMessageDelete = "Confirma Excluir Rescisão de Contrato?";
    protected $exibirBotaoIncluir = false;

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['create', 'edit', 'delete','list']);
        $collection->add('caso_causa', 'caso-causa', [], [], [], '', [], ['POST']);
    }

    /**
     * @param ContratoServidor|null $fkPessoalContratoServidor
     * @return null|string
     */
    public function getMatricula(ContratoServidor $fkPessoalContratoServidor = null)
    {
        if ($fkPessoalContratoServidor) {
            return $fkPessoalContratoServidor->getFkPessoalContrato()->getRegistro()
            . " - "
            . $fkPessoalContratoServidor->getFkPessoalServidorContratoServidores()->last()
            ->getFkPessoalServidor()->getFkSwCgmPessoaFisica()->getFkSwCgm()->getNomCgm();
        }
        return null;
    }

    public function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        parent::configureGridFilters($datagridMapper, GeneralFilterAdmin::RECURSOSHUMANOS_PESSOAL_RESCISAO_CONTRATO_SERVIDOR);
    }

    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $filter = $this->getDataGrid()->getValues();

        if (!$value['value']) {
            return;
        }

        // FILTRO POR MATRICULA
        if (isset($filter['codContrato']['value'])) {
            $contratos = $filter['codContrato']['value'];

            $queryBuilder->resetDQLPart('where');
            $queryBuilder->andWhere(
                $queryBuilder->expr()->in('o.codContrato', $contratos)
            );
        }
    }

    public function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codContrato', null, [
                'label' => 'label.codContrato'
            ])
            ->add('fkPessoalContratoServidor', null, [
                'label' => 'label.pessoal.servidor.matriculaSwCgm',
                'admin_code' => 'recursos_humanos.admin.contrato_servidor',
                'associated_property' => function (ContratoServidor $contratoServidor) {
                    $result = null;
                    if ($contratoServidor->getFkPessoalServidorContratoServidores()->count() > 0) {
                        $result = $contratoServidor
                            ->getFkPessoalServidorContratoServidores()
                            ->last()
                            ->getFkPessoalServidor();
                    }
                    return $result;
                }
            ])
            ->add('dtRescisao', null, [
                'label' => 'label.rescisaoContrato.dtRescisao'
            ])
            ->add('fkPessoalCasoCausa', null, [
                'label' => 'label.rescisaoContrato.casoCausa'
            ])
            ->add('_action', 'actions', [
                'actions' => [
                    'delete' => [
                        'template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'
                    ]
                ]
            ]);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $entityManager = $this->getEntityManager();

        $id = $this->getAdminRequestId();
        $this->setBreadCrumb(is_null($id) ? [] : ['id' => $id]);

        $fkPessoalContratoServidor = $entityManager->getRepository(ContratoServidor::class)
        ->findOneByCodContrato($this->getRequest()->query->get('id'));

        $fieldOptions = [];

        $fieldOptions['codContrato'] = [
            'data' => $this->getRequest()->query->get('id'),
            'mapped' => false
        ];

        if (is_null($this->getRequest()->query->get('parent'))) {
            $rotaDeRetorno = 'rescisao-contrato';
        } else {
            $rotaDeRetorno = $this->getRequest()->query->get('parent');
        }

        $fieldOptions['rotaDeRetorno'] = [
            'data' => $rotaDeRetorno,
            'mapped' => false,
        ];

        $fieldOptions['codCasoCausa'] = [
            'mapped' => false
        ];

        $fieldOptions['matricula'] = [
            'label' => 'label.matricula',
            'disabled' => true,
            'mapped' => false,
            'required' => false,
            'data' => $this->getMatricula($fkPessoalContratoServidor)
        ];

        $fieldOptions['codCausaRescisao'] = [
            'label' => 'label.rescisaoContrato.codCasoCausa',
            'mapped' => false,
            'class' => CausaRescisao::class,
            'choice_label' => function ($causaRescisao) {
                return $causaRescisao->getNumCausa() . " - " .
                $causaRescisao->getDescricao();
            },
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('cr')
                ->orderBy('cr.numCausa', 'ASC');
            },
            'placeholder' => 'label.selecione',
            'attr' => [
                'class' => 'select2-parameters'
            ]
        ];

        $fieldOptions['dtRescisao'] = [
            'format' => 'dd/MM/yyyy',
            'label' => 'label.rescisaoContrato.dtRescisao',
        ];

        $fieldOptions['fkPessoalCasoCausa'] = [
            'label' => 'label.rescisaoContrato.codCasoCausa',
            'class' => CasoCausa::class,
        ];

        $fieldOptions['incFolhaSalario'] = [
            'label' => 'label.rescisaoContrato.incFolhaSalario',
            'required' => false,
            'label_attr' => [
                'class' => 'checkbox-sonata'
            ],
            'attr' => [
                'class' => 'checkbox-sonata'
            ],
        ];

        $fieldOptions['incFolhaDecimo'] = [
            'label' => 'label.rescisaoContrato.incFolhaDecimo',
            'required' => false,
            'label_attr' => [
                'class' => 'checkbox-sonata'
            ],
            'attr' => [
                'class' => 'checkbox-sonata'
            ],
        ];

        $eventosCalculado = (new ContratoServidorCasoCausaModel($entityManager))
        ->getEventosCalculados($this->getRequest()->query->get('id'));

        if (count($eventosCalculado) == 0) {
            $fieldOptions['incFolhaDecimo']['disabled'] = true;
        }

        $fieldOptions['codTipoNorma'] = [
            'label' => 'label.rescisaoContrato.codTipoNorma',
            'class' => TipoNorma::class,
            'choice_label' => function ($tipoNorma) {
                return $tipoNorma->getCodTipoNorma() . " - " . $tipoNorma->getNomTipoNorma();
            },
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => false,
        ];

        $fieldOptions['codNorma'] = [
            'label' => 'label.rescisaoContrato.codNorma',
            'class' => Norma::class,
            'req_params' => [
                'codTipoNorma' => 'varJsCodTipoNorma'
            ],
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repo, $term, Request $request) {
                $qb = $repo->createQueryBuilder('n')
                    ->where('LOWER(n.nomNorma) LIKE :nomNorma')
                    ->andWhere('n.codTipoNorma = :codTipoNorma')
                    ->andWhere('n.exercicio = :exercicio')
                    ->setParameter('nomNorma', "%" . strtolower($term) . "%")
                    ->setParameter('codTipoNorma', $request->get('codTipoNorma'))
                    ->setParameter('exercicio', $this->getExercicio())
                ;

                return $qb;
            },
            'mapped' => false,
            'required' => false,
        ];

        $fieldOptions['casoCausa'] = [
            'label' => 'label.rescisaoContrato.casoCausa',
            'attr' => [
                'class' => 'readonly '
            ],
            'mapped' => false,
        ];

        $formMapper
            ->with('label.rescisaoContrato.dadosRescisao')
                ->add('codContrato', 'hidden', $fieldOptions['codContrato'])
                ->add('codCasoCausa', 'hidden', $fieldOptions['codCasoCausa'])
                ->add('matricula', 'text', $fieldOptions['matricula'])
                ->add('dtRescisao', 'sonata_type_date_picker', $fieldOptions['dtRescisao'])
                ->add('codCausaRescisao', 'entity', $fieldOptions['codCausaRescisao'])
                ->add('rotaDeRetorno', 'hidden', $fieldOptions['rotaDeRetorno'])
            ->end()
            ->with('label.rescisaoContrato.incorporarCalculosRescisao')
                ->add('incFolhaSalario', 'checkbox', $fieldOptions['incFolhaSalario'])
                ->add('incFolhaDecimo', 'checkbox', $fieldOptions['incFolhaDecimo'])
            ->end()
            ->with('label.rescisaoContrato.dadosRescisao')
                ->add('casoCausa', 'text', $fieldOptions['casoCausa'])
                ->add('codTipoNorma', 'entity', $fieldOptions['codTipoNorma'])
                ->add('codNorma', 'autocomplete', $fieldOptions['codNorma'])
            ->end()
        ;
    }

    public function prePersist($contratoServidorCasoCausa)
    {
        $entityManager = $this->getEntityManager();

        $fkPessoalContratoServidor = $entityManager->getRepository(ContratoServidor::class)
        ->findOneByCodContrato($this->getForm()->get('codContrato')->getData());

        $contratoServidorCasoCausa->setFkPessoalContratoServidor($fkPessoalContratoServidor);

        $fkNormasNorma = $this->getForm()->get('codNorma')->getData();

        if ($fkNormasNorma) {
            $contratoServidorCasoCausaNorma = new ContratoServidorCasoCausaNorma();
            $contratoServidorCasoCausaNorma->setFkPessoalContratoServidorCasoCausa($contratoServidorCasoCausa);
            $contratoServidorCasoCausaNorma->setFkNormasNorma($fkNormasNorma);

            $contratoServidorCasoCausa->setFkPessoalContratoServidorCasoCausaNorma($contratoServidorCasoCausaNorma);
        }

        $fkPessoalCasoCausa = $entityManager->getRepository(CasoCausa::class)
        ->findOneByCodCasoCausa($this->getForm()->get('codCasoCausa')->getData());

        $contratoServidorCasoCausa->setFkPessoalCasoCausa($fkPessoalCasoCausa);
    }

    public function redirect(Servidor $servidor)
    {
        $rotaDeRetorno = $this->getForm()->get('rotaDeRetorno')->getData();

        if ($rotaDeRetorno == 'rescisao-contrato') {
            $servidor = $servidor->getCodServidor();
            return $this->forceRedirect('/recursos-humanos/pessoal/servidor/' . $servidor .'/show');
        } else {
            $servidor = $servidor->getCodServidor();
            return $this->redirectByRoute('urbem_recursos_humanos_pessoal_rescisao_contrato_servidor_list');
        }
    }

    /**
     * {@inheritDoc}
     */
    public function postPersist($contratoServidorCasoCausa)
    {
        $servidor = $contratoServidorCasoCausa
                            ->getFkPessoalContratoServidor()
                            ->getFkPessoalServidorContratoServidores()
                            ->last()
                            ->getFkPessoalServidor();

        $this->redirect($servidor);
    }

    /**
     * {@inheritDoc}
     */
    public function postRemove($contratoServidorCasoCausa)
    {
        $servidor = $contratoServidorCasoCausa
                                ->getFkPessoalContratoServidor()
                                ->getFkPessoalServidorContratoServidores()
                                ->last()
                                ->getFkPessoalServidor();

        $this->redirect($servidor);
    }
}
