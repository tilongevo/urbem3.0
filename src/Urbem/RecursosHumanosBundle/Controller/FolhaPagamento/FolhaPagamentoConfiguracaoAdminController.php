<?php

namespace Urbem\RecursosHumanosBundle\Controller\FolhaPagamento;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Entity\Administracao\Configuracao;
use Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento\FolhaPagamentoConfiguracaoAdmin;

class FolhaPagamentoConfiguracaoAdminController extends CRUDController
{
    /**
     * {@inheritdoc}
     */
    protected function preCreate(Request $request, $object)
    {
        if ($request->getMethod() === "POST") {
            $entityManager = $this
            ->get('doctrine')
            ->getManager();

            $configuracaoModel = new ConfiguracaoModel($entityManager);

            $formData = $request->request->get($request->query->get('uniqid'));

            try {
                foreach ($formData as $field => $value) {
                    if (array_key_exists($field, FolhaPagamentoConfiguracaoAdmin::PARAMETROS)) {
                        $id = $this->admin->getExercicio()
                        . "~"
                        . ConfiguracaoModel::MODULO_RH_FOLHAPAGAMENTO
                        . "~"
                        . FolhaPagamentoConfiguracaoAdmin::PARAMETROS[$field];


                        $configuracao = $this->admin->getModelManager()->find(
                            Configuracao::class,
                            $id
                        );

                        $configuracaoModel->persistConfiguracao(
                            $this->admin->getExercicio(),
                            ConfiguracaoModel::MODULO_RH_FOLHAPAGAMENTO,
                            FolhaPagamentoConfiguracaoAdmin::PARAMETROS[$field],
                            $value,
                            $configuracao
                        );
                    }
                }
                $this->addFlash('sonata_flash_success', 'flash_edit_success');
            } catch (\Exception $e) {
                $this->addFlash('sonata_flash_error', 'flash_edit_error');
            }
            return $this->redirectToRoute('urbem_recursos_humanos_folha_pagamento_configuracao_create');
        }
    }
}
