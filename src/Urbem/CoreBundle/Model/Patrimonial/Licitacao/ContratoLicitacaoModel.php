<?php
namespace Urbem\CoreBundle\Model\Patrimonial\Licitacao;

use Doctrine\ORM;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Licitacao\Contrato;
use Urbem\CoreBundle\Entity\Licitacao\ContratoLicitacao;
use Urbem\CoreBundle\Entity\Licitacao\Licitacao;
use Urbem\CoreBundle\Repository\Patrimonio\Licitacao\LicitacaoRepository;

/**
 * Class LicitacaoModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Licitacao
 */
class ContratoLicitacaoModel extends AbstractModel
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
        $this->repository = $this->entityManager->getRepository("CoreBundle:Licitacao\\ContratoLicitacao");
    }

    /**
     * @param Contrato $contrato
     * @param Licitacao $licitacao
     */
    public function saveContratoLicitacao(Contrato $contrato, Licitacao $licitacao)
    {
        $contratoLicitacao = new ContratoLicitacao();
        $contratoLicitacao->setFkLicitacaoContrato($contrato);
        $contratoLicitacao->setFkLicitacaoLicitacao($licitacao);
        $this->save($contratoLicitacao);
    }
}
