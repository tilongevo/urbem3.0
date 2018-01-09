<?php
namespace Urbem\RecursosHumanosBundle\Controller\Diarias;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Administracao\Configuracao;
use Urbem\CoreBundle\Entity\Diarias\Diaria;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\RecursosHumanosBundle\Helper\Constants\Diarias\Diaria as DiariaConstants;

/**
 * Class DiariaAdminController
 * @package Urbem\RecursosHumanosBundle\Controller\Diarias
 */
class DiariaAdminController extends Controller
{

    /**
     * @param Request $request
     */
    public function reciboAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $id = $request->get($this->admin->getIdParameter());

        $diaria = $this->admin->getModelManager()->find(Diaria::class, $id);

        $codEntidadePrefeitura = $entityManager->getRepository(Configuracao::class)
        ->findOneBy([
            'parametro' => 'cod_entidade_prefeitura',
            'exercicio' => $this->admin->getExercicio()
        ]);

        $entidade =  $this->admin->getModelManager()->find(
            Entidade::class,
            $this->admin->getExercicio() . "~" . $codEntidadePrefeitura->getValor()
        );

        $params = [
            'term_user' => $this->get('security.token_storage')->getToken()->getUser()->getUsername(),
            'entidade' => $codEntidadePrefeitura->getValor(),
            'inCodContrato' => (string) $diaria->getCodContrato(),
            'inCodDiaria' => (string) $diaria->getCodDiaria(),
            'stTimestamp' => $diaria->getTimestamp()->format('Y-m-d H:i:s.u'),
            'inCodMunicipio' => (string) $diaria->getFkSwMunicipio()->getCodMunicipio(),
            'stNomPrefeitura' => $entidade->getFkSwCgm()->getNomcgm(),
            'inCodEstado' => (string) $diaria->getFkSwMunicipio()->getFkSwUf()->getCodUf(),
            'exercicio' => $this->admin->getExercicio(),
            'inCodGestao' => DiariaConstants::INCODGESTAO,
            'inCodModulo' => DiariaConstants::INCODMODULO,
            'inCodRelatorio' => DiariaConstants::INCODRELATORIO,
            'cod_acao' => DiariaConstants::COD_ACAO,
        ];

        $content = $this->admin
            ->getReportService()
            ->setLayoutDefaultReport(DiariaConstants::LAYOUT_REPORT_PATH)
            ->getReportContent($params);

        $this->admin->parseContentToPdf($content->getBody()->getContents(), date("Ymd_His"));
    }
}
