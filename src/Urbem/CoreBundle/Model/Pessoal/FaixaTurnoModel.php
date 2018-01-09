<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Entity\Pessoal;

class FaixaTurnoModel
{
    private $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Pessoal\\FaixaTurno");
    }

    public function getCodigo($cod_grade, $cod_dia)
    {
        $sql = "
        SELECT COALESCE(MAX(cod_turno), 0) AS CODIGO FROM pessoal.faixa_turno WHERE cod_grade = :cod_grade AND cod_dia = :cod_dia
        ";

        $qry = $this->entityManager->getConnection()->prepare($sql);
        $qry->bindValue(':cod_grade', $cod_grade);
        $qry->bindValue(':cod_dia', $cod_dia);
        $qry->execute();
        $res = $qry->fetchAll();

        return $res;
    }

    public function getFaixaByCodGrade($codGrade)
    {
        $return = $this->repository->findByCodGrade($codGrade);
        return $return;
    }

    public function getFaixaTurnoByCodGrade($cod_grade)
    {
        $sql = "
         select * from pessoal.faixa_turno f
         inner join pessoal.grade_horario g
         on g.cod_grade = f.cod_grade
         inner join pessoal.dias_turno d
         on d.cod_dia = f.cod_dia
         where f.cod_grade = :cod_grade;
       ";

        $qry = $this->entityManager->getConnection()->prepare($sql);
        $qry->bindValue(':cod_grade', $cod_grade);
        $qry->execute();
        $res = $qry->fetchAll(\PDO::FETCH_OBJ);

        $turno = array();
        foreach($res as $res_key => $dia) {
            $turno[$dia->cod_grade]['hora_entrada'] = $dia->hora_entrada;
            $turno[$dia->cod_grade]['hora_saida'] = $dia->hora_saida;
            $turno[$dia->cod_grade]['hora_entrada_2'] = $dia->hora_entrada_2;
            $turno[$dia->cod_grade]['hora_saida_2'] = $dia->hora_saida_2;
            $turno[$dia->cod_grade]['descricao'] = $dia->descricao;
            $turno[$dia->cod_grade]['dia'][] = (string)$dia->cod_dia;
        }

        return $turno;
    }

    public function consultaFaixaTurno($cod_grade)
    {
        $sql = "
            SELECT * FROM pessoal.faixa_turno WHERE cod_grade = :cod_grade;
        ";
        $qry = $this->entityManager->getConnection()->prepare($sql);
        $qry->bindValue(':cod_grade', $cod_grade);
        $qry->execute();
        $res = $qry->fetchAll(\PDO::FETCH_OBJ);

        if(count($res)>0){
            $this->deleteFaixaTurno($cod_grade);
        }
        return $res;
    }

    public function deleteFaixaTurno($cod_grade)
    {
        $sql = "
            DELETE FROM pessoal.faixa_turno WHERE cod_grade = :cod_grade;
        ";
        $qry = $this->entityManager->getConnection()->prepare($sql);
        $qry->bindValue(':cod_grade', $cod_grade);
        $qry->execute();
        $res = $qry->fetchAll(\PDO::FETCH_OBJ);

        return $res;
    }

    public function getFaixaTurno($codGrade)
    {
        return $this->repository->getFaixaTurno($codGrade);
    }
}
