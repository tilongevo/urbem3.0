<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Arrecadacao;

use Doctrine\Common\Collections\ArrayCollection;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Administracao\Gestao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Administracao\Relatorio;
use Urbem\CoreBundle\Entity\Arrecadacao\GrupoCredito;
use Urbem\CoreBundle\Entity\Imobiliario\Imovel;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Model\Arrecadacao\GrupoCreditoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class DesoneradosReportAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_arrecadacao_relatorio_desonerados';
    protected $baseRoutePattern = 'tributario/arrecadacao/relatorios/desonerados';
    protected $layoutDefaultReport = '/bundles/report/gestaoTributaria/fontes/RPT/arrecadacao/report/design/relatorioDesonerados.rptdesign';
    protected $legendButtonSave = ['icon' => 'receipt', 'text' => 'Gerar Relatório'];
    protected $includeJs = ['/tributario/javascripts/arrecadacao/reportHelper.js'];
    const COD_ACAO = '2847';

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

        $em = $this->getEntityManager();
        $grupoCreditoModel = new GrupoCreditoModel($em);

        $fieldOptions = array();

        $fieldOptions['inscricaoImobiliaria'] = [
            'attr'        => ['class' => 'select2-parameters '],
            'class'       => Imovel::class,
            'choice_label' => function (Imovel $imovel) {
                return "{$imovel->getLote() } - {$imovel->getLocalizacao()} - {$imovel->getInscricaoMunicipal()}";
            },
            'label'       => 'label.arrecadacao.relatorios.desonerados.inscricaoImobiliaria',
            'mapped'      => false,
            'multiple'    => false,
            'placeholder' => 'label.selecione',
            'required'    => false,
        ];

        $fieldOptions['exercicio'] = [
            'label' => 'label.arrecadacao.relatorios.desonerados.exercicio',
            'mapped' => false,
            'required' => false,
            'attr' => ['minlength' => 4, 'maxlength' => 4]
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
            'label' => 'label.arrecadacao.relatorios.desonerados.contribuinte',
        ];

        $fieldOptions['grupoCredito'] = [
            'attr'        => ['class' => 'select2-parameters '],
            'class'       => GrupoCredito::class,
            'data'        => new ArrayCollection($grupoCreditoModel->getGrupoCredito()),
            'choice_label' => function (GrupoCredito $gCredito) {
                return "{$gCredito->getCodGrupo()}/{$gCredito->getAnoExercicio()} - {$gCredito->getDescricao()}";
            },
            'query_builder' => function ($em) {
                $qb = $em->createQueryBuilder('o');
                $qb->orderBy('o.codGrupo', 'ASC');
                return $qb;
            },
            'label'       => 'label.arrecadacao.relatorios.desonerados.grupoCredito',
            'mapped'      => false,
            'multiple'    => false,
            'placeholder' => 'label.selecione',
            'required'    => true,
        ];

        $formMapper
            ->with('label.arrecadacao.relatorios.desonerados.titulo')
                ->add('inscricaoImobiliaria', 'entity', $fieldOptions['inscricaoImobiliaria'])
                ->add('exercicio', 'number', $fieldOptions['exercicio'])
            ->end()
            ->with(' ')
                ->add('contribuinte', 'autocomplete', $fieldOptions['contribuinte'])
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
        $fileName = $this->parseNameFile("relatorioDesonerados");

        $inscricaoImobiliaria = $this->getForm()->get('inscricaoImobiliaria')->getData();
        $stExercicio = $this->getForm()->get('exercicio')->getData();
        $contribuinte = $this->getForm()->get('contribuinte')->getData();
        $grupoCredito = $this->getForm()->get('grupoCredito')->getData();

        $stImovel = $this::getEnderecoComTipoNomeNumero($inscricaoImobiliaria);
        $stNomCGM = $contribuinte ? $contribuinte->getNomCgm() : '';

        $inscricaoImobiliaria = $inscricaoImobiliaria ? (string) $inscricaoImobiliaria->getInscricaoMunicipal() : '';
        $stExercicio = $stExercicio ? (string) $stExercicio : '';
        $contribuinte = $contribuinte ? (string) $contribuinte->getNumcgm() : '';
        $grupoCredito = $grupoCredito ? (string) $grupoCredito->getCodGrupo() : '';

        $params = [
            'term_user' => $this->getCurrentUser()->getUserName(),
            'cod_acao' => self::COD_ACAO,
            'exercicio' => $exercicio,
            'inCodGestao' => Gestao::GESTAO_TRIBUTARIA,
            'inCodModulo' => Modulo::MODULO_ARRECADACAO ,
            'inCodRelatorio' => Relatorio::TRIBUTARIA_ARRECADACAO_RELATORIO_DESONERADOS,
            'inCodImovel' => $inscricaoImobiliaria,
            'HdninCodImovel' => '',
            'stImovel' => $stImovel,
            'stExercico' => $stExercicio,
            'inCGM' => $contribuinte,
            'HdninCGM' => '',
            'stNomCGM' => $stNomCGM,
            'inCodGrupo' => $grupoCredito,
            'HdninCodGrupo' => '',
            'stGrupo' => ''
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
     * @param $inscricaoImobiliaria
     * @return string
     */
    private function getEnderecoComTipoNomeNumero($inscricaoImobiliaria)
    {
        $stImovel = '';

        if ($inscricaoImobiliaria) {
            $nomeLogradouro = $inscricaoImobiliaria
                ->getFkImobiliarioImovelConfrontacao()
                ->getFkImobiliarioConfrontacaoTrecho()
                ->getFkImobiliarioTrecho()
                ->getFkSwLogradouro()
                ->getFkSwNomeLogradouros()->last();

            $numeroLogradouro = $inscricaoImobiliaria->getNumero();

            $stImovel = $nomeLogradouro.', '.$numeroLogradouro;
        }
        return $stImovel;
    }
}
