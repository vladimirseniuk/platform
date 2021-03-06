<?php

namespace Oro\Bundle\ApiBundle\Tests\Unit\Collection\QueryVisitorExpression;

use Doctrine\Common\Collections\Expr\Comparison;
use Doctrine\ORM\Query\Expr\Comparison as OrmComparison;
use Doctrine\ORM\Query\Parameter;
use Oro\Bundle\ApiBundle\Collection\QueryExpressionVisitor;
use Oro\Bundle\ApiBundle\Collection\QueryVisitorExpression\ContainsComparisonExpression;

class ContainsComparisonExpressionTest extends \PHPUnit_Framework_TestCase
{
    public function testWalkComparisonExpression()
    {
        $expression = new ContainsComparisonExpression();
        $expressionVisitor = new QueryExpressionVisitor();
        $comparison = new Comparison('test', 'CONTAINS', 'text');
        $fieldName = 'a.test';
        $parameterName = 'test_2';

        $result = $expression->walkComparisonExpression(
            $expressionVisitor,
            $comparison,
            $fieldName,
            $parameterName
        );

        $this->assertEquals(
            new OrmComparison('a.test', 'LIKE', ':test_2'),
            $result
        );

        $this->assertEquals(
            [new Parameter('test_2', '%text%', \PDO::PARAM_STR)],
            $expressionVisitor->getParameters()
        );
    }
}
