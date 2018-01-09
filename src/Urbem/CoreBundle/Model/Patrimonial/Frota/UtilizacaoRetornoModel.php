<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Frota;

use Doctrine\ORM;
use Symfony\Component\Form\Form;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Frota;

class UtilizacaoRetornoModel extends AbstractModel
{

    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Frota\UtilizacaoRetorno::class);
    }

    /**
     * @param Frota\UtilizacaoRetorno $utilizacaoRetorno
     * @param array $utilizacao['codVeiculo', 'dtSaida', 'hrSaida']
     * @param Form $form
     * @return Frota\UtilizacaoRetorno
     */
    public function populateUtilizacaoData(Frota\UtilizacaoRetorno $utilizacaoRetorno, $utilizacao, $form)
    {
        $utilizacaoModel = new UtilizacaoModel($this->entityManager);
        $utilizacao = $utilizacaoModel->getUtilizacao($utilizacao);

        $utilizacaoRetorno->setFkFrotaUtilizacao($utilizacao);

        $utilizacaoRetorno->setFkFrotaMotorista($form->get('cgmMotorista')->getData());

        return $utilizacaoRetorno;
    }
}
