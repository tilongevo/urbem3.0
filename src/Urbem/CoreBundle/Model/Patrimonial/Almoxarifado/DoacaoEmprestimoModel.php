<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Almoxarifado;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Almoxarifado\DoacaoEmprestimo;
use Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial;
use Urbem\CoreBundle\Entity\SwProcesso;

/**
 * Class DoacaoEmprestimoModel
 */
class DoacaoEmprestimoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * DoacaoEmprestimoModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(DoacaoEmprestimo::class);
    }

    /**
     * @param LancamentoMaterial $lancamentoMaterial
     * @param SwProcesso $swProcesso
     * @return DoacaoEmprestimo
     */
    public function buildOne(LancamentoMaterial $lancamentoMaterial, SwProcesso $swProcesso)
    {
        $doacaoEmprestimo = new DoacaoEmprestimo();
        $doacaoEmprestimo->setFkAlmoxarifadoLancamentoMaterial($lancamentoMaterial);
        $doacaoEmprestimo->setFkSwProcesso($swProcesso);

        $this->save($doacaoEmprestimo);

        return $doacaoEmprestimo;
    }
}
