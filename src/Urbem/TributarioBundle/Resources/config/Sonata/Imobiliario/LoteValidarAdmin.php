<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Imobiliario;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Administracao\Cadastro;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Administracao\UnidadeMedida;
use Urbem\CoreBundle\Entity\Imobiliario\AtributoLoteRuralValor;
use Urbem\CoreBundle\Entity\Imobiliario\AtributoLoteUrbanoValor;
use Urbem\CoreBundle\Entity\Imobiliario\Localizacao;
use Urbem\CoreBundle\Entity\Imobiliario\Lote;
use Urbem\CoreBundle\Entity\Imobiliario\LoteParcelado;
use Urbem\CoreBundle\Entity\Imobiliario\PontoCardeal;
use Urbem\CoreBundle\Entity\Imobiliario\Trecho;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwBairro;
use Urbem\CoreBundle\Entity\SwClassificacao;
use Urbem\CoreBundle\Entity\SwMunicipio;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Entity\SwUf;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Imobiliario\LoteModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;

class LoteValidarAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_tributario_imobiliario_lote_validar';
    protected $baseRoutePattern = 'tributario/cadastro-imobiliario/lote-validar';
    protected $includeJs = array(
        '/core/javascripts/sw-processo.js',
        '/tributario/javascripts/imobiliario/lote-confrontacoes.js',
        '/tributario/javascripts/imobiliario/lote-validar.js'
    );

    /**
     * @return array
     */
    public function getPersistentParameters()
    {
        if (!$this->getRequest()) {
            return array();
        }

        return array(
            'codLote' => $this->getRequest()->get('codLote'),
        );
    }

    /**
     * @return null|Lote
     */
    public function getLote()
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $lote = null;
        if ($this->getPersistentParameter('codLote')) {
            /** @var Lote $lote */
            $lote = $em->getRepository(Lote::class)->find($this->getPersistentParameter('codLote'));
        }
        return $lote;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $configuracaoModel = new ConfiguracaoModel($em);
        $codUf = $configuracaoModel->pegaConfiguracao('cod_uf', Modulo::MODULO_ADMINISTRATIVO, $this->getExercicio(), true);
        $codMunicipio = $configuracaoModel->pegaConfiguracao('cod_municipio', Modulo::MODULO_ADMINISTRATIVO, $this->getExercicio(), true);

        $uf = $municipio = null;
        if (((int) $codUf) && ((int) $codMunicipio)) {
            $uf = $em->getRepository(SwUf::class)->find((integer) $codUf);
            $municipio = $em->getRepository(SwMunicipio::class)->findOneBy(array('codMunicipio' => (integer) $codMunicipio, 'codUf' => (integer) $codUf));
        }

        $dtAtual = new \DateTime();

        $fieldOptions = array();

        $choices = array(
            Cadastro::CADASTRO_TRIBUTARIO_LOTE_URBANO => 'label.imobiliarioLote.urbano.modulo',
            Cadastro::CADASTRO_TRIBUTARIO_LOTE_RURAL => 'label.imobiliarioLote.rural.modulo'
        );

        $fieldOptions['codLote'] = array(
            'mapped' => false
        );

        $fieldOptions['codCadastro'] = array(
            'mapped' => false,
            'data' => Cadastro::CADASTRO_TRIBUTARIO_LOTE_URBANO
        );

        $fieldOptions['areaRestante'] = array(
            'mapped' => false
        );

        $fieldOptions['loteRestante'] = array(
            'mapped' => false
        );

        $fieldOptions['tipoLote'] = array(
            'label' => 'label.imobiliarioLote.tipoLote',
            'mapped' => false,
            'required' => true,
            'expanded' => true,
            'data' => Cadastro::CADASTRO_TRIBUTARIO_LOTE_URBANO,
            'choices' => array_flip($choices),
            'label_attr' => array(
                'class' => 'checkbox-sonata'
            ),
            'attr' => array(
                'class' => 'checkbox-sonata'
            )
        );

        //Lote Localizacao Valor
        $fieldOptions['numLote'] = array(
            'label' => 'label.imobiliarioLote.numLote',
            'mapped' => false
        );

        $fieldOptions['fkImobiliarioLocalizacao'] = array(
            'label' => 'label.imobiliarioLote.localizacao',
            'class' => Localizacao::class,
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => true,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['area'] = array(
            'label' => false,
            'mapped' => false,
            'required' => true,
            'attr' => array(
                'class' => 'money '
            )
        );

        $fieldOptions['fkAdministracaoUnidadeMedida'] = array(
            'label' => false,
            'class' => UnidadeMedida::class,
            'mapped' => false,
            'required' => true,
            'query_builder' => function (EntityRepository $er) {
                $qb = $er->createQueryBuilder('o');
                $qb->where('o.codGrandeza = :codGrandeza');
                $qb->andWhere($qb->expr()->orX(
                    $qb->expr()->eq('o.codUnidade', ':codUnidadeM2'),
                    $qb->expr()->eq('o.codUnidade', ':codUnidadeHA')
                ));
                $qb->setParameters(
                    array(
                        'codGrandeza' => LoteAdmin::COD_GRANDEZA_AREA,
                        'codUnidadeM2' => LoteAdmin::COD_UNIDADE_M2,
                        'codUnidadeHA' => LoteAdmin::COD_UNIDADE_HA
                    )
                );
                return $qb;
            },
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['profundidadeMedia'] = array(
            'label' => 'label.imobiliarioLote.profundidadeMedia',
            'mapped' => false,
            'required' => true,
            'attr' => array(
                'class' => 'money '
            )
        );

        $fieldOptions['codClassificacao'] = array(
            'label' => 'label.imobiliarioLote.classificacao',
            'class' => SwClassificacao::class,
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => false,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('o')
                    ->orderBy('o.codClassificacao', 'ASC');
            },
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['codAssunto'] = array(
            'label' => 'label.imobiliarioLote.assunto',
            'placeholder' => 'label.selecione',
            'choices' => array(),
            'mapped' => false,
            'required' => false,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['codProcesso'] = array(
            'label' => 'label.imobiliarioLote.processo',
            'placeholder' => 'label.selecione',
            'choices' => array(),
            'mapped' => false,
            'required' => false,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['dtInscricao'] = array(
            'label' => 'label.imobiliarioLote.dataInscricao',
            'format' => 'dd/MM/yyyy',
            'data' => $dtAtual
        );

        $fieldOptions['fkSwBairro'] = array(
            'label' => 'label.imobiliarioLote.bairro',
            'class' => SwBairro::class,
            'choice_label' => 'nomBairro',
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => true,
            'query_builder' => function (EntityRepository $er) use ($codUf, $codMunicipio) {
                return $er->createQueryBuilder('o')
                    ->where('o.codUf = :codUf')
                    ->andWhere('o.codMunicipio = :codMunicipio')
                    ->setParameters(
                        array(
                            'codUf' => $codUf,
                            'codMunicipio' => $codMunicipio
                        )
                    )
                    ->orderBy('o.nomBairro', 'ASC');
            },
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['fkImobiliarioPontoCardeal'] = array(
            'label' => 'label.imobiliarioLote.pontoCardeal',
            'class' => PontoCardeal::class,
            'mapped' => false,
            'required' => true,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $choices = array(
            'trecho' => $this->getTranslator()->trans('label.imobiliarioLote.trecho'),
            'lote' => $this->getTranslator()->trans('label.imobiliarioLote.lote'),
            'outros' => $this->getTranslator()->trans('label.imobiliarioLote.outros'),
        );

        $fieldOptions['confrontacaoTipo'] = array(
            'label' => 'label.imobiliarioLote.tipo',
            'mapped' => false,
            'expanded' => true,
            'choices' => array_flip($choices),
            'data' => 'trecho',
            'label_attr' => array(
                'class' => 'checkbox-sonata'
            ),
            'attr' => array(
                'class' => 'checkbox-sonata'
            )
        );

        $fieldOptions['extensao'] = array(
            'label' => 'label.imobiliarioLote.extensao',
            'mapped' => false,
            'required' => true,
            'attr' => array(
                'class' => 'money '
            )
        );

        // Opção Trecho
        // ConfrontacaoTrecho $principal boolean
        $fieldOptions['principal'] = array(
            'label' => 'label.imobiliarioLote.testada',
            'mapped' => false,
            'expanded' => true,
            'required' => true,
            'choices' => array(
                'label_type_yes' => 1,
                'label_type_no' => 0
            ),
            'data' => 0,
            'label_attr' => array(
                'class' => 'checkbox-sonata'
            ),
            'attr' => array(
                'class' => 'checkbox-sonata'
            )
        );

        $fieldOptions['fkSwUf'] = array(
            'label' => 'label.imobiliarioFaceQuadra.estado',
            'class' => SwUf::class,
            'choice_label' => 'nomUf',
            'choice_value' => 'codUf',
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => true,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('uf')
                    ->where('uf.codUf != :codUf')
                    ->setParameter('codUf', LoteAdmin::NAO_INFORMADO);
            },
            'data' => $uf,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['fkSwMunicipio'] = array(
            'label' => 'label.imobiliarioFaceQuadra.municipio',
            'class' => SwMunicipio::class,
            'choice_label' => 'nomMunicipio',
            'choice_value' => 'codMunicipio',
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => true,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('m')
                    ->where('m.codMunicipio != :codMunicipio')
                    ->setParameter('codMunicipio', LoteAdmin::NAO_INFORMADO);
            },
            'data' => $municipio,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['fkImobiliarioTrecho'] = array(
            'label' => 'label.imobiliarioLote.trecho',
            'class' => Trecho::class,
            'req_params' => [
                'codUf' => 'varJsCodUf',
                'codMunicipio' => 'varJsCodMunicipio'
            ],
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $er, $term, Request $request) {
                $qb = $er->createQueryBuilder('o');
                $qb->innerJoin('o.fkSwLogradouro', 'l');
                $qb->innerJoin('l.fkSwNomeLogradouros', 'nl');
                $qb->innerJoin('nl.fkSwTipoLogradouro', 'tl');
                $qb->where('l.codUf = :codUf');
                $qb->andWhere('l.codMunicipio = :codMunicipio');
                $qb->andWhere($qb->expr()->orX(
                    $qb->expr()->eq('o.codTrecho', ':codTrecho'),
                    $qb->expr()->like("LOWER(CONCAT(tl.nomTipo, ' ', nl.nomLogradouro))", $qb->expr()->literal('%' . strtolower($term) . '%'))
                ));
                $qb->setParameter('codUf', (int) $request->get('codUf'));
                $qb->setParameter('codMunicipio', (int) $request->get('codMunicipio'));
                $qb->setParameter('codTrecho', (int) $term);
                $qb->orderBy('o.codTrecho', 'ASC');
                return $qb;
            },
            'mapped' => false,
            'required' => true,
        );

        // Opção Lote
        $fieldOptions['fkImobiliarioLote'] = array(
            'label' => 'label.imobiliarioLote.lote',
            'class' => Lote::class,
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => true,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('o')
                    ->leftJoin('o.fkImobiliarioBaixaLotes', 'b')
                    ->where('b.dtInicio is not null')
                    ->andWhere('b.dtTermino is not null')
                    ->orWhere('b.dtInicio is null')
                    ->orderBy('o.codLote', 'ASC');
            },
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        //Opção Outros
        $fieldOptions['descricao'] = array(
            'label' => 'label.imobiliarioLote.descricao',
            'mapped' => false,
            'required' => true
        );

        $fieldOptions['fkImobiliarioConfrontacoes'] = array(
            'label' => false,
            'mapped' => false,
            'template' => 'TributarioBundle::Imobiliario/Lote/confrontacoes.html.twig',
            'attr' => array(
                'style' => 'display:none;'
            ),
            'data' => array(
                'confrontacoes' => array()
            )
        );

        $fieldOptions['listaEdificacoes'] = array(
            'label' => false,
            'mapped' => false,
            'template' => 'TributarioBundle::Imobiliario/Lote/edificacoes.html.twig',
            'attr' => array(
                'style' => 'display:none;'
            ),
            'data' => array(
                'edificacoes' => array()
            )
        );

        $lote = $this->getLote();
        if ($lote) {
            $fieldOptions['codLote']['data'] = $lote->getCodLote();

            $fieldOptions['tipoLote']['disabled'] = true;
            $fieldOptions['tipoLote']['data'] = ($lote->getFkImobiliarioLoteUrbano()) ? Cadastro::CADASTRO_TRIBUTARIO_LOTE_URBANO : Cadastro::CADASTRO_TRIBUTARIO_LOTE_RURAL;

            $fieldOptions['codCadastro']['data'] = ($lote->getFkImobiliarioLoteUrbano()) ? Cadastro::CADASTRO_TRIBUTARIO_LOTE_URBANO : Cadastro::CADASTRO_TRIBUTARIO_LOTE_RURAL;

            $fieldOptions['fkImobiliarioLocalizacao']['disabled'] = true;
            $fieldOptions['fkImobiliarioLocalizacao']['data'] = $lote->getFkImobiliarioLoteLocalizacao()->getFkImobiliarioLocalizacao();

            $fieldOptions['area']['data'] = number_format($lote->getFkImobiliarioAreaLotes()->last()->getAreaReal(), 2, ',', '.');
            $fieldOptions['fkAdministracaoUnidadeMedida']['data'] = $lote->getFkImobiliarioAreaLotes()->last()->getFkAdministracaoUnidadeMedida();

            $fieldOptions['profundidadeMedia']['data'] = number_format($lote->getFkImobiliarioProfundidadeMedias()->last()->getVlProfundidadeMedia(), 2, ',', '.');

            $fieldOptions['fkSwBairro']['data'] = $lote->getFkImobiliarioLoteBairros()->last()->getFkSwBairro();

            $fieldOptions['fkImobiliarioConfrontacoes']['data'] = array(
                'confrontacoes' => $lote->getFkImobiliarioConfrontacoes()
            );

            /** @var LoteParcelado $loteParcelado */
            $loteParcelado = $em->getRepository(LoteParcelado::class)->findOneByCodLote($lote->getCodLote());
            $parcelamentoSolo = $loteParcelado->getFkImobiliarioParcelamentoSolo();

            $fieldOptions['numLote']['data'] = (string) $lote;
            if ($parcelamentoSolo->getFkImobiliarioLote()->getCodLote() == $lote->getCodLote()) {
                $fieldOptions['numLote']['disabled'] = true;
            }

            $areaRestante = 0;
            $loteRestante = 0;
            foreach ($parcelamentoSolo->getFkImobiliarioLoteParcelados() as $loteParcelado) {
                if ($loteParcelado->getValidado() == false) {
                    $areaRestante += $loteParcelado->getFkImobiliarioLote()->getFkImobiliarioAreaLotes()->last()->getAreaReal();
                    $loteRestante++;
                }
            }
            $fieldOptions['areaRestante']['data'] = $areaRestante;
            $fieldOptions['loteRestante']['data'] = $loteRestante;

            $fieldOptions['listaEdificacoes']['data'] = array(
                'edificacoes' => (new LoteModel($em))->getEdificacoes($parcelamentoSolo->getFkImobiliarioLote())
            );
        }

        $formMapper->tab('label.imobiliarioLote.lote');
        $formMapper->with('label.imobiliarioLote.dadosLote');
        $formMapper->add('codLote', 'hidden', $fieldOptions['codLote']);
        $formMapper->add('codCadastro', 'hidden', $fieldOptions['codCadastro']);
        $formMapper->add('areaRestante', 'hidden', $fieldOptions['areaRestante']);
        $formMapper->add('loteRestante', 'hidden', $fieldOptions['loteRestante']);
        $formMapper->add('tipoLote', 'choice', $fieldOptions['tipoLote']);
        $formMapper->add('numLote', 'text', $fieldOptions['numLote']);
        $formMapper->add('fkImobiliarioLocalizacao', 'entity', $fieldOptions['fkImobiliarioLocalizacao']);
        $formMapper->end();

        $formMapper->with('label.imobiliarioLote.area');
        $formMapper->add('area', 'text', $fieldOptions['area']);
        $formMapper->add('fkAdministracaoUnidadeMedida', 'entity', $fieldOptions['fkAdministracaoUnidadeMedida']);
        $formMapper->end();

        $formMapper->with('label.imobiliarioLote.processo');
        $formMapper->add('codClassificacao', 'entity', $fieldOptions['codClassificacao']);
        $formMapper->add('codAssunto', 'choice', $fieldOptions['codAssunto']);
        $formMapper->add('codProcesso', 'choice', $fieldOptions['codProcesso']);
        $formMapper->end();

        $formMapper->with('');
        $formMapper->add('profundidadeMedia', 'text', $fieldOptions['profundidadeMedia']);
        $formMapper->add('dtInscricao', 'sonata_type_date_picker', $fieldOptions['dtInscricao']);
        $formMapper->add('fkSwBairro', 'entity', $fieldOptions['fkSwBairro']);
        $formMapper->end();

        $formMapper->with('label.imobiliarioLote.listaEdificacoes');
        $formMapper->add('listaEdificacoes', 'customField', $fieldOptions['listaEdificacoes']);
        $formMapper->end();
        $formMapper->end();

        $formMapper->tab('label.imobiliarioLote.confrontacoes');

        $formMapper->with('label.imobiliarioLote.confrontacoes');
        $formMapper->add('fkImobiliarioPontoCardeal', 'entity', $fieldOptions['fkImobiliarioPontoCardeal']);
        $formMapper->add('confrontacaoTipo', 'choice', $fieldOptions['confrontacaoTipo']);
        $formMapper->add('extensao', 'text', $fieldOptions['extensao']);
        $formMapper->end();

        $formMapper->with('label.imobiliarioLote.trecho', array('class' => 'fieldset-trecho'));
        $formMapper->add('fkSwUf', 'entity', $fieldOptions['fkSwUf']);
        $formMapper->add('fkSwMunicipio', 'entity', $fieldOptions['fkSwMunicipio']);
        $formMapper->add('fkImobiliarioTrecho', 'autocomplete', $fieldOptions['fkImobiliarioTrecho']);
        $formMapper->add('principal', 'choice', $fieldOptions['principal']);
        $formMapper->end();

        $formMapper->with('');
        $formMapper->add('fkImobiliarioLote', 'entity', $fieldOptions['fkImobiliarioLote']);
        $formMapper->add('descricao', 'textarea', $fieldOptions['descricao']);
        $formMapper->add('fkImobiliarioConfrontacoes', 'customField', $fieldOptions['fkImobiliarioConfrontacoes']);
        $formMapper->end();

        $formMapper->end();

        $formMapper->tab('label.imobiliarioLote.caracteristicas');

        if ($lote) {
            $atributoLoteValor = null;
            $atributosDinamicos = array();
            if ($lote->getFkImobiliarioLoteUrbano()) {
                $atributoLoteValor = $em->getRepository(AtributoLoteUrbanoValor::class)->findOneByCodLote($lote->getCodLote(), array('timestamp' => 'DESC'));
            } else {
                $atributoLoteValor = $em->getRepository(AtributoLoteRuralValor::class)->findOneByCodLote($lote->getCodLote(), array('timestamp' => 'DESC'));
            }
            if ($atributoLoteValor) {
                $atributosDinamicos = (new LoteModel($em))->getNomAtributoValorByLote($lote, $atributoLoteValor->getTimestamp());
            }
            $fieldOptions['atributosDinamicos'] = array(
                'label' => false,
                'mapped' => false,
                'template' => 'TributarioBundle::Imobiliario/Lote/atributosDinamicos.html.twig',
                'data' => array(
                    'atributosDinamicos' => $atributosDinamicos
                )
            );

            $formMapper->with('label.imobiliarioLote.atributos');
            $formMapper->add('atributosDinamicos', 'customField', $fieldOptions['atributosDinamicos']);
            $formMapper->end();
        }

        $formMapper->end();

        $admin = $this;
        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formMapper, $admin) {
                $form = $event->getForm();
                $data = $event->getData();

                if ($form->has('codAssunto')) {
                    $form->remove('codAssunto');
                }

                if (isset($data['codClassificacao']) && $data['codClassificacao'] != "") {
                    $codAssunto = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                        'codAssunto',
                        'entity',
                        null,
                        array(
                            'class' => SwAssunto::class,
                            'label' => 'label.imobiliarioLote.assunto',
                            'choice_value' => 'codComposto',
                            'placeholder' => 'label.selecione',
                            'mapped' => false,
                            'auto_initialize' => false,
                            'query_builder' => function (EntityRepository $er) use ($data) {
                                return $er->createQueryBuilder('o')
                                    ->where('o.codClassificacao = :codClassificacao')
                                    ->setParameter('codClassificacao', $data['codClassificacao']);
                            },
                            'attr' => array(
                                'class' => 'select2-parameters'
                            )
                        )
                    );

                    $form->add($codAssunto);
                }

                if ($form->has('codProcesso')) {
                    $form->remove('codProcesso');
                }

                if (isset($data['codAssunto']) && $data['codAssunto'] != "") {
                    $codProcesso = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                        'codProcesso',
                        'entity',
                        null,
                        array(
                            'class' => SwProcesso::class,
                            'label' => 'label.imobiliarioLote.assunto',
                            'choice_value' => 'codComposto',
                            'placeholder' => 'label.selecione',
                            'mapped' => false,
                            'auto_initialize' => false,
                            'query_builder' => function (EntityRepository $er) use ($data) {
                                list($codClassificacao, $codAssunto) = explode('~', $data['codAssunto']);
                                return $er->createQueryBuilder('o')
                                    ->where('o.codClassificacao = :codClassificacao')
                                    ->andWhere('o.codAssunto = :codAssunto')
                                    ->setParameters([
                                        'codClassificacao' => $codClassificacao,
                                        'codAssunto' => $codAssunto,
                                    ]);
                            },
                            'attr' => array(
                                'class' => 'select2-parameters'
                            )
                        )
                    );

                    $form->add($codProcesso);
                }
            }
        );
    }

    public function prePersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();

        try {
            /** @var EntityManager $em */
            $em = $this->modelManager->getEntityManager($this->getClass());

            $loteModel = new LoteModel($em);

            /** @var Lote $lote */
            $lote = $this->getLote();

            $edificacoes = $this->request->request->get('edificacoes');
            $confrontacoes = $this->request->request->get('confrontacoes');
            $confrontacoesOld = ($this->request->request->get('confrontacoes_old')) ? $this->request->request->get('confrontacoes_old') : array();

            $loteModel->validarLote($lote, $this->getForm(), $edificacoes, $confrontacoes, $confrontacoesOld);

            $container->get('session')->getFlashBag()->add('success', $this->getTranslator()->trans('label.imobiliarioLote.msgValidar'));
            $this->forceRedirect('/tributario/cadastro-imobiliario/lote/list');
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
            $container->get('session')->getFlashBag()->add('error', $e->getMessage());
            $this->forceRedirect('/tributario/cadastro-imobiliario/lote/list');
        }
    }
}
