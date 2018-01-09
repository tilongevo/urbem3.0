<?php
/**
 * Created by PhpStorm.
 * User: gabrielvie
 * Date: 07/10/16
 * Time: 10:36
 */

namespace Urbem\PatrimonialBundle\Controller\Licitacao;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Controller as ControllerCore;
use Urbem\CoreBundle\Entity\Licitacao;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\EditalModel;

class AtaController extends ControllerCore\BaseController
{
    public function sugestaoInformacoesAction(Request $request)
    {
        $keyEdital = explode('~', $request->query->get('edital'));
        $data = $request->query->get('data');
        $hora = $request->query->get('hora');

        $entityManager = $this->getDoctrine()->getManager();

        $editalModel = new EditalModel($entityManager);

        $edital = $entityManager
            ->getRepository(Licitacao\Edital::class)
            ->find([
                'numEdital' => $keyEdital[0],
                'exercicio' => $keyEdital[1]
            ]);

        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');

        $params = [
            '#data_extenso' => ucfirst(strftime('%A, %d de %B de %Y', strtotime($data))),
            '#horario' => strftime('%H:%M', strtotime($hora))
        ];

        $sugestao = $editalModel->getSugestaoDescricaoParaAta($edital, $params, $this->getExercicio());

        $responseContent['sugestao'] = $sugestao;

        $response = new Response();
        $response->setContent(json_encode($responseContent));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
