<?php

namespace Urbem\TributarioBundle\Controller\Economico;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Administracao\ArquivosDocumento;
use Urbem\CoreBundle\Entity\Administracao\ModeloArquivosDocumento;
use Urbem\CoreBundle\Entity\Administracao\ModeloDocumento;
use Urbem\CoreBundle\Entity\Economico\TipoLicencaModeloDocumento;

/**
 * Class LicencaDiversaController
 * @package Urbem\TributarioBundle\Controller\Economico
 */
class LicencaDiversaController extends BaseController
{
    const MODELO_TIPO_DOCUMENTO = 1;

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getModeloDocumentoByTipoLicencaAction(Request $request)
    {
        $tipoLicenca = $request->query->get('tipoLicenca');
        $em = $this->getDoctrine()->getManager();
        $tipoLicencaModeloDocumento = $em->getRepository(TipoLicencaModeloDocumento::class)
            ->findOneByCodTipo($tipoLicenca);

        if ($tipoLicencaModeloDocumento) {
            $modeloDocumento = $em->getRepository(ModeloDocumento::class)
                ->findByCodDocumento($tipoLicencaModeloDocumento->getCodDocumento());
        } else {
            $modeloDocumento = $em->getRepository(ModeloDocumento::class)
                ->findByCodTipoDocumento(self::MODELO_TIPO_DOCUMENTO);
        }

        $modeloDocumentoArr = array();
        foreach ($modeloDocumento as $modDoc) {
            $modeloArquivosDocumento = $em->getRepository(ModeloArquivosDocumento::class)
                ->findOneBy(['codDocumento' => $modDoc->getCodDocumento()]);

            if ($modeloArquivosDocumento) {
                $arquivoDocumento  = $em->getRepository(ArquivosDocumento::class)
                    ->findOneByCodArquivo($modeloArquivosDocumento->getCodArquivo());
                array_push($modeloDocumentoArr, [
                    'id' => $arquivoDocumento->getCodArquivo(),
                    'label' => $arquivoDocumento->getNomeArquivoSwx()
                ]);
            }
        }

        return new JsonResponse($modeloDocumentoArr);
    }
}
