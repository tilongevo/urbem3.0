<?php
/**
 * Created by PhpStorm.
 * User: gabrielvie
 * Date: 11/08/16
 * Time: 09:31
 */

namespace Urbem\PatrimonialBundle\Controller\Licitacao;

use Symfony\Component\HttpFoundation\Request;

use Urbem\CoreBundle\Controller as ControllerCore;
use Urbem\CoreBundle\Entity\Licitacao\Edital;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Entity;

class EditalController extends ControllerCore\BaseController
{

    public function anularAction(Request $request)
    {
        $this->setBreadCrumb();

        return $this->redirectToRoute(
            'urbem_patrimonial_licitacao_edital_anulado_create',
            [
                'id' => $request->query->get('id')
            ]
        );
    }

    public function perfilAction(Request $request)
    {

        $this->setBreadCrumb();

        $id = $request->query->get('id');

        list($numEdital,$exercicio) = explode("~", $id);

        $em = $this->getDoctrine()->getManager();

        /** @var Edital $edital */
        $edital = $this->getDoctrine()
            ->getRepository('CoreBundle:Licitacao\Edital')
            ->findOneBy([
                'exercicio' => $exercicio,
                'numEdital' => $numEdital,
            ]);

        /** @var Entity\Licitacao\PublicacaoEdital $publicacaoEdital */
        $publicacaoEdital = $edital->getFkLicitacaoPublicacaoEditais();

        $filtros = [
            'exercicio' => $edital->getExercicioLicitacao(),
            'cod_entidade' => $edital->getCodEntidade(),
            'cod_modalidade' => $edital->getCodModalidade(),
            'cod_licitacao' => $edital->getCodLicitacao()
        ];

        $editalModel = new Model\Patrimonial\Licitacao\EditalModel($em);
        $participantes = $editalModel->getParticipantesByLicitacao($filtros);

        /** @var Entity\Licitacao\EditalImpugnado $impugnacaoEdital */
        $impugnacaoEdital = $edital->getFkLicitacaoEditalImpugnados();

        $filtro = [
            'exercicio' => $edital->getExercicio(),
            'num_edital' => $edital->getNumEdital()
        ];

        /** @var boolean $passivelImpugnacao */
        $passivelImpugnacao = (count($editalModel->getEditalPassivelImpugnacao($filtro))> 0) ? true : false ;

        /** @var boolean $passivelAnulacaoImpugnacao */
        $passivelAnulacaoImpugnacao = (count($editalModel->getEditalPassivelAnulacaoImpugnacao($filtro))> 0) ? true : false ;

        /** @var Entity\Licitacao\EditalAnulado $anulacao */
        $anulacao = $edital->getFkLicitacaoEditalAnulado();

        /** @var Entity\Licitacao\EditalSuspenso $suspensaoEdital */
        $suspensaoEdital = $edital->getFkLicitacaoEditalSuspenso();

        /** @var boolean $passivelSuspensao */
        $passivelSuspensao = (count($suspensaoEdital) > 0) ? true : false ;

        return $this->render('PatrimonialBundle::Licitacao/Edital/perfil.html.twig', [
            'edital' => $edital,
            'participantes' => $participantes,
            'publicacoes' => $publicacaoEdital,
            'impugnados' => $impugnacaoEdital,
            'passivelImpugnacao' => $passivelImpugnacao,
            'passivelAnulacaoImpugnacao' => $passivelAnulacaoImpugnacao,
            'anulacao' => $anulacao,
            'passivelSuspensao' => $passivelSuspensao,
        ]);
    }
}
