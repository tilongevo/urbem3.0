<?php

namespace Urbem\RecursosHumanosBundle\Controller\FolhaPagamento;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Urbem\CoreBundle\Entity\Folhapagamento\Evento;
use Urbem\CoreBundle\Entity\Folhapagamento\EventoEvento;
use Urbem\CoreBundle\Entity\Folhapagamento\SequenciaCalculo;
use Urbem\CoreBundle\Model\Folhapagamento\EventoModel;

class EventoAdminController extends Controller
{
    public function consultarDescricaoSequenciaCalculoAction(Request $request)
    {
        $codSequencia = $request->request->get('codSequencia');

        $sequenciaCalculo = $this->admin->getModelManager()->find(SequenciaCalculo::class, $codSequencia);

        $return = false;

        if ($sequenciaCalculo) {
            $return = [
                'descricao' => $sequenciaCalculo->getDescricao(),
                'complemento' => $sequenciaCalculo->getComplemento()
            ];
        }

        return new JsonResponse($return);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function carregaTextoComplementarAction(Request $request)
    {
        $codEvento = $request->request->get('codEvento');
        $observacao = '';
        /** @var EntityManager $entityManager */
        $entityManager = $this->getDoctrine()->getManager();
        /** @var EventoModel $eventoModel */
        $eventoModel = new EventoModel($entityManager);
        $rsEvento = $eventoModel->listarEvento($codEvento);
        $evento = '';
        if (is_array($rsEvento) && (!empty($rsEvento))) {
            foreach ($rsEvento as $eventos) {
                $evento = $eventos;
            }
        }
        $observacao = (isset($evento['observacao'])) ? $evento['observacao'] : '';
        $limiteCalculo = (isset($evento['limite_calculo'])) ? $evento['limite_calculo'] : 'false';
        $apresentaParcela = (isset($evento['apresenta_parcela'])) ? $evento['apresenta_parcela'] : 'false';
        $fixado = $evento['fixado'];
        $eventoSistema = $evento['evento_sistema'];
        $valorQuantidade = ($evento['valor_quantidade']) ? $evento['valor_quantidade'] : 0.00;

        $return = [
            'observacao' => $observacao,
            'fixado' => $fixado,
            'apresentaParcela' => $apresentaParcela,
            'eventoSistema' => $eventoSistema,
            'valorQuantidade' => $valorQuantidade,
            'limiteCalculo' => $limiteCalculo
        ];

        return new JsonResponse($return);
    }

    public function carregaConfiguracaoContratoManutencaoAction(Request $request)
    {
        $codEvento = $request->request->get('codEvento');
        $codSubDivisao = $request->request->get('codSubDivisao');
        $codEspecialidade = $request->request->get('codEspecialidade');

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var Evento $evento */
        $evento = $em->getRepository(Evento::class)->find($codEvento);

        $result = (new EventoModel($em))->carregaConfiguracaoContratoManutencao(
            $evento->getCodigo(),
            $codSubDivisao,
            $codEspecialidade
        );

        return new JsonResponse($result);
    }
}
