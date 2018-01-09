<?php
namespace Urbem\CoreBundle\Model\Patrimonial\Almoxarifado;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel as Model;
use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado\CentroCustoPermissaoRepository;

/**
 * Class CentroCustoPermissaoModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Almoxarifado
 */
class CentroCustoPermissaoModel extends Model
{
    protected $entityManager = null;

    /** @var CentroCustoPermissaoRepository|null */
    protected $repository = null;

    /**
     * CentroCustoPermissaoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        $this->repository = $this->entityManager->getRepository(Almoxarifado\CentroCustoPermissao::class);
    }

    /**
     * @param $numcgm
     * @return array
     */
    public function getCentrosDeCustos($numcgm)
    {
        $centroCustosPermissoes = $this->repository->findBy(['numcgm' => $numcgm]);

        return $centroCustosPermissoes;
    }

    /**
     * @param $cod_centro
     * @param $numcgm
     * @return array
     */
    public function consultaCentroCustoPermissao($cod_centro, $numcgm)
    {
        return $this->repository->consultaCentroCustoPermissao($cod_centro, $numcgm);
    }

    /**
     * @param $numcgm
     * @return array
     */
    public function deleteAllCentroCustoPermissaoByCgm($numcgm)
    {
        return $this->repository->deleteAllCentroCustoPermissaoByCgm($numcgm);
    }

    /**
     * @param Almoxarifado\CentroCusto $centroCusto
     * @param SwCgm $swCgm
     * @param Almoxarifado\CentroCustoPermissao|null $centroCustoPermissao
     * @return Almoxarifado\CentroCustoPermissao
     */
    public function buildOrUpdateWithCentroCusto(
        Almoxarifado\CentroCusto $centroCusto,
        SwCgm $swCgm,
        Almoxarifado\CentroCustoPermissao $centroCustoPermissao = null
    ) {
        if (is_null($centroCustoPermissao)) {
            $centroCustoPermissao = new Almoxarifado\CentroCustoPermissao();
        }

        $centroCustoPermissao->setFkAlmoxarifadoCentroCusto($centroCusto);
        $centroCustoPermissao->setFkSwCgm($swCgm);

        return $centroCustoPermissao;
    }

    /**
     * @param Almoxarifado\CentroCusto $centroCusto
     * @param SwCgm $swCgm
     * @param Almoxarifado\CentroCustoPermissao|null $centroCustoPermissao
     * @return Almoxarifado\CentroCustoPermissao
     */
    public function createOrUpdateWithCentroCusto(
        Almoxarifado\CentroCusto $centroCusto,
        SwCgm $swCgm,
        Almoxarifado\CentroCustoPermissao $centroCustoPermissao = null
    ) {
        $isUpdate = is_null($centroCustoPermissao) != true;

        $centroCustoPermissao = $this->buildOrUpdateWithCentroCusto($centroCusto, $swCgm, $centroCustoPermissao);

        if ($isUpdate) {
            $this->update($centroCustoPermissao);
        } else {
            $this->save($centroCustoPermissao);
        }

        return $centroCustoPermissao;
    }

    /**
     * @param Almoxarifado\CentroCusto $centroCusto
     * @param SwCgm $cgm
     * @return null|Almoxarifado\CentroCustoPermissao
     */
    public function findByCentroCusto(Almoxarifado\CentroCusto $centroCusto, SwCgm $cgm)
    {
        return $this->repository->find([
            'codCentro' => $centroCusto->getCodCentro(),
            'numcgm' => $cgm->getNumcgm()
        ]);
    }

    /**
     * @param Almoxarifado\CentroCusto $centroCusto
     * @return null|Almoxarifado\CentroCustoPermissao
     */
    public function findResponsavelCentroCusto(Almoxarifado\CentroCusto $centroCusto)
    {
        /** @var Almoxarifado\CentroCustoPermissao|null $centroCustoPermissaoResponsavel */
        $centroCustoPermissaoResponsavel = $this->repository->findOneBy([
            'codCentro' => $centroCusto->getCodCentro(),
            'responsavel' => true
        ]);

        return $centroCustoPermissaoResponsavel;
    }

    /**
     * @param $numcgm
     * @param $codCentro
     */
    public function removeCentroCustoPermissao($numcgm, $codCentro)
    {
        $centroCustoPermissao = $this->repository->find([
            'numcgm' => $numcgm,
            'codCentro' => $codCentro
        ]);

        $this->remove($centroCustoPermissao);
    }
}
