<?php

namespace Urbem\RecursosHumanosBundle\Controller\Pessoal;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Model\Pessoal\CarteiraVacinacaoModel;
use Urbem\CoreBundle\Model\Pessoal\ComprovanteMatriculaModel;
use Urbem\CoreBundle\Model\Pessoal\DependenteModel;

class DependenteAdminController extends CRUDController
{
    private $codDocumento;
    private $codDependente;

    public function alteraFlagDocumentosAction(Request $request)
    {
        $this->codDocumento = $request->get('codDocumento');
        $this->codDependente = $request->get('codDependente');

        $documento = $request->get('documento');
        $flag = $request->get('flag') == 'true' ? true: false;

        if ($this->isCarteiraVacinacao($documento)) {
            $this->alteraFlagCarteira($flag);
        } else {
            $this->alteraFlagComprovanteMatricula($flag);
        }

        $this->verificaDocumentosApresentados();

        return new JsonResponse([
           'message' => 'Flag Alterada'
        ], 200);
    }

    private function isCarteiraVacinacao($documento)
    {
        if ($documento == 'carteira-vacinacao') {
            return true;
        }
        return false;
    }

    private function alteraFlagCarteira($flag)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $carteiraVacinacaoModel = new CarteiraVacinacaoModel($em);
        $carteiraVacinacaoModel
            ->alterarFlagApresentada($this->codDocumento, $flag);
    }

    private function alteraFlagComprovanteMatricula($flag)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $comprovanteMatricula = new ComprovanteMatriculaModel($em);
        $comprovanteMatricula
            ->alteraFlagApresentada($this->codDocumento, $flag);
    }

    private function verificaDocumentosApresentados()
    {
        $em = $this->getDoctrine()->getEntityManager();
        /** @var DependenteModel $dependenteModel */
        $dependenteModel = new DependenteModel($em);
        $dependenteModel
            ->verificaDocumentosApresentados($this->codDependente);
    }
}
