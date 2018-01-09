<?php

namespace Urbem\CoreBundle\Model\Administracao;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\Configuracao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Model;

class ModuloModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Administracao\\Modulo");
    }

    public function findOneBynomModulo($nomModulo)
    {
        return $this->repository->findOneBynomModulo($nomModulo);
    }

    public function getAllModulos()
    {
        return $this->repository->getAllModulos();
    }

    /**
     * @param $codModulo
     * @return null|object
     */
    public function findOneByCodModulo($codModulo)
    {
        return $this->repository->findOneBy(
            [
                'codModulo' => $codModulo
            ]
        );
    }

    /**
     * @param array|null $moduleList
     * @return bool
     */
    public function saveMenuModule(array $moduleList = null)
    {
        $modulo = $this->repository->findOneByCodModulo(Modulo::MODULO_ADMINISTRATIVO);
        $configuracaoRepository = $this->entityManager->getRepository(Configuracao::class);

        foreach ($moduleList as $module => $enabled) {
            $paramName = sprintf("menu_%s", $module);
            $configuracao = $configuracaoRepository->findOneBy(['parametro' => $paramName, 'exercicio' => '9999', 'codModulo' => $modulo->getCodModulo()]);
            if (empty($configuracao)) {
                $configuracao = new Configuracao();
                $configuracao->setParametro($paramName);
            }

            $configuracao->setExercicio('9999');
            $configuracao->setFkAdministracaoModulo($modulo);
            $configuracao->setValor($enabled ? 'true' : 'false');

            $this->entityManager->persist($configuracao);
        }

        $this->entityManager->flush();
        return true;
    }
}
