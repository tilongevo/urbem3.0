<?php

namespace Urbem\TributarioBundle\Controller\Economico;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Entity\Economico\AtividadeCadastroEconomico;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomicoAutonomo;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomicoEmpresaDireito;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomicoEmpresaFato;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Entity\SwProcessoInteressado;
use Urbem\CoreBundle\Model\Economico\AtividadeModel;
use Urbem\CoreBundle\Model\Economico\LicencaAtividadeModel;

/**
 * Class LicencaAtividadeController
 * @package Urbem\TributarioBundle\Controller\Economico
 */
class LicencaAtividadeController extends BaseController
{
    /**
     * @param Request $request
     */
    public function homeAction()
    {
        $this->setBreadCrumb();
        return $this->render('TributarioBundle::Economico/Licenca/home.html.twig');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getAtividadeAction(Request $request)
    {
        $codAtvidade = $request->query->get('codAtividade');
        $em = $this->getDoctrine()->getManager();
        $atividade = array();
        $result = (new AtividadeModel($em))
            ->getAtividade($codAtvidade);

        foreach ($result as $a) {
            $dtInicio = null;
            $dtTermino = null;
            $principal = false;
            foreach ($a->getFkEconomicoAtividadeCadastroEconomicos() as $atividadeCadastroEconomico) {
                $dtInicio = $atividadeCadastroEconomico->getDtInicio();
                $dtTermino = $atividadeCadastroEconomico->getDtTermino();
                $principal = $atividadeCadastroEconomico->getPrincipal();
            }
            array_push($atividade, [
                'codAtividade' => $a->getCodAtividade(),
                'nomAtividade' => $a->getNomAtividade(),
                'dtInicioAtividade' => ($dtInicio ? $dtInicio->format('d/m/Y') : '-') ,
                'dtTerminoAtividade' => ($dtTermino ? $dtTermino->format('d/m/Y') : '-'),
                'principal' => ($principal ? 'Sim' : 'Não')
            ]);
        }

        return new JsonResponse($atividade);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getSwCgmInscricaoEconomicaAction(Request $request)
    {
        $search = $request->query->get('q');
        $em = $this->getDoctrine()->getManager();
        $inscricoes = (new LicencaAtividadeModel($em))
            ->getSwCgmInscricaoEconomica($search);
        $cgms = array();
        foreach ($inscricoes as $cgm) {
            array_push($cgms, array('id' => $cgm['inscricao_economica'],'label' => (string) $cgm['numcgm'].' - '.$cgm['nom_cgm'].' - '.$cgm['inscricao_economica']));
        }
        $items = [
            'items' => $cgms
        ];
        return new JsonResponse($items);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getProcessoBySwcgmAction(Request $request)
    {
        $numCgm = $request->query->get('numCgm');
        $em = $this->getDoctrine()->getManager();
        $processosArr = array();
        $processoInteressado = $em->getRepository(SwProcessoInteressado::class)
            ->findByNumcgm($numCgm);
        $processos = new ArrayCollection();
        foreach ($processoInteressado as $processo) {
            $processo = $em->getRepository(SwProcesso::class)
                ->findOneByCodProcesso($processo->getCodProcesso());
            $processos->add($processo);
        }
        foreach ($processos as $p) {
            array_push($processosArr, [
                'id' => $p->getCodProcesso(),
                'label' => $p->getAnoExercicio()
            ]);
        }

        return new JsonResponse($processosArr);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getAtividadeBySwcgmAction(Request $request)
    {
        $numCgm = trim($request->query->get('numCgm'));
        $em = $this->getDoctrine()->getManager();
        $atividades = array();

        $result =  $em->getRepository(CadastroEconomicoAutonomo::class)
            ->findByNumcgm($numCgm);

        if (!$result) {
            $result =  $em->getRepository(CadastroEconomicoEmpresaDireito::class)
                ->findByNumcgm($numCgm);
            if (!$result) {
                $result =  $em->getRepository(CadastroEconomicoEmpresaFato::class)
                    ->findByNumcgm($numCgm);
            }
        }

        foreach ($result as $cadastroEconomico) {
            $atividadesEconomicas = $em->getRepository(AtividadeCadastroEconomico::class)
                ->getAtividadeBySwcgmAction($cadastroEconomico->getInscricaoEconomica());

            foreach ($atividadesEconomicas as $ae) {
                $atividade = (new AtividadeModel($em))
                    ->getAtividade($ae->cod_atividade);
                foreach ($atividade as $a) {
                    array_push($atividades, [
                        'id' => $a->getCodAtividade(),
                        'label' => $a->getNomAtividade()
                    ]);
                }
            }
        }
        return new JsonResponse($atividades);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getProcessosByNameAndCodProcessoAction(Request $request)
    {
        $search = $request->query->get('q');
        $codAssunto = $request->query->get('select_assunto');

        $em = $this->getDoctrine()->getManager();
        if ($codAssunto != 0 && is_numeric($search)) {
            $processos = $em->getRepository(SwProcesso::class)
                ->findBy(['codProcesso' => $search, 'codAssunto' => $codAssunto]);
        } elseif ($codAssunto == 0 && is_numeric($search)) {
            $processos = $em->getRepository(SwProcesso::class)
                ->findByCodProcesso($search);
            if (!$processos) {
                $processos = $em->getRepository(SwProcesso::class)
                    ->findByCodAsunto($search);
            }
        } elseif ($codAssunto == 0 && !is_numeric($search)) {
            $processos = $em->getRepository(SwProcesso::class)
                ->createQueryBuilder('processo')
                ->where('processo.observacoes LIKE :search')
                ->setParameter('search', '%'.$search.'%')
                ->getQuery()
                ->getResult();
            if (!$processos) {
                $processos = $em->getRepository(SwProcesso::class)
                    ->createQueryBuilder('processo')
                    ->where('processo.resumoAssunto LIKE %:search%')
                    ->setParameter('search', '%'.$search.'%')
                    ->getQuery()
                    ->getResult();
            }
        } elseif ($codAssunto != 0 && !is_numeric($search)) {
            $processos = $em->getRepository(SwProcesso::class)
                ->createQueryBuilder('processo')
                ->where('processo.codAssunto = :codAssunto')
                ->setParameter('codAssunto', $codAssunto)
                ->getQuery()
                ->getResult();
        }
        $processos_arr = array();
        foreach ($processos as $p) {
            array_push($processos_arr, array('id' => $p->getCodProcesso(), 'label' => (string) $p));
        }
        $items = [
            'items' => $processos_arr
        ];
        return new JsonResponse($items);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getAssuntosByClassificacaoAction(Request $request)
    {
        $codClassificacao = $request->query->get('codClassificacao');
        $em = $this->getDoctrine()->getManager();
        $assuntos = $em->getRepository(SwAssunto::class)
            ->findBy(['codClassificacao' => $codClassificacao], ['codAssunto' => 'ASC']);
        $assuntos_arr = array();
        foreach ($assuntos as $a) {
            array_push($assuntos_arr, array('id' => $a->getCodAssunto(), 'label' => (string) $a->getNomAssunto()));
        }
        $items = [
            'items' => $assuntos_arr
        ];
        return new JsonResponse($items);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getNumcgmByInscricaoEconomicaAction(Request $request)
    {
        $inscricaoEconomica = $request->query->get('inscricaoEconomica');
        $em = $this->getDoctrine()->getManager();
        $result = $em->getRepository(CadastroEconomicoEmpresaFato::class)
            ->findOneBy(['inscricaoEconomica' => $inscricaoEconomica]);
        if (!$result) {
            $result = $em->getRepository(CadastroEconomicoEmpresaDireito::class)
                ->findOneBy(['inscricaoEconomica' => $inscricaoEconomica]);
            if (!$result) {
                $result = $em->getRepository(CadastroEconomicoAutonomo::class)
                    ->findOneBy(['inscricaoEconomica' => $inscricaoEconomica]);
            }
        }
        ($result) ? $result = $result->getNumCgm() : $result = null;
        $items = [
            'items' => $result
        ];
        return new JsonResponse($items);
    }
}
