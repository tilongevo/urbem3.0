<?php
namespace Urbem\RecursosHumanosBundle\Controller\Pessoal;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Pessoal\Ferias;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Model\Pessoal\FeriasModel;

class ConcederFeriasAdminController extends Controller
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

            $entityManager->getConnection()->beginTransaction();

            try {
                $formData = $request->request->get($request->query->get('uniqid'));

                (new FeriasModel($entityManager))->concederFerias($formData);

                $entityManager->getConnection()->commit();

                $periodoMovimentacao = new PeriodoMovimentacaoModel($entityManager);
                $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
                $periodoUnico = reset($periodoUnico);

                $entityManager->getRepository(Ferias::class)->geraRegistroFerias(
                    $formData['codContrato'],
                    $periodoUnico->cod_periodo_movimentacao,
                    $this->admin->getExercicio()
                );

                $this->addFlash('sonata_flash_success', 'flash_edit_success');
            } catch (\Exception $e) {
                $entityManager->getConnection()->rollback();
                $this->addFlash('sonata_flash_error', 'flash_edit_error');
            }
            return $this->redirectToRoute('urbem_recursos_humanos_pessoal_ferias_conceder_list');
        }
    }

    public function preencherQuantDiasGozoAction(Request $request)
    {
        $entityManager = $this
        ->get('doctrine')
        ->getManager();
    }
}
