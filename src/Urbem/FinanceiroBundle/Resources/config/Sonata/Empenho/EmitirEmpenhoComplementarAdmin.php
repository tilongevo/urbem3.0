<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Empenho;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Urbem\CoreBundle\Entity\Empenho\Empenho;

class EmitirEmpenhoComplementarAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_empenho_emitir_empenho_complementar';
    protected $baseRoutePattern = 'financeiro/empenho/emitir-empenho-complementar';
    protected $includeJs = array(
        '/financeiro/javascripts/empenho/emitir-empenho-complementar.js'
    );
    
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove("delete");
        $collection->remove("export");
        $collection->remove("batch");
        $collection->add('get_empenho_original', 'get-empenho-original', array(), array(), array(), '', array(), array('POST'));
        $collection->add('get_informacao_empenho_original', 'get-informacao-empenho-original', array(), array(), array(), '', array(), array('POST'));
    }
    
    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);
        
        $container = $this->getConfigurationPool()->getContainer();
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $formOptions = array();

        $formOptions['exercicio'] = array(
            'data' => $this->getExercicio(),
            'mapped' => false,
        );

        $formOptions['codEntidade'] = array(
            'label' => 'label.preEmpenho.codEntidade',
            'class' => 'CoreBundle:Orcamento\Entidade',
            'choice_value' => 'codEntidade',
            'choice_label' => 'fkSwCgm.nomCgm',
            'attr' => array(
                'class' => 'select2-parameters filtro-empenho-complementar'
            ),
            'query_builder' => function (\Doctrine\ORM\EntityRepository $er) {
                return $er->createQueryBuilder("e")
                ->where("e.exercicio = '" . $this->getExercicio() . "'");
            },
            'placeholder' => 'label.selecione',
            'mapped' => false
        );
        
        $formOptions['codEmpenhoInicial'] = array(
            'label' => 'label.emitirEmpenhoComplementar.codEmpenhoInicial',
            'mapped' => false,
            'attr' => array(
                'class' => 'filtro-empenho-complementar '
            ),
        );
        
        $formOptions['codEmpenhoFinal'] = array(
            'label' => 'label.emitirEmpenhoComplementar.codEmpenhoFinal',
            'mapped' => false,
            'attr' => array(
                'class' => 'filtro-empenho-complementar '
            ),
        );
        
        $formOptions['periodoInicial'] = array(
            'label' => 'label.emitirEmpenhoComplementar.periodoInicial',
            'format' => 'dd/MM/yyyy',
            'mapped' => false,
            'attr' => array(
                'class' => 'filtro-empenho-complementar '
            ),
        );
        
        $formOptions['periodoFinal'] = array(
            'label' => 'label.emitirEmpenhoComplementar.periodoFinal',
            'format' => 'dd/MM/yyyy',
            'mapped' => false,
            'attr' => array(
                'class' => 'filtro-empenho-complementar '
            ),
        );
        
        $formOptions['codEmpenho'] = array(
            'label' => 'label.emitirEmpenhoComplementar.codEmpenho',
            'choices' => array(),
            'attr' => array(
                'class' => 'select2-parameters'
            ),
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => false
        );
        
        $formOptions['codDespesa'] = array(
            'label' => 'label.preEmpenho.codDespesa',
            'mapped' => false,
            'disabled' => true,
            'required' => false,
        );
        
        $formOptions['codClassificacao'] = array(
            'label' => 'label.preEmpenho.codClassificacao',
            'mapped' => false,
            'disabled' => true,
            'required' => false,
        );
        
        $formOptions['saldoDotacao'] = array(
            'label' => 'label.preEmpenho.saldoDotacao',
            'mapped' => false,
            'disabled' => true,
            'required' => false,
            'currency' => 'BRL',
            'attr' => array(
                'class' => 'money '
            ),
        );
        
        $formOptions['numOrgao'] = array(
            'label' => 'label.preEmpenho.numOrgao',
            'mapped' => false,
            'disabled' => true,
            'required' => false,
        );

        $formOptions['numUnidade'] = array(
            'label' => 'label.preEmpenho.numUnidade',
            'mapped' => false,
            'disabled' => true,
            'required' => false,
        );
        
        $formOptions['cgmBeneficiario'] = array(
            'label' => 'label.emitirEmpenhoComplementar.cgmBeneficiario',
            'mapped' => false,
            'disabled' => true,
            'required' => false,
        );

        $formOptions['codCategoria'] = array(
            'label' => 'label.preEmpenho.codCategoria',
            'mapped' => false,
            'disabled' => true,
            'required' => false,
        );
        
        $formOptions['descricao'] = array(
            'label' => 'label.emitirEmpenhoDiversos.descricao',
            'required' => false,
            'attr' => [
                'class' => 'mensagem-inicial '
            ]
        );
        
        $formOptions['dtEmpenho'] = array(
            'label' => 'label.emitirEmpenhoDiversos.dtEmpenho',
            'format' => 'dd/MM/yyyy',
            'mapped' => false,
        );
        
        $formOptions['dtValidadeFinal'] = array(
            'label' => 'label.preEmpenho.dtValidadeFinal',
            'format' => 'dd/MM/yyyy',
            'mapped' => false,
        );
        
        $formOptions['codCategoria'] = array(
            'label' => 'label.preEmpenho.codCategoria',
            'mapped' => false,
            'disabled' => true,
            'required' => false,
        );
        
        $formOptions['codHistorico'] = array(
            'label' => 'label.preEmpenho.codHistorico',
            'mapped' => false,
            'disabled' => true,
            'required' => false,
        );
        
        $formOptions['stExercicioContrato'] = array(
            'label' => 'label.emitirEmpenhoDiversos.stExercicioContrato',
            'mapped' => false,
            'required' => false,
        );

        $formOptions['inCodContrato'] = array(
            'label' => 'label.emitirEmpenhoDiversos.inCodContrato',
            'mapped' => false,
            'required' => false,
            'choices' => array(),
            'attr' => array(
                'class' => 'select2-parameters'
            ),
            'placeholder' => 'label.selecione',
        );
        
        $formMapper
            ->with('label.emitirEmpenhoComplementar.dadoEntidade')
                ->add(
                    'exercicio',
                    'hidden',
                    $formOptions['exercicio']
                )
                ->add(
                    'codEntidade',
                    'entity',
                    $formOptions['codEntidade']
                )
            ->end()
            ->with('label.emitirEmpenhoComplementar.filtroEmpenhOriginal')
                ->add(
                    'codEmpenhoInicial',
                    'number',
                    $formOptions['codEmpenhoInicial']
                )
                ->add(
                    'codEmpenhoFinal',
                    'number',
                    $formOptions['codEmpenhoFinal']
                )
                ->add(
                    'periodoInicial',
                    'sonata_type_date_picker',
                    $formOptions['periodoInicial']
                )
                ->add(
                    'periodoFinal',
                    'sonata_type_date_picker',
                    $formOptions['periodoFinal']
                )
                ->add(
                    'codEmpenho',
                    'choice',
                    $formOptions['codEmpenho']
                )
            ->end()
            ->with('label.emitirEmpenhoComplementar.dadosEmpenho')
                ->add(
                    'codDespesa',
                    'text',
                    $formOptions['codDespesa']
                )
                ->add(
                    'codClassificacao',
                    'text',
                    $formOptions['codClassificacao']
                )
                ->add(
                    'saldoDotacao',
                    'money',
                    $formOptions['saldoDotacao']
                )
                ->add(
                    'numOrgao',
                    'text',
                    $formOptions['numOrgao']
                )
                ->add(
                    'numUnidade',
                    'text',
                    $formOptions['numUnidade']
                )
                ->add(
                    'cgmBeneficiario',
                    'text',
                    $formOptions['cgmBeneficiario']
                )
                ->add(
                    'codCategoria',
                    'text',
                    $formOptions['codCategoria']
                )
                ->add(
                    'dtEmpenho',
                    'sonata_type_date_picker',
                    $formOptions['dtEmpenho']
                )
                ->add(
                    'dtValidadeFinal',
                    'sonata_type_date_picker',
                    $formOptions['dtValidadeFinal']
                )
                ->add(
                    'codHistorico',
                    'text',
                    $formOptions['codHistorico']
                )
                ->add(
                    'descricao',
                    'textarea',
                    $formOptions['descricao']
                )
            ->end()
        ;
        
        $formMapper->with('label.preEmpenho.atributos');

        $atributos = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
        ->getAtributosDinamicos();

        foreach ($atributos as $atributo) {
            $type = "";
            $field_name = 'Atributo_' . $atributo->cod_atributo . '_' . $atributo->cod_cadastro;
            switch ($atributo->cod_tipo) {
                case 1:
                    $type = "number";
                    $formOptions[$field_name] = array(
                        'label' => $atributo->nom_atributo,
                        'required' => ! $atributo->nao_nulo,
                        'mapped' => false,
                    );
                    break;
                case 3:
                    $type = "choice";

                    $valor_padrao = explode(",", $atributo->valor_padrao);
                    $valor_padrao_desc = explode("[][][]", $atributo->valor_padrao_desc);
                    $choices = array();

                    foreach ($valor_padrao_desc as $key => $desc) {
                        $choices[$desc] = $valor_padrao[$key];
                    }

                    $formOptions[$field_name] = array(
                        'label' => $atributo->nom_atributo,
                        'choices' => $choices,
                        'required' => ! $atributo->nao_nulo,
                        'mapped' => false,
                        'attr' => array(
                            'class' => 'select2-parameters'
                        ),
                        'placeholder' => 'label.selecione'
                    );
                    break;
                default:
                    $type = "text";
                    $formOptions[$field_name] = array(
                        'label' => $atributo->nom_atributo,
                        'required' => ! $atributo->nao_nulo,
                        'mapped' => false,
                    );
                    break;
            }
            
            if ($this->id($this->getSubject())) {
                $data = $entityManager->getRepository('CoreBundle:Empenho\AtributoEmpenhoValor')
                ->findOneBy(
                    array(
                        'codPreEmpenho' => $this->getSubject()->getCodPreEmpenho(),
                        'exercicio' => $autorizacaoEmpenho->getExercicio(),
                        'codModulo' => Empenho::CODMODULO,
                        'codCadastro' => $atributo->cod_cadastro,
                        'codAtributo' => $atributo->cod_atributo,
                    ),
                    array(
                        'timestamp' => 'DESC'
                    )
                )->getValor();

                $formOptions[$field_name]['data'] = $data;
            }

            $formMapper->add(
                $field_name,
                $type,
                $formOptions[$field_name]
            );
        }

        $formMapper->end();

        $formMapper->with('label.emitirEmpenhoDiversos.codContratoTitle')
            ->add(
                'stExercicioContrato',
                'number',
                $formOptions['stExercicioContrato']
            )
            ->add(
                'inCodContrato',
                'choice',
                $formOptions['inCodContrato']
            )
        ->end();
        
        $admin = $this;
        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formMapper, $admin, $entityManager, $formOptions) {
                $form = $event->getForm();
                $data = $event->getData();
                $subject = $admin->getSubject($data);

                if ($form->has('codEmpenho')) {
                    $form->remove('codEmpenho');
                }
                
                $container = $this->getConfigurationPool()->getContainer();
                $currentUser = $container->get('security.token_storage')->getToken()->getUser();
                
                $formOptions['codEmpenho']['auto_initialize'] = false;
                $formOptions['codEmpenho']['choices'] = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
                ->getEmpenhoOriginal(
                    $data['codEntidade'],
                    $currentUser->getFkSwCgm()->getNumcgm(),
                    $data['exercicio'],
                    $data['codEmpenhoInicial'],
                    $data['codEmpenhoFinal'],
                    $data['periodoInicial'],
                    $data['periodoFinal'],
                    true
                );

                $codEmpenho = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                    'codEmpenho',
                    'choice',
                    null,
                    $formOptions['codEmpenho']
                );

                $form->add($codEmpenho);
            }
        );
    }
    
    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $showMapper
            ->add('codPreEmpenho')
            ->add('implantado')
            ->add('descricao')
        ;
    }
    
    public function prePersist($object)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        
        $container = $this->getConfigurationPool()->getContainer();
        $currentUser = $container->get('security.token_storage')->getToken()->getUser();
        
        (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
        ->saveEmitirEmpenhoComplementar($object, $this->getForm(), $currentUser);

        $this->redirectToUrl('/financeiro/empenho/emitir-empenho-complementar/' . $object->getExercicio() . "~". $object->getCodPreEmpenho() . '/show');
    }
    
    public function getDespesa()
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        return (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
        ->getDespesa($this->getSubject());
    }
    
    public function getAtributos()
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $atributos = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
        ->getAtributosDinamicos();

        $atributosArr = array();
        foreach ($atributos as $atributo) {
            $field_name = 'Atributo_' . $atributo->cod_atributo . '_' . $atributo->cod_cadastro;

            $data = $entityManager->getRepository('CoreBundle:Empenho\AtributoEmpenhoValor')
            ->findOneBy(
                array(
                    'codPreEmpenho' => $this->getSubject()->getCodPreEmpenho(),
                    'exercicio' => $this->getSubject()->getExercicio(),
                    'codModulo' => Empenho::CODMODULO,
                    'codCadastro' => $atributo->cod_cadastro,
                    'codAtributo' => $atributo->cod_atributo,
                ),
                array(
                    'timestamp' => 'DESC'
                )
            )->getValor();

            $valor = "&nbsp;";
            switch ($atributo->cod_tipo) {
                case 3:
                    $valor_padrao = explode(",", $atributo->valor_padrao);
                    $valor_padrao_desc = explode("[][][]", $atributo->valor_padrao_desc);
            
                    $choices = array();
                    
                    foreach ($valor_padrao_desc as $key => $desc) {
                        $choices[$valor_padrao[$key]] = $desc;
                    }
                    
                    if (! is_null($data)) {
                        $valor = $choices[$data];
                    } else {
                        $valor = "";
                    }
                    break;
                default:
                    if (! is_null($data)) {
                        $valor = $data;
                    } else {
                        $valor = "";
                    }
                    break;
            }
            
            $atributosArr[$field_name] = array(
                'label' => $atributo->nom_atributo,
                'data' => $valor
            );
        }
        
        return $atributosArr;
    }

    public function getItemPreEmpenho()
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $itemPreEmpenhoList = $entityManager->getRepository("CoreBundle:Empenho\ItemPreEmpenho")
        ->findBy(
            array(
                'exercicio' => $this->getSubject()->getExercicio(),
                'codPreEmpenho' => $this->getSubject()->getCodPreEmpenho(),
                'fkEmpenhoPreEmpenho' => $this->getSubject()
            )
        );

        return $itemPreEmpenhoList;
    }
    
    public function getEmpenhoAssinatura()
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        
        $codEmpenho = $this->getEmpenho();
        
        $empenhoAssinaturaList = $entityManager->getRepository("CoreBundle:Empenho\EmpenhoAssinatura")
        ->findBy(
            array(
                'codEmpenho' => $codEmpenho->getCodEmpenho(),
                'codEntidade' => $codEmpenho->getCodEntidade(),
                'exercicio' => $this->getSubject()->getExercicio(),
            )
        );

        return $empenhoAssinaturaList;
    }

    public function getVlTotal()
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $reservaSaldos = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
        ->getReservaSaldoPerfil($this->getSubject());
        
        if ($reservaSaldos) {
            return $reservaSaldos->getVlReserva();
        } else {
            return null;
        }
    }

    public function getEmpenho()
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $empenho = $entityManager->getRepository("CoreBundle:Empenho\Empenho")
        ->findOneBy(
            array(
                'codPreEmpenho' => $this->getSubject()->getCodPreEmpenho(),
                'exercicio' => $this->getSubject()->getExercicio()
            )
        );
        
        return $empenho;
    }
    
    public function validate(\Sonata\CoreBundle\Validator\ErrorElement $errorElement, $object)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $configuracao = $entityManager->getRepository("CoreBundle:Administracao\Configuracao")
        ->pegaConfiguracao(
            "utilizar_encerramento_mes",
            9,
            $this->getExercicio()
        );

        if ($configuracao[0]['valor'] != "false") {
            $ultimoMesEncerrado = $entityManager->getRepository("CoreBundle:Contabilidade\EncerramentoMes")
            ->getUltimoMesEncerrado($this->getExercicio());

            $dtAutorizacao = date("m", mktime(0, 0, 0, date("m"), date("d"), $this->getExercicio()));
            if (!empty($ultimoMesEncerrado)) {
                if ($ultimoMesEncerrado->mes >= (int) $dtAutorizacao) {
                    $error = "Mês do Empenho encerrado!";
                    $errorElement->with('codEntidade')->addViolation($error)->end();
                    $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $error);
                }
            }
        }
    }
}
