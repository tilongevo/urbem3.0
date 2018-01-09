<?php
namespace Urbem\CoreBundle\Model\Patrimonial\Licitacao;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Compras\CompraDireta;
use Urbem\CoreBundle\Entity\Licitacao\Contrato;
use Urbem\CoreBundle\Entity\Licitacao\ContratoCompraDireta;

/**
 * Class LicitacaoModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Licitacao
 */
class ContratoCompraDiretaModel extends AbstractModel
{
    protected $entityManager = null;

    protected $repository = null;

    /**
     * LicitacaoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Licitacao\\ContratoCompraDireta");
    }

    /**
     * @param Contrato $contrato
     * @param CompraDireta $compraDireta
     */
    public function saveContratoCompraDireta(Contrato $contrato, CompraDireta $compraDireta)
    {
        $contratoCompraDireta = new ContratoCompraDireta();
        $contratoCompraDireta->setFkLicitacaoContrato($contrato);
        $contratoCompraDireta->setFkComprasCompraDireta($compraDireta);
        $this->save($contratoCompraDireta);
    }
}
