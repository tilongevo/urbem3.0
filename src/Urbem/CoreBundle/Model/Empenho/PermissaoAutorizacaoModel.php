<?php

namespace Urbem\CoreBundle\Model\Empenho;

use Doctrine\ORM;
use Urbem\CoreBundle\Model;

class PermissaoAutorizacaoModel implements Model\InterfaceModel
{
    private $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Empenho\PermissaoAutorizacao");
    }

    public function canRemove($object)
    {
    }

    public function save($formData, $exercicio)
    {
        $numcgm = $formData->get('numcgm')->getData()->getNumcgm();
        $numUnidades = $formData->get('numUnidade')->getData();

        $permissaoAutorizacaoExiste = $this->repository->findBy(
            array(
                'numcgm' => $numcgm,
                'exercicio' => $exercicio
            )
        );

        foreach ($permissaoAutorizacaoExiste as $permissaoAutorizacao) {
            $this->entityManager->remove($permissaoAutorizacao);
        }
        $this->entityManager->flush();

        foreach ($numUnidades as $numUnidade) {
            $permissaoAutorizacao = new \Urbem\CoreBundle\Entity\Empenho\PermissaoAutorizacao();
            $permissaoAutorizacao->setNumcgm($numcgm);
            $permissaoAutorizacao->setNumUnidade($numUnidade->getNumUnidade());
            $permissaoAutorizacao->setNumOrgao($numUnidade->getNumOrgao());
            $permissaoAutorizacao->setExercicio($exercicio);
            $this->entityManager->persist($permissaoAutorizacao);
        }
        $this->entityManager->flush();

        return true;
    }

    /**
     * @param $exercicio
     * @param $numUnidade
     * @param $numOrgao
     * @param $numCgm
     * @return null|object
     */
    public function checarPermissaoAutorizacao($exercicio, $numUnidade, $numOrgao, $numCgm)
    {
        return $this->repository->findOneBy(
            [
                'numcgm' => $numCgm,
                'exercicio' => $exercicio,
                'numUnidade' => $numUnidade,
                'numOrgao' => $numOrgao
            ]
        );
    }
}
