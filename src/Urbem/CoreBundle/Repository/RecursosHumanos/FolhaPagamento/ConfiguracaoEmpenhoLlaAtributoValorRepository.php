<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento;

use Doctrine\ORM;

class ConfiguracaoEmpenhoLlaAtributoValorRepository extends ORM\EntityRepository
{
    public function updateCodConfiguracaoLla($configuracaoEmpenhoLla, $object)
    {
        $sql = sprintf(
            "UPDATE folhapagamento.configuracao_empenho_lla_atributo_valor
            SET cod_configuracao_lla = %d
            WHERE cod_config_empenho = '%s' AND cod_atributo = %d AND exercicio= '%s'",
            $configuracaoEmpenhoLla->getCodConfiguracaoLla(),
            $object->getCodConfigEmpenho(),
            $object->getCodAtributo(),
            $object->getExercicio()
        );

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();
        return $query->fetchAll();
    }
}
