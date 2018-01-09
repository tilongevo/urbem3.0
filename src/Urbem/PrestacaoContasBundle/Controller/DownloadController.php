<?php

namespace Urbem\PrestacaoContasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\PrestacaoContas\FilaRelatorio;
use Urbem\CoreBundle\Model\PrestacaoContas\FilaRelatorioModel;

class DownloadController extends Controller
{
    public function downloadAction(FilaRelatorio $fila)
    {
        $model = new FilaRelatorioModel($this->getDoctrine()->getManager());

        if (false === $model->canDownload($fila)) {
            return $this->redirectToRoute('prestacao_contas');
        }

        $path = rtrim($this->getParameter('prestacao_contas_file_path'), '/\\');
        $path = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path) . DIRECTORY_SEPARATOR;

        $response = new Response(file_get_contents($path . $fila->getCaminhoDownload()));
        $response->headers->set('Content-Type', 'application/zip');
        $response->headers->set('Content-Disposition', 'attachment;filename="' . $fila->getCaminhoDownload() . '"');
        $response->headers->set('Content-length', filesize($path . $fila->getCaminhoDownload()));

        return $response;
    }
}
