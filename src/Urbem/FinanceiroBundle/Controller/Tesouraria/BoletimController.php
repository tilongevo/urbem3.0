<?php

namespace Urbem\FinanceiroBundle\Controller\Tesouraria;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Model\Tesouraria\Boletim\BoletimModel;

/**
 * Class BoletimController
 * @package Urbem\FinanceiroBundle\Controller\Tesouraria
 */
class BoletimController extends BaseController
{
    const VIEW_PATH = "FinanceiroBundle::Tesouraria/Boletim/";

    public function profileAction(Request $request)
    {
        list($model, $boletim, $attributes) = $this->getBoletimAndModel($request->attributes->all());
        $this->setBreadCrumb($attributes);

        $forms = $this->generateForm($boletim);
        foreach ($forms as $key => $form) {
            $forms[$key] = $form->handleRequest($request)->createView();
        }

        return $this->render(
            self::VIEW_PATH . 'profile.html.twig',
            [
                'boletim' => $boletim,
                'forms' => $forms
            ]
        );
    }

    /**
     * Apartir do status, retorna os botões
     * @param $boletim
     * @return array
     */
    private function generateForm($boletim)
    {
        $em = $this->getDoctrine()->getManager();

        $boletimModel = new BoletimModel($em);

        $status = $boletimModel->getRepository()->verificarStatusBoletim([$boletim->getCodBoletim(), $boletim->getExercicio(), $boletim->getCodEntidade()]);
        $statusSePodeSerLiberado = $boletimModel->getRepository()->verificarBoletimPodeSerLiberadoStatus([$boletim->getCodBoletim(), $boletim->getExercicio(), $boletim->getCodEntidade()]);

        $forms = [];
        //Situação 1 Se o boletim não estiver fechado ou esta como "reaberto"
        if ($status['situacao'] == "aberto" || $status['situacao'] == "reaberto") {
            $forms['formFechar'] = $this->createForms($boletim, 'tesouraria_boletim_fechar_boletim', 'Fechar', 'fechar', 'close-btn');
        } elseif ($status["situacao"] == "fechado") {
            //Situação 2 Se o boletim estiver fechado
            $forms['formReabrir'] = $this->createForms($boletim, 'tesouraria_boletim_reabrir_boletim', 'Reabrir', 'reabrir', 're-open-btn');
        } else {
            //Não esta habilitado a ser liberado
            if (empty($statusSePodeSerLiberado)) {
                $forms['formCancelarLiberacao'] = $this->createForms($boletim, 'tesouraria_boletim_cancelar_liberacao_boletim', 'Cancelar liberação', 'cancelar', 'cancel-btn');
            }
        }
        //Esta habilitado a ser Liberado
        if (!empty($statusSePodeSerLiberado)) {
            $forms['formLiberar'] = $this->createForms($boletim, 'tesouraria_boletim_liberar_boletim', 'Liberar', 'liberar', 'free-btn');
            ;
        }
        return $forms;
    }

    /**
     * Monta os forms para os Botões
     * @param $boletim
     * @param $url
     * @param $label
     * @return mixed
     */
    protected function createForms($boletim, $url, $label, $nameButton, $icon = null)
    {
        return  $this->createFormBuilder([])
                ->add('codBoletim', HiddenType::class, ['data' => $boletim->getCodBoletim()])
                ->add('codEntidade', HiddenType::class, ['data' => $boletim->getCodEntidade()])
                ->add('exercicio', HiddenType::class, ['data' => $boletim->getExercicio()])
                ->add('submit_' . $nameButton, SubmitType::class, ['label'=>$label, 'attr' => ['class' => 'white-text blue darken-4 btn btn-success save ' . $icon]])
                ->setAction($this->generateUrl($url))
                ->getForm();
    }

    public function fecharBoletimAction(Request $request)
    {
        list($model, $boletim, $attributes) = $this->getBoletimAndModel($request->request->get('form'));
        $container = $this->container;

        $boletimFechar = $model->dadosFecharBoletim($boletim);

        try {
            $model->save($boletimFechar);
            $container->get('session')->getFlashBag()->add('success', 'Boletim fechado com sucesso!');
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', 'Não foi possivel liberar o boletim!');
        }

        return $this->redirectToRoute('tesouraria_boletim_profile', $attributes);
    }

    public function reabrirBoletimAction(Request $request)
    {
        list($model, $boletim, $attributes) = $this->getBoletimAndModel($request->request->get('form'));
        $container = $this->container;

        try {
            $boletimReaberto = $model->dadosReabrirBoletim($boletim);
            $model->save($boletimReaberto);
            $container->get('session')->getFlashBag()->add('success', 'Boletim reaberto com sucesso!');
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', 'Erro ao reabrir um boletim.');
        }

        return $this->redirectToRoute('tesouraria_boletim_profile', $attributes);
    }

