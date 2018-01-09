<?php

namespace Urbem\CoreBundle\Model\Pessoal\Assentamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Pessoal\Sefip;
use Urbem\CoreBundle\Model;

class MovSefipSaidaMovSefipRetornoModel extends AbstractModel
{
    protected $entityManager = null;
    /** @var ORM\EntityRepository|null|\Urbem\CoreBundle\Repository\RecursosHumanos\Pessoal\MovSefipSaidaMovSefipRetornoRepository */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Pessoal\MovSefipSaidaMovSefipRetorno");
    }

    public function insere($saida, $retorno)
    {
        $sql = "INSERT INTO pessoal.mov_sefip_saida_mov_sefip_retorno(cod_sefip_saida, cod_sefip_retorno) VALUES($saida, $retorno)";
        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->execute();
    }

    public function getRetornoBySefip(Sefip $sefip)
    {
        return $this->entityManager
            ->getRepository('CoreBundle:Pessoal\MovSefipSaidaMovSefipRetorno')
            ->findOneBy([
                'codSefipSaida' => $sefip
            ]);
    }

    public function consulta($codigo, $delete = false)
    {
        $sql = sprintf("select * from pessoal.mov_sefip_saida_mov_sefip_retorno where cod_sefip_saida = %d", $codigo);
        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->execute();

        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        if ($result > 0 && $delete) {
            $this->removerRetornoBySaida($codigo);
        }

        return $result;
    }

    public function removerRetornoBySaida($id)
    {
        $sql = sprintf("DELETE FROM pessoal.mov_sefip_saida_mov_sefip_retorno WHERE cod_sefip_saida = %d", $id);
        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->execute();
    }

    public function removerRetorno($id)
    {
        $sql = sprintf("DELETE FROM pessoal.mov_sefip_saida_mov_sefip_retorno WHERE cod_sefip_retorno = %d", $id);
        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->execute();
    }

    /**
     * @param bool $stFiltroSefipRetorno
     *
     * @return array
     */
    public function recuperaMovSefipRetorno($stFiltroSefipRetorno = false)
    {
        return $this->repository->recuperaMovSefipRetorno($stFiltroSefipRetorno);
    }
}
