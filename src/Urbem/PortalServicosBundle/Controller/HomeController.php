<?php

namespace Urbem\PortalServicosBundle\Controller;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\Controller\BaseController as Controller;
use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Entity\Arrecadacao\Lancamento;
use Urbem\CoreBundle\Entity\Divida\DividaCgm;
use Urbem\CoreBundle\Model\Divida\ConsultaInscricaoDividaModel;

/**
 * Class HomeController
 *
 * @package Urbem\PortalServicosBundle\Controller
 */
class HomeController extends Controller
{

    const COLOR_DIVIDA_ATIVA = '#F66';
    const COLOR_IPTU = '#3CF';
    const COLOR_ISS = '#6C0';
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $this->setBreadCrumb();

        $folderAdmimBundle = $this->container->getParameter('administrativobundle');

        $dividas = $this->getDividaAtivaCalendario();
        $arrecadacoesIptu = $this->getArrecadacaoCalendario('IPTU');
        $arrecadacoesIss = $this->getArrecadacaoCalendario('ISS');

        return $this->render(
            'PortalServicosBundle:Home:index.html.twig',
            [
                'ultimasNoticiasCNM' => $this->getUltimasNoticiasCNM(),
                'usuario' => $this->get('security.token_storage')->getToken()->getUser(),
                'profilePictureDir' => $folderAdmimBundle['usuarioShow'],
                'calendarios' => array_merge($dividas, $arrecadacoesIptu, $arrecadacoesIss)
            ]
        );
    }

    /**
     * @return mixed|null
     */
    protected function getUltimasNoticiasCNM()
    {
        $fileName = "ultimasNoticiasCNM.txt";
        $urlUltimasNoticiasCNM = $this->getParameter("url_ultimas_noticias_cnm");

        $serviceExternalData = $this->get('gestor_external_content');

        list($domXML, $contentDOMXPath) = $serviceExternalData->getContentExternalData($urlUltimasNoticiasCNM, $fileName);

        $content = $this->parseUltimasNoticiasCNM($domXML, $contentDOMXPath);

        return $content ? str_replace("<a href", "<a target='blank' href", $content) : null;
    }

    /**
     * @param \DOMDocument $dom
     * @param \DOMXPath $domxPath
     * @return null|string
     */
    protected function parseUltimasNoticiasCNM(\DOMDocument $dom, \DOMXPath $domxPath)
    {
        $tags = $domxPath->query('//section[@class="outras_noticias"]');
        if ($tags->length) {
            return $dom->saveHTML($tags->item(0));
        }

        return null;
    }

    /**
     * Retorna últimas parcelas da divida ativa
     *
     * @return array
     */
    protected function getDividaAtivaCalendario()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getEntityManager();
        /** @var Usuario $usuario */
        $usuario = $this->getCurrentUser();

        $model = new ConsultaInscricaoDividaModel($em);

        /** @var DividaCgm $dividaCgm */
        $dividaCgm = $em->getRepository(DividaCgm::class)->findOneByNumcgm($usuario->getNumcgm(), ['exercicio' => 'DESC']);

        $dividas = array();
        if ($dividaCgm) {
            $url = $this->generateUrl('urbem_portalservicos_divida_ativa_consulta_inscricao_show', ['id' => sprintf('%s~%s', $dividaCgm->getExercicio(), $dividaCgm->getCodInscricao())]);

            $cobrancas = $model->getListaCobrancasDivida($dividaCgm->getFkDividaDividaAtiva());
            foreach ($cobrancas as $cobranca) {
                $parcelas = $model->getListaParcelas($cobranca->num_parcelamento);
                foreach ($parcelas as $parcela) {
                    $exp = explode('/', $parcela->vencimento);
                    $dtStart = sprintf('%s-%s-%s', $exp[2], $exp[1], $exp[0]);

                    $dividas[] = [
                        'title' => sprintf('Dívida Ativa %s/%s', $dividaCgm->getCodInscricao(), $dividaCgm->getExercicio()),
                        'titleTwo' => sprintf('Parcela %s', $parcela->info_parcela),
                        'start' => $dtStart,
                        'url' => $url,
                        'color' => self::COLOR_DIVIDA_ATIVA
                    ];
                }
            }
        }

        return $dividas;
    }

    /**
     * Retorna arrecadações do último ano IPTU/ISSQN
     *
     * @param $tipo
     * @return array
     */
    protected function getArrecadacaoCalendario($tipo)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getEntityManager();
        /** @var Usuario $usuario */
        $usuario = $this->getCurrentUser();

        $arrecadacoes = array();

        $lancamentos = $em->getRepository(Lancamento::class)->getArrecadacao($usuario->getNumcgm(), $this->getExercicio(), null, null, null);
        foreach ($lancamentos as $lancamento) {
            $origem = $lancamento['origem'];
            if (preg_match("/{$tipo}/", $origem)) {
                if ($tipo == 'IPTU') {
                    $url = $this->generateUrl('urbem_portalservicos_arrecadacao_consulta_iptu_show', ['id' => $lancamento['cod_lancamento']]);
                    $color = self::COLOR_IPTU;
                } else {
                    $url = $this->generateUrl('urbem_portalservicos_arrecadacao_consulta_iss_show', ['id' => $lancamento['cod_lancamento']]);
                    $color = self::COLOR_ISS;
                }

                /** @var Lancamento $lancamento */
                $lancamento = $em->getRepository(Lancamento::class)->find($lancamento['cod_lancamento']);

                /** @var \Urbem\CoreBundle\Entity\Arrecadacao\Parcela $parcela */
                foreach ($lancamento->getFkArrecadacaoParcelas() as $parcela) {
                    $infoParcela = ($parcela->getNrParcela()) ? sprintf('Parcela %s/%s', $parcela->getNrParcela(), $lancamento->getTotalParcelas()) : 'Parcela Única';
                    $arrecadacoes[] = [
                        'title' => $origem,
                        'titleTwo' => $infoParcela,
                        'start' => $parcela->getVencimento()->format('Y-m-d'),
                        'url' => $url,
                        'color' => $color
                    ];
                }
            }
        }

        return $arrecadacoes;
    }
}