    public function liberarBoletimAction(Request $request)
    {
        list($model, $boletim, $attributes) = $this->getBoletimAndModel($request->request->get('form'));
        $container = $this->container;

        try {
            $statusSeLiberado = $model->getRepository()->verificarBoletimPodeSerLiberadoStatus([$boletim->getCodBoletim(), $boletim->getExercicio(), $boletim->getCodEntidade()]);
        } catch (\Exception $e) {
            throw $this->createNotFoundException($e->getMessage());
        }

        if (!empty($statusSeLiberado)) {
            $loteSemRetencao = [];
            $loteComRetencao = [];
            try {
                $listaArrecadacaoSemRetencao = $model->listarArrecadacao(false, $boletim);
                $loteSemRetencao[] = $model->lancarArrecadacao($listaArrecadacaoSemRetencao, false);
                $loteSemRetencao[] = $model->lancarArrecadacao($listaArrecadacaoSemRetencao, true);
                try {
                    $listaArrecadacaoComRetencao = $model->listarArrecadacao(true);
                    $loteComRetencao[] = $model->lancarArrecadacao($listaArrecadacaoComRetencao, false);
                    $loteComRetencao[] = $model->lancarArrecadacao($listaArrecadacaoComRetencao, true);
                } catch (\Exception $e) {
                    throw new \Exception($e);
                }
            } catch (\Exception $e) {
            }


            $boletimLiberado = $model->dadosliberarBoletim($boletim);
            $this->populaBoletimLiberadoComLote($loteSemRetencao, $model, $boletimLiberado);
            $this->populaBoletimLiberadoComLote($loteComRetencao, $model, $boletimLiberado);


            try {
                $model->save($boletimLiberado);
                $container->get('session')->getFlashBag()->add('success', 'Boletim liberado com sucesso!');
            } catch (\Exception $e) {
                $container->get('session')->getFlashBag()->add('error', 'Não foi possivel liberar o boletim!');
            }
        } else {
            $container->get('session')->getFlashBag()->add('error', 'Esse Boletim não pode ser liberado, verifique se ele já foi fechado!');
        }

         return $this->redirectToRoute('tesouraria_boletim_profile', $attributes);
    }

    /**
     * Verifica se $arrayLote tem lote, se sim vai add BoletimLiberado com BoletimLiberadoLote para cada lote retornado
     * @param $arrayLote
     * @param $model
     * @param $boletimLiberado
     */
    protected function populaBoletimLiberadoComLote($arrayLote, $model, $boletimLiberado)
    {
        if (!empty($arrayLote)) {
            foreach ($arrayLote as $lote) {
                $model->dadosliberarLoteBoletim($boletimLiberado, $lote);
            }
        }
    }

    /**
     * @param $attributes
     * @return array
     */
    protected function getBoletimAndModel($attributes)
    {
        $arrayKeys = ['codBoletim' => null, 'codEntidade' => null, 'exercicio' => null];
        //Remove todos que forem diferente das "keys" que estão dentro de $arrayKeys
        foreach (array_diff_key($attributes, $arrayKeys) as $key => $item) {
            unset($attributes[$key]);
        }

        $em = $this->getDoctrine()->getManager();
        $model = new BoletimModel($em);

        /**
         * Dados necessarios para buscar o Boletim
         * codBoletim"
         * codEntidade"
         * exercicio"
         */
        $boletim = $model->findOneBy($attributes);
        return array($model, $boletim, $attributes);
    }


    public function cancelarLiberacaoBoletimAction(Request $request)
    {
        list($model, $boletim, $attributes) = $this->getBoletimAndModel($request->request->get('form'));
        $container = $this->container;

        try {
            $model->cancelarLiberacaoBoletim($boletim->getfkTesourariaBoletimFechados());
            $container->get('session')->getFlashBag()->add('success', 'Boletim Cancelado com sucesso!');
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', 'Não foi possivel cancelar o boletim!');
        }

        return $this->redirectToRoute('tesouraria_boletim_profile', $attributes);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function buscaBoletimAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getEntityManager();

        $codEntidade = $request->get('cod_entidade');

        $boletimModel = new BoletimModel($entityManager);

        $params = [
            sprintf("exercicio = '%s'", $this->getExercicio()),
            sprintf("cod_entidade IN (%s)", $codEntidade),
        ];
        $boletins = $boletimModel->getBoletins($params);

        $jsonResponse = [];

        if (!is_null($boletins)) {
            foreach ($boletins as $boletim) {
                $codigo = $boletim->cod_boletim;
                $data = $boletim->dt_boletim;

                $jsonResponse[] = [
                    'value' => $boletim->cod_boletim,
                    'label' => sprintf('%d - %s', $codigo, $data)
                ];
            }
        }

        $boletins = json_encode($jsonResponse);

        $response = new Response();
        $response->setContent($boletins);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
