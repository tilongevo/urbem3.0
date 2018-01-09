<?php

namespace Urbem\CoreBundle\Model\Administracao;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\Grupo;
use Urbem\CoreBundle\Entity\Administracao\Rota;
use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Repository\Administracao\GrupoRepository;
use Urbem\CoreBundle\Repository\Administracao\RotaRepository;

/**
 * Class GrupoModel
 *
 * @package Urbem\CoreBundle\Model\Administracao
 */
class GrupoModel extends AbstractModel
{
    /** @var GrupoRepository $repository */
    protected $repository;

    /** @var RotaRepository $rotaRepository */
    private $rotaRepository;

    protected static $rotasIgnoradas = [
        'home-urbem',
        'recursos_humanos',
        'administrativo',
        'patrimonial',
        'tributario',
        'financeiro',
        'download-urbem',
        'show-urbem'
    ];

    /**
     * GrupoModel constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        $this->repository = $entityManager->getRepository(Grupo::class);
        $this->rotaRepository = $entityManager->getRepository(Rota::class);
    }

    /**
     * @param $grupoPermissao
     *
     * @return bool
     */
    public function saveGrupoPermissao($grupoPermissao)
    {
        $data = json_decode($grupoPermissao);

        $permissoes = [
            'codGrupo'    => null,
            'acesso_rota' => []
        ];

        $codRotaList = [];
        foreach ($data as $dataKey => $dataValue) {
            switch ($dataValue->name) {
                case 'codGrupo':
                    $permissoes['codGrupo'] = $dataValue->value;
                    break;
                case 'permissoes':
                    $codRotaList = $this->rotaRepository->findByCodRota(json_decode($dataValue->value));
                    break;
                case 'acesso_rota':
                    $rota = $this->rotaRepository->findOneByCodRota($dataValue->value);
                    $permissoes['acesso_rota'][] = $rota;
                    break;
            }
        }
        $permissaoList = (array_unique(array_merge($permissoes['acesso_rota'], $codRotaList)));

        $grupo = $this->repository->findOneByCodGrupo($permissoes['codGrupo']);
        $grupo->setGrupoPermissao($permissaoList);
        $this->entityManager->persist($grupo);
        $this->entityManager->flush();

        return true;
    }

    /**
     * @deprecated Use o método `RotaModel::hasPermissaoGrupo`
     *
     * @param $codGrupo
     * @param $codRota
     *
     * @return int
     */
    public function getPermissaoByGrupo($codGrupo, $codRota)
    {
        $sql = "
        SELECT * FROM administracao.grupo_permissao WHERE cod_grupo = :cod_grupo AND cod_rota = :cod_rota;";

        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->bindValue("cod_grupo", $codGrupo);
        $query->bindValue("cod_rota", $codRota);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return count($result);
    }

    /**
     * @deprecated Use o método `RotaModel::getPermissionsByGrupo()`
     *
     * @param null $codGrupo
     *
     * @return bool|string
     */
    public function getAllPermissaoByGrupo($codGrupo = null)
    {
        if ($codGrupo) {
            $sql = "SELECT cod_rota FROM administracao.grupo_permissao WHERE cod_grupo = :cod_grupo;";

            $query = $this->entityManager->getConnection()->prepare($sql);
            $query->bindValue("cod_grupo", $codGrupo);
            $query->execute();
            $result = $query->fetchAll(\PDO::FETCH_OBJ);

            $route_list = [];
            foreach ($result as $key => $value) {
                $route_list[] = $value->cod_rota;
            }

            return json_encode($route_list);
        }

        return false;
    }

    /**
     * @param $descricaoRota
     *
     * @return null|object|Rota
     */
    public function checkRotaExiste($descricaoRota)
    {
        return $this->rotaRepository->findOneBy([
            'descricaoRota' => $descricaoRota
        ]);
    }

    /**
     * @param Rota $rota
     * @param $cod_usuario
     *
     * @return bool
     */
    public function checkPermissao(Rota $rota, $cod_usuario)
    {
        $sql = "
        SELECT *
        FROM administracao.grupo_usuario
        WHERE cod_usuario = :cod_usuario
        ORDER BY cod_grupo DESC LIMIT 1;";

        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->bindValue("cod_usuario", $cod_usuario);
        $query->execute();
        $result = $query->fetch(\PDO::FETCH_OBJ);

        $flag = 0;
        if ($result) {
            // Verificar se a rota tem permissão
            $sql = "
            SELECT *
            FROM administracao.grupo_permissao gp
            INNER JOIN administracao.rota r ON r.cod_rota = gp.cod_rota
            WHERE r.descricao_rota = :descricao_rota;";

            $query = $this->entityManager->getConnection()->prepare($sql);
            $query->bindValue("descricao_rota", $rota->getDescricaoRota());
            $query->execute();
            $result = $query->fetch(\PDO::FETCH_OBJ);

            if (!$result) {
                // Se não tiver permissão nela mesma, verificar se os filhos tem
                $sql = "
                SELECT *
                FROM administracao.grupo_permissao gp
                INNER JOIN administracao.rota r ON r.cod_rota = gp.cod_rota
                WHERE r.rota_superior = :rota_superior;";

                $query = $this->entityManager->getConnection()->prepare($sql);
                $query->bindValue("rota_superior", $rota->getDescricaoRota());
                $query->execute();
                $result = $query->fetchAll(\PDO::FETCH_OBJ);

                foreach ($result as $key => $value) {
                    $flag++;
                }
            } else {
                $flag++;
            }
        }

        if ($flag == 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @deprecated Use o método `RotaModel::getRotasIgnoradas()`.
     *
     * @return array
     */
    public function getRotasIgnoradas()
    {
        return (new RotaModel($this->entityManager))->getRotasIgnoradas();
    }

    /**
     * Retorna o proximo codigo do grupo.
     *
     * @return int
     */
    public function getNextCodGroup()
    {
        return $this->repository->nextVal('cod_grupo');
    }

    public function clearGrupoUsuarioByGrupo(Grupo $grupo)
    {
        $sql = 'DELETE FROM administracao.grupo_usuario WHERE cod_grupo = :cod_grupo';
        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->bindValue('cod_grupo', $grupo->getCodGrupo());

        return $query->execute();
    }
}
