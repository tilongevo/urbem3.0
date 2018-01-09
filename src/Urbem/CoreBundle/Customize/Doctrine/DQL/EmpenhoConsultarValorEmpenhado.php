<?php

namespace Urbem\CoreBundle\Customize\Doctrine\DQL;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

class EmpenhoConsultarValorEmpenhado extends FunctionNode
{
    private $empenho_PreEmpenho_exercicio;
    private $empenho_Empenho_codEmpenho;
    private $empenho_Empenho_codEntidade;

    /**
     * @param SqlWalker $sqlWalker
     * @return string
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        return sprintf(
            "empenho.fn_consultar_valor_empenhado(%s, %s, %s)",
            $this->empenho_PreEmpenho_exercicio->dispatch($sqlWalker),
            $this->empenho_Empenho_codEmpenho->dispatch($sqlWalker),
            $this->empenho_Empenho_codEntidade->dispatch($sqlWalker)
        );
    }

    /**
     * @param Parser $parser
     * @return void
     */
    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->empenho_PreEmpenho_exercicio = $parser->StringPrimary();

        $parser->match(Lexer::T_COMMA);
        $this->empenho_Empenho_codEmpenho = $parser->StringPrimary();

        $parser->match(Lexer::T_COMMA);
        $this->empenho_Empenho_codEntidade = $parser->StringPrimary();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
