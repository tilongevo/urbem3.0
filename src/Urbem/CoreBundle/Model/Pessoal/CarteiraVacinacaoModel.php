<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM\EntityManager;
use phpDocumentor\Reflection\Types\Boolean;
use Urbem\CoreBundle\Entity\Pessoal\CarteiraVacinacao;

class CarteiraVacinacaoModel
{
    private $entityManager = null;
    protected $repository = null;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(CarteiraVacinacao::class);
    }

    /**
     * @param $codCarteira
     * @param $flag
     */
    public function alterarFlagApresentada($codCarteira, $flag)
    {
        $carteiraVacinacao = $this->repository->findOneBy(['codCarteira' => $codCarteira]);
        $carteiraVacinacao
            ->setApresentada($flag);

        $this->entityManager->persist($carteiraVacinacao);
        $this->entityManager->flush();
    }
}
