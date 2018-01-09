<?php

namespace Urbem\FinanceiroBundle\Controller\Orcamento;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Helper\UploadHelper;

class ClassificacaoInstitucionalController extends BaseController
{

    /**
     * Método para listar todos os reponsáveis ténicos
     *      disponíveis para cadastro em classificação
     *      institucional
     * @param Request $request
     * @return JsonResponse
     */
    public function getResponsaveisTecnicosAction(Request $request)
    {
        $repo = $this->getDoctrine()->getRepository(Entidade::class);
        $responsaveis = $repo->getResponsaveisTecnicos();

        if (count($responsaveis)) {
            for ($i=0; $i < count($responsaveis); $i++) {
                $responsaveis[$i]['registro'] =
                    $responsaveis[$i]['nom_registro']
                    . ' - ' . $responsaveis[$i]['num_registro']
                    . ' - '
                    . $responsaveis[$i]['nom_uf']
                ;
            }
        }

        return new JsonResponse($responsaveis);
    }

    /**
     * Força o download do logotipo
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function logotipoAction(Request $request)
    {
        $uploadHelper = new UploadHelper();

        /* /var/www/projetos/urbem/app/../var/datafiles/financeiro/institucionalLogotipo/ */
        $path = $this->get('kernel')->getRootDir(). "/../{$uploadHelper->getBasePath()}{$this->getParameter('financeirobundle')['institucionalPath']}/{$request->attributes->get('_id')}";
        $content = file_get_contents($path);

        $response = new \Symfony\Component\HttpFoundation\Response();
        $response->headers->set('Content-Type', 'image/jpeg');
        $response->headers->set('Content-Disposition', 'attachment;filename="logotipo-'.$request->attributes->get('_id'));
        $response->setContent($content);
        return $response;
    }
}
