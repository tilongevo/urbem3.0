<?php

namespace Urbem\CoreBundle\Model\Empenho;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho;
use Urbem\CoreBundle\Entity\Empenho\CategoriaEmpenho;
use Urbem\CoreBundle\Entity\Empenho\ContrapartidaAutorizacao;
use Urbem\CoreBundle\Entity\Empenho\PreEmpenho;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\Orcamento\Unidade;
use Urbem\CoreBundle\Model;

/**
 * Class AutorizacaoEmpenhoModel
 * @package Urbem\CoreBundle\Model\Empenho
 */
class ContrapartidaAutorizacaoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * AutorizacaoEmpenhoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Empenho\ContrapartidaAutorizacao");
    }

    /**
     * @param AutorizacaoEmpenho $autorizacaoEmpenho
     * @return AutorizacaoEmpenho
     */
    public function saveContrapartidaAutorizacao(AutorizacaoEmpenho $autorizacaoEmpenho)
    {
        $obTEmpenhoContrapartidaAutorizacao = new ContrapartidaAutorizacao();
        $obTEmpenhoContrapartidaAutorizacao->setFkContrapartidaAutorizacaoAutorizacaoEmpenho($autorizacaoEmpenho);
        $this->save($obTEmpenhoContrapartidaAutorizacao);
    }
}
