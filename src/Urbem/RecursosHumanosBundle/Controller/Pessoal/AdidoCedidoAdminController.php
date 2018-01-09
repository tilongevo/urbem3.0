<?php
namespace Urbem\RecursosHumanosBundle\Controller\Pessoal;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Urbem\CoreBundle\Entity\Pessoal\AdidoCedido;
use Urbem\CoreBundle\Entity\Pessoal\AdidoCedidoExcluido;

class AdidoCedidoAdminController extends Controller
{
    /**
     * @inheritdoc
     */
    protected function preDelete(Request $request, $object)
    {
        if ($request->getMethod() === "DELETE") {
            $entityManager = $this
                ->get('doctrine')
                ->getManager();

            try {
                $adidoCedidoExcluido = new AdidoCedidoExcluido();
                $adidoCedidoExcluido->setFkPessoalAdidoCedido($object);

                $entityManager->persist($adidoCedidoExcluido);
                $entityManager->flush();
                $this->addFlash('sonata_flash_success', 'flash_edit_success');
            } catch (\Exception $e) {
                $this->addFlash('sonata_flash_error', 'flash_edit_error');
            }
            return $this->redirectToRoute('urbem_recursos_humanos_pessoal_adidos_cedidos_list');
        }
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function consultarAdidoCedidoAction(Request $request)
    {
        $mensagem = '';
        $codContrato = $request->request->get('codContrato');
        /** @var AdidoCedido $adidoCedido */
        $adidoCedido = $this->admin->getModelManager()->findOneBy(
            AdidoCedido::class,
            [
                'codContrato' => $codContrato
            ]
        );

        if (is_object($adidoCedido)) {
            if (($adidoCedido->getTipoCedencia() == "c") && ($adidoCedido->getIndicativoOnus() == "c")
                || (($adidoCedido->getTipoCedencia() == "c") && ($adidoCedido->getTipoCedencia() == "e"))
            ) {
                $mensagem = "Para tipo de cedência adido/cedido e indicativo de ônus cedente/cessionário não é permitido registro de eventos.";
            }
        }

        $return = [
            'mensagem' => $mensagem,
        ];

        return new JsonResponse($return);
    }
}
