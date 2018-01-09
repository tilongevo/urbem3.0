<?php

namespace Urbem\CoreBundle\Model\Administracao;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\Grupo;
use Urbem\CoreBundle\Entity\Administracao\GrupoPermissao;
use Urbem\CoreBundle\Entity\Administracao\Rota;
use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Repository\Administracao\GrupoPermissaoRepository;

/**
 * Class GrupoPermissaoModel
 *
 * @package Urbem\CoreBundle\Model\Administracao
 */
class GrupoPermissaoModel extends AbstractModel
{
    /** @var EntityRepository|GrupoPermissaoRepository */
    protected $repository;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(GrupoPermissao::class);
    }

    /**
     * Salva uma permissão na tabela intermediária usando um Grupo e uma Rota.
     *
     * @param Grupo $grupo
     * @param Rota  $rota
     *
     * @return GrupoPermissao
     */
    public function saveGrupoPermissao(Grupo $grupo, Rota $rota)
    {
        $grupoPermissao = new GrupoPermissao();
        $grupoPermissao->setFkAdministracaoGrupo($grupo);
        $grupoPermissao->setFkAdministracaoRota($rota);

        $this->save($grupoPermissao);

        return $grupoPermissao;
    }

    /**
     * @param Grupo $grupo
     * @param Rota  $rota
     */
    public function saveGrupoPermissaoRotaSuperior(Grupo $grupo, Rota $rota)
    {
        $rotaModel = new RotaModel($this->entityManager);
        $rotaSuperior = $rotaModel->findByRotaSuperior($rota->getRotaSuperior());

        if (!$rotaModel->hasPermissionByGrupo($grupo, $rota) && !is_null($rota)) {
            $this->saveGrupoPermissao($grupo, $rotaSuperior);
            $this->saveGrupoPermissaoRotaSuperior($grupo, $rota);
        }
    }

    /**
     * @param Grupo $grupo
     * @param Rota  $rota
     */
    public function saveGrupoPermissaoRotasInferiores(Grupo $grupo, Rota $rota)
    {
        $rotaModel = new RotaModel($this->entityManager);
        $rotasInferiores = $rotaModel->getChildren($rota);

        foreach ($rotasInferiores as $rotaInferior) {
            $this->saveGrupoPermissao($grupo, $rotaInferior);
        }
    }

    /**
     * Remove/Revoga a permissão de acesso a uma rota por Grupo.
     *
     * @param Grupo $grupo
     * @param Rota  $rota
     *
     * @return void
     */
    public function removeGrupoPermissao(Grupo $grupo, Rota $rota)
    {
        /** @var GrupoPermissao $grupoPermissao */
        $grupoPermissao = $this->repository->findOneBy([
            'fkAdministracaoGrupo' => $grupo,
            'fkAdministracaoRota'  => $rota,
        ]);

        $this->remove($grupoPermissao);
    }

    /**
     * @param Usuario $usuario
     * @param Rota    $rota
     *
     * @return bool
     */
    public function hasAccessToRoute(Usuario $usuario, Rota $rota)
    {
        $hasAccess = $this->repository->hasAccessToRoute($usuario->getNumcgm(), $rota->getDescricaoRota());

        // Se o usuario nao possuir acesso a rota,
        // o codigo abaixo verifica se o usuario possui acesso a alguma das rotas que sao filhas da rota fornecida.
        if (false == $hasAccess) {
            $rotaModel = new RotaModel($this->entityManager);
            $rotasFilha = $rotaModel->getChildren($rota);

            /** @var Rota $rotaFilha */
            foreach ($rotasFilha as $rotaFilha) {
                $hasAccess = $this->hasAccessToRoute($usuario, $rotaFilha);

                // Se encontrar uma rota da qual o usuario possui acesso o mesmo interrompera o looping.
                if (true == $hasAccess) {
                    break;
                }
            }
        }

        return $hasAccess;
    }
}
