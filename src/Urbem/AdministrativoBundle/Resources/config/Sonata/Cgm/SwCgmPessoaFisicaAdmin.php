<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Cgm;

use Doctrine\ORM\EntityManager;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Entity\SwCategoriaHabilitacao;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\SwCgmPessoaFisica;
use Urbem\CoreBundle\Entity\SwEscolaridade;
use Urbem\CoreBundle\Entity\SwPais;
use Urbem\CoreBundle\Entity\SwUf;
use Urbem\CoreBundle\Helper\StringHelper;
use Urbem\CoreBundle\Helper\ValidaDocumentoHelper;
use Urbem\CoreBundle\Model\SwCgmModel;

class SwCgmPessoaFisicaAdmin extends SwCgmAdmin
{
    protected $baseRouteName = 'urbem_administrativo_cgm_pessoa_fisica';
    protected $baseRoutePattern = 'administrativo/cgm/pessoa-fisica';

    protected $includeJs = [
        '/administrativo/javascripts/cgm/swcgmpessoafisica.js'
    ];

    protected $model = SwCgmModel::class;

    protected $datagridValues = [
        '_sort_order' => 'ASC',
        '_sort_by'    => 'numcgm',
    ];

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('autocomplete', 'autocomplete/');
        $collection->add('autocomplete_servidor', 'autocomplete-servidor/');
        $collection->add('recupera_endereco', 'recupera-endereco');
        $collection->add('recupera_dados', 'recupera-dados');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('fkSwCgm.nomCgm', null, ['label' => 'label.nome'])
            ->add('cpf', null, ['label' => 'label.servidor.cpf']);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        // Cuidado, não mexer em numcgm.nomCgm, pois ele esta sendo usado em ConvenioAdmin e outras paradas
        $listMapper
            ->add('numcgm', null, ['label' => 'label.cgm'])
            ->add('fkSwCgm.nomCgm', null, ['label' => 'label.nome']);

        $this->addActionsGrid($listMapper);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        /** @var SwCgmPessoaFisica $swCgmPessoaFisica */
        $swCgmPessoaFisica = $this->getSubject();

        /** @var EntityManager $entityManager */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $fieldOptions = [];
        $fieldOptions['nomCgm'] = [
            'attr'        => ['maxlength' => 200],
            'constraints' => [$this->addConstraintLength(200)],
            'label'       => 'label.nome',
            'mapped'      => false,
            'required'    => true
        ];

        $fieldOptions['cpf'] = [
            'label'    => 'label.servidor.cpf',
            'required' => true
        ];

        $fieldOptions['rg'] = [
            'label' => 'label.servidor.rg',
            'attr' => [
                'maxlength' => 15
            ]
        ];

        $fieldOptions['orgaoEmissor'] = [
            'label' => 'label.servidor.orgaoemissor'
        ];

        // UF do Órgao Emissor
        // TODO Adicionar default da Prefeitura
        $fieldOptions['fkSwUf'] = [
            'attr'     => ['class' => 'select2-parameters '],
            'choices'  => $entityManager->getRepository(SwUf::class)
                ->findBy([], ['nomUf' => 'ASC']),
            'label'    => 'label.servidor.uforgaoemissor',
            'required' => true
        ];

        $fieldOptions['dtEmissaoRg'] = [
            'format'   => 'dd/MM/yyyy',
            'label'    => 'label.servidor.dtEmissao',
            'required' => false
        ];

        // TODO Adicionar máscara 999.99999.99-9
        $fieldOptions['servidorPisPasep'] = [
            'label'    => 'label.servidor.pis',
            'required' => false
        ];

        $paisArr = $entityManager->getRepository(SwPais::class)->findBy([], ['nacionalidade' => 'ASC']);
        $paisSelecionado = null;
        foreach ($paisArr as $pais) {
            if ($pais->getCodPais() == 1) {
                $paisSelecionado = $pais;
            }
        }
        
        // Nacionalidade
        $fieldOptions['fkSwPais'] = [
            'attr'         => ['class' => 'select2-parameters '],
            'choice_label' => 'nacionalidade',
            'choices'      => $paisArr,
            'label'        => 'label.servidor.nacionalidade',
            'required'     => true,
            'data' => $paisSelecionado
        ];

        $escolaridadeArr = $entityManager->getRepository(SwEscolaridade::class)->findBy([], ['codEscolaridade' => 'ASC']);
        $escolaridadeSelecionado = null;
        foreach ($escolaridadeArr as $escolaridade) {
            if ($escolaridade->getCodEscolaridade() == 0) {
                $escolaridadeSelecionado = $escolaridade;
            }
        }
        
        $fieldOptions['fkSwEscolaridade'] = [
            'attr'         => ['class' => 'select2-parameters '],
            'choice_label' => 'descricao',
            'choices'      => $escolaridadeArr,
            'data'         => $escolaridadeSelecionado,
            'label'        => 'label.servidor.escolaridade',
            'required'     => true
        ];

