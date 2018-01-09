<?php
namespace Urbem\CoreBundle\Model\Patrimonial\Almoxarifado;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;

class CatalogoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct($entityManager = null)
    {
        if (! $entityManager) {
            global $kernel;
            if ('AppCache' == get_class($kernel)) {
                $kernel = $kernel->getKernel();
            }

            $entityManager = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        }
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Almoxarifado\Catalogo");
    }

    /**
     * @param array $params
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\Catalogo
     */
    public function findOneBy($params)
    {
        return $this->repository->findOneBy($params);
    }
}
