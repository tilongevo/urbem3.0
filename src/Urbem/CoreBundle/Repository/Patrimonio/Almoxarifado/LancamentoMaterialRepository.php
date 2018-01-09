<?php

namespace Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado;

use Doctrine\ORM;

/**
 * @ORM\Entity(repositoryClass="Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial")
 */
class LancamentoMaterialRepository extends ORM\EntityRepository
{
    /**
     * @param $codItem
     * @param $codMarca
     * @param $codAlmoxarifado
     * @param $codCentro
     * @return array
     */
    public function getMovimentacaoEstoque($codItem, $codMarca, $codAlmoxarifado, $codCentro)
    {
        $sql = "
            select atributo_estoque_material_valor.valor                                                   
                , alm.cod_lancamento                                                                      
                , alm.cod_item                                                                            
                , atributo_estoque_material_valor.cod_atributo                                            
                , atributo_dinamico.nom_atributo                                                          
             from almoxarifado.lancamento_material alm                                                    
            left join almoxarifado.atributo_estoque_material_valor                                        
                   on alm.cod_almoxarifado = atributo_estoque_material_valor.cod_almoxarifado             
                  and alm.cod_item = atributo_estoque_material_valor.cod_item                             
                  and alm.cod_centro = atributo_estoque_material_valor.cod_centro                         
                  and alm.cod_marca = atributo_estoque_material_valor.cod_marca                           
                  and alm.cod_lancamento = atributo_estoque_material_valor.cod_lancamento                 
            left join administracao.atributo_dinamico                                                     
                   on atributo_estoque_material_valor.cod_atributo = atributo_dinamico.cod_atributo       
                  and atributo_estoque_material_valor.cod_modulo = atributo_dinamico.cod_modulo           
                  and atributo_estoque_material_valor.cod_cadastro = atributo_dinamico.cod_cadastro       
            where alm.cod_item = :codItem                                          
             and alm.cod_marca = :codMarca                                        
             and alm.cod_almoxarifado = :codAlmoxarifado                           
             and alm.cod_centro = :codCentro                                       
            order by cod_lancamento, nom_atributo         
        ";

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute(
            [
                'codItem' => $codItem,
                'codMarca' => $codMarca,
                'codAlmoxarifado' => $codAlmoxarifado,
                'codCentro' => $codCentro,
            ]
        );

        $result = $stmt->fetchAll();

        return $result;
    }

    /**
     * @return int|mixed
     */
    public function getNextCodLancamento()
    {
        $maxCodLancamento = $this->_em->createQueryBuilder()
            ->select('MAX(l.codLancamento)')
            ->from('CoreBundle:Almoxarifado\LancamentoMaterial', 'l')
            ->getQuery()
            ->getSingleScalarResult();

        if (null != $maxCodLancamento) {
            return $maxCodLancamento + 1;
        }

        return 1;
    }

    /**
     * @param string|integer $codItem
     * @return array
     */
    public function getRestoValor($codItem)
    {
        $sql = <<<SQL
SELECT
  CASE WHEN SUM(quantidade) <> 0 THEN
    SUM(valor_mercado)-TRUNC(TRUNC(SUM(valor_mercado)/SUM(quantidade),2)*SUM(quantidade),2)
  ELSE 0 END AS resto
FROM almoxarifado.lancamento_material
WHERE cod_item = :cod_item
SQL;
        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);

        $stmt->execute([
            'cod_item' => $codItem
        ]);

        return $stmt->fetch();
    }

    /**
     * @param string|integer $codItem
     * @return array
     */
    public function getSaldoValorUnitario($codItem)
    {
        $sql = <<<SQL
SELECT
  CASE WHEN SUM(quantidade) <> 0 THEN
    COALESCE(TRUNC(SUM(valor_mercado) / SUM(quantidade),2),0)
  ELSE 0 END AS valor_unitario
FROM almoxarifado.lancamento_material
WHERE cod_item = :cod_item
SQL;
        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);

        $stmt->execute([
            'cod_item' => $codItem
        ]);

        return $stmt->fetch();
    }
}
