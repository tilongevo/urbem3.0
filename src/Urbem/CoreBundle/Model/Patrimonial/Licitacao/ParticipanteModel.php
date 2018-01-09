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

use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\Entity\Licitacao;
use Urbem\CoreBundle\Entity\Orcamento;
use Urbem\CoreBundle\Entity\SwCgm;

class ParticipanteModel extends AbstractModel
{
    protected $entityManager = null;

    /**
     * @var \Urbem\CoreBundle\Repository\Patrimonio\Licitacao\ParticipanteRepository $repository
     */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Licitacao\\Participante");
    }

    public function getPartcipantes(Licitacao\Licitacao $licitacao)
    {
        $cgmParticipantes = $this->repository->findBy(['fkLicitacaoLicitacao' => $licitacao]);

        $ids = [];

        /** @var Licitacao\Participante $cgms */
        foreach ($cgmParticipantes as $cgms) {
            if (!is_null($cgms->getCgmFornecedor())) {
                $ids[] = $cgms->getCgmFornecedor();
            }
        }

        $queryBuilderFornecedor = $this->entityManager->createQueryBuilder();
        $queryBuilderFornecedor
            ->select('fornecedor')
            ->from(Compras\Fornecedor::class, 'fornecedor')
            ->join('fornecedor.fkSwCgm', 'cgm');

        if (count($ids) > 0) {
            $queryBuilderFornecedor->where(
                $queryBuilderFornecedor->expr()->notIn('fornecedor.cgmFornecedor', $ids)
            );
        }


        return $queryBuilderFornecedor;
    }
}