        $fieldOptions['dtNascimento'] = [
            'format'   => 'dd/MM/yyyy',
            'label'    => 'label.servidor.datanascimento',
            'required' => false
        ];

        $fieldOptions['sexo'] = [
            'attr'       => ['class' => 'checkbox-sonata '],
            'choices'    => [
                'label.servidor.masculino' => 'm',
                'label.servidor.feminino'  => 'f'
            ],
            'data'       => 'm',
            'expanded'   => true,
            'label'      => 'label.servidor.sexo',
            'label_attr' => ['class' => 'checkbox-sonata'],
        ];

        // TODO Não permitir a inclusão de letras
        $fieldOptions['numCnh'] = [
            'label'    => 'label.servidor.numerocnh',
            'required' => false
        ];

        $categoriasHabilitacao = $entityManager->getRepository(SwCategoriaHabilitacao::class)->findAll();
        $categoriasHabilitacaoSelecionado = null;
        foreach ($categoriasHabilitacao as $categoria) {
            if ($categoria->getCodCategoria() == 0) {
                $categoriasHabilitacaoSelecionado = $categoria;
            }
        }
        
        $fieldOptions['fkSwCategoriaHabilitacao'] = [
            'attr'         => ['class' => 'select2-parameters '],
            'choice_label' => 'nomCategoria',
            'choices'      => $categoriasHabilitacao,
            'data'         => $categoriasHabilitacaoSelecionado,
            'label'        => 'label.servidor.categoriacnh',
            'required'     => false,
        ];

        $fieldOptions['dtValidadeCnh'] = [
            'format'   => 'dd/MM/yyyy',
            'label'    => 'label.servidor.datavalidadecnh',
            'required' => false,
        ];

        $fieldOptions['createUser'] = [
            'label' => 'label.usuario.criarUsuarioAutomaticamente',
            'mapped' => false,
            'required' => false,
            'attr' => ['class' => 'checkbox-sonata'],
            'label_attr' => ['class' => 'checkbox-sonata']
        ];

        if (!is_null($this->id($swCgmPessoaFisica))) {
            $fieldOptions['nomCgm']['data'] = $swCgmPessoaFisica->getFkSwCgm()->getNomCgm();
            $fieldOptions['fkSwEscolaridade']['data'] = $swCgmPessoaFisica->getFkSwEscolaridade();
            $fieldOptions['fkSwCategoriaHabilitacao']['data'] = $swCgmPessoaFisica->getFkSwCategoriaHabilitacao();

            $this->swCgm = $swCgmPessoaFisica->getFkSwCgm();
        }

        $formMapper->with('label.dados_cgm');
        $formMapper->add('nomCgm', 'text', $fieldOptions['nomCgm']);
        $formMapper->add('cpf', 'text', $fieldOptions['cpf']);
        $formMapper->add('rg', 'text', $fieldOptions['rg']);
        $formMapper->add('orgaoEmissor', 'text', $fieldOptions['orgaoEmissor']);
        // fkSwUf: UF do Órgao Emissor
        $formMapper->add('fkSwUf', null, $fieldOptions['fkSwUf']);
        $formMapper->add('dtEmissaoRg', 'sonata_type_date_picker', $fieldOptions['dtEmissaoRg']);
        $formMapper->add('numCnh', 'text', $fieldOptions['numCnh']);
        $formMapper->add('fkSwCategoriaHabilitacao', null, $fieldOptions['fkSwCategoriaHabilitacao']);
        $formMapper->add('dtValidadeCnh', 'sonata_type_date_picker', $fieldOptions['dtValidadeCnh']);
        $formMapper->add('servidorPisPasep', 'text', $fieldOptions['servidorPisPasep']);
        // fkSwPais: Nacionalidade
        $formMapper->add('fkSwPais', null, $fieldOptions['fkSwPais']);
        $formMapper->add('fkSwEscolaridade', null, $fieldOptions['fkSwEscolaridade']);
        $formMapper->add('dtNascimento', 'sonata_type_date_picker', $fieldOptions['dtNascimento']);
        $formMapper->add('sexo', 'choice', $fieldOptions['sexo']);

        // Criar Usuário Automaticamente
        if ($this->id($this->getSubject())) {
            /** @var SwCgm $cgm */
            $cgm = $this->getSubject();
            $usuario = $entityManager->getRepository(Usuario::class)->find($cgm->getNumcgm());
            if (!$usuario) {
                $formMapper->add('createUser', 'checkbox', $fieldOptions['createUser']);
            }
        } else {
            $formMapper->add('createUser', 'checkbox', $fieldOptions['createUser']);
        }

        $formMapper->end();

