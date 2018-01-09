<?php

namespace Urbem\PatrimonialBundle\Controller\Almoxarifado\Relatorios;

use Sonata\AdminBundle\Controller\CRUDController;
use Sonata\DoctrineORMAdminBundle\Model\ModelManager;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Administracao\Gestao;
use Urbem\CoreBundle\Entity\Administracao\Mes;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Administracao\Relatorio;
use Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado;
use Urbem\CoreBundle\Entity\Almoxarifado\Catalogo;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem;
use Urbem\CoreBundle\Entity\Almoxarifado\Natureza;
use Urbem\CoreBundle\Entity\Almoxarifado\TipoItem;
use Urbem\CoreBundle\Entity\Compras\Fornecedor;
use Urbem\CoreBundle\Helper\StringHelper;

/**
 * Class MovimentacaoController
 *
 * @package Urbem\PatrimonialBundle\Controller\Almoxarifado\Relatorios
 */
class MovimentacaoController extends AbstractRelatoriosController
{
    public function movimentacaoAction(Request $request)
    {
        $form = $this->getForm();

        if ($form->isSubmitted()) {
            /** @var ModelManager $modelManager */
            $modelManager = $this->admin->getModelManager();

            /** @var Relatorio $relatorio */
            $relatorio = $modelManager->findOneBy(Relatorio::class, [
                'codGestao'    => Gestao::GESTAO_PATRIMONIAL,
                'codModulo'    => Modulo::MODULO_PATRIMONIAL_ALMOXARIFADO,
                'codRelatorio' => Almoxarifado::RELATORIO_MOVIMENTACAO,
            ]);

            $almoxarifados = $form->get('almoxarifados')->getData();
            $centrosCusto = $form->get('centrosCusto')->getData();

            /** @var CatalogoItem $itemInicial */
            $itemInicial = $form->get('itemDe')->getData();

            /** @var CatalogoItem $itemFinal */
            $itemFinal = $form->get('itemPara')->getData();

            /** @var Catalogo $catalogo */
            $catalogo = $form->get('catalogo')->getData();

            $codClassificacao = $request->get('catalogoClassificacaoComponent');
            $codClassificacao = is_null($codClassificacao) ? '' : end($codClassificacao)['nivelDinamico'];

            $descricaoItem = $form->get('itemDescricao')->getData();

            /** @var Fornecedor $fornecedor */
            $fornecedor = $form->get('fornecedor')->getData();

            /** @var TipoItem $tipoItem */
            $tipoItem = $form->get('tipoItem')->getData();

            $periodicidade = $form->get('periodicidade')->getData();

            switch ($periodicidade) {
                case 'dia':
                    /** @var \DateTime $dataInicial */
                    $dataInicial = $form->get('dia')->getData();
                    $dataFinal = $dataInicial;
                    break;
                case 'mes':
                    /** @var Mes $mes */
                    $mes = $form->get('mes')->getData();
                    $ano = $form->get('ano')->getData();

                    $dataInicial = new \DateTime(sprintf('01-%d-%d', $mes->getCodMes(), $ano));

                    $dataFinal = clone $dataInicial;
                    $dataFinal = $dataFinal->modify('last day of this month');
                    break;
                case 'ano':
                    $ano = $form->get('ano')->getData();

                    $dataInicial = new \DateTime(sprintf('01-01-%d', $ano));

                    $dataFinal = clone $dataInicial;
                    $dataFinal = $dataFinal->modify('last day of December');
                    break;
                default:
                    $intervalo = $form->get('intervalo')->getData();

                    /** @var \DateTime $dataInicial */
                    $dataInicial = $intervalo['start'];

                    /** @var \DateTime $dataFinal */
                    $dataFinal = $intervalo['end'];
                    break;
            }

            $agrupamento = $form->get('quebraPor')->getData();

            $tipoRelatorio = $form->get('tipoRelatorio')->getData();

            $unidadeMedida = $form->get('unidadeMedida')->getData();

            $demonstrativoNatureza = $form->get('demonstrativoNatureza')->getData();

            $naturezas = $form->get('natureza')->getData();

            $params = [
                'codAlmoxarifado'  => StringHelper::arrayCollectionToString($almoxarifados, ',', 'codAlmoxarifado'),
                'codCatalogo'      => $catalogo->getCodCatalogo(),
                'codClassificacao' => $codClassificacao,
                'codCentroCusto'   => StringHelper::arrayCollectionToString($centrosCusto, ',', 'codCentro'),
                'inCGM'            => is_null($fornecedor) ? '' : $fornecedor->getFkSwCgm()->getNumcgm(),
                'stNomCGM'         => is_null($fornecedor) ? '' : $fornecedor->getFkSwCgm()->getNomCgm(),
                'inCodItemInicial' => is_null($itemFinal) ? '' : $itemInicial->getCodItem(),
                'inCodItemFinal'   => is_null($itemFinal) ? '' : $itemFinal->getCodItem(),
                'descricaoItem'    => is_null($descricaoItem) ? '' : $descricaoItem,
                'tipoItem'         => $tipoItem->getCodTipo() == 0 ? '' : $tipoItem->getCodTipo(),
                'dtIni'            => $dataInicial->format('d/m/Y'),
                'dtFim'            => $dataFinal->format('d/m/Y'),
                'data_saldo'       => $dataFinal->format('d/m/Y'),
                'tipo_ordenacao'   => $form->get('ordenar')->getData(),
                'tipo_agrupamento' => implode(',', $agrupamento),
                'tipo_relatorio'   => $tipoRelatorio == 'analitico' ? 'A' : 'S',
                'unidade_medida'   => $unidadeMedida,
                'natureza'         => $demonstrativoNatureza,
                'inCodNatureza'    => StringHelper::arrayCollectionToString($naturezas, ',', 'codNatureza'),
                'cgm_usuario'      => $this->admin->getCurrentUser()->getNumcgm(),
            ];

            $layoutReportPath = self::LAYOUT_REPORT_PATH . DIRECTORY_SEPARATOR . $relatorio->getArquivo();

            $content = $this->admin
                ->getReportService()
                ->setLayoutDefaultReport($layoutReportPath)
                ->getReportContent($params);

            $this->admin->parseContentToPdf($content->getBody()->getContents(), $relatorio->getNomRelatorio());
        }

        return $this->createAction();
    }
}
