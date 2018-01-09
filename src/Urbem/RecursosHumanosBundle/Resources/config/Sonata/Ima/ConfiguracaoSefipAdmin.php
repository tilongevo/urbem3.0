<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Ima;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Ima\CategoriaSefip;
use Urbem\CoreBundle\Entity\Ima\ModalidadeRecolhimento;
use Urbem\CoreBundle\Entity\Pessoal\Categoria;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Economico\CnaeFiscalModel;
use Urbem\CoreBundle\Model\Ima\CategoriaSefipModel;
use Urbem\CoreBundle\Model\SwCgmModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ConfiguracaoSefipAdmin extends AbstractSonataAdmin
{

    protected $baseRouteName = 'urbem_recursos_humanos_ima_configuracao_sefip';
    protected $baseRoutePattern = 'recursos-humanos/ima/configuracao-sefip';

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $exercicio = $this->getExercicio();

        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        /** @var ConfiguracaoModel $configuracaoModel */
        $configuracaoModel = new ConfiguracaoModel($entityManager);
        $cnaeFiscal = $configuracaoModel->getConfiguracao('cnae_fiscal', Modulo::MODULO_IMA, true, $exercicio);
        $centralizacao = $configuracaoModel->getConfiguracao('centralizacao', Modulo::MODULO_IMA, true, $exercicio);
        $codigoOutrasEntidadesSefip = $configuracaoModel->getConfiguracao('codigo_outras_entidades_sefip', Modulo::MODULO_IMA, true, $exercicio);
        $fpas = $configuracaoModel->getConfiguracao('fpas', Modulo::MODULO_IMA, true, $exercicio);
        $gps = $configuracaoModel->getConfiguracao('gps', Modulo::MODULO_IMA, true, $exercicio);
        $tipoInscricao = $configuracaoModel->getConfiguracao('tipo_inscricao', Modulo::MODULO_IMA, true, $exercicio);
        $inscricaoFornecedor = $configuracaoModel->getConfiguracao('inscricao_fornecedor', Modulo::MODULO_IMA, true, $exercicio);
        $nomePessoaContatoSefip = $configuracaoModel->getConfiguracao('nome_pessoa_contato_sefip', Modulo::MODULO_IMA, true, $exercicio);
        $telefonePessoaContatoSefip = $configuracaoModel->getConfiguracao('telefone_pessoa_contato_sefip', Modulo::MODULO_IMA, true, $exercicio);
        $dddPessoaContatoSefip = $configuracaoModel->getConfiguracao('DDD_pessoa_contato_sefip', Modulo::MODULO_IMA, true, $exercicio);
        $mailPessoaContatoSefip = $configuracaoModel->getConfiguracao('mail_pessoa_contato_sefip', Modulo::MODULO_IMA, true, $exercicio);

        /** @var CnaeFiscalModel $cnaeFiscalModel */
        $cnaeFiscalModel = new CnaeFiscalModel($entityManager);
        $cnaeFiscais = $cnaeFiscalModel->findCnaeFiscal();
        $cnaeArray = [];

        foreach ($cnaeFiscais as $cnae) {
            $label = $cnae['valor_composto'] . " - " . $cnae['nom_atividade'];
            $id = $cnae['cod_cnae'];
            $cnaeArray[$label] = $id;
        }

        $fieldOptions['cnae_fiscal'] = [
            'choices' => $cnaeArray,
            'label' => 'label.recursosHumanos.ima.configuracaoSefip.cnaeFiscal',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'mapped' => false,
            'data' => $cnaeFiscal
        ];

        $fieldOptions['centralizacao'] = [
            'label' => 'label.recursosHumanos.ima.configuracaoSefip.centralizacao',
            'attr' => [
                'class' => 'numeric '
            ],
            'mapped' => false,
            'data' => $centralizacao
        ];

        $fieldOptions['codigo_outras_entidades_sefip'] = [
            'label' => 'label.recursosHumanos.ima.configuracaoSefip.codigoOutrasEntidadesSefip',
            'attr' => [
                'class' => 'numeric '
            ],
            'mapped' => false,
            'data' => $codigoOutrasEntidadesSefip
        ];

        $fieldOptions['fpas'] = [
            'label' => 'label.recursosHumanos.ima.configuracaoSefip.fpas',
            'attr' => [
                'class' => 'numeric '
            ],
            'mapped' => false,
            'data' => $fpas
        ];

        $fieldOptions['gps'] = [
            'label' => 'label.recursosHumanos.ima.configuracaoSefip.gps',
            'attr' => [
                'class' => 'numeric '
            ],
            'mapped' => false,
            'data' => $gps
        ];

        $fieldOptions['tipo_inscricao'] = [
            'label' => 'label.recursosHumanos.ima.configuracaoSefip.tipoInscricao',
            'choices' => [
                'CNPJ' => 1,
                'CEI' => 2,
                'CPF' => 3,
            ],
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'mapped' => false,
            'data' => $tipoInscricao,
            'required' => false
        ];

        $fieldOptions['inscricao_fornecedor_cei'] = [
            'label' => 'label.recursosHumanos.ima.configuracaoSefip.inscricao_fornecedor_cei',
            'attr' => [
                'class' => 'numeric '
            ],
            'mapped' => false,
            'data' => $inscricaoFornecedor
        ];

        /** @var SwCgmModel $swCmgModel */
        $swCmgModel = new SwCgmModel($entityManager);
        $cgm = $swCmgModel->findOneByNumcgm($inscricaoFornecedor);

        $fieldOptions['inscricao_fornecedor'] = [
            'label' => 'label.recursosHumanos.ima.configuracaoSefip.inscricaoFornecedor',
            'route' => ['name' => 'carrega_sw_cgm'],
            'data' => $cgm,
            'required' => false,
            'mapped' => false,
        ];

        $fieldOptions['nome_pessoa_contato_sefip'] = [
            'label' => 'label.recursosHumanos.ima.configuracaoSefip.nomePessoaContatoSefip',
            'mapped' => false,
            'data' => $nomePessoaContatoSefip
        ];

        $fieldOptions['DDD_pessoa_contato_sefip'] = [
            'label' => 'label.recursosHumanos.ima.configuracaoSefip.dddPessoaContatoSefip',
            'mapped' => false,
            'data' => $dddPessoaContatoSefip,
            'attr' => [
                'maxlength' => 2
            ]
        ];

        $fieldOptions['telefone_pessoa_contato_sefip'] = [
            'label' => 'label.recursosHumanos.ima.configuracaoSefip.telefonePessoaContatoSefip',
            'mapped' => false,
            'data' => $telefonePessoaContatoSefip
        ];

        $fieldOptions['mail_pessoa_contato_sefip'] = [
            'label' => 'label.recursosHumanos.ima.configuracaoSefip.mailPessoaContatoSefip',
            'mapped' => false,
            'data' => $mailPessoaContatoSefip
        ];

        /** @var CategoriaSefip $categoriaSefip */
        $categoriaSefip = $entityManager->getRepository(CategoriaSefip::class)->findAll();
        $modalidadeRecolhimento = $categorias = [];
        /** @var CategoriaSefip $categoria */
        foreach ($categoriaSefip as $categoria) {
            $modalidadeRecolhimento[] = $categoria->getFkImaModalidadeRecolhimento();
            $categorias[] = $categoria->getFkPessoalCategoria();
        }

        $fieldOptions['codModalidade'] = [
            'class' => ModalidadeRecolhimento::class,
            'query_builder' => function (EntityRepository $repository) {
                $qb = $repository->createQueryBuilder('o')
                    ->where('o.codModalidade = 1')
                    ->orWhere('o.codModalidade = 2');

                return $qb;
            },
            'label' => 'label.recursosHumanos.ima.configuracaoSefip.modalidade',
            'required' => true,
            'multiple' => true,
            'data' => $modalidadeRecolhimento
        ];

        $fieldOptions['codCategoria'] = [
            'class' => Categoria::class,
            'label' => 'label.recursosHumanos.ima.configuracaoSefip.categoria',
            'required' => true,
            'multiple' => true,
            'data' => $categorias
        ];

        $formMapper
            ->with('label.recursosHumanos.ima.configuracaoSefip.configuracaodaSefip')
            ->add('cnae_fiscal', 'choice', $fieldOptions['cnae_fiscal'])
            ->add('centralizacao', 'text', $fieldOptions['centralizacao'])
            ->add('codigo_outras_entidades_sefip', 'text', $fieldOptions['codigo_outras_entidades_sefip'])
            ->add('fpas', 'text', $fieldOptions['fpas'])
            ->add('gps', 'text', $fieldOptions['gps'])
            ->add('tipo_inscricao', 'choice', $fieldOptions['tipo_inscricao'])
            ->add('inscricao_fornecedor_cei', 'text', $fieldOptions['inscricao_fornecedor_cei'])
            ->add('inscricao_fornecedor', 'autocomplete', $fieldOptions['inscricao_fornecedor'])
            ->add('nome_pessoa_contato_sefip', 'text', $fieldOptions['nome_pessoa_contato_sefip'])
            ->add('DDD_pessoa_contato_sefip', 'text', $fieldOptions['DDD_pessoa_contato_sefip'])
            ->add('telefone_pessoa_contato_sefip', 'text', $fieldOptions['telefone_pessoa_contato_sefip'])
            ->add('mail_pessoa_contato_sefip', 'text', $fieldOptions['mail_pessoa_contato_sefip'])
            ->end()
            ->with('label.recursosHumanos.ima.configuracaoSefip.modalidadeRecolhimento')
            ->add('codModalidade', 'entity', $fieldOptions['codModalidade'])
            ->add('codCategoria', 'entity', $fieldOptions['codCategoria'])
            ->end();
    }

    public function prePersist($object)
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();
        $categoriaSefipModel = new CategoriaSefipModel($em);

        $form = $this->getForm();

        $modalidadeArray = array_unique($form->get('codModalidade')->getData());

        /** @var ConfiguracaoModel $configuracaoModel */
        $configuracaoModel = new ConfiguracaoModel($em);
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $categoriaSefipModel->removeCategoriaSefip();

            $info = array(
                'cod_modulo' => Modulo::MODULO_IMA,
                'exercicio' => $this->getExercicio()
            );
            $info['parametro'] = 'cnae_fiscal';
            $info['valor'] = $form->get('cnae_fiscal')->getData();
            $configuracaoModel->updateAtributosDinamicos($info);

            $info['parametro'] = 'centralizacao';
            $info['valor'] = $form->get('centralizacao')->getData();
            $configuracaoModel->updateAtributosDinamicos($info);

            $info['parametro'] = 'codigo_outras_entidades_sefip';
            $info['valor'] = $form->get('codigo_outras_entidades_sefip')->getData();
            $configuracaoModel->updateAtributosDinamicos($info);

            $info['parametro'] = 'fpas';
            $info['valor'] = $form->get('fpas')->getData();
            $configuracaoModel->updateAtributosDinamicos($info);

            $info['parametro'] = 'gps';
            $info['valor'] = $form->get('gps')->getData();
            $configuracaoModel->updateAtributosDinamicos($info);

            $info['parametro'] = 'tipo_inscricao';
            $info['valor'] = $form->get('tipo_inscricao')->getData();
            $configuracaoModel->updateAtributosDinamicos($info);

            $inscricao = explode("-", $form->get('inscricao_fornecedor')->getData());

            $valorInscricao = ($form->get('tipo_inscricao')->getData() == 2) ? $form->get('inscricao_fornecedor_cei')->getData() : trim($inscricao[0]);

            $info['parametro'] = 'inscricao_fornecedor';
            $info['valor'] = $valorInscricao;
            $configuracaoModel->updateAtributosDinamicos($info);

            $info['parametro'] = 'nome_pessoa_contato_sefip';
            $info['valor'] = $form->get('nome_pessoa_contato_sefip')->getData();
            $configuracaoModel->updateAtributosDinamicos($info);

            $info['parametro'] = 'DDD_pessoa_contato_sefip';
            $info['valor'] = $form->get('DDD_pessoa_contato_sefip')->getData();
            $configuracaoModel->updateAtributosDinamicos($info);

            $info['parametro'] = 'telefone_pessoa_contato_sefip';
            $info['valor'] = $form->get('telefone_pessoa_contato_sefip')->getData();
            $configuracaoModel->updateAtributosDinamicos($info);

            $info['parametro'] = 'mail_pessoa_contato_sefip';
            $info['valor'] = $form->get('mail_pessoa_contato_sefip')->getData();
            $configuracaoModel->updateAtributosDinamicos($info);

            foreach ($modalidadeArray as $modalidade) {
                foreach ($form->get('codCategoria')->getData() as $categoria) {
                    $categoriaSefipModel->createCategoriaSefip($modalidade, $categoria);
                }
            }

            $em->flush();
            $container->get('session')->getFlashBag()->add('success', $this->getTranslator()->trans('flash_create_success', []));
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $e->getMessage());
        }

        $this->redirectByRoute('urbem_recursos_humanos_ima_configuracao_sefip_create');
    }
}
