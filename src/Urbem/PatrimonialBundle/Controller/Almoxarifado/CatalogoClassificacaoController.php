<?php
/**
 * Created by PhpStorm.
 * User: gabrielvie
 * Date: 29/09/16
 * Time: 18:44
 */

namespace Urbem\PatrimonialBundle\Controller\Almoxarifado;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Urbem\CoreBundle\Controller\BaseController as Controller;
use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CatalogoClassificacaoModel;

/**
 * Class CatalogoClassificacaoController
 * @package Urbem\PatrimonialBundle\Controller\Almoxarifado
 */
class CatalogoClassificacaoController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function getCatalogoClassificacoesByNivelAction(Request $request)
    {
        /**
         * @var \Doctrine\ORM\EntityManager $entityManager
         */
        $entityManager = $this->getDoctrine()->getEntityManager();

        $codClassificacao = $request->get('cod_classificacao');
        $nivel = $request->get('nivel');

        /**
         * @var Almoxarifado\CatalogoClassificacao $classificacao
         */
        $classificacao = $entityManager
            ->getRepository(Almoxarifado\CatalogoClassificacao::class)
            ->find($codClassificacao);

        $catalogoClassificacaoModel = new CatalogoClassificacaoModel($entityManager);
        $result = $catalogoClassificacaoModel->getClassificacaoFilhos([
            'cod_nivel' => $nivel,
            'cod_estrutual' => $classificacao->getCodEstrutural()
        ]);

        $normalizer = new ObjectNormalizer();
        $encoder = new JsonEncoder();

        $serializer = new Serializer(array($normalizer), array($encoder));
        $classificacoes = $serializer->serialize($result, 'json');

        $response = new Response();
        $response->setContent($classificacoes);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
