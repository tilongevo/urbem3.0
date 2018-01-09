<?php

namespace Urbem\CoreBundle\Customize\Doctrine\DQL;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\SqlWalker;

/**
 * Class Lpad
 */
class Lpad extends FunctionNode
{
    /** @var null|string */
    public $string = null;

    /** @var null|string */
    public $length = null;

    /** @var null|string */
    public $padstring = null;

    /**
     * @param Parser $parser
     * @return void
     */
    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->string = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->length = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->padstring = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    /**
     * @param SqlWalker $sqlWalker
     * @return string
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        return 'LPAD(' .
            $this->string->dispatch($sqlWalker) . ', ' .
            $this->length->dispatch($sqlWalker) . ', ' .
            $this->padstring->dispatch($sqlWalker) . ')';
    }
}
