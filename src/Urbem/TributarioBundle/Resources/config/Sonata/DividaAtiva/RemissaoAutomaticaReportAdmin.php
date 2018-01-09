<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\DividaAtiva;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Administracao\Gestao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Administracao\Relatorio;
use Urbem\CoreBundle\Entity\Arrecadacao\GrupoCredito;
use Urbem\CoreBundle\Entity\Divida\DividaAtiva;
use Urbem\CoreBundle\Entity\Divida\DividaCgm;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomico;
use Urbem\CoreBundle\Entity\Imobiliario\Imovel;
use Urbem\CoreBundle\Entity\Monetario\Credito;
use Urbem\CoreBundle\Entity\Normas\Norma;
use Urbem\CoreBundle\Entity\Normas\TipoNorma;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class RemissaoAutomaticaReportAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_divida_ativa_relatorio_remissao_automatica';
    protected $baseRoutePattern = 'tributario/divida-ativa/relatorios/remissao-automatica';
    protected $layoutDefaultReport = '/bundles/report/gestaoTributaria/fontes/RPT/dividaAtiva/report/design/remissaoAutomatica.rptdesign';
    protected $legendButtonSave = ['icon' => 'receipt', 'text' => 'Gerar Relatório'];
    protected $includeJs = ['/tributario/javascripts/dividaAtiva/relatorios/fieldDynamic.js',
        '/tributario/javascripts/dividaAtiva/relatorios/incluir-credito.js'];
    const COD_ACAO = '2375';

    const ORD_CREDITO = 'credito';
    const ORD_GRUPO_CREDITO = 'grupoCredito';

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('create'));
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);
        $fieldOptions = array();

        $ordenacoes = [
            self::ORD_CREDITO => 'label.dividaAtivaRelatorios.remissaoAutomatica.credito',
            self::ORD_GRUPO_CREDITO => 'label.dividaAtivaRelatorios.remissaoAutomatica.grupoCredito'
        ];

        $fieldOptions['inscricaoDividaAtiva'] = [
            'class' => DividaAtiva::class,
            'mapped' => false,
            'json_choice_label' => function ($dividaAtiva) {
                return sprintf(
                    '%d - %s - %d/%d',
                    $dividaAtiva->getFkDividaDividaCgns()->last()->getFkSwCgm()->getNumcgm(),
                    $dividaAtiva->getFkDividaDividaCgns()->last()->getFkSwCgm()->getNomCgm(),
                    $dividaAtiva->getCodInscricao(),
                    $dividaAtiva->getExercicio()
                );
            },
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {

                $qb = $em->createQueryBuilder('dda');
                $qb->innerJoin(DividaCgm::class, 'ddc', 'WITH', 'dda.codInscricao = ddc.codInscricao');
                $qb->leftJoin(SwCgm::class, 'swCgm', 'WITH', 'swCgm.numcgm = ddc.numcgm');
                $qb->andWhere('(dda.codInscricao = :codInscricao OR swCgm.numcgm = :numcgm OR LOWER(swCgm.nomCgm) LIKE :nome)');
                $qb->setParameter('codInscricao', (int) $term);
                $qb->setParameter('numcgm', (int) $term);
                $qb->setParameter('nome', sprintf('%%%s%%', strtolower($term)));

                $qb->orderBy('dda.codInscricao', 'ASC');

                return $qb;
            },
            'required' => false,
            'attr' => [
                'class' => 'select2-parameters',
            ],
            'label' => 'label.dividaAtivaRelatorios.remissaoAutomatica.inscricaoDividaAtivaDe',
        ];

        $fieldOptions['inscricaoImobiliaria'] = [
            'attr'        => ['class' => 'select2-parameters '],
            'class'       => Imovel::class,
            'choice_label' => function (Imovel $imovel) {
                return "{$imovel->getLote() } - {$imovel->getLocalizacao()} - {$imovel->getInscricaoMunicipal()}";
            },
            'label'       => 'label.dividaAtivaRelatorios.remissaoAutomatica.de',
            'mapped'      => false,
            'multiple'    => false,
            'placeholder' => 'label.selecione',
            'required'    => false,
        ];

        $fieldOptions['inscricaoEconomica'] = [
            'attr'        => ['class' => 'select2-parameters '],
            'class'       => CadastroEconomico::class,
            'query_builder' => function ($em) {
                $qb = $em->createQueryBuilder('o');
                $qb->orderBy('o.inscricaoEconomica', 'ASC');
                return $qb;
            },
            'label'       => 'label.dividaAtivaRelatorios.remissaoAutomatica.de',
            'mapped'      => false,
            'multiple'    => false,
            'placeholder' => 'label.selecione',
            'required'    => false,
        ];

        $fieldOptions['contribuinte'] = [
            'class' => SwCgm::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {

                $qb = $em->createQueryBuilder('o');

                $qb->andWhere('(o.numcgm = :numcgm OR LOWER(o.nomCgm) LIKE :nomCgm)');
                $qb->andWhere('o.numcgm <> 0');
                $qb->setParameter('numcgm', (int) $term);
                $qb->setParameter('nomCgm', sprintf('%%%s%%', strtolower($term)));

                $qb->orderBy('o.numcgm', 'ASC');

                return $qb;
            },
            'required' => false,
            'attr' => [
                'class' => 'select2-parameters',
            ],
            'label' => 'label.dividaAtivaRelatorios.remissaoAutomatica.de',
        ];

        $fieldOptions['tipoFundamentacaoLegal'] = [
            'attr'         => ['class' => 'select2-parameters '],
            'class'        => TipoNorma::class,
            'choice_value' => 'codTipoNorma',
            'label'        => 'label.dividaAtivaRelatorios.remissaoAutomatica.tipoFundamentacaoLegal',
            'mapped'       => false,
            'placeholder'  => false,
            'required'     => true,
        ];

        $fieldOptions['fundamentacaoLegal'] = [
            'class' => Norma::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {

                $qb = $em->createQueryBuilder('o');
                $qb->andWhere('(o.codNorma = :codNorma OR LOWER(o.nomNorma) LIKE :nomNorma OR o.exercicio = :exercicio)');
                $qb->andWhere('(o.codNorma IS NOT NULL)');
                $qb->andWhere('(o.codTipoNorma = :codTipoNorma)');
                $qb->setParameter('codNorma', (int) $term);
                $qb->setParameter('nomNorma', sprintf('%%%s%%', strtolower($term)));
                $qb->setParameter('exercicio', sprintf('%%%s%%', strtolower($term)));
                $qb->setParameter('codTipoNorma', (int) $request->get('tipoFundamentacaoLegal'));

                $qb->orderBy('o.codNorma', 'ASC');
                $qb->orderBy('o.exercicio', 'DESC');

                return $qb;
            },
            'required' => false,
            'req_params' => [
                'tipoFundamentacaoLegal' => 'varJsTipoFundamentacaoLegal',
            ],
            'attr' => [
                'class' => 'select2-parameters',
            ],
            'label' => 'label.dividaAtivaRelatorios.remissaoAutomatica.fundamentacaoLegal',
        ];

        $fieldOptions['filtrar'] = [
            'label' => 'label.dividaAtivaRelatorios.remissaoAutomatica.filtrar',
            'placeholder' => false,
            'choices' => array_flip($ordenacoes),
            'mapped' => false,
            'required' => true
        ];

        $fieldOptions['creditoValores'] = [
            'label' => 'Crédito Valores',
            'data' => '',
            'mapped' => false,
            'required' => false,
        ];

        $fieldOptions['exercicio'] = [
            'label' => 'label.dividaAtivaRelatorios.remissaoAutomatica.exercicio',
            'data' => $this->getExercicio(),
            'mapped' => false,
            'required' => true,
            'attr' => ['minlength' => 4, 'maxlength' => 4]
        ];

        $fieldOptions['credito'] = [
            'attr'        => ['class' => 'select2-parameters '],
            'class'       => Credito::class,
            'choice_value' => function ($credito) {
                if (!$credito) {
                    return;
                }

                return sprintf('%d~%d~%d~%d', $credito->getCodCredito(), $credito->getCodNatureza(), $credito->getCodGenero(), $credito->getCodEspecie());
            },
            'choice_label' => function (Credito $credito) {
                return "{$credito->getCodCredito()} - {$credito->getDescricaoCredito()}";
            },
            'label'       => 'label.dividaAtivaRelatorios.remissaoAutomatica.credito',
            'mapped'      => false,
            'multiple'    => false,
            'placeholder' => 'label.selecione',
            'required'    => false,
        ];

        $fieldOptions['listaCreditos'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::DividaAtiva/Relatorios/RemissaoAutomatica/lista_creditos.html.twig',
            'data' => [
                'itens' => '',
            ],
        ];

        $fieldOptions['incluirCredito'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::DividaAtiva/Relatorios/RemissaoAutomatica/incluir_credito_exercicio.html.twig',
            'data' => [],
        ];

        $fieldOptions['grupoCredito'] = [
            'attr'        => ['class' => 'select2-parameters '],
            'class'       => GrupoCredito::class,
            'choice_label' => function (GrupoCredito $gCredito) {
                return "{$gCredito->getCodGrupo()} - {$gCredito->getAnoExercicio()} - {$gCredito->getDescricao()}";
            },
            'query_builder' => function ($em) {
                $qb = $em->createQueryBuilder('o');
                $qb->orderBy('o.codGrupo', 'ASC');
                return $qb;
            },
            'label'       => 'label.dividaAtivaRelatorios.remissaoAutomatica.grupoCredito',
            'mapped'      => false,
            'multiple'    => true,
            'placeholder' => 'label.selecione',
            'required'    => false,
        ];

        $formMapper
            ->with('label.dividaAtivaRelatorios.remissaoAutomatica.titulo')
                ->add('inscricaoDividaAtivaDe', 'autocomplete', $fieldOptions['inscricaoDividaAtiva'])
                ->add('inscricaoDividaAtivaAte', 'autocomplete', array_merge($fieldOptions['inscricaoDividaAtiva'], ['label' => 'label.dividaAtivaRelatorios.remissaoAutomatica.ate']))
            ->end()
            ->with('label.dividaAtivaRelatorios.remissaoAutomatica.inscricaoImobiliaria')
                ->add('inscricaoImobiliariaDe', 'entity', $fieldOptions['inscricaoImobiliaria'])
                ->add('inscricaoImobiliariaAte', 'entity', array_merge($fieldOptions['inscricaoImobiliaria'], ['label' => 'label.dividaAtivaRelatorios.remissaoAutomatica.ate']))
            ->end()
            ->with('label.dividaAtivaRelatorios.remissaoAutomatica.inscricaoEconomica')
                ->add('inscricaoEconomicaDe', 'entity', $fieldOptions['inscricaoEconomica'])
                ->add('inscricaoEconomicaAte', 'entity', array_merge($fieldOptions['inscricaoEconomica'], ['label' => 'label.dividaAtivaRelatorios.remissaoAutomatica.ate']))
            ->end()
            ->with('label.dividaAtivaRelatorios.remissaoAutomatica.contribuinte')
                ->add('contribuinteDe', 'autocomplete', $fieldOptions['contribuinte'])
                ->add('contribuinteAte', 'autocomplete', array_merge($fieldOptions['contribuinte'], ['label' => 'label.dividaAtivaRelatorios.remissaoAutomatica.ate']))
            ->end()
            ->with('label.dividaAtivaRelatorios.remissaoAutomatica.fundamentacaoLegal')
                ->add('tipoFundamentacaoLegal', 'entity', $fieldOptions['tipoFundamentacaoLegal'])
                ->add('fundamentacaoLegal', 'autocomplete', $fieldOptions['fundamentacaoLegal'])
            ->end()
            ->with('label.dividaAtivaRelatorios.remissaoAutomatica.filtrar')
               ->add('filtrar', 'choice', $fieldOptions['filtrar'])
            ->end()
            ->with('label.dividaAtivaRelatorios.remissaoAutomatica.credito', ['class' => 'creditoContainer'])
                ->add('credito', 'entity', $fieldOptions['credito'])
                ->add('exercicio', 'number', $fieldOptions['exercicio'])
                ->add('incluirCredito', 'customField', $fieldOptions['incluirCredito'])
                ->add('listaCreditos', 'customField', $fieldOptions['listaCreditos'])
            ->end()
            ->with('label.dividaAtivaRelatorios.remissaoAutomatica.grupoCredito', ['class' => 'grupoCreditoContainer'])
                ->add('grupoCredito', 'entity', $fieldOptions['grupoCredito'])
            ->end()
        ;
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $exercicio = $this->getExercicio();
        $fileName = $this->parseNameFile("remissaoAutomatica");

        $inscricaoDividaAtivaDe = $this->getForm()->get('inscricaoDividaAtivaDe')->getData();
        $inscricaoDividaAtivaAte = $this->getForm()->get('inscricaoDividaAtivaAte')->getData();
        $inscricaoImobiliariaDe = $this->getForm()->get('inscricaoImobiliariaDe')->getData();
        $inscricaoImobiliariaAte = $this->getForm()->get('inscricaoImobiliariaAte')->getData();
        $inscricaoEconomicaDe = $this->getForm()->get('inscricaoEconomicaDe')->getData();
        $inscricaoEconomicaAte = $this->getForm()->get('inscricaoEconomicaAte')->getData();
        $contribuinteDe = $this->getForm()->get('contribuinteDe')->getData();
        $contribuinteAte = $this->getForm()->get('contribuinteAte')->getData();
        $fundamentacaoLegal = $this->getForm()->get('fundamentacaoLegal')->getData();
        $credito = $this->getRequest()->get('creditos');
        $grupoCredito = $this->getForm()->get('grupoCredito')->getData();
        $exercicioForm = $this->getForm()->get('exercicio')->getData();
        $filtrar = $this->getForm()->get('filtrar')->getData();

        $codNorma = $fundamentacaoLegal ? (int) $fundamentacaoLegal->getCodNorma() : 0;

        $inscricaoDividaAtivaDe = $inscricaoDividaAtivaDe ? (int) $inscricaoDividaAtivaDe->getCodInscricao().",'".$inscricaoDividaAtivaDe->getExercicio()."'," : 'null, null,';
        $inscricaoDividaAtivaAte = $inscricaoDividaAtivaAte ? (int) $inscricaoDividaAtivaAte->getCodInscricao().",'".$inscricaoDividaAtivaAte->getExercicio()."'," : 'null, null,';
        $inscricaoImobiliariaDe = $inscricaoImobiliariaDe ? (int) $inscricaoImobiliariaDe->getInscricaoMunicipal()."," : 'null,';
        $inscricaoImobiliariaAte = $inscricaoImobiliariaAte ? (int) $inscricaoImobiliariaAte->getInscricaoMunicipal()."," : 'null,';
        $inscricaoEconomicaDe = $inscricaoEconomicaDe ? (int) $inscricaoEconomicaDe->getInscricaoEconomica()."," : 'null,';
        $inscricaoEconomicaAte = $inscricaoEconomicaAte ? (int) $inscricaoEconomicaAte->getInscricaoEconomica()."," : 'null,';
        $contribuinteDe = $contribuinteDe ? (int) $contribuinteDe->getNumcgm()."," : 'null,';
        $contribuinteAte = $contribuinteAte ? (int) $contribuinteAte->getNumcgm()."," : 'null,';
        $fundamentacaoLegal = $fundamentacaoLegal ? (int) $fundamentacaoLegal->getCodNorma()."," : 'null,';

        if ($filtrar == 'credito') {
            $credito = $credito ? "'".$this->getCredito($credito)."'," : 'null,';

            if ($credito == 'null,') {
                $exercicioForm = 'null';
            } else {
                $exercicioForm = "'".$exercicioForm."'";
            }

            $filtrar = 'false,';
            $creditoOrGrupoCredito = $credito;
        } elseif ($filtrar == 'grupoCredito') {
            $grupoCredito = $grupoCredito ? "'".$this->getGrupoCredito($grupoCredito)."'," : 'null,';
            $exercicioForm = 'null';
            $filtrar = 'true,';
            $creditoOrGrupoCredito = $grupoCredito;
        }

        $filtro = '('
            .$inscricaoDividaAtivaDe
            .$inscricaoDividaAtivaAte
            .$inscricaoImobiliariaDe
            .$inscricaoImobiliariaAte
            .$inscricaoEconomicaDe
            .$inscricaoEconomicaAte
            .$contribuinteDe
            .$contribuinteAte
            .$fundamentacaoLegal
            .$creditoOrGrupoCredito
            .$filtrar
            .$exercicioForm;

        $params = [
            'term_user' => $this->getCurrentUser()->getUserName(),
            'cod_acao' => self::COD_ACAO,
            'exercicio' => $exercicio,
            'inCodGestao' => Gestao::GESTAO_TRIBUTARIA,
            'inCodModulo' => Modulo::MODULO_DIVIDA_ATIVA ,
            'inCodRelatorio' => Relatorio::TRIBUTARIA_DIVIDA_ATIVA_REMISSAO_AUTOMATICA,
            'stFiltro' => $filtro,
            'cod_norma' => $codNorma
        ];

        $apiService = $this->getReportService();
        $apiService->setReportNameFile($fileName);
        $apiService->setLayoutDefaultReport($this->layoutDefaultReport);
        $res = $apiService->getReportContent($params);

        $this->parseContentToPdf(
            $res->getBody()->getContents(),
            $fileName
        );
    }

    /**
     * @param $choices
     * @return string
     * exemplo de saída: 2017003.001.99.9-
     */
    public function getCredito($choices)
    {
        $valores = '';
        foreach ($choices as $choice) {
            $codigo = $this::formatCodigo($choice['credito']);
            $valores .= $choice['exercicio'].$codigo.'-';
        }

        $valores = substr($valores, 0, -1);

        return $valores;
    }

    /**
     * @param $choices
     * @return string
     * exemplo saída: 20011-
     */
    public function getGrupoCredito($choices)
    {
        $valores = '';
        foreach ($choices as $choice) {
            $valores .= $choice->getAnoExercicio()
                .$choice->getCodGrupo().',';
        }

        $valores = substr($valores, 0, -1);

        return $valores;
    }

    /**
     * @param $valor
     * @return string
     * exemplo de saída: 110.001.01.1
     */
    public function formatCodigo($valor)
    {

        $splittedId = explode('~', $valor);
        $codigo = '';

        for ($i = 0; $i < sizeof($splittedId); $i++) {
            $formattedId = '0000'.$splittedId[$i];

            if ($i == 0) {
                $codigo .= substr($formattedId, strlen($formattedId) -3, 3) . '.';
                continue;
            }

            if ($i == 1) {
                $codigo .=  substr($formattedId, strlen($formattedId) - 3, 3) . '.';
                continue;
            }

            if ($i == 2) {
                $codigo .= substr($formattedId, strlen($formattedId) - 2, 2) . '.';
                continue;
            }

            if ($i == 3) {
                $codigo .= substr($formattedId, strlen($formattedId) - 1, 1);
            }
            return $codigo;
        }
    }
}
