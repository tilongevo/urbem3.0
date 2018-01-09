<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Arrecadacao;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Arrecadacao\Documento;
use Urbem\CoreBundle\Entity\Arrecadacao\DocumentoCgm;
use Urbem\CoreBundle\Entity\Arrecadacao\DocumentoEmissao;
use Urbem\CoreBundle\Entity\Arrecadacao\DocumentoEmpresa;
use Urbem\CoreBundle\Entity\Arrecadacao\DocumentoImovel;
use Urbem\CoreBundle\Entity\Arrecadacao\ParcelaDocumento;
use Urbem\CoreBundle\Entity\Divida\DocumentoParcela;
use Urbem\CoreBundle\Entity\Imobiliario\Lote;
use Urbem\CoreBundle\Entity\Imobiliario\Imovel;
use Urbem\CoreBundle\Entity\Imobiliario\Localizacao;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Model\Arrecadacao\DocumentoEmissaoModel;
use Urbem\CoreBundle\Model\Arrecadacao\ExtratoDebitosReportModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class DocumentoEmissaoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_arrecadacao_documento_emissao';
    protected $baseRoutePattern = 'tributario/arrecadacao/documento-emissao';
    protected $exibirBotaoIncluir = false;
    protected $includeJs = array(
        '/tributario/javascripts/arrecadacao/documento-emissao.js'
    );

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('download', 'download/' . $this->getRouterIdParameter());
        $collection->add('geracertidao', 'gera_certidacao/');
    }

    /**
     * @return string
     */
    public function getGoBackURL()
    {
        return '/tributario/arrecadacao/documento-emissao/list';
    }

    /**
     * @param string $name
     *
     * @return mixed|null|string
     */
    public function getTemplate($name)
    {
        switch ($name) {
            case 'list':
                return 'TributarioBundle:Sonata\Arrecadacao\DocumentoEmissao\CRUD:list.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $documentoEmitidos = $this::getDocumentosEmitidos();
        $numeroDocumentos =  $this::getValoresComVirgula($documentoEmitidos);
        $query = parent::createQuery($context);

        if (!$documentoEmitidos) {
            $query->andWhere('1 = 0');
        } else {
            $query->innerJoin("o.fkArrecadacaoDocumentoCgns", "adc");
            $query->where('adc.numcgm = :cgm');
            $query->andWhere('adc.numDocumento in (:numDocumento)');
            $query->setParameter('cgm', reset($documentoEmitidos)['numcgm']);
            $query->setParameter('numDocumento', $numeroDocumentos);
        }

        return $query;
    }

    /**
     * @return mixed
     */
    public function getDocumentosEmitidos()
    {
        $numcgm = $this->getRequest()->get('cgm');
        $inscricaoEconomica = $this->getRequest()->get('inscricaoEconomica');
        $inscricaoImobiliaria = $this->getRequest()->get('inscricaoImobiliaria');

        $em = $this->modelManager->getEntityManager($this->getClass());
        $documentoEmisssaoModel = new DocumentoEmissaoModel($em);

        $params = array(
            'numCgm' => $numcgm,
            'inscricaoEconomica' => $inscricaoEconomica,
            'inscricaoMunicipal' => $inscricaoImobiliaria
        );

        return $documentoEmisssaoModel->getDocumentosEmitidos($params);
    }

    /**
     * @param $params
     * @return array|string
     */
    public static function getValoresComVirgula($params)
    {
        $valores = array();
        if (sizeof($params) <= 0 || $params == '') {
            return 'null';
        }
        foreach ($params as $param) {
            array_push($valores, (int) $param['num_documento']);
        }

        return $valores;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $listMapper
            ->add(
                'fkArrecadacaoDocumento',
                null,
                array(
                    'label' => 'label.arrecadacaoDocumentoEmissao.documento',
                    'mapped' => false
                )
            )
            ->add(
                'fkArrecadacaoDocumentoCgns',
                null,
                array(
                    'label' => 'label.arrecadacaoDocumentoEmissao.nome',
                    'mapped' => false
                )
            )
            ->add(
                'fkArrecadacaoDocumentoImoveis',
                null,
                array(
                    'label' => 'label.arrecadacaoDocumentoEmissao.inscricaoImobiliaria',
                    'mapped' => false
                )
            )
            ->add(
                'inscricaoEconomica',
                null,
                array(
                    'label' => 'label.arrecadacaoDocumentoEmissao.inscricaoEconomica',
                    'mapped' => false
                )
            )
            ->add(
                'timestamp',
                'date',
                array(
                    'label' => 'label.arrecadacaoDocumentoEmissao.dtEmissao',
                    'mapped' => false,
                    'format' => 'd/m/Y'
                )
            )
            ->add('_action', 'actions', array(
                'actions' => array(
                    'baixar' => array('template' => 'TributarioBundle:Sonata/Arrecadacao/DocumentoEmissao/CRUD:list__action_baixar.html.twig')
                )
            ));
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions['tipo'] = [
            'choices' => [
                'Emissão' => 'emissao',
                'Reemissão' => 'reemissao',
            ],
            'mapped' => false,
            'attr' => [
                'class' => 'js-filtro-select-tipo ',
            ],
            'label' => 'label.dividaAtivaEmitirDocumento.tipo',
        ];

        $fieldOptions['fkArrecadacaoDocumento'] = array(
            'label' => 'label.arrecadacaoDocumentoEmissao.codDocumento',
            'class' => Documento::class,
            'mapped' => true,
            'required' => true,
            'placeholder' => 'Selecione',
            'choice_label' => function (Documento $documento) {
                return "{$documento->getDescricao()}";
            },
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['fkArrecadacaoDocumentoCgns'] = [
            'label' => 'label.arrecadacaoDocumentoEmissao.cgm',
            'class' => SwCgm::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $er, $term, Request $request) {
                $qb = $er->createQueryBuilder('o');
                if (is_numeric($term)) {
                    $qb->where('o.numcgm = :numcgm');
                    $qb->setParameter('numcgm', $term);
                } else {
                    $qb->where('LOWER(o.nomCgm) LIKE :nomCgm');
                    $qb->setParameter('nomCgm', '%' . strtolower($term) . '%');
                }
                return $qb;
            },
            'mapped' => false,
            'required' => false,
        ];

        $fieldOptions['inscricaoEconomica'] = [
            'label' => 'label.economico.licenca.inscricaoEconomica',
            'required' => false,
            'mapped' => false,
            'route' => [
                'name' => 'get_sw_cgm_inscricao_economica'
            ],
        ];

        $fieldOptions['fkImobiliarioLocalizacao'] = [
            'label' => 'label.imobiliarioCondominio.localizacao',
            'class' => Localizacao::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $er, $term) {
                $qb = $er->createQueryBuilder('o');
                $qb->andWhere('o.codigoComposto LIKE :codigoComposto');
                $qb->setParameter('codigoComposto', sprintf('%%%s%%', strtolower($term)));
                $qb->orderBy('o.codLocalizacao', 'ASC');
                return $qb;
            },
            'mapped' => false,
            'required' => false,
        ];

        $fieldOptions['fkImobiliarioLote'] = array(
            'label' => 'label.imobiliarioCondominio.lote',
            'class' => Lote::class,
            'req_params' => [
                'codLocalizacao' => 'varJsCodLocalizacao'
            ],
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $er, $term, Request $request) {
                $qb = $er->createQueryBuilder('o');
                $qb->innerJoin('o.fkImobiliarioLoteLocalizacao', 'l');
                if ($request->get('codLocalizacao') != '') {
                    $qb->andWhere('l.codLocalizacao = :codLocalizacao');
                    $qb->setParameter('codLocalizacao', $request->get('codLocalizacao'));
                }
                $qb->andWhere('lpad(upper(l.valor), 10, \'0\') = :valor');
                $qb->setParameter('valor', str_pad($term, 10, '0', STR_PAD_LEFT));

                $qb->leftJoin('o.fkImobiliarioImovelLotes', 'i');
                $qb->andWhere('i.inscricaoMunicipal is not null');
                $qb->orderBy('o.codLote', 'ASC');
                return $qb;
            },
            'mapped' => false,
            'required' => false,
        );

        $fieldOptions['fkImobiliarioImovel'] = array(
            'label' => 'label.imobiliarioImovel.inscricaoImobiliaria',
            'class' => Imovel::class,
            'req_params' => [
                'codLocalizacao' => 'varJsCodLocalizacao',
                'codLote' => 'varJsCodLote'
            ],
            'json_choice_label' => function (Imovel $imovel) {
                return "{$imovel->getInscricaoMunicipal()} - {$imovel->getLogradouro()}";
            },
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $er, $term, Request $request) {
                $qb = $er->createQueryBuilder('o');
                $qb->innerJoin('o.fkImobiliarioImovelConfrontacao', 'ic');
                if ($request->get('codLocalizacao') != '') {
                    $qb->innerJoin('ic.fkImobiliarioConfrontacaoTrecho', 't');
                    $qb->innerJoin('t.fkImobiliarioConfrontacao', 'c');
                    $qb->innerJoin('c.fkImobiliarioLote', 'l');
                    $qb->innerJoin('l.fkImobiliarioLoteLocalizacao', 'll');
                    $qb->andWhere('ll.codLocalizacao = :codLocalizacao');
                    $qb->setParameter('codLocalizacao', $request->get('codLocalizacao'));
                }
                if ($request->get('codLote') != '') {
                    $qb->andWhere('ic.codLote = :codLote');
                    $qb->setParameter('codLote', $request->get('codLote'));
                }
                $qb->andWhere('o.inscricaoMunicipal = :inscricaoMunicipal');
                $qb->setParameter('inscricaoMunicipal', $term);
                $qb->orderBy('o.inscricaoMunicipal', 'ASC');
                return $qb;
            },
            'mapped' => false,
            'required' => false,
        );

        $formMapper
            ->with('label.arrecadacaoDocumentoEmissao.dados')
            ->add('tipo', 'choice', $fieldOptions['tipo'])
            ->add('fkArrecadacaoDocumento', 'entity', $fieldOptions['fkArrecadacaoDocumento'])
            ->add('fkArrecadacaoDocumentoCgns', 'autocomplete', $fieldOptions['fkArrecadacaoDocumentoCgns'])
            ->add('inscricaoEconomica', 'autocomplete', $fieldOptions['inscricaoEconomica'])
            ->end()
            ->with('label.imobiliarioImovel.inscricaoImobiliaria')
            ->add('fkImobiliarioLocalizacao', 'autocomplete', $fieldOptions['fkImobiliarioLocalizacao'])
            ->add('fkImobiliarioLote', 'autocomplete', $fieldOptions['fkImobiliarioLote'])
            ->add('fkImobiliarioImovel', 'autocomplete', $fieldOptions['fkImobiliarioImovel']);
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     * @return bool
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $imovel = $this->getForm()
            ->get('fkImobiliarioImovel')->getData();
        $cgn = $this->getForm()
            ->get('fkArrecadacaoDocumentoCgns')->getData();
        $inscricaoEconomica = $this->getForm()
            ->get('inscricaoEconomica')->getData();

        if ((!$imovel) && (!$cgn) && (!$inscricaoEconomica)) {
            $error = $this->getTranslator()->trans('label.arrecadacaoDocumentoEmissao.erroValidacao');

            $errorElement->with('fkImobiliarioImovel')->addViolation($error)->end();
            $errorElement->with('fkArrecadacaoDocumentoCgns')->addViolation($error)->end();
            $errorElement->with('inscricaoEconomica')->addViolation($error)->end();
        }
    }

    /**
     * @param mixed $object
     * @throws \Exception
     */
    public function prePersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();

        $cgm = $this->getForm()->get('fkArrecadacaoDocumentoCgns')->getData();
        $cgm = $cgm ? $cgm->getNumcgm() : '';
        $inscricaoEconomica = $this->getForm()->get('inscricaoEconomica')->getData();
        $inscricaoImobiliaria = $this->getForm()->get('fkImobiliarioImovel')->getData();

        if ($this->getForm()->get('tipo')->getData() == 'reemissao') {
            $this->forceRedirect(sprintf('/tributario/arrecadacao/documento-emissao/list?cgm=%s&inscricaoEconomica=%s&inscricaoImobiliaria=%s', $cgm, $inscricaoEconomica, $inscricaoImobiliaria));
            return;
        }

        try {
            $em = $this->modelManager->getEntityManager($this->getClass());

            $documentoEmisssaoModel = new DocumentoEmissaoModel($em);

            $params = array(
                'cod_documento' => $object->getCodDocumento(),
                'exercicio' => $this->getExercicio()
            );

            $numDocumento = $documentoEmisssaoModel->getNextVal($params);

            $object->setExercicio($this->getExercicio());
            $object->setNumDocumento($numDocumento);
            $object->setNumCgm($this->getCurrentUser()->getNumcgm());

            if ($this->getForm()->get('fkArrecadacaoDocumentoCgns')->getData()) {
                $cgm = $this->getForm()->get('fkArrecadacaoDocumentoCgns')->getData();

                $documentoCgns = new DocumentoCgm();

                $documentoCgns->setNumcgm($cgm->getNumcgm());
                $documentoCgns->setFkArrecadacaoDocumentoEmissao($object);

                $object->addFkArrecadacaoDocumentoCgns($documentoCgns);
            }

            if ($this->getForm()->get('fkImobiliarioImovel')->getData()) {
                $documentoImovel = new DocumentoImovel();
                $documentoImovel->setInscricaoMunicipal($this->getForm()->get('fkImobiliarioImovel')->getData('inscricaoMunicipal'));
                $documentoImovel->setFkArrecadacaoDocumentoEmissao($object);
                $object->addFkArrecadacaoDocumentoImoveis($documentoImovel);
            }

            if ($this->getForm()->get('inscricaoEconomica')->getData()) {
                $documentoEmpresa = new DocumentoEmpresa();
                $documentoEmpresa->setInscricaoEconomica($this->getForm()->get('inscricaoEconomica')->getData());
                $documentoEmpresa->setFkArrecadacaoDocumentoEmissao($object);
                $object->addFkArrecadacaoDocumentoEmpresas($documentoEmpresa);
            }

            if ($cgm || $inscricaoEconomica || $inscricaoImobiliaria) {
                $numcgm = $cgm ? $cgm->getNumcgm() : '';
                $parcelasEmAberto = (new ExtratoDebitosReportModel($em))->getListaParcelaEmAberto(
                    array('numcgm' => $numcgm, 'inscricaoMunicipal' => $inscricaoImobiliaria, 'inscricaoEconomica' => $inscricaoEconomica)
                );

                $codigoEVencimentoParcelas = array();
                foreach ($parcelasEmAberto as $parcela) {
                    if (preg_match("^/^", $parcela["cod_lancamento"])) { // É divida ativa
                        $parametros = explode("/", $parcela["cod_lancamento"]);
                        $codigoEVencimentoParcelas = (new ExtratoDebitosReportModel($em))->getListaParcelaDivida((int) $parametros[0], $parametros[1]);
                    } else {
                        $codigoEVencimentoParcelas = (new ExtratoDebitosReportModel($em))->getCodigoAndVencimentoParcela((int) $parcela['cod_lancamento']);
                    }

                    foreach ($codigoEVencimentoParcelas as $codigoEVencimentoParcela) {
                        $parcelaDocumento = new ParcelaDocumento();
                        $parcelaDocumento->setCodParcela($codigoEVencimentoParcela['cod_parcela']);
                        $parcelaDocumento->setCodDocumento($object->getCodDocumento());
                        $parcelaDocumento->setNumDocumento($numDocumento);
                        $parcelaDocumento->setExercicio($this->getExercicio());

                        if ($codigoEVencimentoParcela['vencimento'] < date("Y-m-d")) {
                            $parcelaDocumento->setCodSituacao(2); //Parcela Vencida
                        } else {
                            $parcelaDocumento->setCodSituacao(1); // Parcela Aberta
                        }

                        $object->addFkArrecadacaoParcelaDocumentos($parcelaDocumento);
                    }
                }
            }

            $em->persist($object);
            $em->flush();
            $this->redirectCreate($object);
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
            $container->get('session')->getFlashBag()->add('error', $e->getMessage());
            throw $e;
        }
    }

    /**
     * @param $object
     */
    public function redirectCreate($object)
    {
        $message = $this->getTranslator()->trans('label.arrecadacaoDocumentoEmissao.msgSucesso');
        $message.= '(Certidão:' . $object->getNumDocumento() . ')';

        $container = $this->getConfigurationPool()->getContainer();
        $container->get('session')->getFlashBag()->add('success', $message);
        $this->forceRedirect(sprintf('/tributario/arrecadacao/documento-emissao/download/%d~%s', $object->getNumDocumento(), $object->getExercicio()));
    }

    public function getObject($object)
    {
        if (is_null($object)) {
            return '';
        }

        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        return $entityManager->getRepository(DocumentoEmissao::class)
            ->findOneBy(['numDocumento' => $object->getNumDocumento(), 'exercicio' => $object->getExercicio()]);
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function toString($object)
    {
        return $object instanceof CarneDevolucao
            ? $object->getNumeracao()
            : $this->getTranslator()->trans('label.arrecadacaoCarneDevolucao.modulo');
    }
}
