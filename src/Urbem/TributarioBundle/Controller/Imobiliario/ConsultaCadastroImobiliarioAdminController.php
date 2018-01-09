<?php

namespace Urbem\TributarioBundle\Controller\Imobiliario;

use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Entity\Imobiliario\Condominio;
use Urbem\CoreBundle\Entity\Imobiliario\Corretagem;
use Urbem\CoreBundle\Entity\Imobiliario\Imovel;
use Urbem\CoreBundle\Entity\Imobiliario\Lote;
use Urbem\CoreBundle\Entity\SwBairro;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\SwLogradouro;
use Urbem\CoreBundle\Entity\SwMunicipio;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;

class ConsultaCadastroImobiliarioAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function autocompleteLoteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $codLocalizacao = $request->get('codLocalizacao');
        $term = $request->get('q');

        /** @var QueryBuilder $qb */
        $qb = $em->getRepository(Lote::class)->createQueryBuilder('o');
        $qb->innerJoin('o.fkImobiliarioLoteLocalizacao', 'l');
        if ($codLocalizacao != '') {
            $qb->andWhere('l.codLocalizacao = :codLocalizacao');
            $qb->setParameter('codLocalizacao', $codLocalizacao);
        }
        $qb->andWhere('lpad(upper(l.valor), 10, \'0\') = :valor');
        $qb->setParameter('valor', str_pad($term, 10, '0', STR_PAD_LEFT));
        $qb->orderBy('l.valor', 'ASC');
        $rlt = $qb->getQuery()->getResult();

        $lotes = array();

        /** @var Lote $lote */
        foreach ($rlt as $lote) {
            array_push($lotes, array('id' => $lote->getCodLote(), 'label' => (string) $lote));
        }

        $items = array(
            'items' => $lotes
        );

        return new JsonResponse($items);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function autocompleteImovelAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $codLocalizacao = $request->get('codLocalizacao');
        $codLote = $request->get('codLote');
        $term = $request->get('q');

        /** @var QueryBuilder $qb */
        $qb = $em->getRepository(Imovel::class)->createQueryBuilder('o');
        $qb->innerJoin('o.fkImobiliarioImovelConfrontacao', 'ic');
        if ($codLocalizacao != '') {
            $qb->innerJoin('ic.fkImobiliarioConfrontacaoTrecho', 't');
            $qb->innerJoin('t.fkImobiliarioConfrontacao', 'c');
            $qb->innerJoin('c.fkImobiliarioLote', 'l');
            $qb->innerJoin('l.fkImobiliarioLoteLocalizacao', 'll');
            $qb->andWhere('ll.codLocalizacao = :codLocalizacao');
            $qb->setParameter('codLocalizacao', $codLocalizacao);
        }
        if ($codLote != '') {
            $qb->andWhere('ic.codLote = :codLote');
            $qb->setParameter('codLote', $codLote);
        }
        $qb->andWhere('o.inscricaoMunicipal = :inscricaoMunicipal');
        $qb->setParameter('inscricaoMunicipal', $term);
        $rlt = $qb->getQuery()->getResult();

        $imoveis = array();

        /** @var Imovel $imovel */
        foreach ($rlt as $imovel) {
            array_push($imoveis, array('id' => $imovel->getInscricaoMunicipal(), 'label' => (string) $imovel));
        }

        $items = array(
            'items' => $imoveis
        );

        return new JsonResponse($items);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function autocompleteSwBairroAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $codUf = $request->get('codUf');
        $codMunicipio = $request->get('codMunicipio');
        $term = $request->get('q');

        /** @var QueryBuilder $qb */
        $qb = $em->getRepository(SwBairro::class)->createQueryBuilder('o');
        if ($codUf != '') {
            $qb->andWhere('o.codUf = :codUf');
            $qb->setParameter('codUf', $codUf);
        }
        if ($codMunicipio != '') {
            $qb->andWhere('o.codMunicipio = :codMunicipio');
            $qb->setParameter('codMunicipio', $codMunicipio);
        }
        $qb->andWhere('LOWER(o.nomBairro) LIKE :nomBairro');
        $qb->setParameter('nomBairro', sprintf('%%%s%%', strtolower($term)));
        $rlt = $qb->getQuery()->getResult();

        $bairros = array();

        /** @var SwBairro $swBairro */
        foreach ($rlt as $swBairro) {
            array_push($bairros, array('id' => $swBairro->getCodBairro(), 'label' => (string) $swBairro));
        }

        $items = array(
            'items' => $bairros
        );

        return new JsonResponse($items);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function autocompleteSwLogradouroAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $codUf = $request->get('codUf');
        $codMunicipio = $request->get('codMunicipio');
        $codBairro = $request->get('codBairro');
        $term = $request->get('q');

        /** @var QueryBuilder $qb */
        $qb = $em->getRepository(SwLogradouro::class)->createQueryBuilder('o');
        $qb->innerJoin('o.fkSwNomeLogradouros', 'nl');
        $qb->innerJoin('nl.fkSwTipoLogradouro', 'tl');
        if ($codUf != '') {
            $qb->andWhere('o.codUf = :codUf');
            $qb->setParameter('codUf', $codUf);
        }
        if ($codMunicipio != '') {
            $qb->andWhere('o.codMunicipio = :codMunicipio');
            $qb->setParameter('codMunicipio', $codMunicipio);
        }
        if ($codBairro) {
            $qb->innerJoin('o.fkSwBairroLogradouros', 'bl');
            $qb->andWhere('bl.codBairro = :codBairro');
            $qb->setParameter('codBairro', $codBairro);
        }
        $qb->andWhere('LOWER(CONCAT(tl.nomTipo, \' \', nl.nomLogradouro)) LIKE :nomLogradouro');
        $qb->setParameter('nomLogradouro', sprintf('%%%s%%', strtolower($term)));
        $rlt = $qb->getQuery()->getResult();

        $logradouros = array();

        /** @var SwLogradouro $swLogradouro */
        foreach ($rlt as $swLogradouro) {
            array_push($logradouros, array('id' => $this->admin->getObjectKey($swLogradouro), 'label' => (string) $swLogradouro));
        }

        $items = array(
            'items' => $logradouros
        );

        return new JsonResponse($items);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function autocompleteCondominioAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $term = $request->get('q');

        /** @var QueryBuilder $qb */
        $qb = $em->getRepository(Condominio::class)->createQueryBuilder('o');
        $qb->where('o.codCondominio = :codCondominio');
        $qb->orWhere('LOWER(o.nomCondominio) LIKE :nomCondominio');
        $qb->setParameter('codCondominio', (int) $term);
        $qb->setParameter('nomCondominio', sprintf('%%%s%%', strtolower($term)));
        $qb->orderBy('o.codCondominio', 'ASC');
        $rlt = $qb->getQuery()->getResult();

        $condominios = array();

        /** @var Condominio $condominio */
        foreach ($rlt as $condominio) {
            array_push($condominios, array('id' => $this->admin->getObjectKey($condominio), 'label' => (string) $condominio));
        }

        $items = array(
            'items' => $condominios
        );

        return new JsonResponse($items);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function autocompleteSwCgmAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $term = $request->get('q');

        /** @var QueryBuilder $qb */
        $qb = $em->getRepository(SwCgm::class)->createQueryBuilder('o');
        $qb->where('o.numcgm != 0');
        $qb->andWhere('o.numcgm = :numcgm');
        $qb->orWhere('LOWER(o.nomCgm) LIKE :nomCgm');
        $qb->setParameter('numcgm', (int) $term);
        $qb->setParameter('nomCgm', sprintf('%%%s%%', strtolower($term)));
        $qb->orderBy('o.nomCgm', 'ASC');
        $rlt = $qb->getQuery()->getResult();

        $cgms = array();

        /** @var SwCgm $cgm */
        foreach ($rlt as $cgm) {
            array_push($cgms, array('id' => $this->admin->getObjectKey($cgm), 'label' => (string) $cgm));
        }

        $items = array(
            'items' => $cgms
        );

        return new JsonResponse($items);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function autocompleteCorretagemAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $term = $request->get('q');

        /** @var QueryBuilder $qb */
        $qb = $em->getRepository(Corretagem::class)->createQueryBuilder('o');
        $qb->where('o.creci = :creci');
        $qb->setParameter('creci', (int) $term);
        $qb->orderBy('o.creci', 'ASC');
        $rlt = $qb->getQuery()->getResult();

        $corretagens = array();

        /** @var Corretagem $corretagem */
        foreach ($rlt as $corretagem) {
            array_push($corretagens, array('id' => $this->admin->getObjectKey($corretagem), 'label' => (string) $corretagem));
        }

        $items = array(
            'items' => $corretagens
        );

        return new JsonResponse($items);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function consultarMunicipioAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $codUf = $request->get('codUf');

        /** @var QueryBuilder $qb */
        $qb = $em->getRepository(SwMunicipio::class)->createQueryBuilder('o');
        $qb->andWhere('o.codUf = :codUf');
        $qb->setParameter('codUf', $codUf);
        $rlt = $qb->getQuery()->getResult();

        $municipios = array();

        /** @var SwMunicipio $municipio */
        foreach ($rlt as $municipio) {
            $municipios[$municipio->getCodMunicipio()] = (string) $municipio;
        }

        return new JsonResponse($municipios);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function relatorioAction(Request $request)
    {
        $inscricaoMunicipal = $request->get('id');

        $container = $this->container;
        /** @var Usuario $usuario */
        $usuario = $container->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        /** @var Imovel $imovel */
        $imovel = $em->getRepository(Imovel::class)->find($inscricaoMunicipal);

        if ((count($usuario->getRoles()) === 2) && (in_array('ROLE_MUNICIPE', $usuario->getRoles()))) {
            $proprietario = $imovel->getFkImobiliarioProprietarios()->filter(function ($entry) use ($usuario) {
                if ($entry->getNumcgm() == $usuario->getNumcgm()) {
                    return $entry;
                }
            })->first();
            if (!$proprietario) {
                return (new RedirectResponse('/acesso-negado'))->send();
            }
        }

        $version = $container->getParameter('version');
        $logoTipo = $container->get('urbem.configuracao')->getLogoTipo();
        $entidade = $this->get('urbem.entidade')->getEntidade();

        $html = $this->renderView(
            'TributarioBundle:Imobiliario/Consulta:pdf.html.twig',
            [
                'imovel' => $imovel,
                'entidade' => $entidade,
                'admin' => $this->admin,
                'logoTipo' => $logoTipo,
                'modulo' => 'Cadastro Imobiliário',
                'subModulo' => 'Consultas',
                'funcao' => 'Emitir Recibo',
                'nomRelatorio' => 'Consultar Cadastro Imobiliário',
                'dtEmissao' => new \DateTime(),
                'usuario' => $usuario,
                'versao' => $version
            ]
        );

        $filename = sprintf('ConsultarCadastroImobiliario_%s.pdf', date('Y-m-d'));

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml(
                $html,
                [
                    'encoding' => 'utf-8',
                    'enable-javascript' => true,
                    'footer-line' => true,
                    'footer-left' => 'URBEM - CNM',
                    'footer-right' => '[page]',
                    'footer-center' => 'www.cnm.org.br',
                    'orientation'=>'Landscape'
                ]
            ),
            200,
            [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $filename)
            ]
        );
    }
}
