<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\Pessoal;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class ServidorRepository
 * @package Urbem\CoreBundle\Repository\RecursosHumanos\Pessoal
 */
class ServidorRepository extends AbstractRepository
{
    /**
     * @param $cgm
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function consultaDadosCgmPessoaFisica($cgm)
    {

        $qb = $this->createQueryBuilder('sw');
        $qb->leftJoin('Urbem\CoreBundle\Entity\SwPessoaFisica', 'p', 'WITH', 'sw.numcgm = p.numCgm');
        $qb->where('p.numCgm = :cgm');
        $qb->setParameter('cgm', $cgm);

        return $qb;
    }

    /**
     * @param $codServidor
     * @param $codCtps
     * @return array|string
     */
    public function inserirServidorCtps($codServidor, $codCtps)
    {
        $result = "";
        $this->consultaServidorCtps($codServidor);
        foreach ($codCtps->getValues() as $chave) {
            $val = $chave->getCodCtps();
            $sql = "INSERT INTO pessoal.servidor_ctps(cod_servidor,cod_ctps) VALUES($codServidor,$val);";

            $query = $this->_em->getConnection()->prepare($sql);
            $query->execute();
            $result = $query->fetchAll(\PDO::FETCH_OBJ);
        }

        return $result;
    }

    /**
     * @param $codServidor
     * @return array
     */
    public function consultaServidorCtps($codServidor)
    {
        $sql = "
        SELECT
            *
        FROM pessoal.servidor_ctps
        WHERE cod_servidor = $codServidor";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        if ($result > 0) {
            $this->deleteServidorCtps($codServidor);
        }

