<?php
namespace Urbem\TributarioBundle\Controller\Arrecadacao;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Model\Arrecadacao\CarneModel;

class RelacaoCnpjReportAdminController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function relatorioAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $carneModel = (new CarneModel($em));
        $cnpjs = $carneModel->getCnpj();

        $data = $request->query->get('data');
        $filename = sprintf('cnpjs_%s.txt', $data);

        try {
            $fp = fopen('/tmp/' . $filename, 'w');
            foreach ($cnpjs as $cnpj) {
                fwrite($fp, $cnpj->cnpj."\n");
            }
            fclose($fp);
        } catch (\Exception $e) {
            $this->setErrorMessage($e->getMessage());
        }

        $content = file_get_contents('/tmp/' . $filename);
        return new Response(
            $content,
            200,
            array(
                'Content-type' => 'text/plain; charset=ISO-8859-15',
                'Content-disposition' => sprintf('attachment; filename=' . $filename)
            )
        );
    }
}
