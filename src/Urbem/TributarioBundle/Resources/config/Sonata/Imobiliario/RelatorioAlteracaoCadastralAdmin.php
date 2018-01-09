<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Imobiliario;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Administracao\AtributoDinamico;
use Urbem\CoreBundle\Entity\Administracao\Cadastro;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

class RelatorioAlteracaoCadastralAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_tributario_imobiliario_relatorio_alteracao_cadastral';
    protected $baseRoutePattern = 'tributario/cadastro-imobiliario/relatorios/alteracao-cadastral';
    protected $legendButtonSave = array('icon' => 'description', 'text' => 'Gerar Relatório');
    protected $includeJs = array(
        '/tributario/javascripts/imobiliario/relatorio-alteracao-cadastral.js'
    );
    public $ordenacoes = [
        self::ORD_INSCRICAO_IMOBILIARIA => 'label.imobiliarioRelatorios.alteracaoCadastral.inscricaoImobiliaria',
        self::ORD_LOCALIZACAO => 'label.imobiliarioRelatorios.alteracaoCadastral.localizacao',
        self::ORD_LOTE => 'label.imobiliarioRelatorios.alteracaoCadastral.lote',
        self::ORD_LOGRADOURO => 'label.imobiliarioRelatorios.alteracaoCadastral.logradouro',
        self::ORD_BAIRRO => 'label.imobiliarioRelatorios.alteracaoCadastral.bairro',
        self::ORD_CEP => 'label.imobiliarioRelatorios.alteracaoCadastral.cep'
    ];

    const NAO_INFORMADO = 0;
    const ORD_INSCRICAO_IMOBILIARIA = 'inscricao';
    const ORD_LOCALIZACAO = 'localizacao';
    const ORD_LOTE = 'lote';
    const ORD_LOGRADOURO = 'logradouro';
    const ORD_BAIRRO = 'bairro';
    const ORD_CEP = 'cep';
    const REPORT_ANALITICO = 'analitico';
    const REPORT_SINTETICO = 'sintetico';

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['create']);
        $collection->add('relatorio', 'relatorio');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $em = $this->modelManager->getEntityManager($this->getClass());

        $fieldOptions = [];

        $fieldOptions['localizacaoInicial'] = [
            'label' => 'label.imobiliarioRelatorios.alteracaoCadastral.localizacaoDe',
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'maxlength_9 localizacao_mask '
            ]
        ];

        $fieldOptions['localizacaoFinal'] = [
            'label' => 'label.imobiliarioRelatorios.alteracaoCadastral.localizacaoAte',
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'maxlength_9 localizacao_mask '
            ]
        ];

        $fieldOptions['loteInicial'] = [
            'label' => 'label.imobiliarioRelatorios.alteracaoCadastral.loteDe',
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'maxlength_3 '
            ]
        ];

        $fieldOptions['loteFinal'] = [
            'label' => 'label.imobiliarioRelatorios.alteracaoCadastral.loteAte',
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'maxlength_3 '
            ]
        ];

        $fieldOptions['inscricaoImobiliariaInicial'] = [
            'label' => 'label.imobiliarioRelatorios.alteracaoCadastral.inscricaoImobiliariaDe',
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'maxlength_4 '
            ]
        ];

        $fieldOptions['inscricaoImobiliariaFinal'] = [
            'label' => 'label.imobiliarioRelatorios.alteracaoCadastral.inscricaoImobiliariaAte',
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'maxlength_4 '
            ]
        ];

        $fieldOptions['codigoLogradouroInicial'] = [
            'label' => 'label.imobiliarioRelatorios.alteracaoCadastral.codigoLogradouroDe',
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'maxlength_10 '
            ]
        ];

        $fieldOptions['codigoLogradouroFinal'] = [
            'label' => 'label.imobiliarioRelatorios.alteracaoCadastral.codigoLogradouroAte',
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'maxlength_10 '
            ]
        ];

        $fieldOptions['codigoBairroInicial'] = [
            'label' => 'label.imobiliarioRelatorios.alteracaoCadastral.codigoBairroDe',
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'maxlength_10 '
            ]
        ];

        $fieldOptions['codigoBairroFinal'] = [
            'label' => 'label.imobiliarioRelatorios.alteracaoCadastral.codigoBairroAte',
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'maxlength_10 '
            ]
        ];

        $relatorios = [
            self::REPORT_ANALITICO => 'label.imobiliarioRelatorios.alteracaoCadastral.analitico',
            self::REPORT_SINTETICO => 'label.imobiliarioRelatorios.alteracaoCadastral.sintetico'
        ];

        $fieldOptions['report_type'] = [
            'label' => 'label.imobiliarioRelatorios.alteracaoCadastral.tipoRelatorio',
            'placeholder' => 'label.selecione',
            'choices' => array_flip($relatorios),
            'mapped' => false,
            'required' => true,
            'attr' => [
                'class' => 'js-tipo-relatorio '
            ]
        ];

        $atributos = $em->getRepository(AtributoDinamico::class)->getAlteracaoCadastralAtributos(Modulo::MODULO_CADASTRO_IMOBILIARIO, Cadastro::CADASTRO_TRIBUTARIO_IMOVEL);
        $atributosChoice = [];
        if ($atributos) {
            $keys = array_column($atributos, 'cod_atributo');
            $values = array_column($atributos, 'nom_atributo');
            $atributosChoice = array_combine($keys, $values);
        }

        $fieldOptions['atributos'] = [
            'label' => 'label.imobiliarioRelatorios.alteracaoCadastral.atributos',
            'choices' => array_flip($atributosChoice),
            'multiple' => true,
            'required' => false,
            'mapped' => false,
            'attr' => [
                'class' => 'js-atributos '
            ]
        ];


        $ordenacoes = [
            self::ORD_INSCRICAO_IMOBILIARIA => 'label.imobiliarioRelatorios.alteracaoCadastral.inscricaoImobiliaria',
            self::ORD_LOCALIZACAO => 'label.imobiliarioRelatorios.alteracaoCadastral.localizacao',
            self::ORD_LOTE => 'label.imobiliarioRelatorios.alteracaoCadastral.lote',
            self::ORD_LOGRADOURO => 'label.imobiliarioRelatorios.alteracaoCadastral.logradouro',
            self::ORD_BAIRRO => 'label.imobiliarioRelatorios.alteracaoCadastral.bairro',
            self::ORD_CEP => 'label.imobiliarioRelatorios.alteracaoCadastral.cep'
        ];

        $fieldOptions['ordenacao'] = [
            'label' => 'label.imobiliarioRelatorios.alteracaoCadastral.ordenacao',
            'placeholder' => 'label.selecione',
            'choices' => array_flip($this->ordenacoes),
            'data' => self::ORD_INSCRICAO_IMOBILIARIA,
            'mapped' => false,
            'required' => true
        ];

        $formMapper
            ->add(
                'localizacaoInicial',
                'text',
                $fieldOptions['localizacaoInicial']
            )
            ->add(
                'localizacaoFinal',
                'text',
                $fieldOptions['localizacaoFinal']
            )
            ->add(
                'loteInicial',
                'number',
                $fieldOptions['loteInicial']
            )
            ->add(
                'loteFinal',
                'number',
                $fieldOptions['loteFinal']
            )
            ->add(
                'inscricaoImobiliariaInicial',
                'number',
                $fieldOptions['inscricaoImobiliariaInicial']
            )
            ->add(
                'inscricaoImobiliariaFinal',
                'number',
                $fieldOptions['inscricaoImobiliariaFinal']
            )
            ->add(
                'codigoLogradouroInicial',
                'number',
                $fieldOptions['codigoLogradouroInicial']
            )
            ->add(
                'codigoLogradouroFinal',
                'number',
                $fieldOptions['codigoLogradouroFinal']
            )
            ->add(
                'codigoBairroInicial',
                'number',
                $fieldOptions['codigoBairroInicial']
            )
            ->add(
                'codigoBairroFinal',
                'number',
                $fieldOptions['codigoBairroFinal']
            )
            ->add('tipoRelatorio', 'choice', $fieldOptions['report_type'])
            ->add('atributos', 'choice', $fieldOptions['atributos'])
            ->add('ordenacao', 'choice', $fieldOptions['ordenacao'])
        ;
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $params = [
            'localizacaoInicial' => $this->getFormField($this->getForm(), 'localizacaoInicial'),
            'localizacaoFinal' => $this->getFormField($this->getForm(), 'localizacaoFinal'),
            'loteInicial' => $this->getFormField($this->getForm(), 'loteInicial'),
            'loteFinal' => $this->getFormField($this->getForm(), 'loteFinal'),
            'inscricaoImobiliariaInicial' => $this->getFormField($this->getForm(), 'inscricaoImobiliariaInicial'),
            'inscricaoImobiliariaFinal' => $this->getFormField($this->getForm(), 'inscricaoImobiliariaFinal'),
            'codigoLogradouroInicial' => $this->getFormField($this->getForm(), 'codigoLogradouroInicial'),
            'codigoLogradouroFinal' => $this->getFormField($this->getForm(), 'codigoLogradouroFinal'),
            'codigoBairroInicial' => $this->getFormField($this->getForm(), 'codigoBairroInicial'),
            'codigoBairroFinal' => $this->getFormField($this->getForm(), 'codigoBairroFinal'),
            'tipoRelatorio' => $this->getFormField($this->getForm(), 'tipoRelatorio'),
            'atributos' => $this->getFormField($this->getForm(), 'atributos'),
            'ordenacao' => $this->getFormField($this->getForm(), 'ordenacao')
        ];

        $this->forceRedirect($this->generateUrl('relatorio', $params));
    }

    /**
     * @param $form
     * @param $fieldName
     * @return mix
     * @return string
     */
    public function getFormField($form, $fieldName)
    {
        return ($form->get($fieldName)->getData()) ? $form->get($fieldName)->getData() : '';
    }

    /**
     * @param $inscricaoMunicipal
     * @return array
     */
    public function getAtributosByImovel($inscricaoMunicipal)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $alteracaoCadastral = $em->getRepository(AtributoDinamico::class)
            ->getAtributosByImovel(
                $inscricaoMunicipal,
                Modulo::MODULO_CADASTRO_IMOBILIARIO,
                Cadastro::CADASTRO_TRIBUTARIO_IMOVEL
            );

        return $alteracaoCadastral;
    }

    /**
     * @param $codAtributo
     * @return array
     */
    public function getNomeAtributo($codAtributo)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $atributo = $em->getRepository(AtributoDinamico::class)
            ->findOneBy(
                [
                    'codModulo' => Modulo::MODULO_CADASTRO_IMOBILIARIO,
                    'codCadastro' => Cadastro::CADASTRO_TRIBUTARIO_IMOVEL,
                    'codAtributo' => $codAtributo
                ]
            );

        return $atributo;
    }

    /**
     * @return array
     */
    public function getOrdenacao()
    {
        return $this->ordenacoes;
    }
}
