<?php

namespace Urbem\PatrimonialBundle\Controller\Frota;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller as ControllerCore;
use Urbem\CoreBundle\Entity\Administracao\Mes;
use Urbem\CoreBundle\Entity\Frota;
use Urbem\CoreBundle\Model\Patrimonial\Frota\ProprioModel;

/**
 * Frota>Veiculo controller.
 */
class VeiculoController extends ControllerCore\BaseController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function perfilAction(Request $request)
    {
        $this->setBreadCrumb();

        $id = $request->query->get('id');
        $entityManager = $this->getDoctrine()->getManager();

        /** @var Frota\Veiculo $veiculo */
        $veiculo = $entityManager
            ->getRepository(Frota\Veiculo::class)
            ->find($id);

        $tipoVeiculo = ( $veiculo->getFkFrotaVeiculoPropriedades() && $veiculo->getFkFrotaVeiculoPropriedades()->last() ? (
            $veiculo->getFkFrotaVeiculoPropriedades()->last()->getFkFrotaProprio() ? 'proprio' :
          ( $veiculo->getFkFrotaVeiculoPropriedades()->last()->getFkFrotaTerceiros() ? 'terceiros' : 'default' )
        ) : 'default' );

        $documentosMes = [];
        foreach ($veiculo->getFkFrotaVeiculoDocumentos() as $documento) {
            $documentosMes[$documento->getCodDocumento()] = $entityManager->getRepository(Mes::class)->findOneBy([
                'codMes' => $documento->getMes()
            ]);
        }

        return $this->render('PatrimonialBundle::Frota/Veiculo/perfil.html.twig', [
            'veiculo' => $veiculo,
            'veiculoCombustivel' => $veiculo->getFkFrotaVeiculoCombustiveis(),
            'controleInterno' => $veiculo->getFkFrotaControleInternos(),
            'cessoes' => $veiculo->getFkFrotaVeiculoCessoes(),
            'documentos' => $veiculo->getFkFrotaVeiculoDocumentos(),
            'documentosMes' => $documentosMes,
            'proprio' => ( $veiculo->getFkFrotaVeiculoPropriedades()->last() ?
                $veiculo->getFkFrotaVeiculoPropriedades()->last()->getFkFrotaProprio() : null),
            'terceiros' => ( $veiculo->getFkFrotaVeiculoPropriedades()->last() ?
                $veiculo->getFkFrotaVeiculoPropriedades()->last()->getFkFrotaTerceiros() : null),
            'utilizacao' => $veiculo->getFkFrotaUtilizacoes()->last(),
            'terceirosHistorico' => (
                $veiculo->getFkFrotaVeiculoPropriedades()->last() && $veiculo->getFkFrotaVeiculoPropriedades()->last()->getFkFrotaTerceiros() ?
                    $veiculo->getFkFrotaVeiculoPropriedades()->last()->getFkFrotaTerceiros()->getFkFrotaTerceirosHistorico() : null
            ),
            'terceirosResponsavel' => (
                $veiculo->getFkFrotaVeiculoPropriedades()->last() && $veiculo->getFkFrotaVeiculoPropriedades()->last()->getFkFrotaTerceiros() ?
                    $veiculo->getFkFrotaVeiculoTerceirosResponsaveis() : null
            ),
            'terceirosLocacao' => (
                $veiculo->getFkFrotaVeiculoPropriedades()->last() && $veiculo->getFkFrotaVeiculoPropriedades()->last()->getFkFrotaTerceiros() ?
                    $veiculo->getFkFrotaVeiculoLocacoes() : null
            ),
            'tipoVeiculo' => $tipoVeiculo
        ]);
    }
}
