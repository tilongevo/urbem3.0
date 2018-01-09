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
use Urbem\CoreBundle\Entity\SwCgm;

/**
 * Class ParticipanteConvenioModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Licitacao
 */
class ParticipanteConvenioModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * ParticipanteConvenioModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Licitacao\ParticipanteConvenio::class);
    }

    /**
     * @param $cgm
     * @param Licitacao\ParticipanteConvenio $participanteConvenio
     * @return Licitacao\ParticipanteConvenio
     */
    public function setCertificacao($cgm, Licitacao\ParticipanteConvenio $participanteConvenio)
    {
        $participanteCertificacao = $this->entityManager
            ->getRepository(Licitacao\ParticipanteCertificacao::class)
            ->findOneBy(['cgmFornecedor' => $cgm]);

        $participanteConvenio->setFkLicitacaoParticipanteCertificacao($participanteCertificacao);

        return $participanteConvenio;
    }
}
