<?php

namespace Urbem\PatrimonialBundle\Controller\Almoxarifado\Relatorios;

use Sonata\AdminBundle\Controller\CRUDController;
use Sonata\DoctrineORMAdminBundle\Model\ModelManager;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

use Urbem\CoreBundle\Entity\Administracao\Gestao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Administracao\Relatorio;
use Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado;
use Urbem\CoreBundle\Entity\Almoxarifado\Catalogo;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem;
use Urbem\CoreBundle\Entity\Almoxarifado\Natureza;
use Urbem\CoreBundle\Entity\Almoxarifado\TipoItem;
use Urbem\CoreBundle\Helper\StringHelper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class AlmoxarifadoRelatoriosController
 *
 * @package Urbem\PatrimonialBundle\Controller\Almoxarifado
 */
class ItensEstoqueController extends AbstractRelatoriosController
{
    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function itensEstoqueAction(Request $request)
    {
        $form = $this->getForm();

        if ($form->isSubmitted()) {
            /** @var ModelManager $modelManager */
            $modelManager = $this->admin->getModelManager();

            /** @var Relatorio $relatorio */
            $relatorio = $modelManager->findOneBy(Relatorio::class, [
                'codGestao'    => Gestao::GESTAO_PATRIMONIAL,
                'codModulo'    => Modulo::MODULO_PATRIMONIAL_ALMOXARIFADO,
                'codRelatorio' => Almoxarifado::RELATORIO_ITENS_ESTOQUE,
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

            /** @var TipoItem $tipoItem */
            $tipoItem = $form->get('tipoItem')->getData();

            /** @var Natureza $natureza */
            $natureza = $form->get('natureza')->getData();

            /** @var \DateTime $periodicidade */
            $periodicidade = $form->get('situacao')->getData();

            $ordenacao = $form->get('ordenar')->getData();

            $tipoQuebra = $form->get('tipoQuebra')->getData();

            $params = array_merge($this->configureDefaultReportParams($relatorio), [
                'codAlmoxarifado'     => StringHelper::arrayCollectionToString($almoxarifados, ',', 'codAlmoxarifado'),
                'codCentroCusto'      => StringHelper::arrayCollectionToString($centrosCusto, ',', 'codCentro'),
                'codCatalogo'         => $catalogo->getCodCatalogo(),
                'codClassificacao'    => $codClassificacao,
                'codItemInicial'      => is_null($itemFinal) ? '' : $itemInicial->getCodItem(),
                'codItemFinal'        => is_null($itemFinal) ? '' : $itemFinal->getCodItem(),
                'descricaoItem'       => is_null($descricaoItem) ? '' : $descricaoItem,
                'exibirItensComSaldo' => $form->get('saldo')->getData(),
                'tipoItem'            => $tipoItem->getCodTipo() == 0 ? '' : $tipoItem->getCodTipo(),
                'stTipoBuscaDescItem' => 'contem',
                'inCodNatureza'       => is_null($natureza) ? '' : $natureza->getCodNatureza(),
                'periodicidade'       => $periodicidade->format('d/m/Y'),
                'ordenacao'           => $ordenacao,
                'stTipoQuebra'        => $tipoQuebra,
            ]);

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
