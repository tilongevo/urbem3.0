<?php

namespace Urbem\CoreBundle\Model\Administracao;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Model;

class FuncaoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Administracao\\Funcao");
    }

    public function executaFuncaoPL($sql)
    {
        return $this->repository->executaFuncaoPL($sql);
    }

    public function recuperaFuncao($param)
    {
        $funcao = $this
                    ->entityManager
                    ->getRepository('CoreBundle:Administracao\Funcao')
                    ->findOneBy([
                        'codFuncao' => $param->cod_funcao,
                        'codModulo' => $param->cod_modulo,
                        'codBiblioteca' => $param->cod_biblioteca
                    ]);

        return $funcao;
    }
}
