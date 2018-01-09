<?php

namespace Urbem\CoreBundle\Model\Ima;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel as Model;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Folhapagamento\Evento;
use Urbem\CoreBundle\Entity\Ima;
use Urbem\CoreBundle\Entity\Ima\ConsignacaoBanrisulLiquido;
use Urbem\CoreBundle\Repository;
use Symfony\Component\Validator\Validator;

class ConsignacaoBanrisulLiquidoModel extends AbstractModel
{
    protected $entityManager = null;
    /** @var Repository\RecursosHumanos\Ima\ConsignacaoBanrisulLiquidoRepository|null  */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Ima\ConsignacaoBanrisulLiquido::class);
    }

    public function removeConsignacaoBanrisulLiquido()
    {
        $this->repository->removeConsignacaoBanrisulLiquido();
    }

    /**
     * @param Evento $evento
     * @return ConsignacaoBanrisulLiquido
     */
    public function createConsignacaoBanrisulLiquido(Evento $evento)
    {
        $consignacaoBanrisulLiquido = new ConsignacaoBanrisulLiquido();
        $consignacaoBanrisulLiquido->setFkFolhapagamentoEvento($evento);

        $this->save($consignacaoBanrisulLiquido);

        return $consignacaoBanrisulLiquido;
    }
}
