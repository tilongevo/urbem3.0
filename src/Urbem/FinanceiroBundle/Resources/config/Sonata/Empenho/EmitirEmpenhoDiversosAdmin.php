<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Empenho;

use Urbem\CoreBundle\Entity\Empenho\Empenho;
use Urbem\CoreBundle\Model\Orcamento\DespesaModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class EmitirEmpenhoDiversosAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_empenho_emitir_empenho_diversos';
    protected $baseRoutePattern = 'financeiro/empenho/emitir-empenho-diversos';
    protected $includeJs = array(
        '/financeiro/javascripts/empenho/emitir-empenho-diversos.js'
    );

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove("delete");
        $collection->remove("export");
        $collection->remove("batch");
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

        $numCgm = $container->get('security.token_storage')->getToken()->getUser();

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
                'class' => 'select2-parameters'
            ),
            'query_builder' => function (\Doctrine\ORM\EntityRepository $er) {
                return $er->createQueryBuilder("e")
                    ->where("e.exercicio = '" . $this->getExercicio() . "'");
            },
            'placeholder' => 'label.selecione',
            'mapped' => false
        );

        $formOptions['dtEmpenho'] = array(
            'label' => 'label.emitirEmpenhoDiversos.dtEmpenho',
            'format' => 'dd/MM/yyyy',
            'mapped' => false,
        );

        $formOptions['codDespesa'] = array(
            'label' => 'label.preEmpenho.codDespesa',
            'choices' => array(),
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'attr' => array(
                'class' => 'select2-parameters'
            ),
        );

        $formOptions['codClassificacao'] = array(
            'label' => 'label.preEmpenho.codClassificacao',
            'choices' => array(),
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'attr' => array(
                'class' => 'select2-parameters'
            ),
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

        $formOptions['fkSwCgm'] = array(
            'label' => 'label.preEmpenho.cgmBeneficiario',
            'class' => 'CoreBundle:SwCgm',
            'property' => 'nomCgm',
            'to_string_callback' => function (\Urbem\CoreBundle\Entity\SwCgm $swCgm, $property) {
                return $swCgm->getNomCgm();
            },
            'attr' => array(
                'class' => 'select2-parameters'
            ),
        );

        $formOptions['codCategoria'] = array(
            'label' => 'label.preEmpenho.codCategoria',
            'class' => 'CoreBundle:Empenho\CategoriaEmpenho',
            'choice_label' => 'descricao',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'mapped' => false,
            'placeholder' => 'label.selecione',
        );

        $formOptions['contaContrapartida'] = array(
            'label' => 'label.preEmpenho.contaContrapartida',
            'choices' => array(),
            'mapped' => false,
            'attr' => array(
                'class' => 'select2-parameters'
            ),
            'placeholder' => 'label.selecione',
        );

        $formOptions['fkEmpenhoHistorico'] = array(
            'label' => 'label.preEmpenho.codHistorico',
            'class' => 'CoreBundle:Empenho\Historico',
            'attr' => array(
                'class' => 'select2-parameters'
            ),
            'query_builder' => function (\Doctrine\ORM\EntityRepository $er) {
                return $er->createQueryBuilder("h")
                    ->where("h.exercicio = '" . $this->getExercicio() . "'");
            },
            'placeholder' => 'label.selecione',
            'required' => true,
        );

        $formOptions['fkEmpenhoTipoEmpenho'] = array(
            'label' => 'label.emitirEmpenhoDiversos.codTipo',
            'class' => 'CoreBundle:Empenho\TipoEmpenho',
            'choice_label' => 'nomTipo',
            'attr' => array(
                'class' => 'select2-parameters'
            ),
            'query_builder' => function (\Doctrine\ORM\EntityRepository $er) {
                return $er->createQueryBuilder("te")
                    ->where("te.codTipo <> 0");
            },
            'placeholder' => 'label.selecione',
        );

        $formOptions['dtValidadeFinal'] = array(
            'label' => 'label.preEmpenho.dtValidadeFinal',
            'format' => 'dd/MM/yyyy',
            'mapped' => false,
        );

        $formOptions['descricao'] = array(
            'label' => 'label.emitirEmpenhoDiversos.descricao',
            'required' => false,
            'attr' => [
                'class' => 'mensagem-inicial '
            ]
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

        if ($this->id($this->getSubject())) {
            $autorizacaoEmpenho = $this->getSubject()->getAutorizacaoEmpenho()->last();

            $formOptions['codEntidade']['data'] = $autorizacaoEmpenho->getCodEntidade();
            $formOptions['dtAutorizacao']['data'] = $autorizacaoEmpenho->getDtAutorizacao();
            $formOptions['numOrgao']['choices'] = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
                ->getOrgaoOrcamentario(
                    $autorizacaoEmpenho->getExercicio(),
                    $autorizacaoEmpenho->getCodEntidade()->getCodEntidade(),
                    $numCgm->getNumcgm()->getNumcgm(),
                    true
                );

            $formOptions['numOrgao']['data'] = $autorizacaoEmpenho->getNumOrgao()->getNumOrgao();

            $formOptions['numUnidade']['choices'] = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
                ->getUnidadeOrcamentaria(
                    $autorizacaoEmpenho->getCodEntidade()->getCodEntidade(),
                    $autorizacaoEmpenho->getNumOrgao()->getNumOrgao(),
                    true
                );

            $preEmpenhoDespesa = $entityManager->getRepository('CoreBundle:Empenho\PreEmpenhoDespesa')
                ->findOneBy(
                    array(
                        'codPreEmpenho' => $this->getSubject()->getCodPreEmpenho(),
                        'exercicio' => $autorizacaoEmpenho->getExercicio(),
                    )
                );

            $formOptions['codDespesa']['choices'] = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
                ->getDotacaoOrcamentaria(
                    $autorizacaoEmpenho->getExercicio(),
                    $numCgm->getNumcgm()->getNumcgm(),
                    $autorizacaoEmpenho->getCodEntidade()->getCodEntidade(),
                    true
                );

            if ($preEmpenhoDespesa) {
                $formOptions['codDespesa']['data'] = $preEmpenhoDespesa->getCodDespesa();

                $formOptions['codClassificacao']['choices'] = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
                    ->getDesdobramento(
                        $preEmpenhoDespesa->getCodDespesa(),
                        $autorizacaoEmpenho->getExercicio(),
                        true
                    );

                $formOptions['codClassificacao']['data'] = $entityManager->getRepository('CoreBundle:Orcamento\ContaDespesa')
                    ->findOneBy(
                        array(
                            'exercicio' => $autorizacaoEmpenho->getExercicio(),
                            'codConta' => $preEmpenhoDespesa->getCodConta()
                        )
                    )->getCodEstrutural();

                $formOptions['saldoDotacao']['data'] = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
                    ->getSaldoDotacao(
                        $autorizacaoEmpenho->getExercicio(),
                        $preEmpenhoDespesa->getCodDespesa(),
                        $autorizacaoEmpenho->getDtAutorizacao()->format("d/m/Y"),
                        $autorizacaoEmpenho->getCodEntidade()->getCodEntidade(),
                        true
                    );
            }

            $formOptions['numUnidade']['data'] = $autorizacaoEmpenho->getNumUnidade()->getNumUnidade();
            $formOptions['codCategoria']['data'] = $autorizacaoEmpenho->getCodCategoria();
            $formOptions['contaContrapartida']['choices'] = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
                ->getContraPartida(
                    $autorizacaoEmpenho->getExercicio(),
                    $this->getSubject()->getFkSwCgm()->getNumcgm(),
                    true
                );

            $formOptions['contaContrapartida']['data'] = $entityManager->getRepository('CoreBundle:Empenho\ContrapartidaAutorizacao')
                ->findOneBy(
                    array(
                        'exercicio' => $autorizacaoEmpenho->getExercicio(),
                        'codEntidade' => $autorizacaoEmpenho->getCodEntidade()->getCodEntidade(),
                        'codAutorizacao' => $autorizacaoEmpenho->getCodAutorizacao(),
                    )
                )->getContaContrapartida();
        } else {
            $formOptions['dtValidadeFinal']['data'] = new \DateTime('Dec 31');
            $formOptions['stExercicioContrato']['data'] = $this->getExercicio();
        }

        $formMapper
            ->with('label.emitirEmpenhoDiversos.dadosEmpenho')
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
            ->add(
                'dtEmpenho',
                'sonata_type_date_picker',
                $formOptions['dtEmpenho']
            )
            ->add(
                'codDespesa',
                'choice',
                $formOptions['codDespesa']
            )
            ->add(
                'codClassificacao',
                'choice',
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
                'fkSwCgm',
                'sonata_type_model_autocomplete',
                $formOptions['fkSwCgm'],
                array(
                    'admin_code' => 'core.admin.filter.sw_cgm'
                )
            )
            ->add(
                'codCategoria',
                'entity',
                $formOptions['codCategoria']
            )
            ->add(
                'contaContrapartida',
                'choice',
                $formOptions['contaContrapartida']
            )
            ->add(
                'fkEmpenhoTipoEmpenho',
                'entity',
                $formOptions['fkEmpenhoTipoEmpenho']
            )
            ->add(
                'dtValidadeFinal',
                'sonata_type_date_picker',
                $formOptions['dtValidadeFinal']
            )
            ->add(
                'fkEmpenhoHistorico',
                'entity',
                $formOptions['fkEmpenhoHistorico']
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
                            'codModulo' => 10,
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
            function (FormEvent $event) use ($formMapper, $admin, $entityManager, $numCgm, $formOptions) {
                $form = $event->getForm();
                $data = $event->getData();
                $subject = $admin->getSubject($data);

                if ($form->has('codDespesa')) {
                    $form->remove('codDespesa');
                }

                if (isset($data['codEntidade']) && $data['codEntidade'] != "") {
                    $formOptions['codDespesa']['auto_initialize'] = false;
                    $formOptions['codDespesa']['choices'] = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
                        ->getDotacaoOrcamentaria(
                            $data['exercicio'],
                            $numCgm->getFkSwCgm()->getNumcgm(),
                            $data['codEntidade'],
                            true
                        );

                    $codDespesa = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                        'codDespesa',
                        'choice',
                        null,
                        $formOptions['codDespesa']
                    );

                    $form->add($codDespesa);
                }

                if ($form->has('codClassificacao')) {
                    $form->remove('codClassificacao');
                }

                if (isset($data['codDespesa']) && $data['codDespesa'] != "") {
                    $formOptions['codClassificacao']['auto_initialize'] = false;
                    $formOptions['codClassificacao']['choices'] = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
                        ->getDesdobramento(
                            $data['codDespesa'],
                            $data['exercicio'],
                            true
                        );

                    $codClassificacao = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                        'codClassificacao',
                        'choice',
                        null,
                        $formOptions['codClassificacao']
                    );

                    $form->add($codClassificacao);
                }

                if ($form->has('numOrgao')) {
                    $form->remove('numOrgao');
                }

                if (isset($data['codEntidade']) && $data['codEntidade'] != "") {
                    $formOptions['numOrgao']['auto_initialize'] = false;
                    $formOptions['numOrgao']['choices'] = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
                        ->getOrgaoOrcamentario(
                            $data['exercicio'],
                            $data['codEntidade'],
                            $numCgm->getFkSwCgm()->getNumcgm(),
                            true
                        );

                    $numOrgao = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                        'numOrgao',
                        'choice',
                        null,
                        $formOptions['numOrgao']
                    );

                    $form->add($numOrgao);
                }

                if ($form->has('numUnidade')) {
                    $form->remove('numUnidade');
                }

                if (isset($data['numOrgao']) && $data['numOrgao'] != "") {
                    $formOptions['numUnidade']['auto_initialize'] = false;
                    $formOptions['numUnidade']['choices'] = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
                        ->getUnidadeOrcamentaria(
                            $data['codEntidade'],
                            $data['numOrgao'],
                            true
                        );

                    $numUnidade = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                        'numUnidade',
                        'choice',
                        null,
                        $formOptions['numUnidade']
                    );

                    $form->add($numUnidade);
                }

                if ($form->has('contaContrapartida')) {
                    $form->remove('contaContrapartida');
                }

                if (isset($data['fkSwCgm']) && $data['fkSwCgm'] != "") {
                    $formOptions['contaContrapartida']['auto_initialize'] = false;
                    $formOptions['contaContrapartida']['choices'] = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
                        ->getContrapartida(
                            $data['exercicio'],
                            $data['fkSwCgm'],
                            true
                        );

                    $contaContrapartida = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                        'contaContrapartida',
                        'choice',
                        null,
                        $formOptions['contaContrapartida']
                    );

                    $form->add($contaContrapartida);
                }
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
            ->add('exercicio')
            ->add('implantado')
            ->add('descricao')
        ;
    }

    public function prePersist($object)
    {
        // Salvando os dados
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $container = $this->getConfigurationPool()->getContainer();
        $numCgm = $container->get('security.token_storage')->getToken()->getUser();
        $codPreEmpenho = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
            ->getUltimoPreEmpenho($this->getExercicio());

        $object->setExercicio($this->getExercicio());
        $object->setCodPreEmpenho($codPreEmpenho);
        $object->setCgmUsuario($numCgm->getNumcgm());

        $entityManager->persist($object);

        $postPersist = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
            ->afterEmitirEmpenhoDiversos($object, $this->getForm());

        $this->redirectToUrl('/financeiro/empenho/emitir-empenho-diversos/' . $object->getExercicio() . "~". $object->getCodPreEmpenho() . '/show');
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
                        'codModulo' => 10,
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

    /**
     * @return mixed
     */
    public function getSaldoDotacao()
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $container = $this->getConfigurationPool()->getContainer();

        $locale = $container->getParameter('locale');

        return (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
            ->getSaldoDotacaoDataAtual(
                $this->getSubject()->getExercicio(),
                $this->getSubject()->getFkEmpenhoPreEmpenhoDespesa()->getCodDespesa(),
                $this->getSubject()->getDtEmpenho(),
                $this->getSubject()->getCodEntidade(),
                $locale
            );
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

        // Obter o último empenho cadastrado no sistema para cada entidade
        $codEntidade = $this->getForm()->get('codEntidade')->getData();
        $repository = $this->getDoctrine()->getRepository(Empenho::class);
        $lastDataEmpenho = $repository->findOneBy(['codEntidade' => $codEntidade->getCodEntidade()], ['dtEmpenho' => 'DESC']);
        $dataEmpenhoFormulario = $this->getForm()->get('dtEmpenho')->getData()->format('Y-m-d');
        $lastDataEmpenho = $lastDataEmpenho ? $lastDataEmpenho->getDtEmpenho()->format('Y-m-d') : '';

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

        if ($dataEmpenhoFormulario < $lastDataEmpenho) {
            $error = $this->trans('label.emitirEmpenhoDiversos.erroDtEmpenho');
            $errorElement->with('dtEmpenho')->addViolation($error)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $error);
        }
    }
}
