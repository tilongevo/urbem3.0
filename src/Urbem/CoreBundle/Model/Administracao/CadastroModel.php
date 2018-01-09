<?php

namespace Urbem\CoreBundle\Model\Administracao;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\Cadastro;
use Urbem\CoreBundle\Model;

/**
 * Class CadastroModel
 * @package Urbem\CoreBundle\Model\Administracao
 */
class CadastroModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    const CADASTRO_ELEMENTOS = 5;
    const CADASTRO_DESONERACAO = 3;

    /**
     * CadastroModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Cadastro::class);
    }

    /**
     * @param $nomCadastro
     * @return mixed
     */
    public function findOneBynomCadastro($nomCadastro)
    {
        return $this->repository->findOneBynomCadastro($nomCadastro);
    }
}
