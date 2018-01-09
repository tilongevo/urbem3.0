<?php

namespace Urbem\CoreBundle\Repository\Orcamento;

use Urbem\CoreBundle\Repository\AbstractRepository;

class ReservaSaldosRepository extends AbstractRepository
{
    /**
     * @param string $exercicio
     * @return int
     */
    public function getProximoCodReserva($exercicio)
    {
        return $this->nextVal('cod_reserva', ['exercicio' => $exercicio]);
    }

    /**
     * @param $exercicio
     * @param $codDespesa
     * @param $dataEmpenho
     * @param $codEntidade
     * @param $tipo
     * @return bool|string
     */
    public function getSaldoDotacao($exercicio, $codDespesa, $dataEmpenho, $codEntidade, $tipo)
    {
        $query = $this->_em->getConnection()->prepare(
            sprintf(
                "SELECT empenho.fn_saldo_dotacao_data_empenho ( :exercicio, :codDespesa, :dataEmpenho, :codEntidade, :tipo) AS saldo"
            )
        );
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('codDespesa', $codDespesa);
        $query->bindValue('dataEmpenho', $dataEmpenho);
        $query->bindValue('codEntidade', $codEntidade);
        $query->bindValue('tipo', $tipo);

        $query->execute();
        return $query->fetchColumn();
    }

    /**
     * @param $codReserva
     * @param $exercicio
     * @param $codDespesa
     * @param $dtValidadeInicial
     * @param $dtValidadeFinal
     * @param $vlReserva
     * @param $tipo
     * @param $motivo
     * @return mixed
     * @throws \Doctrine\DBAL\DBALException
     */
    public function montaincluiReservaSaldo($codReserva, $exercicio, $codDespesa, $dtValidadeInicial, $dtValidadeFinal, $vlReserva, $tipo, $motivo)
    {
        $sql = <<<SQL
SELECT orcamento.fn_reserva_saldo(:cod_reserva,
                                  :exercicio,
                                  :cod_despesa,
                                  :dt_validade_inicial,
                                  :dt_validade_final,
                                  :vl_reserva,
                                  :tipo,
                                  :motivo)
SQL;

        $query = $this->_em->getConnection()->prepare($sql);

        $query->bindValue('cod_reserva', $codReserva);
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('cod_despesa', $codDespesa);
        $query->bindValue('dt_validade_inicial', $dtValidadeInicial);
        $query->bindValue('dt_validade_final', $dtValidadeFinal);
        $query->bindValue('vl_reserva', $vlReserva);
        $query->bindValue('tipo', $tipo);
        $query->bindValue('motivo', $motivo);

        $query->execute();
        return $query->fetchAll();
    }

    /**
     * @param int        $codReserva
     * @param string|int $exercicio
     * @param float|int  $vlReserva
     *
     * @return array
     */
    public function alteraReservaSaldo($codReserva, $exercicio, $vlReserva)
    {
        $sql = "SELECT orcamento.fn_altera_reserva_saldo (:cod_reserva, :exercicio ,:vl_reserva);";

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);

        $stmt->execute([
            'cod_reserva' => $codReserva,
            'exercicio'   => $exercicio,
            'vl_reserva'  => $vlReserva,
        ]);

        return $stmt->fetchAll();
    }

    /**
     * @param $codReserva
     * @param $exercicio
     * @return mixed
     */
    public function getValueAvaiableDotacao($codReserva, $exercicio)
    {
        $sql = <<<SQL
SELECT *
FROM orcamento.reserva_saldos
WHERE reserva_saldos.cod_reserva = :cod_reserva
      AND exercicio = :exercicio
      AND NOT EXISTS(SELECT *
                     FROM orcamento.reserva_saldos_anulada AS RSA
                     WHERE RSA.cod_reserva = reserva_saldos.cod_reserva
                           AND RSA.exercicio = reserva_saldos.exercicio);
SQL;

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);

        $stmt->execute([
            'cod_reserva' => $codReserva,
            'exercicio'   => $exercicio,
        ]);

        return $stmt->fetch();
    }
}
