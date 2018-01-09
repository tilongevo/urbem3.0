<?php

namespace Urbem\RedeSimplesBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Urbem\CoreBundle\Entity\RedeSimples\Protocolo;

class ProtocoloController extends CRUDController
{
    /**
     * @param Protocolo $protocolo
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function enviarAction(Protocolo $protocolo)
    {
        if (!empty($protocolo->getProtocolo())) {
            $this->addFlash('sonata_flash_error', $this->trans('rede_simples.enviar.error_existe'));
            return $this->redirectToRoute('rede_simples_protocolo_show', ['id' => $protocolo->getId()]);
        }

        try {
            $this->get('rede_simples.form_send_transaction')->transact($protocolo);

            $this->addFlash(
                'sonata_flash_success',
                $this->trans(
                    'rede_simples.enviar.sucesso',
                    ['%protocolo%' => $protocolo->getProtocolo()]
                )
            );
        } catch (\Exception $e) {
            $this->getLogger()->emergency(sprintf('%s:%s (%s)', $e->getFile(), $e->getLine(), $e->getMessage()));

            $this->addFlash('sonata_flash_error', $this->trans('rede_simples.enviar.erro'));
        }

        return $this->redirectToRoute('rede_simples_protocolo_show', ['id' => $protocolo->getId()]);
    }

    /**
     * @param Protocolo $protocolo
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function consultarAction(Protocolo $protocolo)
    {
        try {
            $this->get('rede_simples.form_status_transaction')->transact($protocolo);

            $this->addFlash(
                'sonata_flash_success',
                $this->trans(
                    'rede_simples.consultar_sucesso',
                    [
                        '%protocolo%' => $protocolo->getProtocolo(),
                        '%mensagem%' => $protocolo->getRetorno()
                    ]
                )
            );
        } catch (\Exception $e) {
            $this->getLogger()->emergency(sprintf('%s:%s (%s)', $e->getFile(), $e->getLine(), $e->getMessage()));

            $this->addFlash('sonata_flash_error', $this->trans('rede_simples.consultar_erro'));
        }

        return $this->redirectToRoute('rede_simples_protocolo_show', ['id' => $protocolo->getId()]);
    }
}
