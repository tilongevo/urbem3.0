<?php

namespace Urbem\CoreBundle\Model\Tesouraria;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Tesouraria\Assinatura;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\AbstractModel;

class AssinaturaModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Assinatura::class);
    }

    /**
     * @param Entity\Orcamento\Entidade $entidade
     * @param $matricula
     * @param $cargo
     * @param Entity\SwCgm $cgm
     * @param $exercicio
     * @param string $tipo
     */
    public function saveAssinatura(
        Entity\Orcamento\Entidade $entidade,
        $matricula,
        $cargo,
        Entity\SwCgm $cgm,
        $exercicio,
        $tipo = 'CO'
    ) {

        $assinatura = $this->repository->findOneBy([
            'exercicio' => $exercicio,
            'codEntidade' => $entidade->getCodEntidade(),
            'numcgm' => $cgm->getNumcgm(),
            'tipo' => $tipo
        ]);

        if (is_null($assinatura)) {
            $assinatura = new Assinatura();
            $assinatura->setExercicio($exercicio);
            $assinatura->setCargo($cargo);
            $assinatura->setFkOrcamentoEntidade($entidade);
            $assinatura->setFkSwCgm($cgm);
            $assinatura->setNumMatricula($matricula);
            $assinatura->setTipo($tipo);
            $this->save($assinatura);
        }
    }
}
