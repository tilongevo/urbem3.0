<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento;

use Doctrine\ORM;

class ConfiguracaoEmpenhoLlaLotacaoRepository extends ORM\EntityRepository
{
    public function updateCodConfiguracaoLla($configuracaoEmpenhoLla, $object)
    {
        $sql = sprintf(
            "UPDATE folhapagamento.configuracao_empenho_lla_lotacao
            SET cod_configuracao_lla = %d
            WHERE cod_config_empenho = '%s' AND cod_orgao = %d AND exercicio= '%s'",
            $configuracaoEmpenhoLla->getCodConfiguracaoLla(),
            $object->getCodConfigEmpenho(),
            $object->getCodOrgao()->getCodOrgao(),
            $object->getExercicio()
        );

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();
        return $query->fetchAll();
    }
}
