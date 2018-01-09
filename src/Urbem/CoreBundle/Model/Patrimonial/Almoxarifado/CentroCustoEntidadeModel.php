<?php
namespace Urbem\CoreBundle\Model\Patrimonial\Almoxarifado;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Entity\Orcamento;
use Urbem\CoreBundle\AbstractModel as Model;

/**
 * Class CentroCustoEntidadeModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Almoxarifado
 */
class CentroCustoEntidadeModel extends Model
{
    protected $entityManager = null;

    /** @var ORM\EntityRepository|null $repository */
    protected $repository = null;

    /**
     * CentroCustoEntidadeModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Almoxarifado\CentroCustoEntidade::class);
    }

    /**
     * @param $codCentro
     * @return null|Almoxarifado\CentroCustoEntidade
     */
    public function getCentroCustoByCodCentro(Almoxarifado\CentroCusto $codCentro)
    {
        return $this->repository->findOneBy([
            'codCentro' => $codCentro
        ]);
    }

    /**
     * @param Almoxarifado\CentroCusto $centroCusto
     * @param Orcamento\Entidade $entidade
     * @param Almoxarifado\CentroCustoEntidade $centroCustoEntidade
     * @return Almoxarifado\CentroCustoEntidade
     */
    public function createOrUpdateWithCentroCusto(
        Almoxarifado\CentroCusto $centroCusto,
        Orcamento\Entidade $entidade,
        Almoxarifado\CentroCustoEntidade $centroCustoEntidade = null
    ) {
        if (is_null($centroCustoEntidade)) {
            $centroCustoEntidade = new Almoxarifado\CentroCustoEntidade();
        }

        $centroCustoEntidade->setFkAlmoxarifadoCentroCusto($centroCusto);
        $centroCustoEntidade->setFkOrcamentoEntidade($entidade);

        return $centroCustoEntidade;
    }
}
