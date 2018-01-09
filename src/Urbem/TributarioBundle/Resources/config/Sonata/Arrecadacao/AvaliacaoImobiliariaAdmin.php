<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Arrecadacao;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Imobiliario\Proprietario;
use Urbem\CoreBundle\Entity\Arrecadacao\ImovelVVenal;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\Imobiliario\TransferenciaImovel;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Urbem\CoreBundle\Model\Arrecadacao\AvaliacaoImobiliariaModel;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;

class AvaliacaoImobiliariaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_arrecadacao_movimentacoes_avaliacao_imobiliaria';
    protected $baseRoutePattern = 'tributario/arrecadacao/movimentacoes/avaliacao-imobiliaria';
    protected $includeJs = array(
        '/administrativo/javascripts/administracao/atributo-dinamico-component.js',
        '/tributario/javascripts/arrecadacao/movimentacoes.js'
    );
    protected $exibirBotaoIncluir = false;

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $qb = parent::createQuery($context);

        $qb->innerJoin(SwCgm::class, 'cg', 'WITH', 'o.numcgm = cg.numcgm');
        $qb->orderBy('o.inscricaoMunicipal');

        return $qb;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'fkSwCgm',
                'doctrine_orm_model_autocomplete',
                [
                    'label' => 'label.arrecadacaoImovelVVenal.contribuinte'
                ],
                'sonata_type_model_autocomplete',
                [
                    'attr' => ['class' => 'select2-parameters '],
                    'callback' => function (AbstractSonataAdmin $admin, $property, $value) {
                        $datagrid = $admin->getDatagrid();
                        /** @var QueryBuilder|ProxyQueryInterface $query */
                        $query = $datagrid->getQuery();

                        $rootAlias = $query->getRootAlias();

                        $query->join(SwCgm::class, "cg", "WITH", "{$rootAlias}.numcgm = cg.numcgm");

                        $query->where("LOWER({$rootAlias}.nomCgm) LIKE :nomCgm");
                        $query->setParameter('nomCgm', sprintf('%%%s%%', strtolower($value)));

                        $datagrid->setValue($property, 'LIKE', $value);
                    },
                    'property' => 'nomCgm'
                ],
                [
                    'admin_code' => 'core.admin.filter.sw_cgm',
                ]
            )
            ->add('inscricaoMunicipal', null, ['label' => 'label.imobiliarioTransferenciaPropriedade.inscricaoImobiliaria'])
            ->add(
                'fkImobiliarioImovel.fkImobiliarioImovelLotes.fkImobiliarioLote.fkImobiliarioLoteLocalizacao.fkImobiliarioLocalizacao',
                null,
                array(
                    'label' => 'label.imobiliarioImovel.localizacao'
                )
            )
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();
        $listMapper
            ->add('inscricaoMunicipal', null, ['label' => 'label.imobiliarioTransferenciaPropriedade.inscricaoImobiliaria'])
            ->add(
                'fkSwCgm',
                null,
                [
                    'label' => 'label.imobiliarioImovel.proprietario'
                ]
            )
            ->add('_action', 'actions', [
                'actions' => [
                    'edit'       => ['template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'],
                ]
            ])
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $em = $this->modelManager->getEntityManager($this->getClass());

        $proprietario = $this->getSubject();

        $fieldOptions['inscricaoImob'] = [
            'mapped' => false,
            'label' => 'label.imobiliarioImovel.inscricaoImobiliaria',
            'data' => null,
            'attr' => [
                'disabled' => true,
                'class' => 'js-inscricao-imob '
            ]
        ];

        $fieldOptions['proprietarios'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::Arrecadacao/Movimentacoes/AvaliacaoImobiliaria/proprietarios.html.twig',
            'data' => [
                'proprietarios' => [],
            ]
        ];

        $fieldOptions['fkImobiliarioImovel.fkArrecadacaoImovelVVenais.venalTerritorialInformado'] = [
            'label' => 'label.arrecadacaoImovelVVenal.informado',
            'mapped' => false,
            'required' => false,
            'currency' => 'BRL',
            'attr' => array(
                'class' => 'money js-venal-territorial '
            ),
        ];

        $fieldOptions['fkImobiliarioImovel.fkArrecadacaoImovelVVenais.venalTerritorialCalculado'] = [
            'label' => 'label.arrecadacaoImovelVVenal.calculado',
            'mapped' => false,
            'required' => false,
            'currency' => 'BRL',
            'attr' => [
                'disabled' => true
            ]
        ];

        $fieldOptions['fkImobiliarioImovel.fkArrecadacaoImovelVVenais.venalPredialInformado'] = [
            'label' => 'label.arrecadacaoImovelVVenal.informado',
            'mapped' => false,
            'required' => false,
            'currency' => 'BRL',
            'attr' => array(
                'class' => 'money js-venal-predial '
            ),
        ];

        $fieldOptions['fkImobiliarioImovel.fkArrecadacaoImovelVVenais.venalPredialCalculado'] = [
            'label' => 'label.arrecadacaoImovelVVenal.calculado',
            'mapped' => false,
            'required' => false,
            'currency' => 'BRL',
            'attr' => [
                'disabled' => true
            ]
        ];

        $fieldOptions['fkImobiliarioImovel.fkArrecadacaoImovelVVenais.venalTotalInformado'] = [
            'label' => 'label.arrecadacaoImovelVVenal.informado',
            'mapped' => false,
            'required' => false,
            'currency' => 'BRL',
            'attr' => [
                'class' => 'money js-venal-total ',
                'disabled' => true
            ]
        ];

        $fieldOptions['fkImobiliarioImovel.fkArrecadacaoImovelVVenais.venalTotalCalculado'] = [
            'label' => 'label.arrecadacaoImovelVVenal.calculado',
            'mapped' => false,
            'required' => false,
            'currency' => 'BRL',
            'attr' => [
                'class' => 'money ',
                'disabled' => true
            ]
        ];

        $fieldOptions['fkImobiliarioImovel.fkArrecadacaoImovelVVenais.exercicio'] = [
            'label' => 'label.arrecadacaoImovelVVenal.exercicio',
            'mapped' => false,
            'required' => false,
            'data' => $this->getExercicio(),
        ];

        $fieldOptions['fkImobiliarioImovel.fkArrecadacaoImovelVVenais.valorFinanciado'] = [
            'label' => 'label.arrecadacaoImovelVVenal.valorFinanciado',
            'mapped' => false,
            'required' => false,
            'currency' => 'BRL',
            'attr' => [
                'class' => 'money js-valor-financiado '
            ]
        ];

        $fieldOptions['atributosDinamicos'] = [
            'mapped' => false,
            'required' => false
        ];

        if ($id) {
            $fieldOptions['inscricaoImob']['data'] = $proprietario->getInscricaoMunicipal();

            $proprietarios = $em->getRepository(Proprietario::class)->findBy(
                [
                    'inscricaoMunicipal' => $proprietario->getInscricaoMunicipal()
                ]
            );

            if ($proprietarios) {
                $fieldOptions['proprietarios']['data']['proprietarios'] = $proprietarios;
            }

            $imovelVVenal = $em->getRepository(ImovelVVenal::class)->findBy(
                [
                    'inscricaoMunicipal' => $proprietario->getInscricaoMunicipal(),
                    'exercicio' => $this->getExercicio()
                ],
                [
                    'timestamp' => 'DESC'
                ]
            );

            if ($imovelVVenal) {
                $fieldOptions['fkImobiliarioImovel.fkArrecadacaoImovelVVenais.venalTerritorialInformado']['data'] = (int) $imovelVVenal[0]->getVenalTerritorialInformado();
                $fieldOptions['fkImobiliarioImovel.fkArrecadacaoImovelVVenais.venalPredialInformado']['data'] = (int) $imovelVVenal[0]->getVenalPredialInformado();
                $fieldOptions['fkImobiliarioImovel.fkArrecadacaoImovelVVenais.venalTotalInformado']['data'] = (int) $imovelVVenal[0]->getVenalTotalInformado();
                $fieldOptions['fkImobiliarioImovel.fkArrecadacaoImovelVVenais.venalTerritorialCalculado']['data'] = (int) $imovelVVenal[0]->getVenalTerritorialCalculado();
                $fieldOptions['fkImobiliarioImovel.fkArrecadacaoImovelVVenais.venalPredialCalculado']['data'] = (int) $imovelVVenal[0]->getVenalPredialCalculado();
                $fieldOptions['fkImobiliarioImovel.fkArrecadacaoImovelVVenais.venalTotalCalculado']['data'] = (int) $imovelVVenal[0]->getVenalTotalCalculado();
            }

            $fieldOptions['atributosDinamicos'] = array(
                'mapped' => false,
                'required' => false,
            );
        }

        $formMapper
            ->with('label.arrecadacaoImovelVVenal.dados')
                ->add(
                    'inscricaoImob',
                    'text',
                    $fieldOptions['inscricaoImob']
                )
            ->end()
            ->with('label.arrecadacaoImovelVVenal.listaProprietarios')
                ->add('proprietarios', 'customField', $fieldOptions['proprietarios'])
            ->end()
            ->with('label.arrecadacaoImovelVVenal.valorVenalTerritorial')
                ->add(
                    'fkImobiliarioImovel.fkArrecadacaoImovelVVenais.venalTerritorialInformado',
                    'money',
                    $fieldOptions['fkImobiliarioImovel.fkArrecadacaoImovelVVenais.venalTerritorialInformado']
                )
                ->add(
                    'fkImobiliarioImovel.fkArrecadacaoImovelVVenais.venalTerritorialCalculado',
                    'money',
                    $fieldOptions['fkImobiliarioImovel.fkArrecadacaoImovelVVenais.venalTerritorialCalculado']
                )
            ->end()
            ->with('label.arrecadacaoImovelVVenal.valorVenalPredial')
                ->add(
                    'fkImobiliarioImovel.fkArrecadacaoImovelVVenais.venalPredialInformado',
                    'money',
                    $fieldOptions['fkImobiliarioImovel.fkArrecadacaoImovelVVenais.venalPredialInformado']
                )
                ->add(
                    'fkImobiliarioImovel.fkArrecadacaoImovelVVenais.venalPredialCalculado',
                    'money',
                    $fieldOptions['fkImobiliarioImovel.fkArrecadacaoImovelVVenais.venalPredialCalculado']
                )
            ->end()
            ->with('label.arrecadacaoImovelVVenal.valorVenalTotal')
                ->add(
                    'fkImobiliarioImovel.fkArrecadacaoImovelVVenais.venalTotalInformado',
                    'money',
                    $fieldOptions['fkImobiliarioImovel.fkArrecadacaoImovelVVenais.venalTotalInformado']
                )
                ->add(
                    'fkImobiliarioImovel.fkArrecadacaoImovelVVenais.venalTotalCalculado',
                    'money',
                    $fieldOptions['fkImobiliarioImovel.fkArrecadacaoImovelVVenais.venalTotalCalculado']
                )
                ->add(
                    'fkImobiliarioImovel.fkArrecadacaoImovelVVenais.exercicio',
                    'text',
                    $fieldOptions['fkImobiliarioImovel.fkArrecadacaoImovelVVenais.exercicio']
                )
            ->end()
            ->with('label.atributos')
                ->add('atributosDinamicos', 'text', $fieldOptions['atributosDinamicos'])
            ->end()
        ;
    }

    /**
     * @param Proprietario $object
     */
    public function preUpdate($object)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $exercicio = $this->getForm()->get('fkImobiliarioImovel__fkArrecadacaoImovelVVenais__exercicio')->getData();
        $venalTerritorialInformado = $this->getForm()->get('fkImobiliarioImovel__fkArrecadacaoImovelVVenais__venalTerritorialInformado')->getData();
        $venalPredialInformado = $this->getForm()->get('fkImobiliarioImovel__fkArrecadacaoImovelVVenais__venalPredialInformado')->getData();

        $dateTime = new DateTimeMicrosecondPK();

        $imovelVVenal = new ImovelVVenal();

        $imovelVVenal->setExercicio($exercicio);
        $imovelVVenal->setVenalTerritorialInformado($venalTerritorialInformado);
        $imovelVVenal->setVenalPredialInformado($venalPredialInformado);
        $imovelVVenal->setVenalTotalInformado($venalTerritorialInformado + $venalPredialInformado);
        $imovelVVenal->setTimestamp($dateTime);

        $object->getFkImobiliarioImovel()->addFkArrecadacaoImovelVVenais($imovelVVenal);

        if ($this->request->request->get('atributoDinamico')) {
            $atributosDinamicos = $this->request->request->get('atributoDinamico');
            $imovelVVenalModel = new AvaliacaoImobiliariaModel($em);
            $imovelVVenalModel->saveAtributoImovelVVenalValor($object, $imovelVVenal, $this->getForm(), $atributosDinamicos);
        }
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('inscricaoMunicipal')
            ->add('timestamp')
            ->add('exercicio')
            ->add('venalTerritorialInformado')
            ->add('venalPredialInformado')
            ->add('venalTotalInformado')
            ->add('venalTerritorialCalculado')
            ->add('venalPredialCalculado')
            ->add('venalTotalCalculado')
            ->add('venalTerritorialDeclarado')
            ->add('venalPredialDeclarado')
            ->add('venalTotalDeclarado')
            ->add('venalTerritorialAvaliado')
            ->add('venalPredialAvaliado')
            ->add('venalTotalAvaliado')
            ->add('valorFinanciado')
            ->add('aliquotaValorAvaliado')
            ->add('aliquotaValorFinanciado')
        ;
    }
}
