<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Tesouraria;

use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class TerminalAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_tesouraria_terminal';
    protected $baseRoutePattern = 'financeiro/tesouraria/terminal';
    protected $legendButtonSave = ['icon' => 'save', 'text' => 'Salvar'];
    protected $includeJs = ['/financeiro/javascripts/tesouraria/terminal/gerarVerificador.js'];
    protected $maxPerPage = 3;
    protected $datagridValues = [
        '_page' => 1,
        '_sort_order' => "DESC",
        '_sort_by' => 'codTerminal'
    ];

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('gerar_verificador', 'gerar-verificador/');
        $collection->add('desativar_terminal', "{$this->getRouterIdParameter()}/desativar-terminal");
        $collection->add('ativar_terminal', "{$this->getRouterIdParameter()}/ativar-terminal");
        $collection->add('fechar_terminal', "{$this->getRouterIdParameter()}/fechar-terminal");
        $collection->add('fechar_todos_terminais', "fechar-todos-terminais");
        $collection->add('reabrir_terminal', "{$this->getRouterIdParameter()}/reabrir-terminal");
    }

    public function getTemplate($name)
    {
        switch ($name) {
            case 'list':
                return 'FinanceiroBundle:Tesouraria/Terminal:base_list.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codTerminal', null, ['label' => 'label.tesouraria.terminalUsuarios.codTerminal'])
            ->add(
                'fkTesourariaUsuarioTerminais.fkSwCgm',
                'doctrine_orm_choice',
                array(
                    'label' => 'label.tesouraria.terminalUsuarios.responsavelTerminal'
                ),
                'autocomplete',
                array(
                    'route' => array(
                        'name' => 'api-search-swcgm-pessoa-fisica-numcgm-nomecgm'
                    )
                )
            )
            ->add('codVerificador', null, ['label' => 'label.tesouraria.terminalUsuarios.verificador'])
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
                'codTerminal',
                null,
                [
                    'label' => 'label.tesouraria.terminalUsuarios.codTerminal'
                ]
            )
            ->add(
                'fkTesourariaUsuarioTerminais',
                'string',
                [
                    'template' => 'FinanceiroBundle:Tesouraria/Terminal:usuarioResponsavel.html.twig',
                    'label' => 'label.tesouraria.terminalUsuarios.responsavelTerminal'
                ]
            )
        ;
        $this->addActionsGrid($listMapper);
    }

    protected function addActionsGrid(ListMapper $listMapper)
    {
        $listMapper
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'),
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                      'ativar_desativar_fechar_reabrir' => array('template' => 'FinanceiroBundle:Tesouraria/Terminal:list__action_terminal.html.twig'),
                )
            ))
        ;
    }

    public function prePersist($object)
    {
        list($repository, $date) = $this->dataAndCgm();
        $object->setTimestampTerminal($date);
        foreach ($object->getFkTesourariaUsuarioTerminais() as $usuarioTerminal) {
            $usuarioTerminal->setFkSwCgm($repository->find($usuarioTerminal->getCgmUsuario()));
            $usuarioTerminal->setFkTesourariaTerminal($object);
        }
    }

    public function preUpdate($object)
    {
        list($repository, $date) = $this->dataAndCgm();
        foreach ($object->getFkTesourariaUsuarioTerminais() as $usuarioTerminal) {
            if (empty($usuarioTerminal->getFkSwCgm())) {
                $usuarioTerminal->setFkSwCgm($repository->find($usuarioTerminal->getCgmUsuario()));
                $usuarioTerminal->setFkTesourariaTerminal($object);
                $usuarioTerminal->setTimestampUsuario($date);
            }
        }
    }

    /**
     * @return array
     */
    protected function dataAndCgm()
    {
        $repository = $this->getDoctrine()->getRepository('CoreBundle:SwCgm');
        $date = new DateTimeMicrosecondPK();
        return array($repository, $date);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $entityManager = $this->getConfigurationPool()->getContainer()->get('doctrine')->getManager();
        $repository = $entityManager->getRepository('CoreBundle:Tesouraria\Terminal');
        $ultimoTerminal =  $repository->findOneBy([], ['codTerminal' => 'DESC']);


        $fieldOptions['canAddNivel'] = [
            'mapped' => false,
            'data' => true
        ];

        $fieldOptions['codUsuarioTerminal'] = [
            'by_reference' => false,
            'label' => false
        ];

        $fieldOptions['ultimoTerminal'] = [
            'data' => $ultimoTerminal->getCodTerminal() + 1
        ];

        $fieldOptions['codVerificador'] = [
            'help'=>'<a href="javascript://Gerar codigo verificador" class="white-text blue darken-4 btn btn-success save gerar-verficador" onclick="gerarVerificador()"><i class="material-icons left">input</i>gerar</a>'
        ];
        $fieldOptions['codVerificador']['attr'] = ['readonly'=>'readonly'];
        $fieldOptions['codVerificador']['label'] = 'label.tesouraria.terminalUsuarios.verificador';

        if ($this->id($this->getSubject())) {
            $fieldOptions['ultimoTerminal']['data'] = $ultimoTerminal->getCodTerminal();
            $fieldOptions['canAddNivel']['data'] = false;
            $fieldOptions['codUsuarioTerminal']['type_options'] = [
                'delete' => false,
                'delete_options' => [
                    'type' => 'hidden'
                ],
            ];
        }

        $formMapper
            ->with('Dados para Terminal e Usuários')
                ->add(
                    'codTerminal',
                    'text',
                    [
                        'label' => 'label.tesouraria.terminalUsuarios.codTerminal',
                        'data' => $fieldOptions['ultimoTerminal']['data'],
                        'attr' => ['readonly'=>'readonly']
                    ]
                )
                ->add(
                    'codVerificador',
                    'text',
                    $fieldOptions['codVerificador']
                )
            ->end()
        ;
        $formMapper
            ->with('Usuários de Terminal de Caixa')
                ->add('fkTesourariaUsuarioTerminais', 'sonata_type_collection', $fieldOptions['codUsuarioTerminal'], [
                    'edit' => 'inline',
                    'inline' => 'table',
                    'sortable'  => 'position'
                ])
                ->add('canAddNivel', 'hidden', $fieldOptions['canAddNivel'])
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        list($codTerminal) = explode("~", $id);
        $repository = $this->getDoctrine()->getRepository('CoreBundle:Tesouraria\Terminal');
        $status = $repository->statusTerminal($codTerminal);
        $this->situacao = $status['situacao'];

        $showMapper
            ->with('label.tesouraria.terminalUsuarios.consultarTerminalUsuarios')
            ->add('codTerminal', null, ['label' => 'label.tesouraria.terminalUsuarios.codTerminal'])
            ->add('codVerificador', null, ['label' => 'label.tesouraria.terminalUsuarios.verificador'])
            ->add(
                'situacao',
                'entity',
                [
                    'template' => 'FinanceiroBundle:Tesouraria/Terminal:situacao.html.twig',
                    'label' => 'label.tesouraria.terminalUsuarios.situacao'
                ]
            )
            ->add(
                'fkTesourariaUsuarioTerminais',
                'entity',
                [
                    'label' => 'label.tesouraria.terminalUsuarios.usuarios',
                    'class' => 'CoreBundle:Tesouraria\UsuarioTerminal',
                    'associated_property' => function ($codUsuarioTerminal) {
                        return $codUsuarioTerminal->getFkSwCgm()->getNomCgm() . ($codUsuarioTerminal->getResponsavel() ? ' - Usuário Responsavel' : '') ;
                    }
                ]
            )
            ->end()
        ;
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        if (!empty($this->getForm()->getViewData())) {
            $this->getValoresParaValidacaoUsuario($errorElement, $object);
            if (empty($object->getTimestampTerminal())) {
                $this->seCodTerminalAndVerificadorExiste($errorElement, $object);
            }
        }
    }

    /**
     * Faz as validações :
     * Já existe este Nr. de Terminal cadastrado para o exercício atual!
     * Já existe Terminal cadastrado com este código verificador no exercício atual!
     * @param ErrorElement $errorElement
     * @param $object
     */
    protected function seCodTerminalAndVerificadorExiste(ErrorElement $errorElement, $object)
    {
        $repository = $this->getDoctrine()->getRepository('CoreBundle:Tesouraria\Terminal');
        $ultimoTerminal =  $repository->findOneBy(['codTerminal' => $object->getCodTerminal()]);

        if (!empty($ultimoTerminal)) {
            if ($ultimoTerminal->getCodVerificador() == $object->getCodVerificador()) {
                $error = "Já existe um código verificador para esse número de terminal.";
                $this->validateTerminal($errorElement, $error);
            }
        }

        $terminalPorCodigoVerificador =  $repository->findOneBy(['codVerificador' => $object->getCodVerificador()]);
        if (!empty($terminalPorCodigoVerificador)) {
            $date = new \DateTime();
            $ultimoTerminalTimestamp = new \DateTime($terminalPorCodigoVerificador->getTimestampTerminal());
            if ($terminalPorCodigoVerificador->getCodVerificador() == $object->getCodVerificador() &&
                $ultimoTerminalTimestamp->format('Y') == $date->format('Y')
            ) {
                $error = "Código verificador já esta cadastrado para esse exercicio.";
                $this->validateTerminal($errorElement, $error);
            }
        }
    }

    protected function getValoresParaValidacaoUsuario(ErrorElement $errorElement, $object)
    {
        $usuarios = [];
        $responsavel = [];
        foreach ($object->getFkTesourariaUsuarioTerminais() as $usuarioTerminal) {
            $usuario = $this->getDoctrine()->getRepository(SwCgm::class)->find($usuarioTerminal->getCgmUsuario());
            $usuarios[] = $usuario;
            $responsavel[] = $usuarioTerminal->getResponsavel();
        }
        $this->isUsuariosDuplicados($errorElement, $usuarios);
        $this->validaResponsavel($errorElement, $responsavel);
    }

    /**
     * Verifica se na lista de UsuarioTerminal tem cgm_usuario duplicado
     * @param ErrorElement $errorElement
     * @param $usuarios
     */
    protected function isUsuariosDuplicados(ErrorElement $errorElement, $usuarios)
    {
        if (count($usuarios) !== count(array_unique($usuarios))) {
            $error = "Não pode ter usuários duplicados para o mesmo boletim.";
            $this->validateTerminal($errorElement, $error);
        }
    }

    /**
     * verificar se tem ao menos um responsavel
     * verificar se tem apenas um responsavel
     * @param ErrorElement $errorElement
     * @param $responsavel
     */
    protected function validaResponsavel(ErrorElement $errorElement, $responsavel)
    {
        $count = count(array_filter($responsavel, function ($v) {
            return $v == true;
        }, ARRAY_FILTER_USE_BOTH));

        switch ($count) {
            case 0:
                $error = "O Terminal precisa ter um responsavel.";
                $this->validateTerminal($errorElement, $error);
                break;
            case 2:
                $error = "Apenas um usuário pode ser responsavel!";
                $this->validateTerminal($errorElement, $error);
                break;
        }
    }

    /**
     * @param ErrorElement $errorElement
     * @param $error
     */
    public function validateTerminal(ErrorElement $errorElement, $error)
    {
        $errorElement->with('codUsuarioTerminal')->addViolation($error)->end();
        $this->getRequest()->getSession()->getFlashBag()->add("error", $error);
    }
}
