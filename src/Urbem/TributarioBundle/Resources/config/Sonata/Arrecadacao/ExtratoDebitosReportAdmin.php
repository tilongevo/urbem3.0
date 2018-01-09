<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Arrecadacao;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Imobiliario\Lote;
use Urbem\CoreBundle\Entity\Imobiliario\Imovel;
use Urbem\CoreBundle\Entity\Imobiliario\Localizacao;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Form\Type\AutoCompleteType;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Form\FormMapper;

class ExtratoDebitosReportAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_arrecadacao_relatorio_extrato_debitos';
    protected $baseRoutePattern = 'tributario/arrecadacao/relatorio/extrato-debitos';
    protected $legendButtonSave = ['icon' => 'save', 'text' => 'Gerar Relatório'];
    protected $includeJs = array(
        '/tributario/javascripts/arrecadacao/relatorio-extrato-debitos.js'
    );

    public function configureRoutes(RouteCollection $collection)
    {
        $collection->add('dados_filtro', 'dados-filtro');
        $collection->add('relatorio', 'relatorio');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

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
            ->with('label.arrecadacaoExtratoDebitosReport.dados')
            ->add(
                'contribuinte',
                AutoCompleteType::class,
                [
                    'class' => SwCgm::class,
                    'required' => false,
                    'mapped' => false,
                    'label' => 'label.arrecadacaoExtratoDebitosReport.contribuinte',
                    'route' => array(
                        'name' => 'api-search-swcgm-pessoa-fisica-numcgm-nomecgm'
                    )
                ]
            )
            ->add(
                'inscricaoEconomica',
                AutoCompleteType::class,
                [
                    'required' => false,
                    'mapped' => false,
                    'label' => 'label.arrecadacaoExtratoDebitosReport.inscricaoEconomica',
                    'route' => array(
                        'name' => 'tributario_arrecadacao_relatorio_extrato_debitos_api_inscricao_economica'
                    )
                ]
            )
            ->add(
                'exercicio',
                'number',
                [
                    'label' => 'label.arrecadacaoExtratoDebitosReport.exercicio',
                    'mapped' => false,
                    'required' => false
                ]
            )
            ->end()
            ->with('label.imobiliarioImovel.inscricaoImobiliaria')
            ->add('fkImobiliarioLocalizacao', 'autocomplete', $fieldOptions['fkImobiliarioLocalizacao'])
            ->add('fkImobiliarioLote', 'autocomplete', $fieldOptions['fkImobiliarioLote'])
            ->add('fkImobiliarioImovel', 'autocomplete', $fieldOptions['fkImobiliarioImovel']);
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $imovel = $this->getForm()
            ->get('fkImobiliarioImovel')->getData();
        $contribuinte = $this->getForm()
            ->get('contribuinte')->getData();
        $inscricaoEconomica = $this->getForm()
            ->get('inscricaoEconomica')->getData();

        if ((!$imovel) && (!$contribuinte) && (!$inscricaoEconomica)) {
            $error = $this->getTranslator()->trans('label.arrecadacaoExtratoDebitosReport.erroValidacao');

            $errorElement->with('fkImobiliarioImovel')->addViolation($error)->end();
            $errorElement->with('contribuinte')->addViolation($error)->end();
            $errorElement->with('inscricaoEconomica')->addViolation($error)->end();
        }
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        if ($inscricaoMunicipal = $this->getForm()->get('fkImobiliarioImovel')->getData()) {
            $numCgm = $inscricaoMunicipal->getFkImobiliarioProprietarios()->last()->getNumCgm();
            $contribuinte = $this->getForm()->get('fkImobiliarioImovel')->getData()->getFkImobiliarioProprietarios()->last()->getFkSwCgm()->getNomCgm();
        } else if ($inscricaoEconomica = $this->getForm()->get('inscricaoEconomica')->getData()) {
            list($inscricao, $contribuinte) = explode("~", $inscricaoEconomica);
        } elseif ($cgm = $this->getForm()->get('contribuinte')->getData()) {
            $numCgm = $cgm->getNumCgm();
            $contribuinte = $cgm->getNomCgm();
        }

        $params = [
            'numcgm' => (isset($numCgm)) ? $numCgm : null,
            'inscricaoEconomica' => (isset($inscricao)) ? $inscricao : null,
            'inscricaoMunicipal' => (!is_null($this->getForm()->get('fkImobiliarioImovel')->getData())) ? $this->getForm()->get('fkImobiliarioImovel')->getData()->getInscricaoMunicipal() : null,
            'exercicio' => (!is_null($this->getForm()->get('exercicio')->getData())) ? $this->getForm()->get('exercicio')->getData() : null,
            'contribuinte' => (isset($contribuinte)) ? $contribuinte : null
        ];
        $this->forceRedirect($this->generateUrl('dados_filtro', $params));
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function toString($object)
    {
        return $this->getTranslator()->trans('label.arrecadacaoExtratoDebitosReport.modulo');
    }
}
