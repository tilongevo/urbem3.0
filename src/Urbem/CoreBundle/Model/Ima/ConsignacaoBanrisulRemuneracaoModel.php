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

class ConsignacaoBanrisulRemuneracaoModel extends AbstractModel
{
    protected $entityManager = null;
    /** @var Repository\RecursosHumanos\Ima\ConsignacaoBanrisulRemuneracaoRepository|null  */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Ima\ConsignacaoBanrisulRemuneracao::class);
    }

    public function removeConsignacaoBanrisulRemuneracao()
    {
        $this->repository->removeConsignacaoBanrisulRemuneracao();
    }

    /**
     * @param Evento $evento
     * @return Ima\ConsignacaoBanrisulRemuneracao
     */
    public function createConsignacaoBanrisulRemuneracao(Evento $evento)
    {
        $consignacaoBanrisulRemuneracao = new Ima\ConsignacaoBanrisulRemuneracao();
        $consignacaoBanrisulRemuneracao->setFkFolhapagamentoEvento($evento);

        $this->save($consignacaoBanrisulRemuneracao);

        return $consignacaoBanrisulRemuneracao;
    }
}
