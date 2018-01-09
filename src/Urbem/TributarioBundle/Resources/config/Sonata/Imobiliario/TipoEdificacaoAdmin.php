<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Imobiliario;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Urbem\CoreBundle\Model\Administracao\AtributoDinamicoModel;
use Urbem\CoreBundle\Model\Administracao\CadastroModel;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Entity\Economico\AtributoElemento;
use Urbem\CoreBundle\Entity\Administracao\AtributoDinamico;
use Urbem\CoreBundle\Entity\Administracao\Configuracao;
use Urbem\CoreBundle\Entity\Imobiliario\TipoEdificacao;
use Urbem\CoreBundle\Entity\Imobiliario\TipoEdificacaoValorM2;
use Urbem\CoreBundle\Entity\Imobiliario\TipoEdificacaoAliquota;
use Urbem\CoreBundle\Entity\Normas\Norma;
use Urbem\TributarioBundle\Controller\Imobiliario\ConfiguracaoController;
use Urbem\CoreBundle\Model\Normas\NormaModel;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoEdificacao;

class TipoEdificacaoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_imobiliario_tipo_edificacao';
    protected $baseRoutePattern = 'tributario/cadastro-imobiliario/tipo-edificacao';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codTipo', null, ['label' => 'label.imobiliarioEdificacao.codTipo'])
            ->add('nomTipo', null, ['label' => 'label.imobiliarioEdificacao.nomTipo'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codTipo', null, ['label' => 'label.imobiliarioEdificacao.codTipo'])
            ->add('nomTipo', null, ['label' => 'label.imobiliarioEdificacao.nomTipo'])
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $em = $this->modelManager->getEntityManager($this->getClass());
        $atributoDinamicoModel = new AtributoDinamicoModel($em);

        $objTipoEdificacao = $this->getSubject();

        // Atributos Selecionados
        $qb = $em->getRepository(AtributoDinamico::class)->createQueryBuilder('o');
        $qb->join(AtributoTipoEdificacao::class, 'atributo_tipo_edificacao', 'WITH', 'o.codAtributo = atributo_tipo_edificacao.codAtributo
            AND o.codCadastro = atributo_tipo_edificacao.codCadastro AND o.codModulo = atributo_tipo_edificacao.codModulo');
        $qb->where('o.codCadastro = :codCadastro AND o.codModulo = :codModulo AND atributo_tipo_edificacao.codTipo = :codTipo');
        $qb->setParameter('codCadastro', CadastroModel::CADASTRO_ELEMENTOS);
        $qb->setParameter('codModulo', ConfiguracaoModel::MODULO_TRIBUTARIO_IMOBILIARIO_TIPO_EDIFICACAO);
        $qb->setParameter('codTipo', $objTipoEdificacao ? $objTipoEdificacao->getCodTipo() : null);
        $atributosSelecionados = $qb->getQuery()->getResult();


        $tipoEdificacaoConfigId = array_search('label.configuracaoImobiliaria.tipoEdificacao', ConfiguracaoController::OPCOES);

        // Valores
        $valorM2Config = $em->getRepository(Configuracao::class)
            ->pegaConfiguracao(
                ConfiguracaoController::PARAMETRO_VALOR_MD,
                ConfiguracaoModel::MODULO_TRIBUTARIO_IMOBILIARIO_TIPO_EDIFICACAO,
                $this->getExercicio()
            )
        ;
        $valoresM2Class =  ['class' => 'hidden'];
        $valorM2Obj = false;
        if (!empty($valorM2Config)) {
            $valorM2Config = explode(',', $valorM2Config[0]['valor']);
            if (in_array($tipoEdificacaoConfigId, $valorM2Config)) {
                $valoresM2Class =  [];
                $valorM2Obj = $objTipoEdificacao->getFkImobiliarioTipoEdificacaoValorM2s()->current();
            }
        }

        // Aliquotas
        $aliquotaConfig = $em->getRepository(Configuracao::class)
            ->pegaConfiguracao(
                ConfiguracaoController::PARAMETRO_ALIQUOTAS,
                ConfiguracaoModel::MODULO_TRIBUTARIO_IMOBILIARIO_TIPO_EDIFICACAO,
                $this->getExercicio()
            )
        ;
        $aliquotasClass = ['class' => 'hidden'];
        $aliquotaObj = false;
        if (!empty($aliquotaConfig)) {
            $aliquotaConfig = explode(',', $aliquotaConfig[0]['valor']);
            if (in_array($tipoEdificacaoConfigId, $aliquotaConfig)) {
                $aliquotasClass =  [];
                $aliquotaObj = $objTipoEdificacao->getFkImobiliarioTipoEdificacaoAliquotas()->current();
            }
        }

        $normaModel = new NormaModel($em);
        $normas = $normaModel->getNormas($this->getExercicio());

        $normasArray = array();
        foreach ($normas as $norma) {
            $normasArray[$norma['nom_norma']] = $norma['cod_norma'];
        }

        $formMapper
            ->with('label.imobiliarioEdificacao.dados')
                ->add(
                    'nomTipo',
                    'text',
                    [
                        'label' => 'label.imobiliarioEdificacao.nomTipo',
                        'required' => true
                    ]
                )
                ->add(
                    'codAtributo',
                    ChoiceType::class,
                    [
                        'mapped' => false,
                        'label' => 'label.imobiliarioEdificacao.atributoTipoEdificacao',
                        'multiple' => true,
                        'required' => false,
                        'choices' => $em->getRepository(AtributoDinamico::class)->findBy(
                            [
                                'codCadastro' => CadastroModel::CADASTRO_ELEMENTOS,
                                'codModulo' => ConfiguracaoModel::MODULO_TRIBUTARIO_IMOBILIARIO_TIPO_EDIFICACAO
                            ]
                        ),
                        'choice_label' => 'nomAtributo',
                        'data' => $atributosSelecionados,
                        'attr' => ['class' => 'select2-parameters']
                    ]
                )
            ->end()
            ->with('label.imobiliarioEdificacao.valoresM2', $valoresM2Class)
                    ->add(
                        'fkImobiliarioTipoEdificacaoValorM2s.valorM2Territorial',
                        'money',
                        [
                            'label' => 'label.imobiliarioEdificacao.valorTerritorial',
                            'attr' => [
                                'class' => 'money '
                            ],
                            'currency' => 'BRL',
                            'mapped' => false,
                            'required' => empty($valoresM2Class) ? true : false,
                            'data' => ($valorM2Obj === false) ? null : $valorM2Obj->getValorM2Territorial()
                        ]
                    )
                    ->add(
                        'fkImobiliarioTipoEdificacaoValorM2s.valorM2Predial',
                        'money',
                        [
                            'label' => 'label.imobiliarioEdificacao.aliquotaPredial',
                            'attr' => [
                               'class' => 'money '
                            ],
                            'currency' => 'BRL',
                            'mapped' => false,
                            'required' => empty($valoresM2Class) ? true : false,
                            'data' => ($valorM2Obj === false) ? null : $valorM2Obj->getValorM2Predial()
                        ]
                    )
                    ->add(
                        'fkImobiliarioTipoEdificacaoValorM2s.dtVigencia',
                        'sonata_type_date_picker',
                        [
                            'label' => 'label.imobiliarioEdificacao.inicioVigencia',
                            'format' => 'dd/MM/yyyy',
                            'mapped' => false,
                            'required' => empty($valoresM2Class) ? true : false,
                            'data' => ($valorM2Obj === false) ? null : $valorM2Obj->getDtVigencia()
                        ]
                    )
                    ->add(
                        'fkImobiliarioTipoEdificacaoValorM2s.codNorma',
                        ChoiceType::class,
                        [
                            'label' => 'label.imobiliarioEdificacao.fundamentacaoLegalValorM2',
                            'multiple' => false,
                            'choices' => $normasArray,
                            'attr' => ['class' => 'select2-parameters'],
                            'mapped' => false,
                            'required' => empty($valoresM2Class) ? true : false,
                            'placeholder' => 'Selecione',
                            'data' => ($valorM2Obj === false) ? null : $valorM2Obj->getCodNorma()
                        ]
                    )
            ->end()
            ->with('label.imobiliarioEdificacao.aliquotas', $aliquotasClass)
                    ->add(
                        'fkImobiliarioTipoEdificacaoAliquotas.aliquotaTerritorial',
                        'money',
                        [
                            'label' => 'label.imobiliarioEdificacao.valorTerritorial',
                            'attr' => [
                                'class' => 'money ',
                            ],
                            'currency' => 'BRL',
                            'mapped' => false,
                            'required' => empty($aliquotasClass) ? true : false,
                            'data' => ($aliquotaObj === false) ? null : $aliquotaObj->getAliquotaTerritorial()
                        ]
                    )
                    ->add(
                        'fkImobiliarioTipoEdificacaoAliquotas.aliquotaPredial',
                        'money',
                        [
                            'label' => 'label.imobiliarioEdificacao.aliquotaPredial',
                            'attr' => [
                                'class' => 'money ',
                            ],
                            'currency' => 'BRL',
                            'mapped' => false,
                            'required' => empty($aliquotasClass) ? true : false,
                            'data' => ($aliquotaObj === false) ? null : $aliquotaObj->getAliquotaPredial()
                        ]
                    )
                    ->add(
                        'fkImobiliarioTipoEdificacaoAliquotas.dtVigencia',
                        'sonata_type_date_picker',
                        [
                            'label' => 'label.imobiliarioEdificacao.inicioVigencia',
                            'format' => 'dd/MM/yyyy',
                            'mapped' => false,
                            'required' => empty($aliquotasClass) ? true : false,
                            'data' => ($aliquotaObj === false) ? null : $aliquotaObj->getDtVigencia()
                        ]
                    )
                    ->add(
                        'fkImobiliarioTipoEdificacaoAliquotas.codNorma',
                        ChoiceType::class,
                        [
                            'label' => 'label.imobiliarioEdificacao.fundamentacaoLegalAliquota',
                            'multiple' => false,
                            'choices' => $normasArray,
                            'attr' => ['class' => 'select2-parameters'],
                            'mapped' => false,
                            'required' => empty($aliquotasClass) ? true : false,
                            'placeholder' => 'Selecione',
                            'data' => ($aliquotaObj === false) ? null : $aliquotaObj->getCodNorma()
                        ]
                    )
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);
        $tipoEdificacao = $this->getSubject();

        $this->aliquota = null;
        if ($tipoEdificacao->getCodTipo() && $aliquota = $tipoEdificacao->getFkImobiliarioTipoEdificacaoAliquotas()->current()) {
            $this->aliquota = $aliquota;
            $this->aliquotaNorma = $aliquota->getFkNormasNorma()->getNomNorma();
        }

        $this->valorM2 = null;
        if ($tipoEdificacao->getCodTipo() && $valorM2 = $tipoEdificacao->getFkImobiliarioTipoEdificacaoValorM2s()->current()) {
            $this->valorM2 = $valorM2;
            $this->valorM2Norma = $valorM2->getFkNormasNorma()->getNomNorma();
        }

        $showMapper
            ->with('label.imobiliarioEdificacao.dados')
                ->add('codTipo', null, ['label' => 'label.codigo'])
                ->add('nomTipo', null, ['label' => 'label.nome'])
                ->add(
                    'codAtributo',
                    'customField',
                    [
                        'label' => 'label.atributos',
                        'template' => 'TributarioBundle::Imobiliario/TipoEdificacao/tipo_edificacao_show.html.twig',
                    ]
                )
            ->end()
        ;
    }

    /**
     * @param TipoEdificacao $object
     */
    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $em->persist($object);

        $this->persistAtributos($object);
        $this->persistValorM2($object);
        $this->persistAliquota($object);
    }

    /**
     * @param TipoEdificacao $object
     */
    public function preUpdate($object)
    {
        $this->persistAtributos($object);
        $this->persistValorM2($object);
        $this->persistAliquota($object);
    }

    /**
     * @param TipoEdificacao $object
     * @return void
     */
    protected function persistValorM2(TipoEdificacao $object)
    {
        $valorM2Territorial = $this->getForm()->get('fkImobiliarioTipoEdificacaoValorM2s__valorM2Territorial')->getData();
        $valorM2Predial = $this->getForm()->get('fkImobiliarioTipoEdificacaoValorM2s__valorM2Predial')->getData();
        $valorM2DtVigencia = $this->getForm()->get('fkImobiliarioTipoEdificacaoValorM2s__dtVigencia')->getData();
        $valorM2CodNorma = $this->getForm()->get('fkImobiliarioTipoEdificacaoValorM2s__codNorma')->getData();

        if ($valorM2Territorial && $valorM2Predial && $valorM2DtVigencia && $valorM2CodNorma) {
            $em = $this->modelManager->getEntityManager($this->getClass())->getRepository(TipoEdificacaoValorM2::class);

            $tipoEdificacaoValorM2 = $em->findOneBy(['codTipo' => $object->getCodTipo()]);
            $tipoEdificacaoValorM2 = $tipoEdificacaoValorM2 ? : new TipoEdificacaoValorM2();
            $tipoEdificacaoValorM2->setCodTipo($object->getCodTipo());
            $tipoEdificacaoValorM2->setCodNorma($valorM2CodNorma);
            $tipoEdificacaoValorM2->setDtVigencia($valorM2DtVigencia);
            $tipoEdificacaoValorM2->setValorM2Territorial($valorM2Territorial);
            $tipoEdificacaoValorM2->setValorM2Predial($valorM2Predial);

            $object->addFkImobiliarioTipoEdificacaoValorM2s($tipoEdificacaoValorM2);
        }
    }

    /**
     * @param TipoEdificacao $object
     * @return void
     */
    protected function persistAliquota(TipoEdificacao $object)
    {
        $aliquotaTerritorial = $this->getForm()->get('fkImobiliarioTipoEdificacaoAliquotas__aliquotaTerritorial')->getData();
        $aliquotaPredial = $this->getForm()->get('fkImobiliarioTipoEdificacaoAliquotas__aliquotaPredial')->getData();
        $aliquotaDtVigencia = $this->getForm()->get('fkImobiliarioTipoEdificacaoAliquotas__dtVigencia')->getData();
        $aliquotaCodNorma = $this->getForm()->get('fkImobiliarioTipoEdificacaoAliquotas__codNorma')->getData();

        if ($aliquotaTerritorial && $aliquotaPredial && $aliquotaDtVigencia && $aliquotaCodNorma) {
            $em = $this->modelManager->getEntityManager($this->getClass())->getRepository(TipoEdificacaoAliquota::class);

            $tipoEdificacaoAliquota = $em->findOneBy(['codTipo' => $object->getCodTipo()]);
            $tipoEdificacaoAliquota = $tipoEdificacaoAliquota ? : new TipoEdificacaoAliquota();
            $tipoEdificacaoAliquota->setCodTipo($object->getCodTipo());
            $tipoEdificacaoAliquota->setCodNorma($aliquotaCodNorma);
            $tipoEdificacaoAliquota->setDtVigencia($aliquotaDtVigencia);
            $tipoEdificacaoAliquota->setAliquotaTerritorial($aliquotaTerritorial);
            $tipoEdificacaoAliquota->setAliquotaPredial($aliquotaPredial);

            $object->addFkImobiliarioTipoEdificacaoAliquotas($tipoEdificacaoAliquota);
        }
    }

    /**
     * @param TipoEdificacao $object
     * @return void
     */
    protected function persistAtributos(TipoEdificacao $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass())->getRepository(AtributoTipoEdificacao::class);

        foreach ($object->getFkImobiliarioAtributoTipoEdificacoes() as $atributoTipoEdificacao) {
            $object->removeFkImobiliarioAtributoTipoEdificacoes($atributoTipoEdificacao);
        }

        $this->modelManager->getEntityManager($this->getClass())->flush();

        foreach ((array) $this->getForm()->get('codAtributo')->getData() as $atributo) {
                $atributoTipoEdificacao = new AtributoTipoEdificacao();
                $atributoTipoEdificacao->setFkAdministracaoAtributoDinamico($atributo);
                $atributoTipoEdificacao->setCodCadastro($atributo->getCodCadastro());
                $object->addFkImobiliarioAtributoTipoEdificacoes($atributoTipoEdificacao);
        }
    }


    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        // valida somente em edição

        if ($this->getAdminRequestId()) {
            $em = $this->modelManager->getEntityManager($this->getClass());
            $tipoEdificacao = $em->getRepository(TipoEdificacao::class)
                ->findOneBy(['nomTipo' => $object->getNomTipo()]);

            if ($tipoEdificacao && $tipoEdificacao->getCodTipo() != $object->getCodTipo()) {
                $error = $this->getTranslator()->trans('label.imobiliarioEdificacao.erroNome', array('%nome%' => $object->getNomTipo()));
                $errorElement->with('nomTipo')->addViolation($error)->end();
            }
        }
    }

    /**
    * @param mixed $object
    * @return string
    */
    public function toString($object)
    {
        return ($object->getNomTipo())
            ? (string) $object
            : $this->getTranslator()->trans('label.imobiliarioEdificacao.modulo');
    }
}
