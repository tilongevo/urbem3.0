<?php

namespace Urbem\CoreBundle\Repository\Administracao;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class ModeloArquivosDocumentoRepository
 * @package Urbem\CoreBundle\Repository\Administracao
 */
class ModeloArquivosDocumentoRepository extends AbstractRepository
{
    /**
     * @param $codTipoDocumento
     * @return mixed
     */
    public function getModeloArqDocumento($codTipoDocumento, $alvarasDisponiveis)
    {
        $sql = 'SELECT model.cod_documento, ad.cod_arquivo, ad.nome_arquivo_swx 
                FROM administracao.modelo_documento model
                INNER JOIN administracao.modelo_arquivos_documento model_arq
                ON model.cod_documento = model_arq.cod_documento
                INNER JOIN administracao.arquivos_documento ad
                ON  model_arq.cod_arquivo = ad.cod_arquivo
                WHERE model.cod_tipo_documento = :cod
                AND model.nome_documento = :alvaraAtividade OR model.nome_documento = :alvaraSanitario
                GROUP BY model.cod_documento, ad.cod_arquivo, ad.nome_arquivo_swx 
                ORDER BY model.cod_documento ASC ';
        $q = $this->_em->getConnection()->prepare($sql);
        $q->bindValue('cod', $codTipoDocumento);
        $q->bindValue('alvaraAtividade', $alvarasDisponiveis['atividade']);
        $q->bindValue('alvaraSanitario', $alvarasDisponiveis['sanitario']);
        $q->execute();
        return $q->fetchAll();
    }

    /**
     * @param $codArquivo
     * @return array
     */
    public function getModeloArqDocumentoByCodArquivo($codArquivo)
    {
        $sql = 'SELECT  m.cod_arquivo, ac.nome_arquivo_swx
                FROM administracao.modelo_arquivos_documento m
                INNER JOIN administracao.arquivos_documento ac
                ON m.cod_arquivo = ac.cod_arquivo
                WHERE ac.cod_arquivo = :cod
                GROUP BY m.cod_documento, m.cod_arquivo, ac.nome_arquivo_swx
                ORDER BY m.cod_documento ASC ';
        $q = $this->_em->getConnection()->prepare($sql);
        $q->bindValue('cod', $codArquivo);
        $q->execute();
        return $q->fetchAll();
    }
}
