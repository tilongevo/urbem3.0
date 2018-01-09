<?php
namespace Urbem\CoreBundle\Model\Patrimonial\Almoxarifado;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Urbem\CoreBundle\AbstractModel as Model;
use Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoItem;
use Urbem\CoreBundle\Entity\Almoxarifado\AtributoEstoqueMaterialValor;
use Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial;

/**
 * Class AtributoEstoqueMaterialValorModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Almoxarifado
 */
class AtributoEstoqueMaterialValorModel extends Model
{
    protected $entityManager = null;

    /** @var EntityRepository repository */
    protected $repository = null;

    /**
     * BemModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(AtributoEstoqueMaterialValor::class);
    }

    /**
     * @param AtributoCatalogoItem  $atributoCatalogoItem
     * @param LancamentoMaterial    $lancamentoMaterial
     * @param string                $valor
     * @return AtributoEstoqueMaterialValor
     */
    public function saveAtributoEstoqueMaterialValor(AtributoCatalogoItem $atributoCatalogoItem, LancamentoMaterial $lancamentoMaterial, $valor)
    {
        $atributoEstoqueMaterialValor = new AtributoEstoqueMaterialValor();
        $atributoEstoqueMaterialValor->setFkAlmoxarifadoAtributoCatalogoItem($atributoCatalogoItem);
        $atributoEstoqueMaterialValor->setFkAlmoxarifadoLancamentoMaterial($lancamentoMaterial);
        $atributoEstoqueMaterialValor->setValor($valor);

        $this->save($atributoEstoqueMaterialValor);

        return $atributoEstoqueMaterialValor;
    }
}
