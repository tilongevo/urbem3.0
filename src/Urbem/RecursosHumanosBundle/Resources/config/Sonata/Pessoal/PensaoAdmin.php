<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal;

use Sonata\AdminBundle\Form\Type\Filter\ChoiceType;
use Urbem\CoreBundle\Entity\Pessoal\PensaoFuncao;
use Urbem\CoreBundle\Entity\Pessoal\PensaoValor;
use Urbem\CoreBundle\Model\Pessoal\PensaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Urbem\CoreBundle\Entity\Pessoal\PensaoIncidencia;
use Urbem\CoreBundle\Entity\Pessoal\PensaoExcluida;

class PensaoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_pessoal_pensao';
    protected $baseRoutePattern = 'recursos-humanos/pessoal/pensao';

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('consultar_matricula', 'consultar-matricula', array(), array(), array(), '', array(), array('POST'));
        $collection->add('consultar_dependente', 'consultar-dependente', array(), array(), array(), '', array(), array('POST'));
        $collection->add('consultar_agencia', 'consultar-agencia', array(), array(), array(), '', array(), array('POST'));
        $collection->add('listar_dependentes', 'listar-dependentes/'  . $this->getRouterIdParameter());
    }

    protected $includeJs = [
        '/recursoshumanos/javascripts/pessoal/pensao_filtro.js'
    ];


    protected function addActionsGrid(ListMapper $listMapper)
    {
        $listMapper
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                    'edit' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'),
                )
            ))
        ;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $tipo = $this->getRequest()->query->get('filter')['tipoFiltro']['type'];
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $model = (new \Urbem\CoreBundle\Model\Pessoal\PensaoModel($entityManager));
        $datagridMapper
            ->add(
                'tipoFiltro',
                'doctrine_orm_boolean',
                [],
                'choice',
                [
                    'choices' => [
                        'label.servidor.modulo' => 0,
                        'label.dependente' => 1
                    ],
                    'expanded' => true,
                    'multiple' => false,
                    'required'    => false,
                    'placeholder' => false,
                    'empty_data'  => null,
                    'mapped' => false
                ]
            );

        $datagridMapper->has('<br />');

        /*
         * Se o tipo for igual a 0, vai exibir o form filter Servidor
         */
        if (empty($tipo)) {
            $datagridMapper->add(
                'codServidor',
                'doctrine_orm_callback',
                [
                    'label' => 'label.servidor.modulo',
                    'callback' => [$this,'callbackCodServidor']
                ],
                'choice',
                [
                    'choices' => $model->getAllServidores(),
                    'attr' => [
                        'class' => 'select2-parameters '
                    ]
                ]
            )
            ->add(
                'codServidor.numcgm.numcgm',
                'doctrine_orm_callback',
                [
                    'label' => 'label.cgm',
                    'callback' => [$this,'callbackCgms']
                ],
                'choice',
                [
                    'choices' => $model->getAllCgms(),
                    'attr' => [
                        'class' => 'select2-parameters '
                    ]
                ]
            )
            ->add(
                'codServidor.numcgm.cpf',
                'doctrine_orm_callback',
                [
                    'label' => 'label.servidor.cpf',
                    'callback' => [$this,'callbackCpf']
                ]
            )
            ->add(
                'codServidor.codServidor',
                'doctrine_orm_choice',
                [
                    'label' => 'label.pensao.titulo.matricula'
                ]
            );
        }

        /*
         * Se o tipo for igual a 1, vai exibir o form filter Responsavel
         */
        if($tipo == 1){
            $datagridMapper->add(
                'codDependente',
                'doctrine_orm_callback',
                [
                    'label' => 'label.dependente',
                    'callback' => [$this,'callbackDependentes']
                ],
                'choice',
                [
                    'choices' => $model->getAllDependentes(),
                    'attr' => [
                        'class' => 'select2-parameters '
                    ]
                ]
            )
            ->add(
                'codDependente.numcgm.cpf',
                'doctrine_orm_callback',
                [
                    'label' => 'label.servidor.cpf',
                    'callback' => [$this,'callbackCpfDependente']
                ]
            );
        }
    }

    /**
     * Pensao -> PensaoResponsavel -> SwCgmPessoaFisica
     * @param $queryBuilder
     * @param $alias
     * @param $field
     * @param $value
     * @return bool|void
     */
    public function callbackCpf($queryBuilder, $alias, $field, $value)
    {
        if (empty($value['value'])) {
            return;
        }
        $queryBuilder->andWhere("{$alias}.cpf LIKE :cpf");
        $queryBuilder->setParameter('cpf', '%'.$value['value'].'%');
        return true;
    }

    /**
     * Pensao -> Dependente -> SwCgmPessoaFisica
     * @param $queryBuilder
     * @param $alias
     * @param $field
     * @param $value
     * @return bool|void
     */
    public function callbackCpfDependente($queryBuilder, $alias, $field, $value)
    {
        if (empty($value['value'])) {
            return;
        }
        $queryBuilder->andWhere($alias.'.cpf LIKE :cpf');
        $queryBuilder->setParameter('cpf', '%'.$value['value'].'%');
        return true;
    }

    /**
     * @param $queryBuilder
     * @param $alias
     * @param $field
     * @param $value
     * @return bool|void
     */
    public function callbackCodServidor($queryBuilder, $alias, $field, $value)
    {
        if (! $value['value']) {
            return;
        }

        $queryBuilder->andWhere("{$alias}.codServidor = :codServidor");
        $queryBuilder->setParameter("codServidor", $value['value']);

        return true;
    }

    /**
     * @param $queryBuilder
     * @param $alias
     * @param $field
     * @param $value
     * @return bool|void
     */
    public function callbackCgms($queryBuilder, $alias, $field, $value)
    {
        if (! $value['value']) {
            return;
        }
        $queryBuilder->andWhere("s_codServidor_numcgm.numcgm = :numcgm");
        $queryBuilder->setParameter("numcgm", $value['value']);
        return true;
    }

    public function callbackDependentes($queryBuilder, $alias, $field, $value)
    {
        if (! $value['value']) {
            return;
        }

        $queryBuilder->andWhere("{$alias}.codDependente = :codDependente");
        $queryBuilder->setParameter("codDependente", $value['value']);

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
                'codServidor',
                'choice',
                [
                    'label' => 'label.pensao.titulo.matricula'
                ]
            )
            ->add(
                'codServidor.numcgm',
                'choice',
                [
                    'label' => 'label.servidor.modulo'
                ]
            )
            ->add(
                'codServidor.numcgm.cpf',
                'choice',
                [
                    'label' => 'label.servidor.cpf'
                ]
            )
            ->add(
                'codDependente.numcgm',
                'choice',
                [
                    'label' => 'label.pensao.codDependente'
                ]
            )
            ->add(
                'codDependente.numcgm.cpf',
                'choice',
                [
                    'label' => 'label.servidor.cpf'
                ]
            )
            ->add(
                'tipoPensao',
                'choice',
                [
                    'label' => 'label.pensao.tipoPensao'
                ]
            )
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $admin = $this;

        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $matriculas = (new \Urbem\CoreBundle\Model\Pessoal\PensaoModel($entityManager))
        ->getMatricula();

        $cgms = (new \Urbem\CoreBundle\Model\Pessoal\PensaoModel($entityManager))
        ->getAllServidores();

        $incidencias = (new \Urbem\CoreBundle\Model\Pessoal\PensaoModel($entityManager))
        ->getIncidencias();

        $incidenciasChecadas = array();
        if ($id) {
            $incidenciasChecadas = (new \Urbem\CoreBundle\Model\Pessoal\PensaoModel($entityManager))
            ->getIncidenciasChecadas($id);
        }

        $formMapper
            ->with('label.pensao.modulo')
            ->add(
                'codServidor',
                'choice',
                [
                    'choices' => $cgms,
                    'label' => 'label.pensao.codServidor',
                    'attr' => array(
                        'data-sonata-select2' => 'false',
                    )
                ]
            )
            ->end()
            ->with('label.pensao.titulo.dependentes')
            ->add(
                'codDependente',
                'choice',
                [
                    'choices' => [],
                    'label' => 'label.pensao.codDependente',
                    'attr' => [
                        'class' => 'select2-parameters '
                    ]
                ]
            )
            ->add(
                'tipoPensao',
                'choice',
                [
                    'choices' => [
                        'label.pensao.choices.tipoPensao.judicial' => 'J',
                        'label.pensao.choices.tipoPensao.amigavel' => 'A'
                    ],
                    'expanded' => true,
                    'multiple' => false,
                    'label' => 'label.pensao.tipoPensao',
                    'data' => 'J',
                    'label_attr' => array(
                        'class' => 'checkbox-sonata'
                    ),
                    'attr' => array(
                        'class' => 'checkbox-sonata'
                    )
                ]
            )
            ->add(
                'observacao',
                'textarea',
                [
                    'label' => 'label.pensao.observacao',
                ]
            )
            ->add(
                'percentual',
                'text',
                [
                    'label' => 'label.pensao.percentual',
                ]
            )
            ->add(
                'dtInclusao',
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy',
                    'label' => 'label.pensao.dtInclusao',
                ]
            )
            ->add(
                'dtLimite',
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy',
                    'label' => 'label.pensao.dtLimite',
                    'required' => false,
                ]
            )
            ->add(
                'descontoFixado',
                'choice',
                [
                    'choices' => [
                        'Valor'  => '1',
                        'Funçao' => '2',
                    ],
                    'expanded' => true,
                    'multiple' => false,
                    'label' => 'Desconto Fixado	',
                    'mapped' => false,
                    'data' => '1',
                    'label_attr' => array(
                        'class' => 'checkbox-sonata'
                    ),
                    'attr' => array(
                        'class' => 'checkbox-sonata'
                    )
                ]
            )
            ->add(
                'pensaoValorCodPensaoValor',
                'sonata_type_admin',
                [
                    'label' => false,
                    'required' => false,
                ],
                [
                    'edit' => 'inline',
                    'inline' => 'table',
                    'admin_code' => 'recursos_humanos.admin.pensao_valor'
                ],
                null
            )
            ->add('funcao', 'entity', [
                'label' => 'Função',
                'class' => 'CoreBundle:Administracao\Funcao',
                'choice_label' => function ($funcao) {
                    $retorno = $funcao->getCodModulo()->getCodModulo();
                    $retorno .= '.' . $funcao->getCodBiblioteca()->getCodBiblioteca();
                    $retorno .= '.' . str_pad($funcao->getCodFuncao(), 3, "0", STR_PAD_LEFT);
                    $retorno .= ' - ' . $funcao->getNomFuncao();
                    return $retorno;
                },
                'mapped' => false,
            ])

            ->end()
            ->with('label.pensao.titulo.informacoesbancarias')
            ->add(
                'pensaoBancoCodPensaoBanco',
                'sonata_type_admin',
                [
                    'label' => false,
                    'required' => false,
                ],
                [
                    'edit' => 'inline',
                    'inline' => 'table',
                    'admin_code' => 'recursos_humanos.admin.pensao_banco'
                ],
                null
            )
            ->add(
                'rdoResponsavel',
                'choice',
                [
                    'choices' => [
                        'label.pensao.choices.rdoResponsavel.dependente' => 'D',
                        'label.pensao.choices.rdoResponsavel.resplegal' => 'R'
                    ],
                    'expanded' => true,
                    'multiple' => false,
                    'label' => 'label.pensao.rdoResponsavel',
                    'mapped' => false,
                    'data' => 'D',
                    'label_attr' => array(
                        'class' => 'checkbox-sonata'
                    ),
                    'attr' => array(
                        'class' => 'checkbox-sonata'
                    )
                ]
            )
            ->add(
                'pensaoResponsavelLegal',
                'sonata_type_admin',
                [
                    'label' => false,
                    'required' => false,
                    'by_reference' => false,
                ],
                [
                    'edit' => 'inline',
                    'inline' => 'table',
                    'admin_code' => 'recursos_humanos.admin.responsavel_legal'
                ],
                null
            )
            ->end()
            ->with('label.pensao.titulo.incidencias')
            ->add(
                'chIncidencia',
                'choice',
                [
                    'choices' => $incidencias,
                    'expanded' => true,
                    'multiple' => true,
                    'label' => false,
                    'mapped' => false,
                    'data' => $incidenciasChecadas
                ]
            )
            ->end()
        ;

        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formMapper, $admin) {

                $form = $event->getForm();
                $form->remove('codDependente');
                $form->add(
                    'codDependente',
                    'entity',
                    [
                        'class' => 'CoreBundle:Pessoal\Dependente',
                        'choice_label' => 'numcgm.numcgm.nomCgm',
                        'label' => 'label.pensao.codDependente',
                    ]
                );
            }
        );

        if ($this->id($this->getSubject())) {
            $dependentes = (new \Urbem\CoreBundle\Model\Pessoal\PensaoModel($entityManager))
            ->getDependentes($this->getSubject()->getCodServidor());


            $formMapper
                ->add(
                    'codDependente',
                    'choice',
                    [
                        'choices' => $dependentes,
                        'label' => 'label.pensao.codDependente',
                        'choice_attr' => function ($agencia, $key, $index) {
                            if ($index == $this->getSubject()->getCodDependente()) {
                                return ['selected' => 'selected'];
                            } else {
                                return ['selected' => false];
                            }
                        },
                        'attr' => [
                            'class' => 'select2-parameters '
                        ]
                    ]
                )
                ->add(
                    'codServidor',
                    'choice',
                    [
                        'choices' => $cgms,
                        'label' => 'label.pensao.codServidor',
                        'attr' => array(
                            'data-sonata-select2' => 'false',
                        ),
                        'mapped' => false,
                        'choice_attr' => function ($agencia, $key, $index) {
                            if ($index == $this->getSubject()->getCodServidor()) {
                                return ['selected' => 'selected'];
                            } else {
                                return ['selected' => false];
                            }
                        },
                    ]
                );
        }
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add('codServidor.numcgm', null, ['label' => 'label.pensao.nomServidor'])
            ->add('codServidor.numcgm.numcgm', null, ['label' => 'label.pensao.codServidor'])
            ->add('codDependente.numcgm', null, ['label' => 'label.pensao.dependente'])
            ->add('codDependente', null, ['label' => 'label.pensao.codDependente'])
            ->add('tipoPensao', null, ['label' => 'label.pensao.tipoPensao'])
            ->add('dtInclusao', null, ['label' => 'label.pensao.dtInclusao'])
            ->add('dtLimite', null, ['label' => 'label.pensao.dtLimite'])
            ->add('percentual', null, ['label' => 'label.pensao.percentual'])
            ->add('observacao', null, ['label' => 'label.pensao.observacao'])
        ;
    }

    public function prePersist($pensao)
    {
        $container = $this->getConfigurationPool()->getContainer();

        try {

            $codBanco = $this->getForm()->get('pensaoBancoCodPensaoBanco')->get('codBanco')->getData()->getCodBanco();
            $codserv = $this->getForm()->get('codServidor')->getData();

            $entityManager = $this->modelManager->getEntityManager($this->getClass());
            $dc = $this->getConfigurationPool()->getContainer()->get('Doctrine')->getManager();

            $codBancoEntity =     $entityManager->getRepository('CoreBundle:Monetario\Banco')->findOneByCodBanco($codBanco);
            $codServidorEntity =  $entityManager->getRepository('CoreBundle:Pessoal\Servidor')->findOneByCodServidor($codserv);

            $pensao->setCodServidor($codServidorEntity);
            $pensao->getPensaoBancoCodPensaoBanco()->setCodBanco($codBancoEntity);
            $pensao->getPensaoBancoCodPensaoBanco()->setCodPensao($pensao);

            $dependente = $dc->getRepository('CoreBundle:Pessoal\Dependente')->findOneByCodDependente($pensao->getCodDependente());
            $pensao->setCodDependente($dependente);
            $pensao->setCodServidor($codServidorEntity);

            if ($this->getForm()->get('rdoResponsavel')->getData() == "R") {
                $numcgm = $entityManager->getRepository('CoreBundle:SwCgmPessoaFisica')
                ->findOneByNumcgm($this->getForm()->get('codServidor')->getData());

                $pensao->getPensaoResponsavelLegal()->setCodPensao($pensao);
                $pensao->getPensaoResponsavelLegal()->setNumCgm($numcgm);
            } else {
                $pensao->setPensaoResponsavelLegal(null);
            }

            $pensao->getPensaoValorCodPensaoValor()->setCodPensao($pensao);
            $container->get('session')->getFlashBag()->add('success', 'flash_create_success');
        } catch (\Exception $e) {
        }
    }

    public function preUpdate($pensao)
    {

        try {

            $codBanco = $this->getForm()->get('pensaoBancoCodPensaoBanco')->get('codBanco')->getData()->getCodBanco();
            $codserv = $this->getForm()->get('codServidor')->getData();

            $entityManager = $this->modelManager->getEntityManager($this->getClass());

            $codBancoEntity =     $entityManager->getRepository('CoreBundle:Monetario\Banco')->findOneByCodBanco($codBanco);
            $codServidorEntity =  $entityManager->getRepository('CoreBundle:Pessoal\Servidor')->findOneByCodServidor($codserv);

            $pensao->setCodServidor($codServidorEntity);
            $pensao->getPensaoBancoCodPensaoBanco()->setCodBanco($codBancoEntity);

            $pensao->getPensaoBancoCodPensaoBanco()->setCodPensao($pensao);

            if ($this->getForm()->get('rdoResponsavel')->getData() == "R") {
                $numcgm = $entityManager->getRepository('CoreBundle:SwCgmPessoaFisica')
                ->findOneByNumcgm($this->getForm()->get('codServidor')->getData());

                $pensao->getPensaoResponsavelLegal()->setCodPensao($pensao);
                $pensao->getPensaoResponsavelLegal()->setNumCgm($numcgm);
            } else {
                $pensao->setPensaoResponsavelLegal(null);
            }

            $pensao->getPensaoValorCodPensaoValor()->setCodPensao($pensao);
        } catch (\Exception $e) {
        }
    }

    public function postPersist($pensao)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $incidencias = $this->getForm()->get('chIncidencia')->getData();

        foreach ($incidencias as $incidenciaKey => $codIncidencia) {
            $codIncidenciaObj = $entityManager->getRepository('CoreBundle:Pessoal\Incidencia')
            ->findOneByCodIncidencia($codIncidencia);

            $pensaoincidencia = new PensaoIncidencia();
            $pensaoincidencia->setCodPensao($pensao->getCodPensao());
            $pensaoincidencia->setCodIncidencia($codIncidenciaObj);
            $entityManager->persist($pensaoincidencia);
        }

        $entityManager->flush();
    }

    public function postUpdate($pensao)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $incidenciaRemoveObj = $entityManager->getRepository('CoreBundle:Pessoal\PensaoIncidencia')
        ->findByCodPensao($pensao->getCodPensao());

        foreach ($incidenciaRemoveObj as $incidenciaKey => $codIncidencia) {
            $entityManager->remove($codIncidencia);
        }
        $entityManager->flush();

        $incidencias = $this->getForm()->get('chIncidencia')->getData();

        foreach ($incidencias as $incidenciaKey => $codIncidencia) {
            $codIncidenciaObj = $entityManager->getRepository('CoreBundle:Pessoal\Incidencia')
            ->findOneByCodIncidencia($codIncidencia);

            $pensaoincidencia = new PensaoIncidencia();
            $pensaoincidencia->setCodPensao($pensao->getCodPensao());
            $pensaoincidencia->setCodIncidencia($codIncidenciaObj);
            $entityManager->persist($pensaoincidencia);
        }

        $entityManager->flush();
    }

    public function preRemove($pensao)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $pensaoexcluida = new PensaoExcluida();
        $pensaoexcluida->setCodPensao($pensao->getCodPensao());
        $entityManager->persist($pensaoexcluida);
        $entityManager->flush();
    }
}
