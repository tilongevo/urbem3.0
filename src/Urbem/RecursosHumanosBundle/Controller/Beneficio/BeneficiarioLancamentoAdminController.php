<?php
namespace Urbem\RecursosHumanosBundle\Controller\Beneficio;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BeneficiarioLancamentoAdminController extends Controller
{
    public function downloadArquivoAction(Request $request)
    {
        $arquivo = $request->query->get('strArquivo');

        $arquivoZip = readfile('/tmp/'.$arquivo);

        return new Response(
            $arquivoZip,
            200,
            array(
                'Content-Type'        => 'application/zip',
                'Content-Disposition' => sprintf('attachment; filename='.$arquivo)
            )
        );
    }
}
