<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity;

class FolhaPagamentoModel
{
    public function getAllTipoEventoSalarioFamilia(ORM\EntityManager $entityManager)
    {
        $tipoEventoRepository = $entityManager->getRepository("CoreBundle:Folhapagamento\\TipoEventoSalarioFamilia");

        return $tipoEventoRepository->findBy([], ["codTipo" => "ASC"]);
    }
}
