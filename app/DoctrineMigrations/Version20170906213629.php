<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170906213629 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('CREATE OR REPLACE FUNCTION arrecadacao.buscavinculolancamento(integer)
 RETURNS character varying
 LANGUAGE plpgsql
AS $function$
DECLARE
    inCodLancamento ALIAS FOR $1;   
    inExercicio     integer;
    inCalculo       integer;
    inGrupo         integer;
    stDesc          varchar;
BEGIN

    SELECT
        max(cod_calculo)             
    INTO
        inCalculo
    FROM 
        arrecadacao.lancamento_calculo
    WHERE 
        cod_lancamento = inCodLancamento; 

    SELECT 
        cod_grupo
    INTO 
        inGrupo    
    FROM 
        arrecadacao.calculo_grupo_credito
    WHERE 
        cod_calculo = inCalculo;

    if ( inGrupo is not null )  then
        select  cod_grupo||\' - \'||descricao||\'/\'||ano_exercicio
        into    stDesc 
        from    arrecadacao.grupo_credito
        where   cod_grupo = inGrupo;
    else
        select  descricao_credito
        into    stDesc
        from    monetario.credito
        where   (cod_credito,cod_especie,cod_genero, cod_natureza)
        in      ( select    cod_credito,cod_especie,cod_genero, cod_natureza 
                  from      arrecadacao.calculo 
                  where     cod_calculo = inCalculo);
    end if;
    
 
    return stDesc; 
END;
$function$;');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
