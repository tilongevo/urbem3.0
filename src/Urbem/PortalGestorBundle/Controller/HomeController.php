<?php

namespace Urbem\PortalGestorBundle\Controller;

use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Helper\StringHelper;

class HomeController extends BaseController
{
    public function indexAction()
    {
        $this->setBreadCrumb();

        return $this->render(
            'PortalGestorBundle:Home:index.html.twig',
            [
                'dadosIBGE' => $this->getDataIBGE(),
                'ultimasNoticiasCNM' => $this->getUltimasNoticiasCNM()
            ]
        );
    }

    /**
     * @return null|string
     */
    protected function getDataIBGE() {
        $urlIbge = $this->getParameter("url_ibge");
        $codigoIBGE = $this->get('prefeitura.info')->getCodigoIbge();

        if (empty(StringHelper::removeAllSpace($codigoIBGE)) || empty(StringHelper::removeAllSpace($urlIbge))) {
            return "Código do IBGE não informado";
        }

        $fileName = sprintf("%s.txt", $codigoIBGE);
        $serviceExternalData = $this->get('gestor_external_content');
        list($domXML, $contentDOMXPath) = $serviceExternalData->getContentExternalData($urlIbge . $codigoIBGE, $fileName);

        return $this->parseLayoutIBGE($domXML, $contentDOMXPath);
    }

    /**
     * @param \DOMDocument $dom
     * @param \DOMXPath $domxPath
     * @return null|string
     */
    protected function parseLayoutIBGE(\DOMDocument $dom, \DOMXPath $domxPath) {
        $tags = $domxPath->query('//div[@id="responseMunicipios"]');
        if ($tags->length) {
            return $dom->saveHTML($tags->item(0));
        }

        return null;
    }

    /**
     * @return mixed|null
     */
    protected function getUltimasNoticiasCNM() {
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
    protected function parseUltimasNoticiasCNM(\DOMDocument $dom, \DOMXPath $domxPath) {
        $tags = $domxPath->query('//section[@class="outras_noticias"]');
        if ($tags->length) {
            return $dom->saveHTML($tags->item(0));
        }

        return null;
    }
}