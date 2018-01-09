<?php
namespace Urbem\CoreBundle\Model\Patrimonial\Almoxarifado;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Entity\Almoxarifado\Requisicao;
use Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoHomologada;
use Urbem\CoreBundle\Entity\SwCgm;

/**
 * Class RequisicaoHomologadaModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Almoxarifado
 */
class RequisicaoHomologadaModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * RequisicaoHomologadaModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager
            ->getRepository(RequisicaoHomologada::class);
    }

    /**
     * @param Requisicao $requisicao
     */
    public function removeAll(Requisicao $requisicao)
    {
        /** @var RequisicaoHomologada $requisicaoHomologada */
        foreach ($requisicao->getFkAlmoxarifadoRequisicaoHomologadas() as $requisicaoHomologada) {
            $this->remove($requisicaoHomologada);
        }
    }

    /**
     * @param Requisicao $requisicao
     * @param Usuario $usuario
     * @return RequisicaoHomologada
     */
    public function homologaRequisicao(Requisicao $requisicao, Usuario $usuario)
    {
        $requisicaoHomologada = $this->repository->findOneBy([
            'fkAlmoxarifadoRequisicao' => $requisicao
        ]);

        if (true == is_null($requisicaoHomologada)) {
            $requisicaoHomologada = new RequisicaoHomologada();
            $requisicaoHomologada->setFkAlmoxarifadoRequisicao($requisicao);
            $requisicaoHomologada->setFkAdministracaoUsuario($usuario);
        }

        $requisicaoHomologada->setHomologada(true);

        $this->save($requisicaoHomologada);

        return $requisicaoHomologada;
    }

    /**
     * @param Requisicao $requisicao
     * @return RequisicaoHomologada
     */
    public function anulaHomologacaoRequisicao(Requisicao $requisicao)
    {
        $requisicaoHomologada = $requisicao->getFkAlmoxarifadoRequisicaoHomologadas()->first();

        $requisicaoHomologada->setHomologada(false);

        $this->save($requisicaoHomologada);

        return $requisicaoHomologada;
    }

    /**
     * @param $object
     * @return null|object
     */
    public function getRequisicaoHomologada($object)
    {
        $requisicaoHomologada = $this->entityManager->getRepository(RequisicaoHomologada::class)
            ->findOneBy([
                'codRequisicao' =>$object,
            ]);

        return $requisicaoHomologada;
    }
}
