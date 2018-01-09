<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Imobiliario;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Model\Administracao\AtributoDinamicoModel;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Administracao\Cadastro;
use Urbem\CoreBundle\Entity\Administracao\AtributoDinamico;

class RelatorioCadastroImobiliarioAdmin extends AbstractAdmin
{
    const REPORT_SEM_EDIFICACAO = 0;
    const REPORT_COM_EDIFICACAO = 1;
    const REPORT_TODOS_EDIFICACAO = 2;
    const REPORT_ANALITICO = 'analitico';
    const REPORT_SINTETICO = 'sintetico';
    const REPORT_SITUACAO_ATIVOS = 'Ativo';
    const REPORT_SITUACAO_BAIXADOS = 'Baixado';
    const REPORT_SITUACAO_TODOS = 'todos';
    
    const REPORT_ORDENACAO_INSCRICAO = 'inscricao';
    const REPORT_ORDENACAO_LOCALIZACAO = 'localizacao';
    const REPORT_ORDENACAO_LOTE = 'lote';
    const REPORT_ORDENACAO_LOGRADOURO = 'logradouro';
    const REPORT_ORDENACAO_BAIRRO = 'bairro';
    const REPORT_ORDENACAO_CEP = 'cep';
    
    protected $ordenacoes = [
        self::REPORT_ORDENACAO_INSCRICAO => 'label.imobiliarioRelatorios.cadastroImobiliario.ordenacaoOpcoes.incricao',
        self::REPORT_ORDENACAO_LOCALIZACAO => 'label.imobiliarioRelatorios.cadastroImobiliario.ordenacaoOpcoes.localizacao',
        self::REPORT_ORDENACAO_LOTE => 'label.imobiliarioRelatorios.cadastroImobiliario.ordenacaoOpcoes.lote',
        self::REPORT_ORDENACAO_LOGRADOURO => 'label.imobiliarioRelatorios.cadastroImobiliario.ordenacaoOpcoes.logradouro',
        self::REPORT_ORDENACAO_BAIRRO => 'label.imobiliarioRelatorios.cadastroImobiliario.ordenacaoOpcoes.bairro',
        self::REPORT_ORDENACAO_CEP => 'label.imobiliarioRelatorios.cadastroImobiliario.ordenacaoOpcoes.cep'
    ];
    
    protected $baseRouteName = 'urbem_tributario_imobiliario_relatorio_imobiliario';
    protected $baseRoutePattern = 'tributario/cadastro-imobiliario/relatorios/cadastro-imobiliario';
    protected $legendButtonSave = array('icon' => 'description', 'text' => 'Gerar Relatório');
    
    protected $includeJs = [
        '/tributario/javascripts/imobiliario/relatorio-cadastro-imobiliario.js'
    ];
    
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
        
        $fieldOptions = [];
        
