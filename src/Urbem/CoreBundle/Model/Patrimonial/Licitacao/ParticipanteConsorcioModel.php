<?php
/**
 * Created by PhpStorm.
 * User: gabrielvie
 * Date: 05/09/16
 * Time: 15:33
 */

namespace Urbem\CoreBundle\Model\Patrimonial\Licitacao;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Licitacao;

class ParticipanteConsorcioModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Licitacao\ParticipanteConsorcio::class);
    }

    public function insertParticipanteConsorcio(Licitacao\Participante $participante)
    {
        $participanteConsorcio = new Licitacao\ParticipanteConsorcio();
        $participanteConsorcio->setFkLicitacaoParticipante($participante);
        $participanteConsorcio->setFkSwCgm($participante->getFkSwCgm());

        $this->entityManager->persist($participanteConsorcio);
    }
}
