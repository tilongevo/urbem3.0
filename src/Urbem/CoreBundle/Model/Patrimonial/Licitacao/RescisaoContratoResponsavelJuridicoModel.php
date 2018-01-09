<?php
namespace Urbem\CoreBundle\Model\Patrimonial\Licitacao;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Licitacao\Adjudicacao;
use Urbem\CoreBundle\Entity\Licitacao\RescisaoContrato;
use Urbem\CoreBundle\Entity\Licitacao\RescisaoContratoResponsavelJuridico;
use Urbem\CoreBundle\Entity\SwCgm;

class RescisaoContratoResponsavelJuridicoModel extends AbstractModel
{
    /**
     * @var ORM\EntityManager
     *
     */
    protected $entityManager;
    /**
     * @var ORM\EntityRepository
     *
     */
    protected $repository;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Licitacao\\RescisaoContratoResponsavelJuridico");
    }

    /**
     * @param RescisaoContrato $rescisaoContrato
     * @param SwCgm $swCgm
     * @return RescisaoContratoResponsavelJuridico
     */
    public function buildRescisaoContratoResponsavelJuridico(RescisaoContrato $rescisaoContrato, SwCgm $swCgm)
    {
        $rescisaoContratoResponsavelJuridico = new RescisaoContratoResponsavelJuridico();
        $rescisaoContratoResponsavelJuridico->setFkSwCgm($swCgm);
        $rescisaoContratoResponsavelJuridico->setFkLicitacaoRescisaoContrato($rescisaoContrato);

        return $rescisaoContratoResponsavelJuridico;
    }
}
