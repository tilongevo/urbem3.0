<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Almoxarifado;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial;
use Urbem\CoreBundle\Entity\Frota\Autorizacao;

class LancamentoAutorizacaoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Almoxarifado\LancamentoAutorizacao::class);
    }

    /**
     * @param LancamentoMaterial $material
     * @param Autorizacao $autorizacao
     * @return Almoxarifado\LancamentoAutorizacao
     */
    public function saveLancamentoAutorizacao(LancamentoMaterial $material, Autorizacao $autorizacao)
    {
        $lancamentoAutorizacao = new Almoxarifado\LancamentoAutorizacao();
        $lancamentoAutorizacao->setFkFrotaAutorizacao($autorizacao);
        $lancamentoAutorizacao->setFkAlmoxarifadoLancamentoMaterial($material);

        $this->save($lancamentoAutorizacao);

        return $lancamentoAutorizacao;
    }
}
