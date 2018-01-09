<?php
namespace Urbem\CoreBundle\Model\Patrimonial\Compras;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Compras\Solicitacao;
use Urbem\CoreBundle\Entity\Compras\SolicitacaoConvenio;
use Urbem\CoreBundle\Entity\Compras\SolicitacaoEntrega;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\AbstractModel;

class SolicitacaoEntregaModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Compras\\SolicitacaoEntrega");
    }

    /**
     * @param Solicitacao $solicitacao
     * @param SwCgm $swcgm
     * @return SolicitacaoEntrega
     */
    public function findOrCreateSolicitacaoEntrega(Solicitacao $solicitacao, SwCgm $swcgm)
    {
        /** @var SolicitacaoEntrega $solicitacaoEntrega */
        $solicitacaoEntrega = $this->repository->findOneBy([
            'fkComprasSolicitacao' => $solicitacao,
        ]);

        if(!is_null($solicitacaoEntrega) && $solicitacaoEntrega->getNumcgm() != $swcgm->getNumcgm()) {
            $solicitacaoEntrega->setFkSwCgm($swcgm);
            $this->save($solicitacaoEntrega);
        }

        if (true == is_null($solicitacaoEntrega)) {
            $solicitacaoEntrega = new SolicitacaoEntrega();
            $solicitacaoEntrega->setFkComprasSolicitacao($solicitacao);
            $solicitacaoEntrega->setFkSwCgm($swcgm);

            $this->save($solicitacaoEntrega);
        }

        return $solicitacaoEntrega;
    }
}
