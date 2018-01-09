<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\Calendario;

use Doctrine\ORM;

class FeriadoRepository extends ORM\EntityRepository
{
    /**
     * Get dates not registered for current year
     */
    const FREE_DATES = 'E';


    /**
     * @param null $codCalendar
     * @param null $date
     * @param null $mode
     * @return array
     */
    public function getFeriadoPorAno($codCalendar = null, $date = null, $mode = null)
    {

        if ($date) {
            $exercicio = $date->format('Y');
        }

        $paramSelect = '';
        $paramCPF = "cpf.cod_calendar, cpf.cod_feriado, f.tipoferiado";
        $paramCFV = "cfv.cod_calendar, cfv.cod_feriado, f.tipoferiado";
        $paramCDC = "cdc.cod_calendar, cdc.cod_feriado, f.tipoferiado";
        $paramWhere = "where feriadosCalendario.cod_calendar = {$codCalendar} ";

        if ($mode == self::FREE_DATES) {
            $paramSelect = "SELECT * FROM calendario.feriado caf where caf.cod_feriado NOT IN( ";
            $paramCPF = " cpf.cod_feriado ";
            $paramCFV = " cfv.cod_feriado ";
            $paramCDC = " cdc.cod_feriado ";
            $paramWhere = ') and EXTRACT(year FROM "dt_feriado") = '.$exercicio.'  ';
        }

        $sql =
            $paramSelect.' select * from(
                            select '.$paramCPF.' from calendario.calendario_ponto_facultativo cpf 
                                inner join calendario.feriado f on cpf.cod_feriado = f.cod_feriado
                            union
                            select '.$paramCFV.' from calendario.calendario_feriado_variavel cfv
                                inner join calendario.feriado f on cfv.cod_feriado = f.cod_feriado
                            union
                            select '.$paramCDC.' from calendario.calendario_dia_compensado cdc
                                inner join calendario.feriado f on cdc.cod_feriado = f.cod_feriado) as feriadosCalendario  '.$paramWhere.'
        
        ';

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }
}
