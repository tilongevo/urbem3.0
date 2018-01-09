<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLla;
use Urbem\CoreBundle\Model\Administracao\AtributoDinamicoModel;
use Urbem\CoreBundle\Model\Administracao\CadastroModel;
use Urbem\CoreBundle\Model\Administracao\ModuloModel;
use Urbem\CoreBundle\Model\Folhapagamento\ConfiguracaoEmpenhoLlaAtributoValorModel;
use Urbem\CoreBundle\Model\Folhapagamento\ConfiguracaoEmpenhoLlaLocalModel;
use Urbem\CoreBundle\Model\Folhapagamento\ConfiguracaoEmpenhoLlaLotacaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ConfigEmpenhoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_config_empenho';

    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/configuracao/configuracao-autorizacao-empenho';

    const MODULO_PESSOAL = 'Pessoal';

    const CADASTRO_SERVIDOR = 'Cadastro de servidor';

    protected $linkAdminCustom = '/recursos-humanos/folha-pagamento/configuracao/empenho/list?id=';

    protected $keyLinkAdminCustom = 'codConfigEmpenho';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'vigencia',
                'doctrine_orm_datetime',
                [
                    'field_type' => 'sonata_type_datetime_picker',
                    'field_options' => [
                        'format' => 'dd/MM/yyyy'
                    ],
                    'label' => 'label.vigencia'
                ]
            );
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('vigencia');

        $listMapper
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                    'edit' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'),
                    'delete' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'),
                    'admin' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_admin.html.twig'),
                )
            ))
        ;
    }


    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $tipoOpcao = $this->getSubject()->getTipoOpcao();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $now = new \DateTime();

        $atributosDinamicos = $this->getAtributos();

        $formMapper
            ->tab('label.configuracaoEmpenho.dadosAutorizacao')
            ->with('label.configuracaoEmpenho.vigenciaConfiguracao')
            ->add(
                'vigencia',
                'sonata_type_date_picker',
                [
                    'dp_default_date' => $now->format('d/m/Y'),
                    'required' => false,
                    'format' => 'dd/MM/yyyy',
                    'label' => 'label.vigencia'
                ]
            )
            ->end()
            ->with('label.configuracaoEmpenho.configuracaoAutorizacaoEmpenho')
            ->add(
                'configs',
                'sonata_type_collection',
                array(
                    'by_reference' => false,
                    'label' => false,
                    'required' => true,
                ),
                array(
                    'edit' => 'inline',
                    'inline' => 'table',
                    'delete' => false,
                )
            )
            ->end()
            ->end()
            ->tab('label.configuracaoEmpenho.localLotacaoAtributo');

        if ($id) {
            $formMapper
                ->add(
                    'opcao',
                    'hidden',
                    [
                        'data' => $tipoOpcao,
                        'mapped' => false,
                    ]
                );
            $options['tipoOpcao'] = [
                'required' => true,
                'choices' => [
                    'label.lotacao' => 1,
                    'label.local' => 2,
                    'label.atributo' => 3,
                ],
                'placeholder' => 'Selecione',
                'label' => 'label.opcaoConfiguracao',
                'attr' => [
                    'disabled' => true,
                    'class' => 'select2-parameters'
                ]
            ];
        } else {
            $options['tipoOpcao'] = [
                'required' => true,
                'choices' => [
                    'label.lotacao' => 1,
                    'label.local' => 2,
                    'label.atributo' => 3,
                ],
                'placeholder' => 'Selecione',
                'label' => 'label.opcaoConfiguracao',
                'attr' => [
                    'disabled' => false,
                    'class' => 'select2-parameters'
                ]
            ];
        }

        $formMapper
            ->add(
                'tipoOpcao',
                'choice',
                $options['tipoOpcao']
            )
            ->add(
                'lotacoes',
                'sonata_type_collection',
                array(
                    'by_reference' => false,
                    'label' => false
                ),
                array(
                    'edit' => 'inline',
                    'inline' => 'table',
                    'delete' => false,
                )
            )
            ->add(
                'locais',
                'sonata_type_collection',
                array(
                    'by_reference' => false,
                    'label' => false
                ),
                array(
                    'edit' => 'inline',
                    'inline' => 'table',
                    'delete' => false,
                )
            )
            ->add(
                'listaAtributos',
                'choice',
                [
                    'required' => true,
                    'choices' => $atributosDinamicos,
                    'placeholder' => 'Selecione',
                    'label' => 'label.atributoDinamico.modulo',
                    'mapped' => false,
                    'attr' => [
                        'class' => 'select2-parameters'
                    ],
                ]
            )
            ->add(
                'atributoValor',
                'sonata_type_admin',
                array(
                    'by_reference' => false,
                    'label' => false
                ),
                array(
                    'edit' => 'inline',
                    'inline' => 'table',
                    'delete' => true,
                )
            )
            ->end()
            ->end();
    }

    private function getAtributos()
    {
        $info = array(
            'cod_modulo' => self::MODULO_PESSOAL,
            'cod_cadastro' => self::CADASTRO_SERVIDOR,
        );

        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Administracao\AtributoDinamico');
        $atributoDinamicoModel = new AtributoDinamicoModel($em);

        $atributos = $atributoDinamicoModel->getAtributosDinamicosPorModuloeCadastro($info);

        $atributosDinamicos = [];
        foreach ($atributos as $atributo) {
            $atributosDinamicos[$atributo['nom_atributo']] = $atributo['cod_atributo'];
        }

        return $atributosDinamicos;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add('vigencia', 'date', ['label' => 'label.vigencia']);
    }

    public function prePersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();

        try {
            $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Folhapagamento\ConfigEmpenho');

            $configs = count($object->getConfigs());
            if (!$configs) {
                $this->redirect('Configuração de Empenho');
            }
            $tipoOpcao = $this->getForm()->get('tipoOpcao')->getdata();
            if (is_null($tipoOpcao)) {
                $this->redirect('Opções de configuração');
            }

            $info = [
                'vigencia' => $object->getVigencia(),
                'configs' => $object->getConfigs(),
                'lotacoes' => $object->getLotacoes(),
                'locais' => $object->getLocais(),
            ];

            $this->setDataConfig($info);

            if ($tipoOpcao == 1) { // Lotacao
                $object->setAtributoValor(null);
                $this->setDataLotacao($info);
            }

            if ($tipoOpcao == 2) { // Local
                $object->setAtributoValor(null);
                $this->setDataLocal($info);
            }

            if ($tipoOpcao == 3) { // Atributo
                $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Folhapagamento\ConfigEmpenho');

                $atributo = $this->getForm()->get('listaAtributos')->getData();

                $moduloModel = new ModuloModel($em);
                $codModulo = $moduloModel->findOneBynomModulo(self::MODULO_PESSOAL);

                $cadastroModel = new CadastroModel($em);
                $codCadastro = $cadastroModel->findOneBynomCadastro(self::CADASTRO_SERVIDOR);

                $vigencia = $object->getVigencia();
                $exercicio = $vigencia->format('Y');

                $object->getAtributoValor()->setExercicio($exercicio);
                $object->getAtributoValor()->setCodConfigEmpenho($object);
                $object->getAtributoValor()->setCodAtributo($atributo);
                $object->getAtributoValor()->setCodModulo($codModulo->getCodModulo());
                $object->getAtributoValor()->setCodCadastro($codCadastro->getCodCadastro());
            }

            $em->flush();
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            $container->get('session')->getFlashBag()->add('error', self::ERROR_REMOVE_DATA);
            throw $e;
        }
    }

    private function redirect($field)
    {
        $container = $this->getConfigurationPool()->getContainer();

        $container->get('session')->getFlashBag()->add('error', sprintf("%s deve ser preenchido.", $field));
        (new RedirectResponse($this->generateUrl('create')))->send();
        exit;
    }

    public function preUpdate($object)
    {
        $container = $this->getConfigurationPool()->getContainer();

        try {
            $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Folhapagamento\ConfigEmpenho');

            $info = [
                'vigencia' => $object->getVigencia(),
                'configs' => $object->getConfigs(),
                'lotacoes' => $object->getLotacoes(),
                'locais' => $object->getLocais(),
            ];

            $object->setAtributoValor(null);

            $tipoOpcao = $this->getForm()->get('opcao')->getData();

            $this->setDataConfig($info);

            if ($tipoOpcao == 1) { // Lotacao
                $object->setAtributoValor(null);
                $this->setDataLotacao($info);
            }

            if ($tipoOpcao == 2) { // Local
                $object->setAtributoValor(null);
                $this->setDataLocal($info);
            }

            if ($tipoOpcao == 3) { // Atributo
                $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Folhapagamento\ConfigEmpenho');

                $atributo = $this->getForm()->get('listaAtributos')->getData();

                $moduloModel = new ModuloModel($em);
                $codModulo = $moduloModel->findOneBynomModulo(self::MODULO_PESSOAL);

                $cadastroModel = new CadastroModel($em);
                $codCadastro = $cadastroModel->findOneBynomCadastro(self::CADASTRO_SERVIDOR);

                $vigencia = $object->getVigencia();
                $exercicio = $vigencia->format('Y');

                $object->getAtributoValor()->setExercicio($exercicio);
                $object->getAtributoValor()->setCodConfigEmpenho($object);
                $object->getAtributoValor()->setCodAtributo($atributo);
                $object->getAtributoValor()->setCodModulo($codModulo->getCodModulo());
                $object->getAtributoValor()->setCodCadastro($codCadastro->getCodCadastro());
            }

            $object->setTipoOpcao($tipoOpcao);
            $em->flush();
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            $container->get('session')->getFlashBag()->add('error', self::ERROR_REMOVE_DATA);
            throw $e;
        }
    }

    public function postPersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();

        try {
            $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Folhapagamento\ConfigEmpenho');

            $tipoOpcao = $this->getForm()->get('tipoOpcao')->getdata();

            $childrens = $this->getForm()->all();

            if ($tipoOpcao == 1) { // Lotação
                $lotacoes = $childrens['lotacoes'];
                foreach ($lotacoes as $key => $children) {
                    $configuracaoEmpenhoLla = $this->salvaConfiguracaoEmpenhoLla($object);
                    $this->salvaConfiguracaoEmpenhoLlaLotacao($configuracaoEmpenhoLla, $children->getViewData());
                }
            }

            if ($tipoOpcao == 2) { // Local
                $locais = $childrens['locais'];
                foreach ($locais as $key => $children) {
                    $configuracaoEmpenhoLla = $this->salvaConfiguracaoEmpenhoLla($object);
                    $this->salvaConfiguracaoEmpenhoLlaLocal($configuracaoEmpenhoLla, $children->getViewData());
                }
            }

            if ($tipoOpcao == 3) { // Atributo
                $atributoValor = $childrens['atributoValor'];
                $configuracaoEmpenhoLla = $this->salvaConfiguracaoEmpenhoLla($object);
                $this->salvaConfiguracaoEmpenhoLlaAtributoValor($configuracaoEmpenhoLla, $atributoValor->getViewData());
            }
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            $container->get('session')->getFlashBag()->add('error', self::ERROR_REMOVE_DATA);
            throw $e;
        }
    }

    private function setDataConfig($info)
    {
        $vigencia = $info['vigencia'];
        $exercicio = $vigencia->format('Y');

        foreach ($info['configs'] as $config) {
            $config->setVigencia($vigencia);
            $config->setExercicio($exercicio);
        }
    }

    private function setDataLotacao($info)
    {
        $vigencia = $info['vigencia'];
        $exercicio = $vigencia->format('Y');

        foreach ($info['lotacoes'] as $lotacao) {
            $lotacao->setExercicio($exercicio);
        }
    }

    private function setDataLocal($info)
    {
        $vigencia = $info['vigencia'];
        $exercicio = $vigencia->format('Y');

        foreach ($info['locais'] as $local) {
            $local->setExercicio($exercicio);
        }
    }

    private function salvaConfiguracaoEmpenhoLla($object)
    {
        $vigencia = $object->getVigencia();

        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLla');
        $configuracaoEmpenhoLla = new ConfiguracaoEmpenhoLla();
        $configuracaoEmpenhoLla->setVigencia($vigencia);
        $configuracaoEmpenhoLla->setExercicio($vigencia->format('Y'));
        $configuracaoEmpenhoLla->setConfigEmpenho($object);

        $em->persist($configuracaoEmpenhoLla);
        $em->flush();

        return $configuracaoEmpenhoLla;
    }

    private function salvaConfiguracaoEmpenhoLlaLocal($configuracaoEmpenhoLla, $object)
    {
        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaLocal');
        $model = new ConfiguracaoEmpenhoLlaLocalModel($em);
        $model->updateCodConfiguracaoLla($configuracaoEmpenhoLla, $object);
    }

    private function salvaConfiguracaoEmpenhoLlaLotacao($configuracaoEmpenhoLla, $object)
    {
        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaLotacao');
        $model = new ConfiguracaoEmpenhoLlaLotacaoModel($em);
        $model->updateCodConfiguracaoLla($configuracaoEmpenhoLla, $object);
    }

    private function salvaConfiguracaoEmpenhoLlaAtributoValor($configuracaoEmpenhoLla, $object)
    {
        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaLotacao');
        $model = new ConfiguracaoEmpenhoLlaAtributoValorModel($em);
        $model->updateCodConfiguracaoLla($configuracaoEmpenhoLla, $object);
    }
}
