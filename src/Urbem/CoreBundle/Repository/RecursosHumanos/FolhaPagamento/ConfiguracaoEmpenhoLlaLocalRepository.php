<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento;

use Doctrine\ORM;

class ConfiguracaoEmpenhoLlaLocalRepository extends ORM\EntityRepository
{
    public function updateCodConfiguracaoLla($configuracaoEmpenhoLla, $object)
    {
        $sql = sprintf(
            "UPDATE folhapagamento.configuracao_empenho_lla_local
            SET cod_configuracao_lla = %d
            WHERE cod_config_empenho = '%s' AND cod_local = %d AND exercicio= '%s'",
            $configuracaoEmpenhoLla->getCodConfiguracaoLla(),
            $object->getCodConfigEmpenho(),
            $object->getCodLocal()->getCodLocal(),
            $object->getExercicio()
        );

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();
        return $query->fetchAll();
    }
}
