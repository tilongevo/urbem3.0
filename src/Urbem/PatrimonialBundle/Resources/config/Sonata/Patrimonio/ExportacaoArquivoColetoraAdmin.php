<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Patrimonio;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Acl\Exception\Exception;
use Urbem\CoreBundle\Entity\Administracao\Configuracao;
use Urbem\CoreBundle\Entity\Organograma\Local;
use Urbem\CoreBundle\Entity\Patrimonio\ArquivoColetora;
use Urbem\CoreBundle\Entity\Patrimonio\ArquivoColetoraDados;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Patrimonio\ArquivoColetoraConsistenciaModel;
use Urbem\CoreBundle\Model\Patrimonial\Patrimonio\ArquivoColetoraDadosModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Urbem\PatrimonialBundle\Controller\Patrimonio\InventarioAdminController;
use Symfony\Component\Validator\Constraints as Assert;
use Sonata\CoreBundle\Validator\ErrorElement;

/**
 * Class ExportacaoArquivoColetoraAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Patrimonio
 */
class ExportacaoArquivoColetoraAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_patrimonio_exportacao_arquivo_coletora';
    protected $baseRoutePattern = 'patrimonial/patrimonio/inventario/importar-exportar-arquivo-coletora';

    protected $includeJs = [
        '/patrimonial/javascripts/patrimonio/inventario/exportacaoArquivoColetora.js'
    ];

    protected $exibirBotaoIncluir = false;
    protected $exibirMensagemFiltro = true;

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $this->setBreadCrumb();

        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $locais = $em->getRepository(Local::class)->findAll();

        $fieldOptions['places'] = [
            'class' => Local::class,
            'choice_label' => function ($places) {
                return $places->getDescricao();
            },
            'label' => 'label.arquivoColetora.local',
            'mapped' => false,
            'expanded' => false,
            'data' => $locais,
            'multiple' => true,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        ];

        $types = [
            'Inventário' => 'Inventario', 'Cadastro' => 'Cadastro'
        ];

        $formGridOptions['tipoChoices'] = [
            'choices' => $types,
            'expanded' => false,
            'multiple' => false,
            'placeholder' => 'Selecione'
        ];

        $formGridOptions['tipo'] = [
            'label' => 'label.arquivoColetora.arquivo',
            'required' => true,
            'mapped' => false,
            'callback' => [$this, 'getSearchFilter'],
            'attr' => [
                'class' => 'select2-parameters '
            ],
        ];

        $formGridOptions['localChoices'] = [
            'class' => Local::class,
            'expanded' => false,
            'multiple' => true,

        ];

        $formGridOptions['local'] = [
            'label' => 'label.arquivoColetora.local',
            'callback' => [$this, 'getSearchFilter'],
            'required' => true,
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters '
            ],
        ];

        $datagridMapper->add('typeArchive', 'doctrine_orm_callback', $formGridOptions['tipo'], 'choice', $formGridOptions['tipoChoices']);
        $datagridMapper->add('local', 'doctrine_orm_callback', $formGridOptions['local'], 'entity', $formGridOptions['localChoices']);
    }

    /**
     * @param $queryBuilder
     * @param $alias
     * @param $field
     * @param $value
     * @return bool
     */
    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        $filter = $this->getDataGrid()->getValues();

