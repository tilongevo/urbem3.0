<?php

namespace Urbem\CoreBundle\Model\Ldo;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Repository;
use Symfony\Component\Validator\Validator;

class HomologacaoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Ldo\Homologacao");
    }

    public function getExercicioLdoHomologado($codPpa, $sonata = false)
    {
        $sql = "
        SELECT
            acao_validada.ano,
            ppa.cod_ppa,
            (ppa.ano_inicio ::NUMERIC - 1 + acao_validada.ano ::NUMERIC) AS ano_ldo
        FROM ppa.acao
        INNER JOIN ppa.acao_dados
            ON acao.cod_acao = acao_dados.cod_acao
            AND acao.ultimo_timestamp_acao_dados = acao_dados.timestamp_acao_dados
        INNER JOIN ldo.acao_validada
            ON acao_dados.cod_acao = acao_validada.cod_acao
            AND acao_dados.timestamp_acao_dados = acao_validada.timestamp_acao_dados
        INNER JOIN ppa.programa
            ON acao.cod_programa = programa.cod_programa
        INNER JOIN ppa.programa_setorial
            ON programa.cod_setorial = programa_setorial.cod_setorial
        INNER JOIN ppa.macro_objetivo
            ON programa_setorial.cod_macro = macro_objetivo.cod_macro
        INNER JOIN ppa.ppa
            ON macro_objetivo.cod_ppa = ppa.cod_ppa
        WHERE ppa.cod_ppa = :cod_ppa
        AND ppa.fn_verifica_homologacao(ppa.cod_ppa)
        AND NOT ldo.fn_verifica_homologacao_ldo(ppa.cod_ppa, acao_validada.ano)
        GROUP BY ppa.cod_ppa,
                 acao_validada.ano,
                 ppa.ano_inicio
        ;";

        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->bindValue('cod_ppa', $codPpa);
        $query->execute();

        $res = $query->fetchAll(\PDO::FETCH_OBJ);

        $anos = array();
        foreach ($res as $ano) {
            if (! $sonata) {
                $anos[$ano->ano] = $ano->ano_ldo;
            } else {
                $anos[$ano->ano_ldo] = $ano->ano;
            }
        }

        return $anos;
    }

    public function checarDataEncaminhamento($object)
    {
        $sql = "
        SELECT
            ppa_encaminhamento.cod_ppa,
            ppa_encaminhamento.dt_encaminhamento,
            ppa_encaminhamento.dt_devolucao,
            ppa_encaminhamento.nro_protocolo,
            MAX(ppa_encaminhamento.timestamp) AS timestamp,
            ppa.ano_inicio,
            ppa.ano_final
        FROM ppa.ppa_encaminhamento
        INNER JOIN (SELECT
            cod_ppa,
            MAX(timestamp) AS timestamp
        FROM ppa.ppa_encaminhamento
        GROUP BY cod_ppa) AS max_ppa_encaminhamento
            ON ppa_encaminhamento.timestamp = max_ppa_encaminhamento.timestamp
            AND ppa_encaminhamento.cod_ppa = max_ppa_encaminhamento.cod_ppa
        INNER JOIN ppa.ppa
            ON ppa_encaminhamento.cod_ppa = ppa.cod_ppa
        WHERE ppa_encaminhamento.cod_ppa = :cod_ppa
        GROUP BY ppa_encaminhamento.cod_ppa,
                 ppa_encaminhamento.dt_encaminhamento,
                 ppa_encaminhamento.dt_devolucao,
                 ppa_encaminhamento.nro_protocolo,
                 ppa.ano_inicio,
                 ppa.ano_final";

        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->bindValue('cod_ppa', $object->getCodPpa()->getCodPpa());
        $query->execute();

        $res = $query->fetch(\PDO::FETCH_OBJ);

        $retornoPpa = new \DateTime($res->dt_encaminhamento);

        if ($object->getDtEncaminhamento() > $retornoPpa) {
            return true;
        } else {
            return $retornoPpa;
        }
    }

    public function getVeiculoPublicacaoTipo($codTipoVeiculosPublicidade, $sonata = false)
    {
        $numcgmVeiculos = $this->entityManager->getRepository('CoreBundle:Licitacao\VeiculosPublicidade')
            ->findByCodTipoVeiculosPublicidade($codTipoVeiculosPublicidade);
        
        $veiculos = array();
        foreach ($numcgmVeiculos as $numcgmVeiculo) {
            if (! $sonata) {
                $veiculos[$numcgmVeiculo->getFkSwCgm()->getNumcgm()] = $numcgmVeiculo->getFkSwCgm()->getNomcgm();
            } else {
                $veiculos[$numcgmVeiculo->getFkSwCgm()->getNomcgm()] = $numcgmVeiculo->getFkSwCgm()->getNumcgm();
            }
        }
        return $veiculos;
    }

    /**
     * @param $codCompraDireta
     * @param $exercicio
     * @param $codEntidade
     * @param $codModalidade
     * @return null|object
     */
    public function getOneHomologacaoByCodCompraDiretaAndExercicioAndCodEntidadeAndCodModalidade(
        $codCompraDireta,
        $exercicio,
        $codEntidade,
        $codModalidade
    ) {
    
        return $this->repository->findOneBy([
            'exercicioCompraDireta' => $exercicio,
            'codcompraDireta' => $codCompraDireta,
            'codModalidade' => $codModalidade,
            'codEntidade' => $codEntidade,
        ]);
    }
}
