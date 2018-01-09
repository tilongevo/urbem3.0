<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Cse\EstadoCivil;
use Urbem\CoreBundle\Entity\Cse\Raca;
use Urbem\CoreBundle\Entity\Pessoal\Cid;
use Urbem\CoreBundle\Entity\Pessoal\Servidor;
use Urbem\CoreBundle\Entity\Pessoal\Contrato;
use Urbem\CoreBundle\Entity\SwCgmPessoaFisica;
use Urbem\CoreBundle\Entity\SwMunicipio;
use Urbem\CoreBundle\Entity\SwUf;
use Urbem\CoreBundle\Model\Pessoal\ServidorModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Urbem\RecursosHumanosBundle\Helper\Constants\Pessoal\ServidorReservista as ServidorReservistaConstants;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Urbem\CoreBundle\Helper\ValidaDocumentoHelper;

/**
 * Class ServidorAdmin
 * @package Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal
 */
class ServidorAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_pessoal_servidor';
    protected $baseRoutePattern = 'recursos-humanos/pessoal/servidor';
    protected $datagridValues = [
        '_page' => 1,
        '_sort_order' => "DESC",
        '_sort_by' => 'codServidor'
    ];
    protected $model = ServidorModel::class;

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->add(
                'consulta_dados_cgm_pessoa_fisica',
                'consulta-dados-cgm-pessoa-fisica/' . $this->getRouterIdParameter()
            )
            ->add(
                'perfil',
                '{id}/perfil',
                [
                    '_controller' => 'RecursosHumanosBundle:Pessoal/Servidor:perfil'
                ],
                [
                    'id' => $this->getRouterIdParameter()
                ]
            )
        ;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'numcgm',
                'doctrine_orm_string',
                [
                    'label' => 'label.servidor.codServidor',
                ],
                'text',
                [
                    'mapped' => false,
                ]
            )
            ->add(
                'registro',
                'doctrine_orm_string',
                [
                    'label' => 'label.pessoal.servidor.matricula',
                ],
                'text',
                [
                    'mapped' => false,
                ]
            )
        ;
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $alias = $query->getRootAliases()[0];
        $filter = $this->getRequest()->query->get('filter');

        if ($filter) {
            if (array_key_exists('numcgm', $filter)) {
                $numcgm = $filter['numcgm']['value'];
                if (! empty($numcgm)) {
                    $query->join($alias . '.fkSwCgmPessoaFisica', 'pf');
                    $query->join('pf.fkSwCgm', 'cgm');

                    if (is_numeric($numcgm)) {
                        $query->where('cgm.numcgm = ' . $numcgm);
                    } else {
                        $query->where("LOWER(cgm.nomCgm) LIKE '%" .  strtolower($numcgm) . "%'");
                    }
                }
            }

            if (array_key_exists('registro', $filter)) {
                $registro = $filter['registro']['value'];
                if (! empty($registro)) {
                    $query->join("{$alias}.fkPessoalServidorContratoServidores", "scs");
                    $query->join("scs.fkPessoalContratoServidor", "cs");
                    $query->join("cs.fkPessoalContrato", "c");
                    $query->where('c.registro = ' . $registro);
                }
            }
        }

        return $query;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function addActionsGrid(ListMapper $listMapper)
    {
        $listMapper
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                    'delete' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'),
                )
            ))
        ;
    }


    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add(
                'matricula',
                'text',
                [
                    'label' => 'label.matricula',
                    'row_align' => 'right'
                ]
            )
            ->add(
                'fkSwCgmPessoaFisica',
                'text',
                [
                    'label' => 'label.servidor.codServidor',
                    'admin_code' => 'administrativo.admin.sw_cgm_pessoa_fisica',
                ]
            )
            ->add(
                'dtAdmissao',
                'date',
                [
                    'label' => 'label.dtAdmissao'
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
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $this->setIncludeJs(array_merge(parent::getIncludeJs(), [
            '/recursoshumanos/javascripts/pessoal/servidor/form--servidor.js'
        ]));

        $fieldOptions = [];

        $availableTypes = ['image/jpeg', 'image/pjpeg', 'image/png'];
        $imageRules = [
            'mimeTypes'       => $availableTypes,
            'maxSize'         => '500k',
            'maxWidth'        => '512',
            'maxHeight'       => '512',
            'minWidth'        => '256',
            'minHeight'       => '256',
            'mimeTypesMessage'=> $this->trans('usuario.errors.invalidFileType', ['%file_types%' => implode(', ', $availableTypes)], 'validators'),
            'maxSizeMessage'  => $this->trans('usuario.errors.uploadedFileSizeNotAllowed', ['%size%' => '500Kb'], 'validators'),
            'maxWidthMessage' => $this->trans('usuario.errors.maxPicSizeExceeded', ['%max_size%' => '500px'], 'validators'),
            'minWidthMessage' => $this->trans('usuario.errors.minPicSizeExceeded', ['%min_size%' => '256px'], 'validators')
        ];

        $fieldOptions['caminhoFoto'] = [
            'mapped'      => false,
            'label'       => 'label.servidor.foto',
            'required'    => false,
            'constraints' => [new Assert\Image($imageRules)]
        ];

        $fieldOptions['fkSwCgmPessoaFisica'] = [
            'class' => SwCgmPessoaFisica::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repo, $term, Request $request) {
                return $repo->getSwCgmPessoaFisicaQueryBuilder($term);
            },
            'label' => 'label.servidor.codServidor',
            'attr' => [
                'class' => 'select2-parameters'
            ],
        ];

        $fieldOptions['dtNascimento'] = [
            'mapped' => false,
            'required' => true,
            'label' => 'label.servidor.datanascimento',
            'format' => 'dd/MM/yyyy'
        ];

        $fieldOptions['sexo'] = [
            'mapped' => false,
            'attr' => [
                'readonly' => 'readonly',
            ],
            'label' => 'label.servidor.sexo',
            'required' => false,
        ];

        $fieldOptions['nomePai'] = [
            'label' => 'label.servidor.nomepai'
        ];

        $fieldOptions['nomeMae'] = [
            'label' => 'label.servidor.nomemae'
        ];

        $fieldOptions['fkCseEstadoCivil'] = [
            'class' => EstadoCivil::class,
            'choice_label' => 'nomEstado',
            'label' => 'label.servidor.estadoCivil',
            'attr' => [
                'class' => 'select2-parameters ',
            ],
        ];

        $fieldOptions['conjuge'] = [
            'class' => SwCgmPessoaFisica::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repo, $term, Request $request) {
                return $repo->getSwCgmPessoaFisicaQueryBuilder($term);
            },
            'label' => 'label.servidor.conjugeLabel',
            'required' => false,
            'mapped' => false,
        ];

        $fieldOptions['fkCseRaca'] = [
            'class' => Raca::class,
            'choice_label' => 'nomRaca',
            'label' => 'label.servidor.raca',
            'attr' => [
                'class' => 'select2-parameters ',
            ],
        ];

        $fieldOptions['cidEntity'] = [
            'label' => 'label.servidor.cid',
            'minimum_input_length' => 1,
            'class' => Cid::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repo, $term, Request $request) {
                return $repo->createQueryBuilder('c')
                    ->where('LOWER(c.sigla) LIKE :term')
                    ->orWhere('LOWER(c.descricao) LIKE :term')
                    ->setParameter('term', "%" . strtolower($term) . "%");
            },
            'json_choice_label' => function ($entity) {
                $sigla = $entity instanceof Cid ? $entity->getSigla() : $entity['sigla'];
                $descricao = $entity instanceof Cid ? $entity->getDescricao() : $entity['descricao'];
                return sprintf('%s - %s', $sigla, $descricao);
            },
            'label' => 'label.servidor.cid',
            'required' => false,
            'mapped' => false,
        ];

        $fieldOptions['dataLaudoCid'] = [
            'format' => 'dd/MM/yyyy',
            'label' => 'label.servidor.laudo',
            'required' => false,
            'mapped' => false,
        ];

        $fieldOptions['nacionalidade'] = [
            'mapped' => false,
            'attr' => [
                'readonly' => 'readonly',
            ],
            'label' => 'label.servidor.nacionalidade',
            'required' => false,
        ];

        $fieldOptions['fkSwUf'] = [
            'class' => SwUf::class,
            'query_builder' => function (EntityRepository $em) {
                return $em->createQueryBuilder('uf')
                    ->orderBy('uf.nomUf', 'ASC');
            },
            'choice_label' => 'nomUf',
            'label' => 'label.servidor.estado',
            'placeholder' => '',
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters ',
            ],
        ];

        $fieldOptions['municipioCgm'] = [
            'label' => 'label.servidor.cidade',
            'class' => SwMunicipio::class,
            'req_params' => array(
                'codUf' => 'varJsCodUf'
            ),
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repo, $term, Request $request) {
                $qb = $repo->createQueryBuilder('m')
                    ->where('LOWER(m.nomMunicipio) LIKE :nomMunicipio')
                    ->andWhere('m.codUf = :codUf')
                    ->setParameter('nomMunicipio', "%" . strtolower($term) . "%")
                    ->setParameter('codUf', $request->get('codUf'))
                ;

                return $qb;
            },
            'required' => true,
            'mapped' => false,
        ];

        $fieldOptions['endereco'] = [
            'mapped' => false,
            'attr' => [
                'readonly' => 'readonly',
            ],
            'label' => 'label.servidor.endereco',
            'required' => false,
        ];

        $fieldOptions['bairro'] = [
            'mapped' => false,
            'attr' => [
                'readonly' => 'readonly',
            ],
            'label' => 'label.servidor.bairro',
            'required' => false,
        ];

        $fieldOptions['cpf'] = [
            'mapped' => false,
            'label' => 'label.servidor.cpf',
            'required' => false,
        ];

        $fieldOptions['uf'] = [
            'mapped' => false,
            'attr' => [
                'readonly' => 'readonly',
            ],
            'label' => 'label.servidor.uf',
            'required' => false,
        ];

        $fieldOptions['municipio'] = [
            'mapped' => false,
            'attr' => [
                'readonly' => 'readonly',
            ],
            'label' => 'label.servidor.municipio',
            'required' => false,
        ];

        $fieldOptions['cep'] = [
            'mapped' => false,
            'attr' => [
                'readonly' => 'readonly',
            ],
            'label' => 'label.servidor.cep',
            'required' => false,
        ];

        $fieldOptions['fone'] = [
            'mapped' => false,
            'attr' => [
                'readonly' => 'readonly',
            ],
            'label' => 'label.servidor.fone',
            'required' => false,
        ];

        $fieldOptions['escolaridade'] = [
            'mapped' => false,
            'attr' => [
                'readonly' => 'readonly',
            ],
            'label' => 'label.servidor.escolaridade',
            'required' => false,
        ];

        $fieldOptions['rg'] = [
            'mapped' => false,
            'attr' => [
                'readonly' => 'readonly',
            ],
            'label' => 'label.servidor.rg',
            'required' => false,
        ];

        $fieldOptions['orgaoemissor'] = [
            'mapped' => false,
            'attr' => [
                'readonly' => 'readonly',
            ],
            'label' => 'label.servidor.orgaoemissor',
            'required' => false,
        ];

        $fieldOptions['numerocnh'] = [
            'mapped' => false,
            'attr' => [
                'readonly' => 'readonly',
            ],
            'label' => 'label.servidor.numerocnh',
            'required' => false,
        ];

        $fieldOptions['categoriacnh'] = [
            'mapped' => false,
            'attr' => [
                'readonly' => 'readonly',
            ],
            'label' => 'label.servidor.categoriacnh',
            'required' => false,
        ];

        $fieldOptions['pis'] = [
            'mapped' => false,
            'label' => 'label.servidor.pis',
            'required' => true,
        ];

        $fieldOptions['dtPisPasep'] = [
            'format' => 'dd/MM/yyyy',
            'label' => 'label.servidor.datapis',
            'required' => true,
            'mapped' => false,
        ];

        $fieldOptions['nrTituloEleitor'] = [
            'label' => 'label.servidor.nrTituloEleitor'
        ];

        $fieldOptions['secaoTitulo'] = [
            'label' => 'label.servidor.secaoTitulo'
        ];

        $fieldOptions['zonaTitulo'] = [
            'label' => 'label.servidor.zonaTitulo'
        ];

        if ($this->id($this->getSubject())) {
            $fkSwCgmPessoaFisica = $this->getSubject()->getFkSwCgmPessoaFisica();
            $fieldOptions['fkSwUf']['data'] = $this->getSubject()->getFkSwMunicipio()->getFkSwUf();
            $fieldOptions['municipioCgm']['data'] = $this->getSubject()->getFkSwMunicipio();
            if ($fkSwCgmPessoaFisica->getDtNascimento()) {
                $fieldOptions['dtNascimento']['data'] = $fkSwCgmPessoaFisica->getDtNascimento();
            }
            $fieldOptions['sexo']['data'] = $this->trans($fkSwCgmPessoaFisica->getSexo());
            $fieldOptions['endereco']['data'] = $fkSwCgmPessoaFisica->getFkSwCgm()->getLogradouro();
            $fieldOptions['bairro']['data'] = $fkSwCgmPessoaFisica->getFkSwCgm()->getBairro();
            $fieldOptions['uf']['data'] = $fkSwCgmPessoaFisica->getFkSwCgm()->getFkSwMunicipio()->getFkSwUf()->getNomUf();
            $fieldOptions['municipio']['data'] = $fkSwCgmPessoaFisica->getFkSwCgm()->getFkSwMunicipio()->getNomMunicipio();
            $fieldOptions['cep']['data'] = $fkSwCgmPessoaFisica->getFkSwCgm()->getCep();
            $fieldOptions['fone']['data'] = $fkSwCgmPessoaFisica->getFkSwCgm()->getFoneResidencial();
            $fieldOptions['cpf']['data'] = $fkSwCgmPessoaFisica->getCpf();
            $fieldOptions['rg']['data'] = $fkSwCgmPessoaFisica->getRg();
            $fieldOptions['orgaoemissor']['data'] = $fkSwCgmPessoaFisica->getOrgaoEmissor();
            $fieldOptions['numerocnh']['data'] = $fkSwCgmPessoaFisica->getNumCnh();
            $fieldOptions['categoriacnh']['data'] = $fkSwCgmPessoaFisica->getFkSwCategoriaHabilitacao()->getNomCategoria();
            $fieldOptions['pis']['data'] = $fkSwCgmPessoaFisica->getServidorPisPasep();

            $conjuge = $this->getSubject()->getFkPessoalServidorConjuges();
            if (! $conjuge->isEmpty()) {
                $fieldOptions['conjuge']['data'] = $conjuge->last();
            }

            $cid = $this->getSubject()->getFkPessoalServidorCids();
            if (! $cid->isEmpty()) {
                $fieldOptions['cidEntity']['data'] = $cid->last()->getFkPessoalCid();
                $fieldOptions['dataLaudoCid']['data'] = $cid->last()->getDataLaudo();
            }

            $fieldOptions['nacionalidade']['data'] = $fkSwCgmPessoaFisica->getFkSwPais()->getNacionalidade();

            $pis = $this->getSubject()->getFkPessoalServidorPisPaseps();
            if (! $pis->isEmpty()) {
                $fieldOptions['dtPisPasep']['data'] = $pis->last()->getDtPisPasep();
            }

            if ($this->getSubject()->getCaminhoFoto() != "" && ! is_null($this->getSubject()->getCaminhoFoto())) {
                $container = $this->getConfigurationPool()->getContainer();
                $servidorPath = $container->getParameter("recursoshumanosbundle");

                $fullPath = $servidorPath['servidorShow'] . $this->getSubject()->getCaminhoFoto();

                $fieldOptions['caminhoFoto']['help'] = '<a href="' . $fullPath . '">' . $this->getSubject()->getCaminhoFoto() . '</a>';
            }
        }

        $formMapper
            ->with('label.servidor.identificacao')
                ->add(
                    'caminhoFoto',
                    'file',
                    $fieldOptions['caminhoFoto']
                )
                ->add(
                    'fkSwCgmPessoaFisica',
                    'autocomplete',
                    $fieldOptions['fkSwCgmPessoaFisica'],
                    [
                        'admin_code' => 'administrativo.admin.sw_cgm_pessoa_fisica',
                    ]
                )
                ->add(
                    'dtNascimento',
                    'sonata_type_date_picker',
                    $fieldOptions['dtNascimento']
                )
                ->add(
                    'sexo',
                    'text',
                    $fieldOptions['sexo']
                )
                ->add(
                    'nomePai',
                    null,
                    $fieldOptions['nomePai']
                )
                ->add(
                    'nomeMae',
                    null,
                    $fieldOptions['nomeMae']
                )
                ->add(
                    'fkCseEstadoCivil',
                    'entity',
                    $fieldOptions['fkCseEstadoCivil']
                )
                ->add(
                    'conjuge',
                    'autocomplete',
                    $fieldOptions['conjuge'],
                    [
                        'admin_code' => 'administrativo.admin.sw_cgm_pessoa_fisica',
                    ]
                )
                ->add(
                    'fkCseRaca',
                    'entity',
                    $fieldOptions['fkCseRaca']
                )
                ->add(
                    'cidEntity',
                    'autocomplete',
                    $fieldOptions['cidEntity']
                )
                ->add(
                    'dataLaudoCid',
                    'sonata_type_date_picker',
                    $fieldOptions['dataLaudoCid']
                )
                ->add(
                    'nacionalidade',
                    'text',
                    $fieldOptions['nacionalidade']
                )
                ->add(
                    'fkSwUf',
                    'entity',
                    $fieldOptions['fkSwUf']
                )
                ->add(
                    'municipioCgm',
                    'autocomplete',
                    $fieldOptions['municipioCgm']
                )
                ->add(
                    'endereco',
                    'text',
                    $fieldOptions['endereco']
                )
                ->add(
                    'bairro',
                    'text',
                    $fieldOptions['bairro']
                )
                ->add(
                    'uf',
                    'text',
                    $fieldOptions['uf']
                )
                ->add(
                    'municipio',
                    'text',
                    $fieldOptions['municipio']
                )
                ->add(
                    'cep',
                    'text',
                    $fieldOptions['cep']
                )
                ->add(
                    'fone',
                    'text',
                    $fieldOptions['fone']
                )
                ->add(
                    'escolaridade',
                    'text',
                    $fieldOptions['escolaridade']
                )
            ->end()
            ->with('label.servidor.dadosdocumentacao')
                ->add(
                    'cpf',
                    'text',
                    $fieldOptions['cpf']
                )
                ->add(
                    'rg',
                    'text',
                    $fieldOptions['rg']
                )
                ->add(
                    'orgaoemissor',
                    'text',
                    $fieldOptions['orgaoemissor']
                )
                ->add(
                    'numerocnh',
                    'text',
                    $fieldOptions['numerocnh']
                )
                ->add(
                    'categoriacnh',
                    'text',
                    $fieldOptions['categoriacnh']
                )
                ->add(
                    'pis',
                    'text',
                    $fieldOptions['pis']
                )
                ->add(
                    'dtPisPasep',
                    'sonata_type_date_picker',
                    $fieldOptions['dtPisPasep']
                )
                ->add(
                    'nrTituloEleitor',
                    null,
                    $fieldOptions['nrTituloEleitor']
                )
                ->add(
                    'secaoTitulo',
                    null,
                    $fieldOptions['secaoTitulo']
                )
                ->add(
                    'zonaTitulo',
                    null,
                    $fieldOptions['zonaTitulo']
                )
                ->add(
                    'fkPessoalServidorReservista',
                    'sonata_type_admin',
                    [
                        'label' => false,
                        'required' => false,
                    ],
                    [
                        'edit' => 'inline',
                        'inline' => 'table',
                    ],
                    null
                )
            ->end()
        ;
    }

    /**
     * @param integer $codContrato
     * @return mixed
     */
    public function recuperarSituacaoDoContratoLiteral($codContrato)
    {
        return $this->getEntityManager()->getRepository(Contrato::class)
        ->recuperarSituacaoDoContratoLiteral($codContrato);
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $servidor
     */
    public function validate(ErrorElement $errorElement, $servidor)
    {
        $form = $this->getForm();

        $cpf = $form->get('cpf')->getData();

        if ($cpf) {
            $swCgmPessoaFisica = $this->getDoctrine()->getRepository(SwCgmPessoaFisica::class)
            ->findOneByCpf($cpf);

            if ($swCgmPessoaFisica && ($form->get('fkSwCgmPessoaFisica')->getData()->getNumcgm() != $swCgmPessoaFisica->getNumcgm())) {
                $message = $this->trans('servidor.errors.cpf');
                $errorElement->with('cpf')->addViolation($message)->end();
            }
        }

        $pisValido = ValidaDocumentoHelper::NIS($form->get('pis')->getData());

        if (! $pisValido) {
            $message = $this->trans('servidor.errors.pis');
            $errorElement->with('pis')->addViolation($message)->end();
        }
    }

    /**
     * @param Servidor $servidor
     */
    public function redirect(Servidor $servidor)
    {
        $servidor = $servidor->getCodServidor();
        $this->forceRedirect('/recursos-humanos/pessoal/servidor/' . $servidor .'/show');
    }

    /**
     * Recupera o caminho completo da imagem de perfil do usuário, caso a mesma exista.
     *
     * @param Servidor $servidor
     *
     * @return string|null
     */
    private function getCaminhoFotoFile(Servidor $servidor)
    {
        $fileSystem = new Filesystem();
        $foldersAdminBundle = $this->getContainer()->getParameter('recursoshumanosbundle');

        $filePath = sprintf('%s/%s', $foldersAdminBundle['servidor'], $servidor->getCaminhoFoto());

        // Verifica se o arquivo existe na pasta.
        if ($fileSystem->exists($filePath)) {
            return $servidor->getCaminhoFoto();
        }

        return null;
    }

    /**
     * Faz o upload da imagem
     *
     * @param Servidor     $servidor
     * @param UploadedFile $uploadedFile
     */
    private function uploadCaminhoFoto(Servidor $servidor, UploadedFile $uploadedFile)
    {
        $foldersBundle = $this->getContainer()->getParameter('recursoshumanosbundle');

        try {
            $uploadedFile->move($foldersBundle['servidor'], $servidor->getCaminhoFoto());
        } catch (IOException $IOException) {
            $message = $this->trans('usuario.errors.failedMoveCaminhoFoto', [], 'validators');

            $container = $this->getContainer();
            $container
                ->get('session')
                ->getFlashBag()
                ->add('error', $message);

            (new RedirectResponse($this->request->headers->get('referer')))->send();
        }
    }

    /**
     * Persiste a imagem no perfil do usuário
     *
     * @param Servidor $servidor
     */
    private function persistCaminhoFoto(Servidor $servidor)
    {
        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $this->getForm()->get('caminhoFoto')->getData();

        if (!is_null($uploadedFile)) {
            $profilePictureFileName = md5(date('dmyhis'));
            $profilePictureFileName = sprintf('%s.%s', $profilePictureFileName, $uploadedFile->getClientOriginalExtension());

            $servidor->setCaminhoFoto($profilePictureFileName);

            $this->uploadCaminhoFoto($servidor, $uploadedFile);
        }
    }

    /**
     * Remove a foto do perfil.
     *
     * @param Servidor $servidor
     */
    private function removeCaminhoFoto(Servidor $servidor)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $foldersBundle = $this->getContainer()->getParameter('recursoshumanosbundle');

        $filePath = sprintf('%s/%s', $foldersBundle['servidor'], $servidor->getCaminhoFoto());

        $fileSystem = new Filesystem();
        if ($fileSystem->exists($filePath)) {
            try {
                $fileSystem->remove($filePath);
            } catch (IOException $IOException) {
                $message = $this->trans('usuario.errors.failedRemoveCaminhoFoto', [], 'validators');

                $container = $this->getContainer();
                $container
                    ->get('session')
                    ->getFlashBag()
                    ->add('error', $message);

                (new RedirectResponse($this->request->headers->get('referer')))->send();
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function prePersist($servidor)
    {
        $entityManager = $this->getDoctrine();

        $this->persistCaminhoFoto($servidor);

        $servidorModel = new ServidorModel($entityManager);
        $servidorModel->buildServidor($servidor, $this->getForm());
    }

    /**
     * {@inheritdoc}
     */
    public function postPersist($servidor)
    {
        $this->redirect($servidor);
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($servidor)
    {
        $entityManager = $this->getDoctrine();

        $this->updateCaminhoFoto($servidor);

        $servidorModel = new ServidorModel($entityManager);
        $servidorModel->updateServidor($servidor, $this->getForm());
    }

    /**
     * Atualiza a foto do perfil.
     *
     * @param Servidor $servidor
     */
    private function updateCaminhoFoto(Servidor $servidor)
    {
        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $this->getForm()->get('caminhoFoto')->getData();

        if (!is_null($uploadedFile)) {
            $this->removeCaminhoFoto($servidor);
            $this->persistCaminhoFoto($servidor);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function postRemove($servidor)
    {
        $this->removeCaminhoFoto($servidor);
    }

    /**
     * Retorna a label de tradução do campo Categoria do Certificado
     * @param  string
     * @return string
     */
    public function getCatReservistaTrans($value)
    {
        return array_search($value, ServidorReservistaConstants::CATRESERVISTA);
    }

    /**
     * Retorna a label de tradução do campo Órgão Expedidor do Certificado
     * @param  string
     * @return string
     */
    public function getOrigemReservistaTrans($value)
    {
        return array_search($value, ServidorReservistaConstants::ORIGEMRESERVISTA);
    }

    /**
    * @param ShowMapper $showMapper
    */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $this->setIncludeJs(array_merge(parent::getIncludeJs(), [
            '/recursoshumanos/javascripts/pessoal/servidor/show--servidor.js'
        ]));

        /** @var Servidor $servidor */
        $servidor = $this->getSubject();

        $servidor->profilePic = $this->getCaminhoFotoFile($servidor);

        if (! is_null($servidor->profilePic)) {
            $foldersAdminBundle = $this
                                    ->getContainer()
                                    ->getParameter('recursoshumanosbundle');

            $servidor->profilePic = $foldersAdminBundle['servidorShow'] . $servidor->profilePic;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function toString($servidor)
    {
        try {
            return $servidor->getFkSwCgmPessoaFisica()->getFkSwCgm()->getNumCgm()
            . " - " . $servidor->getFkSwCgmPessoaFisica()->getFkSwCgm()->getNomCgm();
        } catch (\Exception $e) {
            return "";
        }
    }
}
