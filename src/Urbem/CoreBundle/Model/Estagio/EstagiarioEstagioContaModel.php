<?php

namespace Urbem\CoreBundle\Model\Estagio;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio;
use Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioConta;
use Urbem\CoreBundle\Entity\Monetario\Agencia;
use Urbem\CoreBundle\Entity\Monetario\Banco;
use Urbem\CoreBundle\Entity\Monetario\ContaCorrente;
use Urbem\CoreBundle\Model\Administracao\AgenciaModel;

class EstagiarioEstagioContaModel extends AbstractModel
{
    protected $entityManager = null;

    protected $repository = null;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Estagio\\EstagiarioEstagioLocal");
    }

    /**
     * @param EstagiarioEstagio $estagiarioEstagio
     * @param Agencia $codAgencia
     * @param ContaCorrente $numConta
     * @param Banco $codBanco
     * @return EstagiarioEstagioConta
     */
    public function saveEstagiarioEstagioConta(EstagiarioEstagio $estagiarioEstagio, Agencia $codAgencia, ContaCorrente $numConta, Banco $codBanco)
    {
        $agencia = $this->entityManager
                ->getRepository('CoreBundle:Monetario\Agencia')
                ->findOneBy([
                    'codBanco' => $codBanco->getCodBanco(),
                    'codAgencia' => $codAgencia->getCodAgencia()
                ]);

        $estagiarioEstagioConta = new EstagiarioEstagioConta();
        $estagiarioEstagioConta
            ->setFkEstagioEstagiarioEstagio($estagiarioEstagio)
            ->setFkMonetarioAgencia($agencia)
            ->setNumConta($numConta);

        $this->save($estagiarioEstagioConta);

        return $estagiarioEstagioConta;
    }

    /**
     * @param EstagiarioEstagio $estagiarioEstagio
     */
    public function removeEstagiarioEstagioConta(EstagiarioEstagio $estagiarioEstagio)
    {
        $this->remove($estagiarioEstagio->getFkEstagioEstagiarioEstagioConta());
    }
}
