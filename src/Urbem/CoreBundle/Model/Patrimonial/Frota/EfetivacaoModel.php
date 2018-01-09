<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Frota;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Frota\Autorizacao;
use Urbem\CoreBundle\Entity\Frota\Efetivacao;
use Urbem\CoreBundle\Entity\Frota\Manutencao;
use Urbem\CoreBundle\Model;

class EfetivacaoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Frota\\Efetivacao");
    }

    public function canRemove($object)
    {
        // TODO: Implement canRemove() method.
    }

    /**
     * Retorna a Efetivação informada
     *
     * @author Helike Long (helikelong@gmail.com)
     * @date   2016-10-25
     *
     * @param  obj Autorizacao
     * @return obj Efetivacao
     */
    public function getEfetivacaoInfo($autorizacao)
    {
        $efetivacao = $this->repository->findOneBy([
            'codAutorizacao' => $autorizacao->getCodAutorizacao(),
            'exercicioAutorizacao' => $autorizacao->getExercicio()
        ]);

        return $efetivacao;
    }

    /**
     * @param Autorizacao $autorizacao
     * @param Manutencao $manutencao
     * @return Efetivacao
     */
    public function buildEfetivacao(Autorizacao $autorizacao, Manutencao $manutencao)
    {
        $efetivacao = new Efetivacao();
        $efetivacao->setFkFrotaManutencao($manutencao);
        $efetivacao->setFkFrotaAutorizacao($autorizacao);

        $this->save($efetivacao);

        return $efetivacao;
    }
}
