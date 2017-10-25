<?php

namespace jc\DatabaseBundle\SQLFunction;

use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;

/**
 * "POW" "(" SimpleArithmeticExpression ")"
 *
 * @category    DoctrineExtensions
 * @package     DoctrineExtensions\Query\Mysql
 */
class Pow extends FunctionNode
{
    public $base;
    public $pow;

    /**
     * @override
     */
    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return "POW(" . $sqlWalker->walkArithmeticPrimary($this->base) . ", " .  $sqlWalker->walkArithmeticPrimary($this->pow) . ")";
    }

    /**
     * @override
     */
    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->base = $parser->ArithmeticExpression();
        $parser->match(Lexer::T_COMMA);
        $this->pow = $parser->ArithmeticExpression();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
