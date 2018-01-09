<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\Funcao;
use Urbem\CoreBundle\Entity\Pessoal\Pensao;
use Urbem\CoreBundle\Entity\Pessoal\PensaoFuncao;

class PensaoFuncaoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Pessoal\Pensao");
    }

    /**
     * @param Pensao $pensao
     * @param Funcao $funcao
     * @return PensaoFuncao
     */
    public function savePensaoFuncaoModel(Pensao $pensao, Funcao $funcao)
    {
        $pensaoFuncao = new PensaoFuncao();
        $pensaoFuncao
            ->setFkPessoalPensao($pensao)
            ->setFkAdministracaoFuncao($funcao);

        $this->save($pensaoFuncao);

        return $pensaoFuncao;
    }
}
