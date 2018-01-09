<?php

namespace Urbem\TributarioBundle\Controller\Imobiliario;

use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Economico\ResponsavelTecnico;
use Urbem\CoreBundle\Entity\Imobiliario\Construcao;
use Urbem\CoreBundle\Entity\Imobiliario\Imovel;
use Urbem\CoreBundle\Entity\Imobiliario\Lote;
use Urbem\CoreBundle\Entity\Imobiliario\Loteamento;
use Urbem\CoreBundle\Entity\Imobiliario\ParcelamentoSolo;
use Urbem\CoreBundle\Model\Imobiliario\LicencaModel;

class LicencaAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function consultarResponsavelTecnicoAction(Request $request)
    {
        list($numcgm, $sequencia) = explode('~', $request->request->get('responsavelTecnico'));
        /** @var ResponsavelTecnico $responsavelTecnico */
        $responsavelTecnico = $this->getDoctrine()
            ->getEntityManager()
            ->getRepository(ResponsavelTecnico::class)
            ->findOneBy([
                'numcgm' => $numcgm,
                'sequencia' => $sequencia
            ]);

        $data = array();
        if ($responsavelTecnico) {
            $data = [
                'numcgm' => $responsavelTecnico->getNumcgm(),
                'codProfissao' => $responsavelTecnico->getCodProfissao(),
                'codUf' => $responsavelTecnico->getCodUf(),
                'numRegistro' => $responsavelTecnico->getNumRegistro(),
                'nomCgm' => $responsavelTecnico->getFkSwCgm()->getNomCgm(),
                'nomUf' => $responsavelTecnico->getFkSwUf()->getNomUf(),
                'nomProfissao' => $responsavelTecnico->getFkCseProfissao()->getNomProfissao()
            ];
        }

        $response = new Response();
        $response->setContent(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function consultarConstrucaoAction(Request $request)
    {
        $options = (new LicencaModel($this->getDoctrine()->getEntityManager()))->getOptionsConstrucoesByIncricaoMunicipal($request->request->get('inscricaoMunicipal'));

        $response = new Response();
        $response->setContent(json_encode($options));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function consultarLoteAction(Request $request)
    {
        $options = (new LicencaModel($this->getDoctrine()->getEntityManager()))->getOptionsLotesByCodLocalizacao($request->request->get('codLocalizacao'));

        $response = new Response();
        $response->setContent(json_encode($options));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function consultarLoteamentoAction(Request $request)
    {
        $options = (new LicencaModel($this->getDoctrine()->getEntityManager()))->getOptionsLoteamentosByCodLote($request->request->get('codLote'));

        $response = new Response();
        $response->setContent(json_encode($options));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function consultarParcelamentoSoloAction(Request $request)
    {
        $options = (new LicencaModel($this->getDoctrine()->getEntityManager()))->getOptionsParcelamentosSoloByCodLote($request->request->get('codLote'), $request->request->get('codTipo'));

        $response = new Response();
        $response->setContent(json_encode($options));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function consultarImovelAction(Request $request)
    {
        $options = (new LicencaModel($this->getDoctrine()->getEntityManager()))->getOptionsImoveisByCodLote($request->request->get('codLote'), $request->request->get('novaUnidade'));

        $response = new Response();
        $response->setContent(json_encode($options));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
