<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Pessoal\CasoCausa;

/**
 * Class CasoCausaModel
 * @package Urbem\CoreBundle\Model\Pessoal
 */
class CasoCausaModel
{
    private $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(CasoCausa::class);
    }

    /**
     * Retorna a lista de Subdivisoes para o campo do tipo select multiplo no formulario
     * @param CasoCausa $casoCausa
     * @return array
     */
    public function getSubDivisoes(CasoCausa $casoCausa)
    {
        $data = [];

        foreach ($casoCausa->getFkPessoalCasoCausaSubDivisoes() as $casoCausaSubDivisao) {
            $data[] = $casoCausaSubDivisao->getFkPessoalSubDivisao();
        }

        return $data;
    }
}
