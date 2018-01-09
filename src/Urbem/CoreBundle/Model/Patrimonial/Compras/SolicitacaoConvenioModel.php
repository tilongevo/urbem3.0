<?php
namespace Urbem\CoreBundle\Model\Patrimonial\Compras;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Compras\Solicitacao;
use Urbem\CoreBundle\Entity\Compras\SolicitacaoConvenio;
use Urbem\CoreBundle\Entity\Licitacao\Convenio;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\AbstractModel;

class SolicitacaoConvenioModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Compras\\SolicitacaoConvenio");
    }

    /**
     * @param Solicitacao $solicitacao
     * @param Convenio $convenio
     * @return SolicitacaoConvenio
     */
    public function findOrCreateSolicitacaoConvenio(Solicitacao $solicitacao, Convenio $convenio)
    {
        /** @var SolicitacaoConvenio $solicitacaoConvenio */
        $solicitacaoConvenio = $this->repository->findOneBy([
            'fkComprasSolicitacao' => $solicitacao
        ]);

        if(!is_null($solicitacaoConvenio) && $solicitacaoConvenio->getNumConvenio() != $convenio->getNumConvenio()){
            $solicitacaoConvenio->setFkLicitacaoConvenio($convenio);
            $this->save($solicitacaoConvenio);
        }

        if (true == is_null($solicitacaoConvenio)) {
            $solicitacaoConvenio = new SolicitacaoConvenio();
            $solicitacaoConvenio->setFkComprasSolicitacao($solicitacao);
            $solicitacaoConvenio->setFkLicitacaoConvenio($convenio);

            $this->save($solicitacaoConvenio);
        }

        return $solicitacaoConvenio;
    }
}
