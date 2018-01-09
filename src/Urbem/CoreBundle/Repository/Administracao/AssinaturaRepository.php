<?php

namespace Urbem\CoreBundle\Repository\Administracao;

use Doctrine\ORM;

/**
 * Class AssinaturaRepository
 * @package Urbem\CoreBundle\Repository\Administracao
 */
class AssinaturaRepository extends ORM\EntityRepository
{
    /**
     * @param $paramsWhere
     * @param $exercicio
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function carregaAdministracaoAssinatura($exercicio, $paramsWhere)
    {
        $sql = sprintf(
            "select * from administracao.assinatura a
                inner join sw_cgm c on c.numcgm = a.numcgm 
            WHERE a.exercicio = '{$exercicio}' %s
            ORDER BY a.timestamp DESC",
            implode(" AND ", $paramsWhere)
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    public function carregaListaAssinaturas($exercicio, $codEntidade, $codModulo)
    {
        $sql = "
             SELECT distinct(ass.numcgm), ass.exercicio, ass.cargo, cgm.nom_cgm
              FROM administracao.assinatura as ass
              join administracao.assinatura_modulo as mod on ass.numcgm = mod.numcgm
              join sw_cgm as cgm on cgm.numcgm = ass.numcgm
              WHERE ass.exercicio = :exercicio
              AND ass.cod_entidade = :cod_entidade
              AND mod.cod_modulo = :cod_modulo
              AND mod.cod_entidade = :cod_entidade
              ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio, \PDO::PARAM_STR);
        $query->bindValue('cod_entidade', $codEntidade, \PDO::PARAM_INT);
        $query->bindValue('cod_modulo', $codModulo, \PDO::PARAM_INT);

        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $exercicio
     * @param $codModulo
     * @return array
     */
    public function carregaListaAssinaturasAberturaInventario($exercicio, $codModulo)
    {
        $sql = "
        SELECT assinatura.exercicio
	 , assinatura.numcgm 
	 , assinatura.cargo as cargo
	 , sw_cgm.nom_cgm 
	 , MAX(assinatura.timestamp) AS timestamp
      FROM  administracao.assinatura
INNER JOIN  sw_cgm 
		ON  assinatura.numcgm = sw_cgm.numcgm
INNER JOIN  administracao.assinatura_modulo
	    ON  assinatura_modulo.cod_entidade = assinatura.cod_entidade
	   AND  assinatura_modulo.exercicio = assinatura.exercicio
	   AND  assinatura_modulo.numcgm = assinatura.numcgm
	   AND  assinatura_modulo.timestamp = assinatura.timestamp
     WHERE  assinatura.exercicio = :exercicio
       AND  assinatura_modulo.cod_modulo = :codModulo
       AND  assinatura.timestamp = (SELECT MAX(aa.\"timestamp\")
							FROM administracao.assinatura as aa
							WHERE aa.numcgm = administracao.assinatura.numcgm)
  GROUP BY  assinatura.exercicio
         ,  assinatura.numcgm
         ,  assinatura.cargo
         ,  sw_cgm.nom_cgm;  
         ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio, \PDO::PARAM_STR);
        $query->bindValue('codModulo', $codModulo, \PDO::PARAM_INT);

        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
    * @param $cargo
    * @return mixed
    */
    public function getSecretarioMunicipalFazendaByCargo($cargo)
    {
        $sql = "SELECT num.nom_cgm AS responsavel, assi.cargo AS cargo, assi.exercicio AS exercicio
                FROM administracao.assinatura assi
                INNER JOIN administracao.assinatura_modulo modul
                ON assi.numcgm = modul.numcgm
                AND assi.exercicio = modul.exercicio
                AND assi.cod_entidade = modul.cod_entidade
                INNER JOIN public.sw_cgm num 
                ON assi.numcgm = num.numcgm
                WHERE cargo LIKE '%{$cargo}%'
                GROUP BY num.nom_cgm, assi.cargo, assi.exercicio
                ORDER BY assi.exercicio DESC
                LIMIT 1 ";
        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        return $query->fetch();
    }

    public function withExercicioQueryBuilder($exercicio)
    {
        $qb = $this->createQueryBuilder('e');
        $qb->select('e, fkSwCgmPessoaFisica');
        $qb->distinct();
        $qb->innerJoin('e.fkSwCgmPessoaFisica', 'fkSwCgmPessoaFisica');
//        $qb->innerJoin('Urbem\CoreBundle\Entity\SwCgm', 'SwCgm', 'WITH', 'SwCgm.numcgm = fkSwCgmPessoaFisica.numcgm');
        $qb->where('e.exercicio = :exercicio');
        $qb->andWhere("e.timestamp = (select max(a.timestamp) from Urbem\\CoreBundle\\Entity\\Administracao\\Assinatura a where a.exercicio = '{$exercicio}')");
        $qb->setParameter('exercicio', $exercicio);
        $qb->orderBy('e.numcgm', 'ASC');
//        $qb->addOrderBy('SwCgm.nomCgm', 'ASC');

        return $qb;
    }

    /**
     * @param $exercicio
     * @param $assinatura
     * @param $entidade
     * @return array
     */
    public function getListaAssinatura($exercicio, $entidades)
    {
        $sql = sprintf(
            "select assinatura.exercicio
                  ,assinatura.cod_entidade
                  ,assinatura.numcgm
                  ,sw_cgm.nom_cgm
                  ,assinatura.timestamp
                  ,assinatura.cargo
                  
                  ,assinatura_crc.insc_crc
            from administracao.assinatura
            join sw_cgm
            using (numcgm)
            left join administracao.assinatura_crc
            using (exercicio,cod_entidade,numcgm,timestamp)
            where assinatura.exercicio = '{$exercicio}'
              and assinatura.timestamp = (select max(timestamp) from  administracao.assinatura where exercicio = '{$exercicio}')
                     AND assinatura.cod_entidade IN ( {$entidades} ) "
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }
}
