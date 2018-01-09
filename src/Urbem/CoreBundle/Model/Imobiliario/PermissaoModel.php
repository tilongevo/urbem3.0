<?php

namespace Urbem\CoreBundle\Model\Imobiliario;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Imobiliario\Licenca;
use Urbem\CoreBundle\Entity\Imobiliario\Permissao;

class PermissaoModel extends AbstractModel
{
    /**
     * @var ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var ORM\EntityRepository
     */
    protected $repository;

    /**
     * NivelModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Permissao::class);
    }

    /**
     * @param Permissao $permissao
     * @return bool
     */
    public function verificarLicencas(Permissao $permissao)
    {
        $licencas = $this
            ->entityManager
            ->getRepository(Licenca::class)
            ->findBy(
                array(
                    'codTipo' => $permissao->getCodTipo(),
                    'numcgm' => $permissao->getNumcgm()
                )
            );
        return (count($licencas)) ? true : false;
    }

    /**
     * @param Permissao $permissao
     */
    public function removerPermissoes(Permissao $permissao)
    {
        $permissoes = $this
            ->repository
            ->findBy(
                array(
                    'codTipo' => $permissao->getCodTipo(),
                    'numcgm' => $permissao->getNumcgm()
                )
            );

        /** @var Permissao $permissao */
        foreach ($permissoes as $permissao) {
            $this->entityManager->remove($permissao);
        }

        $this->entityManager->flush();
    }
}
