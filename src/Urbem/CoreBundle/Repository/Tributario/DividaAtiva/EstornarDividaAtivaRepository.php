<?php

namespace Urbem\CoreBundle\Repository\Tributario\DividaAtiva;

use DateTime;
use PDO;
use Doctrine\ORM\EntityManagerInterface;

class EstornarDividaAtivaRepository
{
    const COD_MOTIVO = 11;

    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
    * @param array $filtro
    * @return array
    */
    public function fetchPagamentos($filtro)
    {
        $query = "
            SELECT
              MAX(
                (
                  SELECT
                    count(dp)
                  FROM
                    divida.parcela AS dp
                  WHERE
                    dp.num_parcelamento = ddp.num_parcelamento
                    AND dp.paga = true
                )
              )
            FROM
              divida.divida_ativa AS dda
              INNER JOIN divida.divida_parcelamento AS ddp ON ddp.cod_inscricao = dda.cod_inscricao
              AND ddp.exercicio = dda.exercicio
            WHERE
              dda.cod_inscricao = :codInscricao
              AND dda.exercicio = :exercicio;";

        $pdo = $this->em->getConnection();

        $sth = $pdo->prepare($query);

        $sth->bindValue('codInscricao', (int) $filtro['codInscricao']);
        $sth->bindValue('exercicio', $filtro['exercicio']);

        $sth->execute();

        return $sth->fetch(PDO::FETCH_COLUMN);
    }

    /**
    * @param array $filtro
    * @return array
    */
    public function fetchCarnes(array $filtro)
    {
        $query = "
            SELECT
              DISTINCT acd.numeracao,
              acd.cod_convenio,
              acd.timestamp
            FROM
              arrecadacao.parcela AS apar
              INNER JOIN arrecadacao.carne AS ac ON apar.cod_parcela = ac.cod_parcela
              INNER JOIN arrecadacao.carne_devolucao AS acd ON acd.numeracao = ac.numeracao
              AND acd.cod_motivo = :codMotivo
            WHERE
              apar.cod_lancamento IN (
                SELECT
                  DISTINCT ap.cod_lancamento
                FROM
                  divida.divida_ativa AS dda
                  INNER JOIN divida.divida_parcelamento AS ddp ON ddp.cod_inscricao = dda.cod_inscricao
                  AND ddp.exercicio = dda.exercicio
                  INNER JOIN divida.parcela_origem AS dpo ON dpo.num_parcelamento = ddp.num_parcelamento
                  INNER JOIN arrecadacao.parcela AS ap ON ap.cod_parcela = dpo.cod_parcela
                WHERE
                  dda.cod_inscricao = :codInscricao
                  AND dda.exercicio = :exercicio
              );";

        $pdo = $this->em->getConnection();

        $sth = $pdo->prepare($query);

        $sth->bindValue('codMotivo', (int) $this::COD_MOTIVO);
        $sth->bindValue('codInscricao', (int) $filtro['codInscricao']);
        $sth->bindValue('exercicio', $filtro['exercicio']);

        $sth->execute();

        return $sth->fetchAll();
    }
}