        $fieldOptions['localizacaoInicial'] = [
            'label' => 'label.imobiliarioRelatorios.cadastroImobiliario.localizacaoDe',
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'maxlength_9 localizacao_mask '
            ]
        ];
        
        $fieldOptions['localizacaoFinal'] = [
            'label' => 'label.imobiliarioRelatorios.cadastroImobiliario.localizacaoAte',
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'maxlength_9 localizacao_mask '
            ]
        ];
        
        $fieldOptions['loteInicial'] = [
            'label' => 'label.imobiliarioRelatorios.cadastroImobiliario.loteDe',
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'maxlength_3 '
            ]
        ];
        
        $fieldOptions['loteFinal'] = [
            'label' => 'label.imobiliarioRelatorios.cadastroImobiliario.loteAte',
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'maxlength_3 '
            ]
        ];
        
        $fieldOptions['inscricaoImobiliariaInicial'] = [
            'label' => 'label.imobiliarioRelatorios.cadastroImobiliario.inscricaoImobiliariaDe',
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'maxlength_4 '
            ]
        ];
        
        $fieldOptions['inscricaoImobiliariaFinal'] = [
            'label' => 'label.imobiliarioRelatorios.cadastroImobiliario.inscricaoImobiliariaAte',
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'maxlength_4 '
            ]
        ];
        
        $fieldOptions['codigoLogradouroInicial'] = [
            'label' => 'label.imobiliarioRelatorios.cadastroImobiliario.codigoLogradouroDe',
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'maxlength_10 '
            ]
        ];
        
        $fieldOptions['codigoLogradouroFinal'] = [
            'label' => 'label.imobiliarioRelatorios.cadastroImobiliario.codigoLogradouroAte',
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'maxlength_10 '
            ]
        ];
        
        $fieldOptions['codigoBairroInicial'] = [
            'label' => 'label.imobiliarioRelatorios.cadastroImobiliario.codigoBairroDe',
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'maxlength_10 '
            ]
        ];
        
        $fieldOptions['codigoBairroFinal'] = [
            'label' => 'label.imobiliarioRelatorios.cadastroImobiliario.codigoBairroAte',
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'maxlength_10 '
            ]
        ];
        
        $imovel = [
            self::REPORT_SEM_EDIFICACAO => 'label.imobiliarioRelatorios.cadastroImobiliario.imovelOpcoes.semEdificacao',
            self::REPORT_COM_EDIFICACAO => 'label.imobiliarioRelatorios.cadastroImobiliario.imovelOpcoes.comEdificacao',
            self::REPORT_TODOS_EDIFICACAO => 'label.imobiliarioRelatorios.cadastroImobiliario.imovelOpcoes.todos'
        ];
        
        $fieldOptions['imovel'] = [
            'label' => 'label.imobiliarioRelatorios.cadastroImobiliario.tipoImovel',
            'placeholder' => 'label.selecione',
            'choices' => array_flip($imovel),
            'mapped' => false,
            'required' => true
        ];
        
        $relatorios = [
            self::REPORT_ANALITICO => 'label.imobiliarioRelatorios.cadastroImobiliario.tipoRelatorioOpcoes.analitico',
            self::REPORT_SINTETICO => 'label.imobiliarioRelatorios.cadastroImobiliario.tipoRelatorioOpcoes.sintetico'
        ];
        
        $fieldOptions['relatorio'] = [
            'label' => 'label.imobiliarioRelatorios.cadastroImobiliario.tipoRelatorio',
            'placeholder' => 'label.selecione',
            'choices' => array_flip($relatorios),
            'data' => self::REPORT_ANALITICO,
            'mapped' => false,
            'required' => true,
            'attr' => [
                'class' => 'js-tipo-relatorio'
            ]
        ];
        
        $fBuscaProprietario = function ($em, $term, Request $request) {
            $qb = $em->createQueryBuilder('o');
            
            $qb->andWhere('(o.numcgm = :numcgm OR LOWER(o.nomCgm) LIKE :nomCgm)');
            $qb->andWhere('o.numcgm <> 0');
            $qb->setParameter('numcgm', (int) $term);
            $qb->setParameter('nomCgm', sprintf('%%%s%%', strtolower($term)));
            
            $qb->orderBy('o.numcgm', 'ASC');
            
            return $qb;
        };
        
        $fieldOptions['proprietarioInicial'] = [
            'class' => SwCgm::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => $fBuscaProprietario,
            'required' => false,
            'attr' => [
                'class' => 'select2-parameters',
            ],
            'label' => 'label.imobiliarioRelatorios.cadastroImobiliario.proprietarioDe',
            ];
        
        $fieldOptions['proprietarioFinal'] = [
            'class' => SwCgm::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => $fBuscaProprietario,
            'required' => false,
            'attr' => [
                'class' => 'select2-parameters',
            ],
            'label' => 'label.imobiliarioRelatorios.cadastroImobiliario.proprietarioAte',
        ];
        
        $em = $this->getEntityManager();
        $atributoModel = new AtributoDinamicoModel($em);
        
        $fieldOptions['atributosImovel'] = [
            'choices'       => $atributoModel->getAtributosDinamicosPorModuloQuery(Modulo::MODULO_CADASTRO_IMOBILIARIO, Cadastro::CADASTRO_TRIBUTARIO_IMOVEL)->getQuery()->getResult(),
            'choice_value' => function (AtributoDinamico $atributos) {
            if (!$atributos) {
                return;
            }
            return sprintf('%s', $atributos->getCodAtributo());
            },
            'choice_label' => function (AtributoDinamico $atributoDinamico) {
                return "{$atributoDinamico->getNomAtributo()}";
            },
            'label'       => 'label.imobiliarioRelatorios.cadastroImobiliario.atributosImovel',
            'mapped'      => false,
            'attr' => ['class' => 'select2-parameters select2-multiple-options-custom attr-relatorio '],
            'multiple'    => true,
            'placeholder' => 'label.selecione',
            'required'    => false,
        ];
        
        $fieldOptions['atributosLoteUrbano'] = [
            'choices'       => $atributoModel->getAtributosDinamicosPorModuloQuery(Modulo::MODULO_CADASTRO_IMOBILIARIO, Cadastro::CADASTRO_TRIBUTARIO_LOTE_URBANO)->getQuery()->getResult(),
            'choice_value' => function (AtributoDinamico $atributos) {
            if (!$atributos) {
                return;
            }
            return sprintf('%s', $atributos->getCodAtributo());
            },
            'choice_label' => function (AtributoDinamico $atributoDinamico) {
                return "{$atributoDinamico->getNomAtributo()}";
            },
            'label'       => 'label.imobiliarioRelatorios.cadastroImobiliario.atributosLoteUrbano',
            'mapped'      => false,
            'attr' => ['class' => 'select2-parameters select2-multiple-options-custom attr-relatorio '],
            'multiple'    => true,
            'placeholder' => 'label.selecione',
            'required'    => false,
        ];
        
        $fieldOptions['atributosLoteRural'] = [
            'choices'       => $atributoModel->getAtributosDinamicosPorModuloQuery(Modulo::MODULO_CADASTRO_IMOBILIARIO, Cadastro::CADASTRO_TRIBUTARIO_LOTE_RURAL)->getQuery()->getResult(),
            'choice_value' => function (AtributoDinamico $atributos) {
            if (!$atributos) {
                return;
            }
            return sprintf('%s', $atributos->getCodAtributo());
            },
            'choice_label' => function (AtributoDinamico $atributoDinamico) {
                return "{$atributoDinamico->getNomAtributo()}";
            },
            'label'       => 'label.imobiliarioRelatorios.cadastroImobiliario.atributosLoteRural',
            'mapped'      => false,
            'attr' => ['class' => 'select2-parameters select2-multiple-options-custom attr-relatorio '],
            'multiple'    => true,
            'placeholder' => 'label.selecione',
            'required'    => false,
        ];
        
        $situacao = [
            self::REPORT_SITUACAO_ATIVOS => 'label.imobiliarioRelatorios.cadastroImobiliario.situacaoOpcoes.ativos',
            self::REPORT_SITUACAO_BAIXADOS => 'label.imobiliarioRelatorios.cadastroImobiliario.situacaoOpcoes.baixados',
            self::REPORT_SITUACAO_TODOS => 'label.imobiliarioRelatorios.cadastroImobiliario.situacaoOpcoes.todos'
        ];
        
        $fieldOptions['situacao'] = [
            'label' => 'label.imobiliarioRelatorios.cadastroImobiliario.situacao',
            'placeholder' => 'label.selecione',
            'choices' => array_flip($situacao),
            'mapped' => false,
            'required' => true
        ];
        
        $ordenacao = $this->getOrdenacao();
        
        $fieldOptions['ordenacao'] = [
            'label' => 'label.imobiliarioRelatorios.cadastroImobiliario.ordenacao',
            'placeholder' => 'label.selecione',
            'choices' => array_flip($ordenacao),
            'mapped' => false,
            'required' => true
        ];
        
        $formMapper
            ->with('label.imobiliarioRelatorios.cadastroImobiliario.titulo')
            ->add('localizacaoInicial', 'text', $fieldOptions['localizacaoInicial'])
            ->add('localizacaoFinal', 'text', $fieldOptions['localizacaoFinal'])
            ->add('loteInicial', 'number', $fieldOptions['loteInicial'])
            ->add('loteFinal', 'number', $fieldOptions['loteFinal'])
            ->add('inscricaoImobiliariaInicial', 'number', $fieldOptions['inscricaoImobiliariaInicial'])
            ->add('inscricaoImobiliariaFinal', 'number', $fieldOptions['inscricaoImobiliariaFinal'])
            ->add('codigoLogradouroInicial', 'number', $fieldOptions['codigoLogradouroInicial'])
            ->add('codigoLogradouroFinal', 'number', $fieldOptions['codigoLogradouroFinal'])
            ->add('codigoBairroInicial', 'number', $fieldOptions['codigoBairroInicial'])
            ->add('codigoBairroFinal', 'number', $fieldOptions['codigoBairroFinal'])
            ->add('proprietarioInicial', 'autocomplete', $fieldOptions['proprietarioInicial'])
            ->add('proprietarioFinal', 'autocomplete', $fieldOptions['proprietarioFinal'])
            ->add('tipoImovel', 'choice', $fieldOptions['imovel'])
            ->end()
            ->with(" ")
            ->add('tipoRelatorio', 'choice', $fieldOptions['relatorio'])
            ->add('atributosImovel', 'choice', $fieldOptions['atributosImovel'])
            ->add('atributosLoteUrbano', 'choice', $fieldOptions['atributosLoteUrbano'])
            ->add('atributosLoteRural', 'choice', $fieldOptions['atributosLoteRural'])
            ->end()
            ->with("  ")
            ->add("situacao", "choice", $fieldOptions['situacao'])
            ->add('ordem', "choice", $fieldOptions['ordenacao'])
            ->end()
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
            'atributosImovel' => $this->getCodAtributo($this->getFormField($this->getForm(), 'atributosImovel')),
            'atributosLoteUrbano' => $this->getCodAtributo($this->getFormField($this->getForm(), 'atributosLoteUrbano')),
            'atributosLoteRural' => $this->getCodAtributo($this->getFormField($this->getForm(), 'atributosLoteRural')),
            'situacao' => $this->getFormField($this->getForm(), 'situacao'),
            'ordem' => $this->getFormField($this->getForm(), 'ordem')
        ];
        
        $proprietarioInico = $this->getFormField($this->getForm(), 'proprietarioInicial');
        if ($proprietarioInico) {
            $params['proprietarioInicial'] = $proprietarioInico->getNumCgm();
        } else {
            $params['proprietarioInicial'] = '';
        }
        
        $proprietarioFinal = $this->getFormField($this->getForm(), 'proprietarioFinal');
        if ($proprietarioFinal) {
            $params['proprietarioFinal'] = $proprietarioFinal->getNumCgm();
        } else {
            $params['proprietarioFinal'] = '';
        }
        
        $this->forceRedirect($this->generateUrl('relatorio', $params));
    }
    
    /**
     * @param $form
     * @param $fieldName
     * @return mixed
     * @return string
     */
    public function getFormField($form, $fieldName)
    {
        return ($form->get($fieldName)->getData()) ? $form->get($fieldName)->getData() : '';
    }
    
    /**
     * @param $atributos
     * @return string|void
     */
    private function getCodAtributo($atributos)
    {
        if (!$atributos) {
            return;
        }
        
        $codAtributo= "";
        foreach ($atributos as $atributo) {
            $codAtributo .= $atributo->getCodAtributo().', ';
        }
        
        return substr($codAtributo, 0, -2);
    }
    
    /**
     * @param $inscricaoMunicipal
     * @return array
     */
    public function getAtributosByImovel($inscricaoMunicipal)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $arr = $em->getRepository(AtributoDinamico::class)
        ->getAtributosByImovel(
            $inscricaoMunicipal,
            Modulo::MODULO_CADASTRO_IMOBILIARIO,
            Cadastro::CADASTRO_TRIBUTARIO_IMOVEL
            );
        
        return $arr;
    }
    
    /**
     * @param int $codLote
     * @return array
     */
    public function getAtributosByLoteUrbano($codLote)
    {
        return $this->_getAtributosByLote($codLote, Cadastro::CADASTRO_TRIBUTARIO_LOTE_URBANO);
    }
    
    /**
     * @param int $codLote
     * @return array
     */
    public function getAtributosByLoteRural($codLote)
    {
        return $this->_getAtributosByLote($codLote, Cadastro::CADASTRO_TRIBUTARIO_LOTE_RURAL);
    }
    
    /**
     * @param int $codLote
     * @param int $codCadastro
     * @return array
     */
    private function _getAtributosByLote($codLote, $codCadastro)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $arr = $em->getRepository(AtributoDinamico::class)
        ->getAtributosByLote(
            $codLote,
            Modulo::MODULO_CADASTRO_IMOBILIARIO,
            $codCadastro
        );
        
        return $arr;
    }
    
    /**
     * @param string $codAtributo
     * @return string
     */
    public function getNomeAtributoImovel($codAtributo)
    {
        return $this->_getNomeAtributo($codAtributo, Cadastro::CADASTRO_TRIBUTARIO_IMOVEL);
    }
    
    /**
     * @param string $codAtributo
     * @return string
     */
    public function getNomeAtributoLoteUrbano($codAtributo)
    {
        return $this->_getNomeAtributo($codAtributo, Cadastro::CADASTRO_TRIBUTARIO_LOTE_URBANO);
    }
    
    /**
     * @param string $codAtributo
     * @return string
     */
    public function getNomeAtributoLoteRural($codAtributo)
    {
        return $this->_getNomeAtributo($codAtributo, Cadastro::CADASTRO_TRIBUTARIO_LOTE_RURAL);
    }
    
    /** 
     * @param int $codAtributo
     * @param string $codCadastro
     * @return string
     */
    private function _getNomeAtributo($codAtributo, $codCadastro)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $atributo = $em->getRepository(AtributoDinamico::class)
        ->findOneBy(
            [
                'codModulo' => Modulo::MODULO_CADASTRO_IMOBILIARIO,
                'codCadastro' => $codCadastro,
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