        return $result;
    }

    /**
     * @param $codServidor
     * @return array
     */
    public function deleteServidorCtps($codServidor)
    {
        $sql = "
        DELETE
        FROM pessoal.servidor_ctps
        WHERE cod_servidor = $codServidor";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }

    /**
     * @return int
     */
    public function getNextCodServidor()
    {
        return $this->nextVal('cod_servidor');
    }

    /**
     * @param $filtro
     * @return array
     */
    public function getRelatorioServidor($filtro)
    {
        $where = $filtro['filtro'].$filtro['situacao'];

        $sql = "select
                    distinct servidor.*,
                    sw_cgm.*,
                    contrato.registro,
                    contrato.cod_contrato,
                    sw_escolaridade.descricao as escolaridade,
                    sw_cgm_pessoa_fisica.cpf,
                    sw_cgm_pessoa_fisica.cod_categoria_cnh,
                    TO_CHAR(
                        sw_cgm_pessoa_fisica.dt_validade_cnh,
                        'dd/mm/yyyy'
                    ) as dt_validade_cnh,
                    sw_categoria_habilitacao.nom_categoria,
                    sw_cgm_pessoa_fisica.orgao_emissor,
                    TO_CHAR(
                        sw_cgm_pessoa_fisica.dt_emissao_rg,
                        'dd/mm/yyyy'
                    ) as dt_emissao_rg,
                    sw_cgm_pessoa_fisica.num_cnh,
                    sw_cgm_pessoa_fisica.rg,
                    sw_cgm_pessoa_fisica.sexo,
                    to_char(
                        sw_cgm_pessoa_fisica.dt_nascimento,
                        'dd/mm/yyyy'
                    ) as dt_nascimento,
                    sw_municipio.nom_municipio,
                    sw_uf.sigla_uf,
                    sw_pais.nom_pais,
                    sw_pais.nacionalidade,
                    to_char(
                        servidor_pis_pasep.dt_pis_pasep,
                        'dd/mm/yyyy'
                    ) as dt_pis_pasep,
                    sw_cgm_pessoa_fisica.servidor_pis_pasep,
                    servidor_reservista.nr_carteira_res,
                    servidor_reservista.cat_reservista,
                    servidor_reservista.origem_reservista,
                    pessoal_servidor_conjuge.nome_conjuge,
                    pessoal_cid.sigla,
                    pessoal_cid.descricao,
                    conselho.sigla as sigla_conselho,
                    contrato_servidor_conselho.nr_conselho,
                    TO_CHAR(
                        contrato_servidor_conselho.dt_validade,
                        'dd/mm/yyyy'
                    ) as dt_validade_conselho,
                    contrato_servidor_padrao.cod_padrao,
                    contrato_servidor_forma_pagamento.cod_forma_pagamento,
                    contrato_servidor.cod_tipo_pagamento,
                    recuperaDescricaoOrgao(
                        orgao.cod_orgao,
                        '".$filtro['exercicio']."-01-01'
                    ) as lotacao,
                    local.descricao as local,
                    orgao.cod_orgao,
                    contrato_servidor_local.cod_local,
                    contrato_servidor_nomeacao_posse.dt_posse,
                    local.descricao as filtro_local,
                    contrato_servidor_situacao.situacao
                from
                    sw_cgm inner join sw_cgm_pessoa_fisica on
                    sw_cgm_pessoa_fisica.numcgm = sw_cgm.numcgm inner join sw_municipio on
                    sw_municipio.cod_municipio = sw_cgm.cod_municipio
                    and sw_municipio.cod_uf = sw_cgm.cod_uf inner join sw_uf on
                    sw_uf.cod_uf = sw_municipio.cod_uf inner join sw_pais on
                    sw_pais.cod_pais = sw_uf.cod_pais inner join pessoal.servidor on
                    servidor.numcgm = sw_cgm_pessoa_fisica.numcgm inner join pessoal.servidor_contrato_servidor on
                    servidor_contrato_servidor.cod_servidor = servidor.cod_servidor inner join pessoal.contrato_servidor on
                    contrato_servidor.cod_contrato = servidor_contrato_servidor.cod_contrato inner join pessoal.contrato on
                    contrato.cod_contrato = contrato_servidor.cod_contrato left join sw_escolaridade on
                    sw_escolaridade.cod_escolaridade = sw_cgm_pessoa_fisica.cod_escolaridade left join(
                        select
                            servidor_pis_pasep.dt_pis_pasep,
                            servidor_pis_pasep.cod_servidor
                        from
                            pessoal.servidor_pis_pasep,
                            (
                                select
                                    cod_servidor,
                                    max( timestamp ) as timestamp
                                from
                                    pessoal.servidor_pis_pasep
                                group by
                                    cod_servidor
                            ) as max_servidor_pis_pasep
                        where
                            servidor_pis_pasep.cod_servidor = max_servidor_pis_pasep.cod_servidor
                            and servidor_pis_pasep.timestamp = max_servidor_pis_pasep.timestamp
                    ) as servidor_pis_pasep on
                    servidor_pis_pasep.cod_servidor = servidor.cod_servidor left join pessoal.servidor_reservista on
                    servidor_reservista.cod_servidor = servidor.cod_servidor left join(
                        select
                            servidor_conjuge.cod_servidor,
                            sw_cgm.numcgm as numcgm_conjuge,
                            sw_cgm.nom_cgm as nome_conjuge
                        from
                            pessoal.servidor_conjuge,
                            (
                                select
                                    cod_servidor,
                                    max( timestamp ) as timestamp
                                from
                                    pessoal.servidor_conjuge
                                group by
                                    cod_servidor
                            ) as max_servidor_conjuge,
                            sw_cgm
                        where
                            servidor_conjuge.cod_servidor = max_servidor_conjuge.cod_servidor
                            and servidor_conjuge.timestamp = max_servidor_conjuge.timestamp
                            and servidor_conjuge.numcgm = sw_cgm.numcgm
                    ) as pessoal_servidor_conjuge on
                    pessoal_servidor_conjuge.cod_servidor = servidor.cod_servidor left join(
                        select
                            pessoal.servidor_cid.cod_servidor,
                            pessoal.cid.sigla,
                            pessoal.cid.descricao
                        from
                            pessoal.servidor_cid,
                            (
                                select
                                    cod_servidor,
                                    max( timestamp ) as timestamp
                                from
                                    pessoal.servidor_cid
                                group by
                                    cod_servidor
                            ) as max_servidor_cid,
                            pessoal.cid
                        where
                            servidor_cid.cod_servidor = max_servidor_cid.cod_servidor
                            and servidor_cid.timestamp = max_servidor_cid.timestamp
                            and servidor_cid.cod_cid = cid.cod_cid
                    ) as pessoal_cid on
                    pessoal_cid.cod_servidor = servidor.cod_servidor left join pessoal.contrato_servidor_conselho on
                    contrato_servidor_conselho.cod_contrato = contrato_servidor.cod_contrato left join pessoal.conselho on
                    conselho.cod_conselho = contrato_servidor_conselho.cod_conselho inner join pessoal.contrato_servidor_orgao as pcso on
                    contrato_servidor.cod_contrato = pcso.cod_contrato
                    and pcso.timestamp =(
                        select
                            timestamp
                        from
                            pessoal.contrato_servidor_orgao
                        where
                            cod_contrato = contrato_servidor.cod_contrato
                        order by
                            timestamp desc limit 1
                    ) inner join organograma.orgao on
                    pcso.cod_orgao = orgao.cod_orgao inner join organograma.vw_orgao_nivel on
                    orgao.cod_orgao = vw_orgao_nivel.cod_orgao left join pessoal.contrato_servidor_local on
                    contrato_servidor_local.cod_contrato = contrato_servidor.cod_contrato left join organograma.local as local on
                    contrato_servidor_local.cod_local = local.cod_local left join pessoal.atributo_contrato_servidor_valor on
                    atributo_contrato_servidor_valor.cod_contrato = contrato_servidor.cod_contrato left join administracao.atributo_dinamico on
                    atributo_dinamico.cod_modulo = atributo_contrato_servidor_valor.cod_modulo
                    and atributo_dinamico.cod_cadastro = atributo_contrato_servidor_valor.cod_cadastro
                    and atributo_dinamico.cod_atributo = atributo_contrato_servidor_valor.cod_atributo inner join pessoal.contrato_servidor_padrao on
                    contrato_servidor.cod_contrato = contrato_servidor_padrao.cod_contrato
                    and contrato_servidor_padrao.timestamp =(
                        select
                            timestamp
                        from
                            pessoal.contrato_servidor_padrao
                        where
                            cod_contrato = contrato_servidor.cod_contrato
                        order by
                            timestamp desc limit 1
                    ) inner join pessoal.contrato_servidor_situacao on
                    contrato_servidor.cod_contrato = contrato_servidor_situacao.cod_contrato
                    and contrato_servidor_situacao.timestamp =(
                        select
                            timestamp
                        from
                            pessoal.contrato_servidor_situacao
                        where
                            cod_contrato = contrato_servidor.cod_contrato
                        order by
                            timestamp desc limit 1
                    ) inner join pessoal.contrato_servidor_forma_pagamento on
                    contrato_servidor_forma_pagamento.cod_contrato = contrato_servidor.cod_contrato inner join pessoal.contrato_servidor_nomeacao_posse on
                    contrato_servidor_nomeacao_posse.cod_contrato = contrato_servidor.cod_contrato
                    and contrato_servidor_nomeacao_posse.timestamp =(
                        select
                            max( timestamp )
                        from
                            pessoal.contrato_servidor_nomeacao_posse as csnp
                        where
                            csnp.cod_contrato = contrato_servidor_nomeacao_posse.cod_contrato
                    ) inner join sw_categoria_habilitacao on
                    sw_categoria_habilitacao.cod_categoria = sw_cgm_pessoa_fisica.cod_categoria_cnh                     
                    ".$where;

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    /**
     * @param $filtro
     * @return array
     */
    public function getRelatorioServidor2($filtro)
    {
        $where = "and cgm.numcgm = ".$filtro['numcgm']." and pc.registro = ".$filtro['registro'];

        $sql = "select
                    pcs.*,
                    ps.cod_servidor,
                    pc.registro,
                    cgm.nom_cgm as servidor,
                    cgm.numcgm,
                    orgao.cod_orgao,
                    recuperaDescricaoOrgao(
                        orgao.cod_orgao,
                        '".$filtro['exercicio']."-01-01'
                    ) as lotacao,
                    vw_orgao_nivel.orgao,
                    cargo.cod_cargo,
                    cargo.descricao as cargo,
                    esp.descricao as esp_cargo,
                    cargo_funcao.cod_cargo as cod_funcao,
                    cargo_funcao.descricao as funcao,
                    to_char(
                        funcao.vigencia,
                        'dd/mm/yyyy'
                    ) as dt_alteracao_funcao,
                    espf.descricao as esp_funcao,
                    local.cod_local || ' - ' || local.descricao as local,
                    pcsl.cod_local,
                    to_char(
                        posse.dt_posse,
                        'dd/mm/yyyy'
                    ) as dt_posse,
                    to_char(
                        posse.dt_nomeacao,
                        'dd/mm/yyyy'
                    ) as dt_nomeacao,
                    to_char(
                        posse.dt_admissao,
                        'dd/mm/yyyy'
                    ) as dt_admissao,
                    pcsp.cod_padrao,
                    recuperarSituacaoDoContratoLiteral(
                        pc.cod_contrato,
                        0,
                        ''
                    ) as situacao,
                    forma_pagamento.cod_forma_pagamento
                from
                    pessoal.servidor_contrato_servidor as psc inner join pessoal.servidor as ps on
                    psc.cod_servidor = ps.cod_servidor inner join pessoal.contrato_servidor as pcs on
                    pcs.cod_contrato = psc.cod_contrato inner join pessoal.contrato_servidor_forma_pagamento on
                    contrato_servidor_forma_pagamento.cod_contrato = pcs.cod_contrato
                    and contrato_servidor_forma_pagamento.timestamp =(
                        select
                            max( timestamp )
                        from
                            pessoal.contrato_servidor_forma_pagamento
                        where
                            cod_contrato = pcs.cod_contrato
                    ) inner join pessoal.forma_pagamento on
                    forma_pagamento.cod_forma_pagamento = contrato_servidor_forma_pagamento.cod_forma_pagamento inner join pessoal.contrato as pc on
                    pcs.cod_contrato = pc.cod_contrato inner join sw_cgm_pessoa_fisica as pf on
                    ps.numcgm = pf.numcgm inner join sw_cgm as cgm on
                    pf.numcgm = cgm.numcgm inner join pessoal.contrato_servidor_nomeacao_posse as posse on
                    pcs.cod_contrato = posse.cod_contrato
                    and posse.timestamp =(
                        select
                            timestamp
                        from
                            pessoal.contrato_servidor_nomeacao_posse
                        where
                            cod_contrato = pcs.cod_contrato
                        order by
                            timestamp desc limit 1
                    ) inner join pessoal.contrato_servidor_funcao as funcao on
                    pcs.cod_contrato = funcao.cod_contrato
                    and funcao.timestamp =(
                        select
                            timestamp
                        from
                            pessoal.contrato_servidor_funcao
                        where
                            cod_contrato = pcs.cod_contrato
                        order by
                            timestamp desc limit 1
                    ) inner join pessoal.cargo as cargo_funcao on
                    funcao.cod_cargo = cargo_funcao.cod_cargo left join pessoal.contrato_servidor_especialidade_cargo as esp_cargo on
                    pcs.cod_contrato = esp_cargo.cod_contrato left join pessoal.especialidade as esp on
                    esp_cargo.cod_especialidade = esp.cod_especialidade left join pessoal.cargo as cargo on
                    pcs.cod_cargo = cargo.cod_cargo left join pessoal.contrato_servidor_local as pcsl on
                    pcs.cod_contrato = pcsl.cod_contrato
                    and pcsl.timestamp =(
                        select
                            timestamp
                        from
                            pessoal.contrato_servidor_local
                        where
                            cod_contrato = pcs.cod_contrato
                        order by
                            timestamp desc limit 1
                    ) left join organograma.local as local on
                    pcsl.cod_local = local.cod_local left join pessoal.contrato_servidor_padrao as pcsp on
                    pcs.cod_contrato = pcsp.cod_contrato
                    and pcsp.timestamp =(
                        select
                            timestamp
                        from
                            pessoal.contrato_servidor_padrao
                        where
                            cod_contrato = pcs.cod_contrato
                        order by
                            timestamp desc limit 1
                    ) left join pessoal.contrato_servidor_especialidade_funcao as esp_funcao on
                    pcs.cod_contrato = esp_funcao.cod_contrato
                    and esp_funcao.timestamp =(
                        select
                            timestamp
                        from
                            pessoal.contrato_servidor_especialidade_funcao
                        where
                            cod_contrato = pcs.cod_contrato
                        order by
                            timestamp desc limit 1
                    ) left join pessoal.especialidade as espf on
                    esp_funcao.cod_especialidade = espf.cod_especialidade inner join pessoal.contrato_servidor_orgao as pcso on
                    pcs.cod_contrato = pcso.cod_contrato
                    and pcso.timestamp =(
                        select
                            timestamp
                        from
                            pessoal.contrato_servidor_orgao
                        where
                            cod_contrato = pcs.cod_contrato
                        order by
                            timestamp desc limit 1
                    ) inner join organograma.orgao on
                    pcso.cod_orgao = orgao.cod_orgao inner join organograma.orgao_nivel on
                    orgao.cod_orgao = orgao_nivel.cod_orgao inner join organograma.nivel on
                    orgao_nivel.cod_nivel = nivel.cod_nivel
                    and orgao_nivel.cod_organograma = nivel.cod_organograma inner join organograma.organograma on
                    nivel.cod_organograma = organograma.cod_organograma inner join organograma.vw_orgao_nivel on
                    orgao.cod_orgao = vw_orgao_nivel.cod_orgao
                    and organograma.cod_organograma = vw_orgao_nivel.cod_organograma
                    and nivel.cod_nivel = vw_orgao_nivel.nivel
                where
                    1 = 1                
                    ".$where."
                order by
                    servidor";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    /**
     * @param $filtro
     * @return array
     */
    public function getDependentesServidor($filtro)
    {
        $sql = "select
                    PD.*,
                    PS.cod_servidor,
                    to_char(
                        PD.dt_inicio_sal_familia,
                        'dd/mm/yyyy'
                    ) as dt_inicio_sal_familia,
                    PDC.cod_cid,
                    sw_cgm.nom_cgm,
                    case
                        when sw_cgm_pessoa_fisica.sexo = 'f' then 'Feminino'
                        else 'Masculino'
                    end as sexo,
                    to_char(
                        sw_cgm_pessoa_fisica.dt_nascimento,
                        'dd/mm/yyyy'
                    ) as dt_nascimento,
                    vinculo_irrf.descricao as descricao_vinculo,
                    cid.descricao as descricao_cid,
                    sw_escolaridade.descricao as escolaridade
                from
                    pessoal.servidor PS,
                    pessoal.servidor_dependente PSD,
                    folhapagamento.vinculo_irrf,
                    pessoal.dependente PD left join pessoal.dependente_cid as PDC on
                    (
                        PD.cod_dependente = PDC.cod_dependente
                    ) left join pessoal.cid on
                    (
                        PDC.cod_cid = cid.cod_cid
                    ) left join sw_cgm on
                    PD.numcgm = sw_cgm.numcgm left join sw_cgm_pessoa_fisica on
                    PD.numcgm = sw_cgm_pessoa_fisica.numcgm left join sw_escolaridade on
                    sw_escolaridade.cod_escolaridade = sw_cgm_pessoa_fisica.cod_escolaridade
                where
                    PS.cod_servidor = PSD.cod_servidor
                    and PSD.cod_dependente = PD.cod_dependente
                    and PD.cod_vinculo = vinculo_irrf.cod_vinculo
                    and PSD.cod_dependente::varchar || PSD.cod_servidor::varchar not in(
                        select
                            cod_dependente::varchar || cod_servidor::varchar
                        from
                            pessoal.dependente_excluido
                    )
                    and PS.cod_servidor = ".$filtro['codServidor']."
                order by
                    nom_cgm";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }
}
