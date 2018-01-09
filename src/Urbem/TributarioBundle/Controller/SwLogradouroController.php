<?php

namespace Urbem\TributarioBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Imobiliario\Trecho;
use Urbem\CoreBundle\Entity\SwBairro;
use Urbem\CoreBundle\Entity\SwBairroLogradouro;
use Urbem\CoreBundle\Entity\SwLogradouro;
use Urbem\CoreBundle\Entity\SwMunicipio;

class SwLogradouroController extends BaseController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function municipioAction(Request $request)
    {
        $codUf = $request->request->get('codUf');

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getEntityManager();

        $municipios = $em->getRepository(SwMunicipio::class)->findByCodUf($codUf);

        $options = array();
        /** @var SwMunicipio $municipio */
        foreach ($municipios as $municipio) {
            $options[$municipio->getCodMunicipio()] = $municipio->getNomMunicipio();
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
    public function bairroAction(Request $request)
    {
        $params = array(
            'codUf' => $request->request->get('codUf'),
            'codMunicipio' => $request->request->get('codMunicipio')
        );

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getEntityManager();

        $bairros = $em->getRepository(SwBairro::class)->findBy($params);

        $options = array();
        /** @var SwBairro $bairro */
        foreach ($bairros as $bairro) {
            $options[$bairro->getCodBairro()] = $bairro->getNomBairro();
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
    public function logradouroAction(Request $request)
    {
        $params = array(
            'codUf' => $request->request->get('codUf'),
            'codMunicipio' => $request->request->get('codMunicipio')
        );

        if ($request->request->get('codBairro')) {
            $params['codBairro'] = $request->request->get('codBairro');
        }

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getEntityManager();

        $options = array();
        if ($request->request->get('codBairro')) {
            /** @var SwBairro $bairro */
            $bairro = $em->getRepository(SwBairro::class)->findOneBy($params);
            /** @var SwBairroLogradouro $bairroLogradouro */
            foreach ($bairro->getFkSwBairroLogradouros() as $bairroLogradouro) {
                $options[$bairroLogradouro->getCodLogradouro()] = (string) $bairroLogradouro->getFkSwLogradouro();
            }
        } else {
            $logradouros = $em->getRepository(SwLogradouro::class)->findBy($params);
            /** @var SwLogradouro $logradouro */
            foreach ($logradouros as $logradouro) {
                $options[$logradouro->getCodLogradouro()] = (string) $logradouro;
            }
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
    public function trechoAction(Request $request)
    {
        $params = array(
            'codUf' => $request->request->get('codUf'),
            'codMunicipio' => $request->request->get('codMunicipio')
        );

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getEntityManager();

        $options = array();

        $qb = $em->getRepository(Trecho::class)->createQueryBuilder('o');
        $qb->leftJoin('o.fkSwLogradouro', 'l');
        $qb->where('l.codUf = :codUf');
        $qb->andWhere('l.codMunicipio = :codMunicipio');
        $qb->setParameters($params);
        // Baixa
        $qb->leftJoin('o.fkImobiliarioBaixaTrechos', 'b');
        $qb->andWhere('b.dtInicio is not null AND b.dtTermino is not null OR b.dtInicio is null');
        $result = $qb->getQuery()->getResult();

        /** @var Trecho $trecho */
        foreach ($result as $trecho) {
            $options[$trecho->getCodTrecho()] = (string) $trecho;
        }

        $response = new Response();
        $response->setContent(json_encode($options));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
