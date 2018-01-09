<?php

namespace Urbem\CoreBundle\Model\Ldo;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Repository;
use Symfony\Component\Validator\Validator;

class ConfiguracaoDividaModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Ldo\\ConfiguracaoDivida");
    }


    public function valida($ppa, $configuracoes)
    {
        $indicadoresCadastrados = [];
        foreach ($configuracoes as $configuracao) {
            $indicadoresCadastrados[] = $configuracao->getExercicio();
        }

        $indicadoresSemCadastro = [];
        for ($i = (integer) $ppa->getAnoInicio(); $i <= (integer) $ppa->getAnoFinal(); ++$i) {
            if (!in_array($i, $indicadoresCadastrados)) {
                $indicadoresSemCadastro[] = $i;
            }
        }

        if (!count($indicadoresSemCadastro)) {
            return [];
        }

        return $indicadoresSemCadastro;
    }
}
