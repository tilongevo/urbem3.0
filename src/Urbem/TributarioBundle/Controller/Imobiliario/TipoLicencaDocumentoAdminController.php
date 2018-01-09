<?php

namespace Urbem\TributarioBundle\Controller\Imobiliario;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Administracao\Cadastro;
use Urbem\CoreBundle\Entity\Administracao\ModeloDocumento;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicenca;

class TipoLicencaDocumentoAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function consultarModelosDocumentoAction(Request $request)
    {
        $qb = $this->getDoctrine()
            ->getEntityManager()
            ->getRepository(ModeloDocumento::class)
            ->createQueryBuilder('o');
        $qb->leftJoin('o.fkImobiliarioTipoLicencaDocumentos', 't');
        $qb->where('t.codTipo = :codTipo');
        $qb->setParameter('codTipo', $request->request->get('codTipo'));
        $rlt = $qb->getQuery()->getResult();

        $options = array();

        /** @var ModeloDocumento $modeloDocumento */
        foreach ($rlt as $modeloDocumento) {
            $options[sprintf('%s~%s', $modeloDocumento->getCodDocumento(), $modeloDocumento->getCodTipoDocumento())] = (string) $modeloDocumento;
        }

        $response = new Response();
        $response->setContent(json_encode($options));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function consultarAtributosDinamicosAction(Request $request)
    {
        $atributosTipoLicenca = $this->getDoctrine()
            ->getEntityManager()
            ->getRepository(AtributoTipoLicenca::class)
            ->findBy(['codTipo' => $request->request->get('codTipo')]);

        $options = array();

        /** @var AtributoTipoLicenca $atributoTipoLicenca */
        foreach ($atributosTipoLicenca as $atributoTipoLicenca) {
            $options[$atributoTipoLicenca->getCodAtributo()] = (string) $atributoTipoLicenca->getFkAdministracaoAtributoDinamico();
        }

        $response = new Response();
        $response->setContent(json_encode($options));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
