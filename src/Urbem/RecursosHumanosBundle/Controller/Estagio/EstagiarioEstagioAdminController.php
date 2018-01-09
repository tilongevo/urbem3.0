<?php

namespace Urbem\RecursosHumanosBundle\Controller\Estagio;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Estagio\Curso;
use Urbem\CoreBundle\Model\Estagio\EstagiarioEstagioModel;
use Urbem\CoreBundle\Model\Pessoal\FaixaTurnoModel;

class EstagiarioEstagioAdminController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function preencherInstituicaoAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()
            ->getManager();

        /** @var EstagiarioEstagioModel $estagiarioEstagioModel */
        $estagiarioEstagioModel = new EstagiarioEstagioModel($em);
        $numcgm = $request->get('numcgm');

        if (is_null($numcgm)) {
            $instituicoes = $estagiarioEstagioModel->montaRecuperaRelacionamento();
        } else {
            $instituicoes = $estagiarioEstagioModel->montaRecuperaInstituicoesDaEntidade($numcgm);
        }

        $instituicoesArr = [];

        foreach ($instituicoes as $instituicao) {
            array_push($instituicoesArr, ['numcgm' => $instituicao->numcgm, 'nom_cgm' => $instituicao->numcgm . " - " . $instituicao->nom_cgm]);
        }

        return new JsonResponse($instituicoesArr);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function preencherGrauAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()
            ->getManager();

        /** @var EstagiarioEstagioModel $estagiarioEstagioModel */
        $estagiarioEstagioModel = new EstagiarioEstagioModel($em);

        $graus = $estagiarioEstagioModel->montaRecuperaGrausDeInstituicaoEnsino($request->get('id'));
        $grausArr = [];

        foreach ($graus as $grau) {
            array_push($grausArr, [
                'cod_grau' => $grau->cod_grau,
                'descricao' => $grau->cod_grau . " - " . $grau->descricao
            ]);
        }

        return new JsonResponse($grausArr);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function preencherCursoAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()
            ->getManager();

        /** @var EstagiarioEstagioModel $estagiarioEstagioModel */
        $estagiarioEstagioModel = new EstagiarioEstagioModel($em);

        $cursos = $estagiarioEstagioModel->montaRecuperarCursos(
            $request->get('numCgmInstituicao'),
            $request->get('codGrau')
        );

        $cursosArr = [];
        foreach ($cursos as $curso) {
            array_push($cursosArr, [
                'cod_curso' => $curso->cod_curso,
                'nom_curso' => $curso->cod_curso . " - " . $curso->nom_curso,
                'vl_bolsa' => $curso->vl_bolsa ? $curso->vl_bolsa : null,
                'nom_mes' => $curso->descricao
            ]);
        }

        return new JsonResponse($cursosArr);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function preencherCursoByGrauAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()
            ->getManager();

        /** @var Curso $cursos */
        $cursos = $em->getRepository(Curso::class)->findBy(
            [
                'codGrau' => $request->get('codGrau')
            ]
        );

        $cursosArr = [];
        /** @var Curso $curso */
        foreach ($cursos as $curso) {
            array_push($cursosArr, [
                'cod_curso' => $curso->getCodCurso(),
                'nom_curso' => $curso->getCodCurso() . " - " . $curso->getNomCurso(),
            ]);
        }

        return new JsonResponse($cursosArr);
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function montaRecuperaGradeAction(Request $request)
    {
        $codGrade = $request->get('codGrade');

        $em = $this->getDoctrine()->getManager();

        $faixaTurnoModel = new FaixaTurnoModel($em);
        $faixaTurno = $faixaTurnoModel->getFaixaTurno($codGrade);

        return $this->render('@RecursosHumanos/Pessoal/FaixaTurno/turnos.html.twig', [
            "turnos" => $faixaTurno
        ]);
    }
}