        parent::configureFormFields($formMapper);
    }

    /**
     * @param SwCgm $swCgm
     */
    private function persistNomcgm(SwCgm $swCgm)
    {
        $form = $this->getForm();

        $nomCgm = $form->get('nomCgm')->getData();
        $nomCgm = StringHelper::clearString($nomCgm);

        $swCgm->setNomCgm($nomCgm);
    }

    /**
     * @param SwCgmPessoaFisica $swCgmPessoaFisica
     *
     * @return $this
     */
    private function persistCpf(SwCgmPessoaFisica $swCgmPessoaFisica)
    {
        $form = $this->getForm();

        $cpf = $form->get('cpf')->getData();
        $cpf = StringHelper::clearString($cpf);

        $swCgmPessoaFisica->setCpf($cpf);

        return $this;
    }

    /**
     * @param SwCgmPessoaFisica $swCgmPessoaFisica
     */
    public function prePersist($swCgmPessoaFisica)
    {
        $swCgm = new SwCgm();

        $this->persistCpf($swCgmPessoaFisica);

        $this->persistNomcgm($swCgm);
        $this->prePersistSwCgm($swCgm);

        $swCgmPessoaFisica->setFkSwCgm($swCgm);
        if ($this->getForm()->get('createUser')->getData()) {
            $this->prePersistUsuario($swCgm, $swCgmPessoaFisica->getCpf());
        }
    }

    /**
     * @param SwCgmPessoaFisica $swCgmPessoaFisica
     */
    public function preUpdate($swCgmPessoaFisica)
    {
        $swCgm = $swCgmPessoaFisica->getFkSwCgm();

        $this->persistCpf($swCgmPessoaFisica);
        $this->persistNomcgm($swCgm);

        parent::preUpdateSwCgm($swCgm);
    }

    /**
     * @param SwCgmPessoaFisica $object
     */
    public function postPersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $message = sprintf('%s - %s cadastrado com sucesso.', $object->getNumcgm(), $object->getFkSwCgm()->getNomCgm());
        $container->get('session')->getFlashBag()->add('success', $message);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        /** @var SwCgmPessoaFisica $swCgmPessoaFisica */
        $swCgmPessoaFisica = $this->getSubject();

        $fieldOptions = [];
        $fieldOptions['sexo'] = [
            'choices' => [
                'm' => 'Masculino',
                'f' => 'Feminino'
            ],
            'label'   => 'label.servidor.sexo'
        ];

        $showMapper
            ->with('label.dados_cgm')
            ->add('fkSwCgm.nomCgm', null, ['label' => 'label.nome'])
            ->add('cpf', null, ['label' => 'label.servidor.cpf'])
            ->add('rg', null, ['label' => 'label.servidor.rg'])
            ->add('orgaoEmissor', null, ['label' => 'label.servidor.orgaoemissor'])
            ->add('fkSwUf.nomUf', null, ['label' => 'label.servidor.uforgaoemissor'])
            ->add('dtEmissaoRg', 'date', ['label' => 'label.servidor.dtEmissao'])
            ->add('numCnh', null, ['label' => 'label.servidor.numerocnh'])
            ->add('fkSwCategoriaHabilitacao.nomCategoria', null, ['label' => 'label.servidor.categoriacnh'])
            ->add('dtValidadeCnh', 'date', ['label' => 'label.servidor.datavalidadecnh'])
            ->add('servidorPisPasep', null, ['label' => 'label.servidor.pis'])
            ->add('fkSwPais.nacionalidade', null, ['label' => 'label.servidor.nacionalidade'])
            ->add('fkSwEscolaridade.descricao', null, ['label' => 'label.servidor.escolaridade'])
            ->add('dtNascimento', 'date', ['label' => 'label.servidor.datanascimento'])
            ->add('sexo', 'choice', $fieldOptions['sexo'])
            ->end();

        $this->swCgm = $swCgmPessoaFisica->getFkSwCgm();

        parent::configureShowFields($showMapper);
    }

    /**
     * @param SwCgmPessoaFisica $swCgmPessoaFisica
     */
    public function postRemove($swCgmPessoaFisica)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $swCgmModel = new SwCgmModel($entityManager);
        $swCgmModel->remove($swCgmPessoaFisica->getFkSwCgm());
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $servidor
     */
    public function validate(ErrorElement $errorElement, $swCgmPessoaFisica)
    {
        $form = $this->getForm();

        $cpf = $form->get('cpf')->getData();

        $cpfValido = ValidaDocumentoHelper::CPF($cpf);

        if (! $cpfValido) {
            $message = $this->trans('swPessoaFisica.error.cpf', [], 'flashes');
            $errorElement->with('cpf')->addViolation($message)->end();
        }

        $cpfDuplicado = $this->getEntityManager()->getRepository(get_class($swCgmPessoaFisica))
        ->findOneByCpf(StringHelper::clearString($cpf));

        if ($cpfDuplicado && ($swCgmPessoaFisica->getNumcgm() != $cpfDuplicado->getNumcgm())) {
            $message = $this->trans('swPessoaFisica.error.cpfDuplicado', [], 'flashes');
            $errorElement->with('cpf')->addViolation($message)->end();
        }
    }
}
