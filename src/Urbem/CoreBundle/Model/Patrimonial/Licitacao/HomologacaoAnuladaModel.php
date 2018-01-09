<?php
/**
 * Created by PhpStorm.
 * User: longevo
 * Date: 27/07/16
 * Time: 15:40
 */

namespace Urbem\CoreBundle\Model\Patrimonial\Licitacao;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Licitacao\Adjudicacao;
use Urbem\CoreBundle\Entity\Licitacao\Homologacao;
use Urbem\CoreBundle\Entity\Licitacao\HomologacaoAnulada;

class HomologacaoAnuladaModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Licitacao\\HomologacaoAnulada");
    }

    /**
     * @param Homologacao $homologacao
     * @param object $item
     */
    public function saveHomologacaoAnulada(Homologacao $homologacao, $item)
    {
        $obtHomologacao = new HomologacaoAnulada();
        $obtHomologacao->setFkLicitacaoHomologacao($homologacao);
        $obtHomologacao->setMotivo($item->justificativa_anulacao);
        $obtHomologacao->setTimestamp(new \DateTime());
        $obtHomologacao->setRevogacao(false);
        if ($item->status == 'Revogado') {
            $obtHomologacao->setRevogacao(true);
        }

        $this->save($obtHomologacao);
    }
}
