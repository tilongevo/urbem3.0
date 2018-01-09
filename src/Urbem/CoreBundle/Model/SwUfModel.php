<?php

namespace Urbem\CoreBundle\Model;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\Expr\Join;

use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\Configuracao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\SwUf;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;

/**
 * Class SwUfModel
 * @package Urbem\CoreBundle\Model
 */
class SwUfModel extends AbstractModel implements InterfaceModel
{
    /** @var \Doctrine\ORM\EntityRepository */
    protected $repository;

    /**
     * {@inheritdoc}
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(SwUf::class);
    }

    /**
     * {@inheritdoc}
     */
    public function canRemove($object)
    {
        return false;
    }

    /**
     * @param null $exercicio
     * @return null|object
     */
    public function getSwUfByConfiguracao($exercicio = null)
    {
        $codUf = (new ConfiguracaoModel($this->entityManager))
            ->getConfiguracaoOuAnterior('cod_uf', Modulo::MODULO_ADMINISTRATIVO, $exercicio);

        $param = ['siglaUf' => $codUf];
        if (is_numeric($codUf)) {
            $param = ['codUf' => $codUf];
        }

        return $this->repository->findOneBy($param);
    }
}
