<?php

namespace Urbem\PatrimonialBundle\Controller\Patrimonio;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Patrimonio\Manutencao;

class ManutencaoController extends BaseController
{
    public function homeAction(Request $request)
    {
        $this->setBreadCrumb();
        return $this->render('PatrimonialBundle::Patrimonial/Manutencao/home.html.twig');
    }

    public function pagaAction(Request $request)
    {
        $id = $request->attributes->get('id');
        list($codBem, $dtAgendamento) = explode("~", $id);

        /** @var Manutencao $manutencao */
        $manutencao = $this->db->getRepository(Manutencao::class)->findOneBy([
            'codBem' => $codBem,
            'dtAgendamento' => $dtAgendamento
        ]);

        $response = [
            'dtAgendamento' => $manutencao
                ->getDtAgendamento()
                ->format('d/m/Y'),
            'observacao' => $manutencao
                ->getObservacao(),
            'codNatureza' => $manutencao
                ->getFkPatrimonioBem()
                ->getFkPatrimonioEspecie()
                ->getFkPatrimonioGrupo()
                ->getFkPatrimonioNatureza()
                ->__toString(),
            'codGrupo' => $manutencao
                ->getFkPatrimonioBem()
                ->getFkPatrimonioEspecie()
                ->getFkPatrimonioGrupo()
                ->__toString(),
            'codEspecie' => $manutencao
                ->getFkPatrimonioBem()
                ->getFkPatrimonioEspecie()
                ->__toString(),
            'codBem' => $manutencao
                ->getFkPatrimonioBem()
                ->getCodBem(),
            'numPlaca' => $manutencao
                ->getFkPatrimonioBem()
                ->getNumPlaca(),
            'descricao' => $manutencao
                ->getFkPatrimonioBem()
                ->getDescricao(),
            'cgm' => $manutencao
                ->getFkSwCgm()
                ->__toString(),
        ];

         return new JsonResponse($response);
    }
}
