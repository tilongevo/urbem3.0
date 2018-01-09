<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Administracao;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Urbem\CoreBundle\Entity\SwCgmLogradouro;
use Urbem\CoreBundle\Model\SwCgmPessoaFisicaModel;
use Urbem\CoreBundle\Model\SwAtributoCgmModel;
use Urbem\CoreBundle\Model\SwCgmAtributoValorModel;
use Urbem\CoreBundle\Model\SwCgmModel;
use Urbem\CoreBundle\Model\Administracao\SwCgmLogradouroModel;
use Urbem\CoreBundle\Entity\SwCgmPessoaFisica;
use Urbem\CoreBundle\Entity\SwCgmAtributoValor;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class SwCgmAdmin extends AbstractSonataAdmin
{

    protected $baseRouteName = 'urbem_administrativo_cgm_manutencao';
    protected $baseRoutePattern = 'administrativo/manutencao';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nomCgm', null, array('label' => 'Nome/Razão Social'))
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('numcgm', null, array('label' => 'CGM', 'sortable' => false))
            ->add('nomCgm', null, array('label' => 'Nome/Razão Social', 'sortable' => false))
        ;

        $this->addActionsGrid($listMapper);
    }

    public function createQuery($context = 'list')
    {

        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\SwCgm');

        $swCgmModel = new SwCgmModel($em);
        $swCgm = $swCgmModel->recuperaExcetoFornecedores();

        $query = parent::createQuery($context);

        if ($swCgm) {
            $query->andWhere(
                $query->expr()->eq('o.tipoPessoa', ':param')
            );

            $query->setParameter('param', '1');
        }

        return $query;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $em = $this->modelManager->getEntityManager($this->getClass());

        $emCatHabilitacao = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\SwCategoriaHabilitacao');
        $catHabilitacaoDefault = $emCatHabilitacao->getRepository('CoreBundle:SwCategoriaHabilitacao')->findOneByCodCategoria(0);

        $emMunicipio = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\SwMunicipio');
        $municipioDefault = $emMunicipio->getRepository('CoreBundle:SwMunicipio')->findOneByCodMunicipio(0);

        $emPais = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\SwPais');
        $paisDefault = $emPais->getRepository('CoreBundle:SwPais')->findOneByCodPais(0);

        $emUf = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\SwUf');
        $ufDefault = $emUf->getRepository('CoreBundle:SwUf')->findOneByCodUf(0);


        $fieldOptions = array();
        $fieldOptions['cpf'] = array(
            'label' => 'label.servidor.cpf',
            'mapped' => false
        );
        $fieldOptions['rg'] = array(
            'label' => 'label.servidor.rg',
            'mapped' => false
        );
        $fieldOptions['orgao_emissor'] = array(
            'label' => 'label.servidor.orgaoemissor',
            'mapped' => false
        );
        $fieldOptions['cod_uf_orgao_emissor'] = array(
            'label'         => 'label.servidor.uforgaoemissor',
            'mapped'        => false,
            'class'         => 'CoreBundle:SwUf',
            'choice_label'  => 'siglaUf',
            'placeholder'   => '',
            'attr'          => [
                'class'       => 'select2-parameters'
            ]
        );
        $fieldOptions['dt_emissao_rg'] = array(
            'format'        => 'dd/MM/yyyy',
            'label'         => 'label.servidor.dtEmissao',
            'mapped'        => false,
            'required'      => false
        );
        $fieldOptions['num_cnh'] = array(
            'label'         => 'label.servidor.numerocnh',
            'mapped'        => false,
            'required'      => false
        );
        $fieldOptions['cod_categoria_cnh'] = array(
            'label'         => 'label.servidor.categoriacnh',
            'mapped'        => false,
            'required'      => false,
            'class'         => 'CoreBundle:SwCategoriaHabilitacao',
            'choice_label'  => 'nom_categoria',
            'data'          => $catHabilitacaoDefault,
            'attr'          => [
                'class'       => 'select2-parameters'
            ]
        );
        $fieldOptions['dt_validade_cnh'] = array(
            'format'        => 'dd/MM/yyyy',
            'label'         => 'label.servidor.datavalidadecnh',
            'mapped'        => false,
            'required'      => false
        );
        $fieldOptions['servidor_pis_pasep'] = array(
            'label'         => 'label.servidor.pis',
            'mapped'        => false,
            'required'      => false
        );
        $fieldOptions['cod_nacionalidade'] = array(
            'label'         => 'label.servidor.nacionalidade',
            'mapped'        => false,
            'class'         => 'CoreBundle:SwPais',
            'choice_label'  => 'nacionalidade',
            'placeholder'   => '',
            'attr'          => [
                'class'       => 'select2-parameters'
            ]
        );
        $fieldOptions['cod_escolaridade'] = array(
            'label'         => 'label.servidor.escolaridade',
            'mapped'        => false,
            'class'         => 'CoreBundle:SwEscolaridade',
            'choice_label'  => 'descricao',
            'placeholder'   => '',
            'attr'          => [
                'class'       => 'select2-parameters'
            ]
        );
        $fieldOptions['dt_nascimento'] = array(
            'format'        => 'dd/MM/yyyy',
            'label'         => 'label.servidor.datanascimento',
            'mapped'        => false,
            'required'      => false
        );
        $fieldOptions['sexo'] = array(
            'choices'       => [
                'label.servidor.masculino'    => 'm',
                'label.servidor.feminino'     => 'f'
            ],
            'label'         => 'label.servidor.sexo',
            'mapped'        => false,
            'attr'          => [
                'class'         => 'select2-parameters'
            ]
        );

        if ($this->getSubject()) {
            if ($this->id($this->getSubject())) {
                $cgmPessoaFisica = (new \Urbem\CoreBundle\Model\SwCgmPessoaFisicaModel($em))
                                    ->getNumCgmByNumCgm($id);

                $fieldOptions['cpf']['data'] = $cgmPessoaFisica->getCpf();
                $fieldOptions['rg']['data'] = $cgmPessoaFisica->getRg();
                $fieldOptions['orgao_emissor']['data'] = $cgmPessoaFisica->getOrgaoEmissor();
                $fieldOptions['cod_uf_orgao_emissor']['data'] = $cgmPessoaFisica->getCodUfOrgaoEmissor();
                $fieldOptions['dt_emissao_rg']['data'] = $cgmPessoaFisica->getDtEmissaoRg();
                $fieldOptions['num_cnh']['data'] = $cgmPessoaFisica->getNumCnh();
                $fieldOptions['cod_categoria_cnh']['data'] = $cgmPessoaFisica->getCodCategoriaCnh();
                $fieldOptions['dt_validade_cnh']['data'] = $cgmPessoaFisica->getDtValidadeCnh();
                $fieldOptions['servidor_pis_pasep']['data'] = $cgmPessoaFisica->getServidorPisPasep();
                $fieldOptions['cod_nacionalidade']['data'] = $cgmPessoaFisica->getCodNacionalidade();
                $fieldOptions['cod_escolaridade']['data'] = $cgmPessoaFisica->getCodEscolaridade();
                $fieldOptions['dt_nascimento']['data'] = $cgmPessoaFisica->getDtNascimento();
                $fieldOptions['sexo']['data'] = $cgmPessoaFisica->getSexo();
            }
        }

        $formMapper
            ->with('label.dados_cgm')
            ->add('nomCgm', null, ['label'                    => 'label.nome'])
            ->add('cpf', 'text', $fieldOptions['cpf'])
            ->add('rg', 'text', $fieldOptions['rg'])
            ->add('orgao_emissor', 'text', $fieldOptions['orgao_emissor'])
            ->add('cod_uf_orgao_emissor', 'entity', $fieldOptions['cod_uf_orgao_emissor'])
            ->add('dt_emissao_rg', 'sonata_type_date_picker', $fieldOptions['dt_emissao_rg'])
            ->add('num_cnh', 'text', $fieldOptions['num_cnh'])
            ->add('cod_categoria_cnh', 'entity', $fieldOptions['cod_categoria_cnh'])
            ->add('dt_validade_cnh', 'sonata_type_date_picker', $fieldOptions['dt_validade_cnh'])
            ->add('servidor_pis_pasep', 'text', $fieldOptions['servidor_pis_pasep'])
            ->add('cod_nacionalidade', 'entity', $fieldOptions['cod_nacionalidade'])
            ->add('cod_escolaridade', 'entity', $fieldOptions['cod_escolaridade'])
            ->add('dt_nascimento', 'sonata_type_date_picker', $fieldOptions['dt_nascimento'])
            ->add('sexo', 'choice', $fieldOptions['sexo'])
            ->end()

            ->with('label.dados_endereco')
            ->add('codPais', null, ['label'          => 'label.pais', 'attr' => array('class' => 'select2-parameters'), 'data' => $paisDefault])
            ->add('codUf', null, ['label'            => 'label.swBairro.codUf', 'attr' => array('class' => 'select2-parameters'), 'data' => $ufDefault])
            ->add('codMunicipio', null, ['label'     => 'label.cidade', 'attr' => array('class' => 'select2-parameters'), 'data' => $municipioDefault])
            ->add('logradouro', null, ['label'       => 'label.logradouro'])
            ->add('numero', null, ['label'           => 'label.numero'])
            ->add('complemento', null, ['label'      => 'label.complemento'])
            ->add('bairro', null, ['label'           => 'label.servidor.bairro'])
            ->add('cep', null, ['label'              => 'label.servidor.cep'])
            ->add('foneResidencial', null, ['label'  => 'label.telefone_residencial'])
            ->add('ramalResidencial', null, ['label' => 'label.ramal'])
            ->add('foneComercial', null, ['label'    => 'label.telefone_comercial'])
            ->add('ramalComercial', null, ['label'   => 'label.ramal'])
            ->add('foneCelular', null, ['label'      => 'label.telefone_celular'])
            ->add('eMail', null, ['label'            => 'label.usuario.email'])
            ->add('eMailAdcional', null, ['label'    => 'label.email_adicional'])
            ->add('site', null, ['label'             => 'label.site'])
            ->add('tipoPessoa', 'hidden', ['attr' => array("hidden" => true), 'data' => '1'])
            ->end()

            ->with('label.dados_endereco_correspondencia')
            ->add('codPaisCorresp', null, ['label'      => 'label.pais', 'attr' => array('class' => 'select2-parameters'), 'data' => $paisDefault])
            ->add('codUfCorresp', null, ['label'        => 'label.swBairro.codUf', 'attr' => array('class' => 'select2-parameters'), 'data' => $ufDefault])
            ->add('codMunicipioCorresp', null, ['label' => 'label.cidade', 'attr' => array('class' => 'select2-parameters'), 'data' => $municipioDefault])
            ->add('logradouroCorresp', null, ['label'   => 'label.logradouro'])
            ->add('numeroCorresp', null, ['label'       => 'label.numero'])
            ->add('complementoCorresp', null, ['label'  => 'label.complemento'])
            ->add('bairroCorresp', null, ['label'       => 'label.servidor.bairro'])
            ->add('cepCorresp', null, ['label'          => 'label.servidor.cep'])
            ->end()
        ;

        $cgmAtributoCollection = (new \Urbem\CoreBundle\Model\SwAtributoCgmModel($em))->getAll();
        $formMapper->with('label.servidor.atributos');
        foreach($cgmAtributoCollection as $cgmAtributo){
            $fieldOptionsAtributo = array(
                'label'         => $cgmAtributo->getNomAtributo(),
                'mapped'        => false,
                'required'      => false
            );

            switch ($cgmAtributo->getTipo()) {
                case 't':
                    $fieldType = 'text';
                    break;
                case 'n':
                    $fieldType = 'number';
                    break;
                case 'l':
                    $fieldType = 'choice';
                    $fieldOptionsAtributo['attr'] = array('class' => 'select2-parameters');
                    $fieldOptionsAtributo['choices'] = array();
                    $options = explode("\r\n", $cgmAtributo->getValorPadrao());
                    foreach($options as $option){
                        $fieldOptionsAtributo['choices'][$option] = $option;
                    }
                    break;
                default:
                    $fieldType = 'text';
                    break;
            }

            if ($this->getSubject()) {
                if ($this->id($this->getSubject())) {
                    $cgmAtributoValor = (new \Urbem\CoreBundle\Model\SwCgmAtributoValorModel($em))->getValorAtributo($id, $cgmAtributo);
                    $fieldOptionsAtributo['data'] = ($cgmAtributoValor ? $cgmAtributoValor[0]['valor'] : $cgmAtributo->getValorPadrao());
                }
            }

            $formMapper->add('cgmAtributo' . $cgmAtributo->getCodAtributo(), $fieldType, $fieldOptionsAtributo);
        }
        $formMapper->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $em = $this->modelManager->getEntityManager($this->getClass());
        $cgmPessoaFisica = (new \Urbem\CoreBundle\Model\SwCgmPessoaFisicaModel($em))
                            ->getNumCgmByNumCgm($id);

        $fieldOptions = array();
        $fieldOptions['cpf'] = array(
            'label' => 'label.servidor.cpf',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
            'data' => $cgmPessoaFisica->getCpf()
        );
        $fieldOptions['rg'] = array(
            'label' => 'label.servidor.rg',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
            'data' => $cgmPessoaFisica->getRg()
        );
        $fieldOptions['orgao_emissor'] = array(
            'label' => 'label.servidor.orgaoemissor',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
            'data' => $cgmPessoaFisica->getOrgaoEmissor()
        );
        $fieldOptions['cod_uf_orgao_emissor'] = array(
            'label' => 'label.servidor.uforgaoemissor',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
            'data' => $cgmPessoaFisica->getCodUfOrgaoEmissor()
        );
        $fieldOptions['dt_emissao_rg'] = array(
            'label' => 'label.servidor.dtEmissao',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
            'data' => ($cgmPessoaFisica->getDtEmissaoRg() ? $cgmPessoaFisica->getDtEmissaoRg()->format('d/m/Y') : "")
        );
        $fieldOptions['num_cnh'] = array(
            'label' => 'label.servidor.numerocnh',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
            'data' => $cgmPessoaFisica->getNumCnh()
        );
        $fieldOptions['cod_categoria_cnh'] = array(
            'label' => 'label.servidor.categoriacnh',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
            'data' => $cgmPessoaFisica->getCodCategoriaCnh()
        );
        $fieldOptions['dt_validade_cnh'] = array(
            'label' => 'label.servidor.datavalidadecnh',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
            'data' => ($cgmPessoaFisica->getDtValidadeCnh() ? $cgmPessoaFisica->getDtValidadeCnh()->format('d/m/Y') : "")
        );
        $fieldOptions['servidor_pis_pasep'] = array(
            'label' => 'label.servidor.pis',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
            'data' => $cgmPessoaFisica->getServidorPisPasep()
        );
        $fieldOptions['cod_nacionalidade'] = array(
            'label' => 'label.servidor.nacionalidade',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
            'data' => $cgmPessoaFisica->getCodNacionalidade()
        );
        $fieldOptions['cod_escolaridade'] = array(
            'label' => 'label.servidor.escolaridade',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
            'data' => $cgmPessoaFisica->getCodEscolaridade()
        );
        $fieldOptions['dt_nascimento'] = array(
            'label' => 'label.servidor.datanascimento',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
            'data' => ($cgmPessoaFisica->getDtNascimento() ? $cgmPessoaFisica->getDtNascimento()->format('d/m/Y') : "")
        );
        $fieldOptions['sexo'] = array(
            'label' => 'label.servidor.sexo',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
            'data' => $cgmPessoaFisica->getSexo()
        );


        $showMapper
            ->add('nomCgm', null, ['label'           => 'label.nome'])
            ->add('cpf', 'text', $fieldOptions['cpf'])
            ->add('rg', 'text', $fieldOptions['rg'])
            ->add('orgao_emissor', 'text', $fieldOptions['orgao_emissor'])
            ->add('cod_uf_orgao_emissor', 'text', $fieldOptions['cod_uf_orgao_emissor'])
            ->add('dt_emissao_rg', 'text', $fieldOptions['dt_emissao_rg'])
            ->add('num_cnh', 'text', $fieldOptions['num_cnh'])
            ->add('cod_categoria_cnh', 'text', $fieldOptions['cod_categoria_cnh'])
            ->add('dt_validade_cnh', 'text', $fieldOptions['dt_validade_cnh'])
            ->add('servidor_pis_pasep', 'text', $fieldOptions['servidor_pis_pasep'])
            ->add('cod_nacionalidade', 'text', $fieldOptions['cod_nacionalidade'])
            ->add('cod_escolaridade', 'text', $fieldOptions['cod_escolaridade'])
            ->add('dt_nascimento', 'text', $fieldOptions['dt_nascimento'])
            ->add('sexo', 'text', $fieldOptions['sexo'])

            ->add('codPais', null, ['label'          => 'label.pais'])
            ->add('codUf', null, ['label'            => 'label.swBairro.codUf'])
            ->add('codMunicipio', null, ['label'     => 'label.cidade'])
            ->add('logradouro', null, ['label'       => 'label.logradouro'])
            ->add('numero', null, ['label'           => 'label.numero'])
            ->add('complemento', null, ['label'      => 'label.complemento'])
            ->add('bairro', null, ['label'           => 'label.servidor.bairro'])
            ->add('cep', null, ['label'              => 'label.servidor.cep'])
            ->add('foneResidencial', null, ['label'  => 'label.telefone_residencial'])
            ->add('ramalResidencial', null, ['label' => 'label.ramal'])
            ->add('foneComercial', null, ['label'    => 'label.telefone_comercial'])
            ->add('ramalComercial', null, ['label'   => 'label.ramal'])
            ->add('foneCelular', null, ['label'      => 'label.telefone_celular'])
            ->add('eMail', null, ['label'            => 'label.usuario.email'])
            ->add('eMailAdcional', null, ['label'    => 'label.email_adicional'])
            ->add('site', null, ['label'             => 'label.site'])

            ->add('codPaisCorresp', null, ['label'      => 'label.pais'])
            ->add('codUfCorresp', null, ['label'        => 'label.swBairro.codUf'])
            ->add('codMunicipioCorresp', null, ['label' => 'label.cidade'])
            ->add('logradouroCorresp', null, ['label'   => 'label.logradouro'])
            ->add('numeroCorresp', null, ['label'       => 'label.numero'])
            ->add('complementoCorresp', null, ['label'  => 'label.complemento'])
            ->add('bairroCorresp', null, ['label'       => 'label.servidor.bairro'])
            ->add('cepCorresp', null, ['label'          => 'label.servidor.cep'])
        ;

        $cgmAtributoCollection = (new \Urbem\CoreBundle\Model\SwAtributoCgmModel($em))->getAll();
        foreach($cgmAtributoCollection as $cgmAtributo){
            $cgmAtributoValor = (new \Urbem\CoreBundle\Model\SwCgmAtributoValorModel($em))->getValorAtributo($id, $cgmAtributo);
            $fieldOptionsAtributo = array(
                'label'         => $cgmAtributo->getNomAtributo(),
                'template'      => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
                'data'          => (empty($cgmAtributoValor) ? $cgmAtributo->getValorPadrao() : $cgmAtributoValor[0]['valor'])
            );

            $showMapper->add('cgmAtributo' . $cgmAtributo->getCodAtributo(), 'text', $fieldOptionsAtributo);
        }
    }

    public function prePersist($object)
    {
        /* @TODO Aguardando a questão de permissões por rota estar resolvida  */
        $object->setCodResponsavel(1);
    }

    public function postPersist($object)
    {


        $emLogradouro = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\SwCgmLogradouro');
        $logradouro_model = new SwCgmLogradouroModel($emLogradouro);

        $emBairro = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\SwBairro');
        $bairro = $emBairro->getRepository("CoreBundle:SwBairro")->createQueryBuilder('b')
                              ->where('LOWER(b.nomBairro) LIKE :bairro')
                              ->andWhere('b.codUf = :cod_uf')
                              ->andWhere('b.codMunicipio = :cod_municipio')
                              ->setParameter('bairro', '%' . strtolower($object->getBairro()) . '%')
                              ->setParameter('cod_uf', $object->getCodUf())
                              ->setParameter('cod_municipio', $object->getCodMunicipio())
                              ->getQuery()
                              ->getResult();

        $codBairro = 0;
        if(!empty($bairro)){
            $codBairro = $bairro[0]->getCodBairro();
        }

        $logradouro = new SwCgmLogradouro();
        $logradouro->setCep($object->getCep());
        $logradouro->setCodBairro($codBairro);
        $logradouro->setCodMunicipio($object->getCodMunicipio()->getCodMunicipio());
        $logradouro->setCodUf($object->getCodUf()->getCodUf());
        $logradouro->setNumcgm($object);

        $logradouro_model->save($logradouro);


        $emPessoaFisica = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\SwCgmPessoaFisica');
        $pessoa_fisica_model = new SwCgmPessoaFisicaModel($emPessoaFisica);

        $pessoa_fisica = new SwCgmPessoaFisica();
        $pessoa_fisica->setCpf($this->getForm()->get('cpf')->getData());
        $pessoa_fisica->setRg($this->getForm()->get('rg')->getData());
        $pessoa_fisica->setOrgaoEmissor($this->getForm()->get('orgao_emissor')->getData());
        $pessoa_fisica->setCodUfOrgaoEmissor($this->getForm()->get('cod_uf_orgao_emissor')->getData());
        $pessoa_fisica->setDtEmissaoRg($this->getForm()->get('dt_emissao_rg')->getData());
        $pessoa_fisica->setNumCnh($this->getForm()->get('num_cnh')->getData());
        $pessoa_fisica->setCodCategoriaCnh($this->getForm()->get('cod_categoria_cnh')->getData());
        $pessoa_fisica->setDtValidadeCnh($this->getForm()->get('dt_validade_cnh')->getData());
        $pessoa_fisica->setServidorPisPasep($this->getForm()->get('servidor_pis_pasep')->getData());
        $pessoa_fisica->setCodNacionalidade($this->getForm()->get('cod_nacionalidade')->getData());
        $pessoa_fisica->setCodEscolaridade($this->getForm()->get('cod_escolaridade')->getData());
        $pessoa_fisica->setDtNascimento($this->getForm()->get('dt_nascimento')->getData());
        $pessoa_fisica->setSexo($this->getForm()->get('sexo')->getData());
        $pessoa_fisica->setNomPai('');
        $pessoa_fisica->setNomMae('');
        $pessoa_fisica->setNumcgm($object);

        $pessoa_fisica_model->save($pessoa_fisica);


        $emCgmAtributo = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\SwAtributoCgm');
        $cgmAtributoModel = new SwAtributoCgmModel($emCgmAtributo);
        $cgmAtributoCollection = $cgmAtributoModel->getAll();
        foreach($cgmAtributoCollection as $cgmAtributo){
            $cgmAtributoValor = new SwCgmAtributoValor();
            $cgmAtributoValor->setNumcgm($object->getNumcgm());
            $cgmAtributoValor->setCodAtributo($cgmAtributo->getCodAtributo());
            $cgmAtributoValor->setValor($this->getForm()->get('cgmAtributo' . $cgmAtributo->getCodAtributo())->getData());

            $cgmAtributoModel->save($cgmAtributoValor);
        }
    }


    public function postUpdate($object)
    {
        $emLogradouro = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\SwCgmLogradouro');
        $logradouro_model = new SwCgmLogradouroModel($emLogradouro);
        $logradouro = $logradouro_model->findOneBynumcgm($object->getNumCgm());

        $emBairro = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\SwBairro');
        $bairro = $emBairro->getRepository("CoreBundle:SwBairro")->createQueryBuilder('b')
                              ->where('LOWER(b.nomBairro) LIKE :bairro')
                              ->andWhere('b.codUf = :cod_uf')
                              ->andWhere('b.codMunicipio = :cod_municipio')
                              ->setParameter('bairro', '%' . strtolower($object->getBairro()) . '%')
                              ->setParameter('cod_uf', $object->getCodUf())
                              ->setParameter('cod_municipio', $object->getCodMunicipio())
                              ->getQuery()
                              ->getResult();

        $codBairro = 0;
        if(!empty($bairro)){
            $codBairro = $bairro[0]->getCodBairro();
        }
        if(is_null($logradouro)){
            $logradouro = new SwCgmLogradouro();
        }

        $logradouro->setCep($object->getCep());
        $logradouro->setCodBairro($codBairro);
        $logradouro->setCodMunicipio($object->getCodMunicipio()->getCodMunicipio());
        $logradouro->setCodUf($object->getCodUf()->getCodUf());
        $logradouro->setNumcgm($object);

        $logradouro_model->save($logradouro);


        $emPessoaFisica = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\SwCgmPessoaFisica');
        $pessoa_fisica_model = new SwCgmPessoaFisicaModel($emPessoaFisica);
        $pessoa_fisica = (new \Urbem\CoreBundle\Model\SwCgmPessoaFisicaModel($emPessoaFisica))
                            ->getNumCgmByNumCgm($object->getNumcgm());

        $pessoa_fisica->setCpf($this->getForm()->get('cpf')->getData());
        $pessoa_fisica->setRg($this->getForm()->get('rg')->getData());
        $pessoa_fisica->setOrgaoEmissor($this->getForm()->get('orgao_emissor')->getData());
        $pessoa_fisica->setCodUfOrgaoEmissor($this->getForm()->get('cod_uf_orgao_emissor')->getData());
        $pessoa_fisica->setDtEmissaoRg($this->getForm()->get('dt_emissao_rg')->getData());
        $pessoa_fisica->setNumCnh($this->getForm()->get('num_cnh')->getData());
        $pessoa_fisica->setCodCategoriaCnh($this->getForm()->get('cod_categoria_cnh')->getData());
        $pessoa_fisica->setDtValidadeCnh($this->getForm()->get('dt_validade_cnh')->getData());
        $pessoa_fisica->setServidorPisPasep($this->getForm()->get('servidor_pis_pasep')->getData());
        $pessoa_fisica->setCodNacionalidade($this->getForm()->get('cod_nacionalidade')->getData());
        $pessoa_fisica->setCodEscolaridade($this->getForm()->get('cod_escolaridade')->getData());
        $pessoa_fisica->setDtNascimento($this->getForm()->get('dt_nascimento')->getData());
        $pessoa_fisica->setSexo($this->getForm()->get('sexo')->getData());
        $pessoa_fisica->setNomPai('');
        $pessoa_fisica->setNomMae('');

        $pessoa_fisica_model->save($pessoa_fisica);


        $emCgmAtributo = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\SwAtributoCgm');
        $cgmAtributoModel = new SwAtributoCgmModel($emCgmAtributo);
        $em = $this->modelManager->getEntityManager($this->getClass());
        $cgmAtributoValorCollection = (new \Urbem\CoreBundle\Model\SwCgmAtributoValorModel($em))->getNumCgm($object->getNumcgm());
        foreach($cgmAtributoValorCollection as $cgmAtributoValor){
            $cgmAtributoValor->setValor($this->getForm()->get('cgmAtributo' . $cgmAtributoValor->getCodAtributo())->getData());

            $cgmAtributoModel->save($cgmAtributoValor);
        }
    }


    public function preRemove($object)
    {
        $emLogradouro = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\SwCgmLogradouro');
        $logradouro_model = new SwCgmLogradouroModel($emLogradouro);
        $logradouro = $logradouro_model->findOneBynumcgm($object->getNumCgm());
        $emLogradouro->remove($logradouro);

        $emPessoaFisica = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\SwCgmPessoaFisica');
        $pessoa_fisica_model = new SwCgmPessoaFisicaModel($emPessoaFisica);
        $pessoa_fisica = $pessoa_fisica_model->getNumCgmByNumCgm($object->getNumcgm());
        $emPessoaFisica->remove($pessoa_fisica);

        $emAtributoValor = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\SwCgmAtributoValor');
        $atributo_valor_model = new SwCgmAtributoValorModel($emAtributoValor);
        $cgmAtributoValorCollection = $atributo_valor_model->getNumCgm($object->getNumcgm());
        foreach($cgmAtributoValorCollection as $cgmAtributoValor){
            $emAtributoValor->remove($cgmAtributoValor);
        }
    }
}
