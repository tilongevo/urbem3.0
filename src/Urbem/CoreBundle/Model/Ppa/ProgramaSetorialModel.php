<?php

namespace Urbem\CoreBundle\Model\Ppa;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Repository;
use Symfony\Component\Validator\Validator;

class ProgramaSetorialModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Ppa\ProgramaSetorial");
    }

    public function getEditProgramaSetorial($codSetorial)
    {
        $sql = "
        SELECT
            programa_setorial.cod_setorial,
            programa_setorial.descricao AS nom_setorial,
            macro_objetivo.cod_macro,
            macro_objetivo.descricao AS nom_macro,
            ppa.cod_ppa,
            ppa.ano_inicio,
            ppa.ano_final
        FROM ppa.programa_setorial
        INNER JOIN ppa.macro_objetivo
            ON programa_setorial.cod_macro = macro_objetivo.cod_macro
        INNER JOIN ppa.ppa
            ON macro_objetivo.cod_ppa = ppa.cod_ppa
        WHERE cod_setorial = :cod_setorial";

        $qry = $this->entityManager->getConnection()->prepare($sql);
        $qry->bindValue(':cod_setorial', $codSetorial);
        $qry->execute();
        $res = $qry->fetch(\PDO::FETCH_OBJ);

        return $res;
    }

    public function getMacroObjetivo($codPpa)
    {
        $sql = "
        SELECT
            mo.cod_macro,
            mo.descricao
        FROM ppa.macro_objetivo mo
        WHERE mo.cod_ppa = :cod_ppa;";

        $qry = $this->entityManager->getConnection()->prepare($sql);
        $qry->bindValue(':cod_ppa', $codPpa);
        $qry->execute();
        $res = $qry->fetchAll(\PDO::FETCH_OBJ);
        
        $macroObjetivos = array();
        foreach($res as $res_key => $macroObjetivo) {
            $macroObjetivos[$macroObjetivo->cod_macro] = $macroObjetivo->descricao;
        }

        return $macroObjetivos;
    }
}
