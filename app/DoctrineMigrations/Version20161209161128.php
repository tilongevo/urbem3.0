<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161209161128 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->createView('orcamento.registros_metas_arrecadacao_receita', 'select
      CR.mascara_classificacao,
      CR.descricao,
      O.cod_receita, O.cod_conta, O.cod_recurso, O.dt_criacao, O.vl_original, O.credito_tributario, O.exercicio, O.cod_entidade,
      row_number() OVER () as rnum
    from
      orcamento.vw_classificacao_receita as CR,
      orcamento.receita as O
    where
      CR.exercicio is not null
      and O.cod_conta = CR.cod_conta
      and O.exercicio = CR.exercicio
    order by
      O.cod_receita');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->dropView('orcamento.registros_metas_arrecadacao_receita');
    }
}
