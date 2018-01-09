<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Arrecadacao;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Administracao\Gestao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Administracao\Relatorio;
use Urbem\CoreBundle\Entity\Arrecadacao\Documento;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ListaCertidoesEmitidasReportAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_arrecadacao_relatorio_lista_certidoes_emitidas';
    protected $baseRoutePattern = 'tributario/arrecadacao/relatorios/lista-certidoes-emitidas';
    protected $layoutDefaultReport = '/bundles/report/gestaoTributaria/fontes/RPT/arrecadacao/report/design/certidoesEmitidas.rptdesign';
    protected $legendButtonSave = ['icon' => 'receipt', 'text' => 'Gerar Relatório'];
    protected $includeJs = ['/tributario/javascripts/dividaAtiva/relatorios/fieldDynamic.js'];
    const COD_ACAO = '2822';

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

        $fieldOptions['periodo'] = [
            'mapped' => false,
            'required' => false,
            'format' => 'dd/MM/yyyy',
            'dp_use_current' => false,
            'label' => 'label.arrecadacao.relatorios.listaCertidoesEmitidas.de',
        ];

        $fieldOptions['numeroDocumento'] = [
            'label' => 'label.arrecadacao.relatorios.listaCertidoesEmitidas.numeroDocumento',
            'mapped' => false,
            'required' => false,
            'attr' => ['maxlength' => 4],
        ];

        $fieldOptions['cgm'] = [
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
            'label' => 'label.arrecadacao.relatorios.listaCertidoesEmitidas.cgm',
        ];

        $fieldOptions['tipoDocumento'] = [
            'attr'        => ['class' => 'select2-parameters '],
            'class'       => Documento::class,
            'choice_label' => function (Documento $documento) {
                return "{$documento->getDescricao()}";
            },
            'label'       => 'label.arrecadacao.relatorios.listaCertidoesEmitidas.tipoDocumento',
            'mapped'      => false,
            'multiple'    => false,
            'placeholder' => 'label.selecione',
            'required'    => false,
        ];

        $formMapper
            ->with('label.arrecadacao.relatorios.listaCertidoesEmitidas.titulo')
                ->add('periodoDe', 'sonata_type_date_picker', $fieldOptions['periodo'])
                ->add('periodoAte', 'sonata_type_date_picker', array_merge($fieldOptions['periodo'], ['label' => 'label.arrecadacao.relatorios.listaCertidoesEmitidas.ate']))
            ->end()
            ->with(' ')
                ->add('numeroDocumento', 'text', $fieldOptions['numeroDocumento'])
                ->add('cgm', 'autocomplete', $fieldOptions['cgm'])
                ->add('tipoDocumento', 'entity', $fieldOptions['tipoDocumento'])
            ->end()
        ;
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {

        $exercicio = $this->getExercicio();
        $fileName = $this->parseNameFile("listaCertidoesEmitidas");

        $periodoDe = $this->getForm()->get('periodoDe')->getData();
        $periodoAte = $this->getForm()->get('periodoAte')->getData();
        $numeroDocumento = $this->getForm()->get('numeroDocumento')->getData();
        $cgm = $this->getForm()->get('cgm')->getData();
        $tipoDocumento = $this->getForm()->get('tipoDocumento')->getData();

        $periodoDe = $periodoDe ? $periodoDe->format('d/m/Y') : '';
        $periodoAte = $periodoAte ? $periodoAte->format('d/m/Y') : '';
        $numeroDocumento = $numeroDocumento ?  (string) $numeroDocumento : '';
        $cgm = $cgm ? (string) $cgm->getNumcgm() : '';
        $tipoDocumento = $tipoDocumento ? (string) $tipoDocumento->getCodTipoDocumento() : '';

        $params = [
            'term_user' => $this->getCurrentUser()->getUserName(),
            'cod_acao' => self::COD_ACAO,
            'exercicio' => $exercicio,
            'inCodGestao' => Gestao::GESTAO_TRIBUTARIA,
            'inCodModulo' => Modulo::MODULO_ARRECADACAO ,
            'inCodRelatorio' => Relatorio::TRIBUTARIA_ARRECADACAO_LISTA_CERTIDOES_EMITIDAS,
            'num_documento' => $numeroDocumento,
            'numcgm' => $cgm,
            'data_inicial' => $periodoDe,
            'data_final' => $periodoAte,
            'cod_tipo_documento' => $tipoDocumento,
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
}
