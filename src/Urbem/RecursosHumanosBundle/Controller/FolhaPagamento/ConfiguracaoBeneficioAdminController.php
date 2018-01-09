<?php

namespace Urbem\RecursosHumanosBundle\Controller\FolhaPagamento;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Folhapagamento\Evento;
use Urbem\CoreBundle\Model\Folhapagamento\ConfiguracaoBeneficioModel;

class ConfiguracaoBeneficioAdminController extends Controller
{
    /**
     * {@inheritdoc}
     */
    protected function preEdit(Request $request, $object)
    {
        if ($request->getMethod() === "POST") {
            $entityManager = $this
            ->get('doctrine')
            ->getManager();

            $formData = $request->request->get($request->query->get('uniqid'));

            $count = [];
            foreach ($formData['fkFolhapagamentoBeneficioEventos'] as $eventos) {
                if (isset($eventos['fkFolhapagamentoEvento']) && ! isset($eventos['_delete'])) {
                    array_push($count, $eventos['fkFolhapagamentoEvento']);
                }
            }
            
            $flag = 0;
            if (count(array_unique($count)) < count($count)) {
                $flag = 1;
            }

            if ($flag == 1) {
                $this->addFlash('sonata_flash_error', $this->trans('label.configuracaoBeneficio.error.codEvento'));
                return $this->redirectToRoute(
                    'urbem_recursos_humanos_folha_pagamento_configuracao_configuracao_beneficio_edit',
                    [
                        'id' => $request->get($this->admin->getIdParameter())
                    ]
                );
            }

            try {
                $pensaoFuncaoPadraoModel = new ConfiguracaoBeneficioModel($entityManager);
                $pensaoFuncaoPadraoModel->persistConfiguracaoBeneficio($formData, $object, $this->admin->getModelManager());
                $this->addFlash('sonata_flash_success', 'flash_edit_success');
            } catch (\Exception $e) {
                $this->addFlash('sonata_flash_error', 'flash_edit_error');
            }
            return $this->redirectToRoute('urbem_recursos_humanos_folha_pagamento_configuracao_configuracao_beneficio_list');
        }
    }

    /**
     * Retorna o valor para o campo Texto Complementar
     * @param Request $request
     * @return JsonResponse
     */
    public function getTextoComplementarAction(Request $request)
    {
        $codEvento =  $request->request->get('codEvento');

        $evento = $this->admin->getModelManager()->find(Evento::class, $codEvento);

        return new JsonResponse($evento->getFkFolhapagamentoEventoEventos()->last()->getObservacao());
    }
}
