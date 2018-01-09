<?php

namespace Urbem\CoreBundle\Model\Administracao;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;

class UsuarioModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Administracao\Usuario");
    }

    public function canRemove($object)
    {
        $sql = "
        SELECT *
        FROM administracao.grupo_usuario gp
        WHERE gp.cod_usuario = :cod_usuario;
        ";

        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->bindValue('cod_usuario', $object->getId());
        $query->execute();

        if ($query->rowCount() > 0) {
            return false;
        }
        return true;
    }

    public function getNumCgm($id)
    {

        $sql = "select sw.numcgm 
                    from administracao.usuario u
                    inner join public.sw_cgm as sw on u.numcgm = sw.numcgm
                where u.id = :id";

        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->bindValue('id', $id);
        $query->execute();

        $numcgm = ($query->fetch(\PDO::FETCH_OBJ));

        $numcgmObj = $this->entityManager->getRepository("CoreBundle:SwCgm")
            ->findOneByNumcgm($numcgm->numcgm);

        return $numcgmObj;
    }

    public function getUsuarioByNumcgm($numcgm)
    {


        $sql = "select u.*, org.descricao as setor 
                    from administracao.modulo m
                    inner join administracao.usuario as u on u.numcgm = m.cod_responsavel
                    left join organograma.orgao_descricao as org on org.cod_orgao = u.cod_orgao 
                where numcgm = :numcgm";

        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->bindValue('numcgm', $numcgm);
        $query->execute();

        return  $query->fetch(\PDO::FETCH_OBJ);
    }

    public function getUsername($id)
    {
        $sql = "select * from administracao.usuario where id = :id";

        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->bindValue('id', $id);
        $query->execute();
        $res = $query->fetch(\PDO::FETCH_OBJ);

        return $res->username;
    }

    public function getNextVal()
    {
        $sql = "SELECT last_value FROM administracao.usuario_id_seq;";

        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->execute();
        $res = $query->fetch(\PDO::FETCH_OBJ);

        return (int) $res->last_value + 1;
    }

    public function getUsuario($id)
    {
        return $this->entityManager->getRepository("CoreBundle:Administracao\Usuario")
        ->findOneById($id);
    }

    public function getOrganogramAtivo()
    {
        $organogramaAtivo = $this->entityManager->getRepository('CoreBundle:Organograma\Organograma')
        ->findOneByAtivo(true);

        return $organogramaAtivo->getCodOrganograma() . " - " . $organogramaAtivo->getImplantacao()->format("d/m/Y");
    }

    public function popularOrgaos($codOrganograma)
    {
        $orgaosList = $this->entityManager->getRepository('CoreBundle:Organograma\Orgao')
        ->getOrgaosOrganograma($codOrganograma);

        $niveisChoices = array();
        foreach ($orgaosList as $orgao) {
            $niveisChoices[$orgao->nivel][$orgao->descricao] = $orgao->cod_orgao;
        }

        return $niveisChoices;
    }

    /**
     * @param string $q
     * @return ORM\QueryBuilder
     */
    public function searchQuery($q)
    {
        $queryBuilder = $this->repository->createQueryBuilder('usuario');

        $queryBuilder
            ->join('usuario.fkSwCgm', 'cgm')
            ->where('LOWER(cgm.nomCgm) LIKE LOWER(:nomCgm)')
            ->setParameter('nomCgm', sprintf("%%%s%%", $q))
        ;

        return $queryBuilder;
    }

    /**
     * @param string $q
     * @return array
     */
    public function search($q)
    {
        return $this->searchQuery($q)->getQuery()->getResult();
    }

    /**
     * @param integer $size
     * @return string
     */
    public function randPassword($size)
    {
        $basic = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $return = "";
        for ($count = 0; $size > $count; $count++) {
            $return .= $basic[rand(0, strlen($basic) - 1)];
        }
        return $return;
    }
}