//        if (isset($filter['local']) && $filter['local'] != '') {
//            $entityManager = $this->modelManager->getEntityManager($this->getClass());
//            $inventarioAdminController = new InventarioAdminController();
//            $inventarioAdminController->exportarColetoraTxtAction(new Request(), $entityManager);
//        }
        return true;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('codigo')
            ->add('nome')
            ->add('md5sum')
            ->add('timestamp')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                ),
            ));
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->setBreadCrumb();

        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $locais = $em->getRepository(Local::class)->findAll();

        $fieldOptions['file'] = [
            'mapped' => false,
            'label' => 'label.arquivoColetora.uploadArquivo',
            'required' => true,
            'constraints' => [
                new Assert\File([
                    'mimeTypes' => ['text/plain'],
                    'mimeTypesMessage' => 'Somente arquivo txt'
                ])
            ]
        ];

        $formMapper
            ->with('label.arquivoColetora.importarArquivoColetora')
            ->add('archive', 'file', $fieldOptions['file']);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codigo')
            ->add('nome')
            ->add('md5sum')
            ->add('timestamp');
    }

    /**
     * @param ErrorElement $errorElement
     * @param ArquivoColetora $arquivoColetora
     */
    public function validate(ErrorElement $errorElement, $arquivoColetora)
    {
        $archive = $this->getForm()->get('archive')->getViewData();
        if (file_exists($archive->getPathname())) {
            if ($archive->getMimeType() != 'text/plain') {
                $error = $this->getTranslator()->trans('label.arquivoColetora.erro.formatoInvalido');
                $errorElement->with('archive')->addViolation($error)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $error);
            }
        }
    }

    /**
     * @param ArquivoColetora $arquivoColetora
     */
    public function prePersist($arquivoColetora)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $archive = $this->getForm()->get('archive')->getViewData();
        $timestamp = getdate();
        $dados = $this->validarArquivo($archive->getPathname());
        $arquivoColetora->setNome('coleta_' . date('YmdHi', ($timestamp[0])) . '.txt');
        $arquivoColetora->setMd5sum(md5_file($archive->getPathname()));
        $importar = $this->importar($dados, '', $arquivoColetora);
        if (!$importar) {
            $this->forceRedirect("/patrimonial/patrimonio/inventario/importar-exportar-arquivo-coletora/create");
        }
    }

    /**
     * @param ArquivoColetora $arquivoColetora
     */
    public function postPersist($arquivoColetora)
    {
        $container = $this->getConfigurationPool()->getContainer();
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        /** @var ArquivoColetoraDadosModel $arquivoColetoraDadosModel */
        $arquivoColetoraDadosModel = new ArquivoColetoraDadosModel($entityManager);


        $archive = $this->getForm()->get('archive')->getViewData();
        $dados = $this->validarArquivo($archive->getPathname());

        if (is_array($dados)) {
            foreach ($dados as $linha) {
                $codLocal = $linha['cod_local'];
                $numPlaca = $linha['num_placa'];

                try {
                    $findOneOrSaveBasedArquivoColetora = $arquivoColetoraDadosModel->findOneOrSaveBasedArquivoColetora($codLocal, $numPlaca, $arquivoColetora);

                    if (is_null($findOneOrSaveBasedArquivoColetora)) {
                        $consultaPlaca = $arquivoColetoraDadosModel->consultaPlaca($numPlaca);
                        if (count($consultaPlaca) >= 0) {
                            if ($codLocal == $consultaPlaca->getCodLocal()) {
                                $status = 'Sem divergência';
                                $orientacao = '';
                            } else {
                                $status = 'Divergente';
                                $orientacao = 'Local informado no sistema: '.$consultaPlaca->getCodLocal();
                                $findOneOrSaveBasedArquivoColetora = $arquivoColetoraDadosModel->findOneOrSaveBasedArquivoColetora($consultaPlaca->getCodLocal(), $numPlaca, $arquivoColetora);
                            }
                        } else {
                            $status = 'Não cadastrado';
                            $orientacao = 'Cadastrar no Urbem';
                        }
                        //inclui na tabela consistencia
                        /** @var ArquivoColetoraConsistenciaModel $arquivocoletoraConsistenciaModel */
                        $arquivocoletoraConsistenciaModel = new ArquivoColetoraConsistenciaModel($entityManager);
                        $addArquivoColetoraConsistencia = $arquivocoletoraConsistenciaModel->saveOneOrBasedArquivoColetora($status, $orientacao, $findOneOrSaveBasedArquivoColetora);
                    }
                } catch (\Exception $e) {
                    $container->get('session')->getFlashBag()->add('error', $e->getMessage());
                    $this->forceRedirect("/patrimonial/patrimonio/inventario/importar-exportar-arquivo-coletora/create");
                }
            }
            $entityManager->flush();
        }
    }

    /**
     * @param $arquivo
     * @param $arquivoColetora
     * @return bool
     */
    public function importar($arquivo, $arquivoColetora)
    {
        if (is_array($arquivo)) {
            $e = $this->validateFileName($arquivoColetora);
            if (!$e) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param ArquivoColetora $arquivoColetora
     * @return bool|string
     */
    public function validateFileName($arquivoColetora)
    {
        $erro = false;
        $regex = '/^coleta_([1-2][0,9][0-9]{2})(0[0-9]|1[0-2])([0-2][0-9]|3[0-1])([0-1][0-9]|2[0-3])([0-5][0-9])\.txt$/';
        if (!preg_match($regex, $arquivoColetora->getNome())) {
            $erro = 'Nome do arquivo não está no padrão (coleta_YYYYMMDDHHMM.txt)';
            return new \Exception($erro);
        }
        return $erro;
    }

    /**
     * @param ArquivoColetora $arquivoColetora
     * @return bool|string
     */
    private function checkFileContent($arquivoColetora)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $erro = false;
        $md5Sum = $arquivoColetora->getMd5sum();

        $getNomeArquivoColetora = $entityManager->getRepository(ArquivoColetora::class)->findOneBy(['md5sum' => $md5Sum]);
        if ($getNomeArquivoColetora != null) {
            $erro = 'O conteúdo desse arquivo já foi importado.';
        }
        return $erro;
    }

    /**
     * @param $file
     * @return bool|string
     */
    private function validarArquivo($file)
    {
        $container = $this->getConfigurationPool()->getContainer();
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $exercicio = (string) $this->getExercicio();

        $dado = array();
        $erro = array();
        $numLinha = 1;
        $handle = @fopen($file, 'r');

        if ($handle) {
            while (!feof($handle)) {
                $linha = fgets($handle, 8096);
                if ($linha != '--- TCE ---') {
                    if (is_numeric(substr($linha, 0, 1))) {
                        $configuracaoModel = new ConfiguracaoModel($entityManager);

                        $coletoraDigitosLocal = $configuracaoModel->getConfiguracao('coletora_digitos_local', $configuracaoModel::MODULO_PATRIMONAL_PATRIMONIO, true, $exercicio);

                        $coletoraDigitosPlaca = $configuracaoModel->getConfiguracao('coletora_digitos_placa', $configuracaoModel::MODULO_PATRIMONAL_PATRIMONIO, true, $exercicio);

                        $coletoraSeparador = $configuracaoModel->getConfiguracao('coletora_separador', $configuracaoModel::MODULO_PATRIMONAL_PATRIMONIO, true, $exercicio);

                        if (isset($coletoraSeparador) && $coletoraSeparador == '') {
                            $tmp['cod_local'] = trim(substr($linha, 0, $coletoraDigitosLocal));
                            $tmp['num_placa'] = trim(substr($linha, $coletoraDigitosLocal, $coletoraDigitosPlaca));
                        } else {
                            $codLocal = $tmp['cod_local'] = trim(substr($linha, 0, $coletoraDigitosLocal));
                            $tmp['num_placa'] = trim(substr($linha, strpos($linha, $coletoraSeparador) + 1, $coletoraDigitosPlaca));

                            $getLocal = $entityManager->getRepository(Local::class)->findOneBy(['codLocal' => $codLocal]);
                            if (is_null($getLocal)) {
                                $erro = 'Local não encontrado na base de dados';
                                $container->get('session')->getFlashBag()->add('error', $erro);
                                $this->forceRedirect("/patrimonial/patrimonio/inventario/importar-exportar-arquivo-coletora/create");
                                return new \Exception($erro);
                            }
                        }
                        array_push($dado, $tmp);
                    } else {
                        array_push($erro, $linha);
                    }
                }
                $numLinha++;
            }
            @fclose($handle);
        }
        return $dado;
    }
}
