<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Administracao;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Urbem\CoreBundle\Model\SwCgmModel;
use Urbem\CoreBundle\Model\Administracao\SwCgmLogradouroModel;
use Urbem\CoreBundle\Entity\SwCgmLogradouro;
use Urbem\CoreBundle\Model\SwCgmPessoaJuridicaModel;
use Urbem\CoreBundle\Model\SwAtributoCgmModel;
use Urbem\CoreBundle\Model\SwCgmAtributoValorModel;
use Urbem\CoreBundle\Entity\SwCgmPessoaJuridica;
use Urbem\CoreBundle\Entity\SwCgmAtributoValor;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class SwCgmAdminPj extends AbstractSonataAdmin
{

    protected $baseRouteName = 'urbem_administrativo_cgm_manutencao_pj';
    protected $baseRoutePattern = 'administrativo/manutencaoPj';

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

            $query->setParameter('param', '2');
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

        $emOrgaoRegistro = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Administracao\OrgaoRegistro');
        $orgaoRegistroDefault = $emOrgaoRegistro->getRepository('CoreBundle:Administracao\OrgaoRegistro')->findOneByCodigo(0);


        $fieldOptions = array();
        $fieldOptions['nom_fantasia'] = array(
            'label'         => 'label.servidor.nomfantasia',
            'mapped'        => false
        );
        $fieldOptions['cnpj'] = array(
            'label'         => 'label.servidor.cnpj',
            'mapped'        => false
        );
        $fieldOptions['insc_estadual'] = array(
            'label'         => 'label.servidor.inscestadual',
            'mapped'        => false,
            'required'      => false
        );
        $fieldOptions['cod_orgao_registro'] = array(
            'label'         => 'label.servidor.orgaoregistro',
            'mapped'        => false,
            'required'      => false,
            'class'         => 'CoreBundle:Administracao\OrgaoRegistro',
            'choice_label'  => 'descricao',
            'data'          => $orgaoRegistroDefault,
            'attr'          => [
                'class'         => 'select2-parameters'
            ]
        );
        $fieldOptions['num_registro'] = array(
            'label'         => 'label.servidor.numregistro',
            'mapped'        => false,
            'required'      => false
        );
        $fieldOptions['dt_registro'] = array(
            'format'        => 'dd/MM/yyyy',
            'label'         => 'label.servidor.dtregistro',
            'mapped'        => false,
            'required'      => false
        );
        $fieldOptions['num_registro_cvm'] = array(
            'label'         => 'label.servidor.numregistrocvm',
            'mapped'        => false,
            'required'      => false
        );
        $fieldOptions['dt_registro_cvm'] = array(
            'format'        => 'dd/MM/yyyy',
            'label'         => 'label.servidor.dtregistrocvm',
            'mapped'        => false,
            'required'      => false
        );
        $fieldOptions['objeto_social'] = array(
            'label'         => 'label.servidor.objetosocial',
            'mapped'        => false,
            'required'      => false
        );

        if ($this->getSubject()) {
            if ($this->id($this->getSubject())) {
                $cgmPessoaJuridica = (new \Urbem\CoreBundle\Model\SwCgmPessoaJuridicaModel($em))
                                    ->getNumCgmByNumCgm($id);

                $fieldOptions['nom_fantasia']['data'] = $cgmPessoaJuridica->getNomFantasia();
                $fieldOptions['cnpj']['data'] = $cgmPessoaJuridica->getCnpj();
                $fieldOptions['insc_estadual']['data'] = $cgmPessoaJuridica->getInscEstadual();
                $fieldOptions['cod_orgao_registro']['data'] = $cgmPessoaJuridica->getCodOrgaoRegistro();
                $fieldOptions['num_registro']['data'] = $cgmPessoaJuridica->getNumRegistro();
                $fieldOptions['dt_registro']['data'] = $cgmPessoaJuridica->getDtRegistro();
                $fieldOptions['num_registro_cvm']['data'] = $cgmPessoaJuridica->getNumRegistroCvm();
                $fieldOptions['dt_registro_cvm']['data'] = $cgmPessoaJuridica->getDtRegistroCvm();
                $fieldOptions['objeto_social']['data'] = $cgmPessoaJuridica->getObjetoSocial();
            }
        }

        $formMapper
            ->with('label.dados_cgm')
            ->add('nomCgm', null, ['label'                    => 'label.nome'])
            ->add('nom_fantasia', 'text', $fieldOptions['nom_fantasia'])
            ->add('cnpj', 'text', $fieldOptions['cnpj'])
            ->add('insc_estadual', 'text', $fieldOptions['insc_estadual'])
            ->add('cod_orgao_registro', 'entity', $fieldOptions['cod_orgao_registro'])
            ->add('num_registro', 'text', $fieldOptions['num_registro'])
            ->add('dt_registro', 'sonata_type_date_picker', $fieldOptions['dt_registro'])
            ->add('num_registro_cvm', 'text', $fieldOptions['num_registro_cvm'])
            ->add('dt_registro_cvm', 'sonata_type_date_picker', $fieldOptions['dt_registro_cvm'])
            ->add('objeto_social', 'textarea', $fieldOptions['objeto_social'])
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
            ->add('tipoPessoa', 'hidden', ['attr' => array("hidden" => true), 'data' => '2'])
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
        $cgmPessoaJuridica = (new \Urbem\CoreBundle\Model\SwCgmPessoaJuridicaModel($em))
                            ->getNumCgmByNumCgm($id);

        $fieldOptions = array();
        $fieldOptions['nom_fantasia'] = array(
            'label' => 'label.servidor.nomfantasia',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
            'data' => $cgmPessoaJuridica->getNomFantasia()
        );
        $fieldOptions['cnpj'] = array(
            'label' => 'label.servidor.cnpj',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
            'data' => $cgmPessoaJuridica->getCnpj()
        );
        $fieldOptions['insc_estadual'] = array(
            'label' => 'label.servidor.inscestadual',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
            'data' => $cgmPessoaJuridica->getInscEstadual()
        );
        $fieldOptions['cod_orgao_registro'] = array(
            'label' => 'label.servidor.orgaoregistro',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
            'data' => $cgmPessoaJuridica->getCodOrgaoRegistro()
        );
        $fieldOptions['num_registro'] = array(
            'label' => 'label.servidor.numregistro',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
            'data' => $cgmPessoaJuridica->getNumRegistro()
        );
        $fieldOptions['dt_registro'] = array(
            'label' => 'label.servidor.dtregistro',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
            'data' => ($cgmPessoaJuridica->getDtRegistro() ? $cgmPessoaJuridica->getDtRegistro()->format('d/m/Y') : "")
        );
        $fieldOptions['num_registro_cvm'] = array(
            'label' => 'label.servidor.numregistrocvm',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
            'data' => $cgmPessoaJuridica->getNumRegistroCvm()
        );
        $fieldOptions['dt_registro_cvm'] = array(
            'label' => 'label.servidor.dtregistrocvm',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
            'data' => ($cgmPessoaJuridica->getDtRegistroCvm() ? $cgmPessoaJuridica->getDtRegistroCvm()->format('d/m/Y') : "")
        );
        $fieldOptions['objeto_social'] = array(
            'label' => 'label.servidor.objetosocial',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
            'data' => $cgmPessoaJuridica->getObjetoSocial()
        );


        $showMapper
            ->add('nomCgm', null, ['label'           => 'label.nome'])
            ->add('nom_fantasia', 'text', $fieldOptions['nom_fantasia'])
            ->add('cnpj', 'text', $fieldOptions['cnpj'])
            ->add('insc_estadual', 'text', $fieldOptions['insc_estadual'])
            ->add('cod_orgao_registro', 'text', $fieldOptions['cod_orgao_registro'])
            ->add('num_registro', 'text', $fieldOptions['num_registro'])
            ->add('dt_registro', 'text', $fieldOptions['dt_registro'])
            ->add('num_registro_cvm', 'text', $fieldOptions['num_registro_cvm'])
            ->add('dt_registro_cvm', 'text', $fieldOptions['dt_registro_cvm'])
            ->add('objeto_social', 'text', $fieldOptions['objeto_social'])

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


        $emPessoaJuridica = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\SwCgmPessoaJuridica');
        $pessoa_juridica_model = new SwCgmPessoaJuridicaModel($emPessoaJuridica);

        $pessoa_juridica = new SwCgmPessoaJuridica();
        $pessoa_juridica->setNomFantasia($this->getForm()->get('nom_fantasia')->getData());
        $pessoa_juridica->setCnpj($this->getForm()->get('cnpj')->getData());
        $pessoa_juridica->setInscEstadual($this->getForm()->get('insc_estadual')->getData());
        $pessoa_juridica->setCodOrgaoRegistro($this->getForm()->get('cod_orgao_registro')->getData());
        $pessoa_juridica->setNumRegistro($this->getForm()->get('num_registro')->getData());
        $pessoa_juridica->setDtRegistro($this->getForm()->get('dt_registro')->getData());
        $pessoa_juridica->setNumRegistroCvm($this->getForm()->get('num_registro_cvm')->getData());
        $pessoa_juridica->setDtRegistroCvm($this->getForm()->get('dt_registro_cvm')->getData());
        $pessoa_juridica->setObjetoSocial($this->getForm()->get('objeto_social')->getData());
        $pessoa_juridica->setNumcgm($object);

        $pessoa_juridica_model->save($pessoa_juridica);


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


        $emPessoaJuridica = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\SwCgmPessoaJuridica');
        $pessoa_juridica_model = new SwCgmPessoaJuridicaModel($emPessoaJuridica);
        $pessoa_juridica = (new \Urbem\CoreBundle\Model\SwCgmPessoaJuridicaModel($emPessoaJuridica))
                            ->getNumCgmByNumCgm($object->getNumcgm());

        $pessoa_juridica->setNomFantasia($this->getForm()->get('nom_fantasia')->getData());
        $pessoa_juridica->setCnpj($this->getForm()->get('cnpj')->getData());
        $pessoa_juridica->setInscEstadual($this->getForm()->get('insc_estadual')->getData());
        $pessoa_juridica->setCodOrgaoRegistro($this->getForm()->get('cod_orgao_registro')->getData());
        $pessoa_juridica->setNumRegistro($this->getForm()->get('num_registro')->getData());
        $pessoa_juridica->setDtRegistro($this->getForm()->get('dt_registro')->getData());
        $pessoa_juridica->setNumRegistroCvm($this->getForm()->get('num_registro_cvm')->getData());
        $pessoa_juridica->setDtRegistroCvm($this->getForm()->get('dt_registro_cvm')->getData());
        $pessoa_juridica->setObjetoSocial($this->getForm()->get('objeto_social')->getData());

        $pessoa_juridica_model->save($pessoa_juridica);


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

        $emPessoaJuridica = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\SwCgmPessoaJuridica');
        $pessoa_juridica_model = new SwCgmPessoaJuridicaModel($emPessoaJuridica);
        $pessoa_juridica = $pessoa_juridica_model->getNumCgmByNumCgm($object->getNumcgm());
        $emPessoaJuridica->remove($pessoa_juridica);

        $emAtributoValor = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\SwCgmAtributoValor');
        $atributo_valor_model = new SwCgmAtributoValorModel($emAtributoValor);
        $cgmAtributoValorCollection = $atributo_valor_model->getNumCgm($object->getNumcgm());
        foreach($cgmAtributoValorCollection as $cgmAtributoValor){
            $emAtributoValor->remove($cgmAtributoValor);
        }
    }
}
