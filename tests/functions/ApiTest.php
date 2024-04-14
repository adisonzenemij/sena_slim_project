<?php
    declare(strict_types = 1);

    namespace MyApp\Tests\Functions;

    use PHPUnit\Framework\TestCase;
    
    use MyApp\Functions\ApiFunction as functionApi;

    class ApiTest extends TestCase {
        /**
         * @covers MyApp\Functions\ApiFunction::queryParams
        */
        public function testQueryParams() : void {
            $params = [
                'token' => 'myToken',
                'table' => 'myTable',
                'column' => 'myColumn',
                'whereCond' => 'myWhereCond',
                'whereField' => 'myWhereField',
                'whereOperator' => 'myWhereOperator',
                'whereEqual' => 'myWhereEqual',
                'orderBy' => 'myOrderBy',
                'orderMode' => 'myOrderMode',
                'limitStart' => 'myLimitStart',
                'limitFinal' => 'myLimitFinal',
                'postData' => 'myPostData',
                'putData' => 'myPutData',
                'deleteData' => 'myDeleteData',
                'dataType' => 'myDataType',
                'htmlSelect' => 'myHtmlSelect',
                'htmlMulti' => 'myHtmlMulti',
                'multiValue' => 'myMultiValue',
            ];
    
            $expectedResult = [
                'token' => 'myToken',
                'table' => 'myTable',
                'column' => 'myColumn',
                'whereCond' => 'myWhereCond',
                'whereField' => 'myWhereField',
                'whereOperator' => 'myWhereOperator',
                'whereEqual' => 'myWhereEqual',
                'orderBy' => 'myOrderBy',
                'orderMode' => 'myOrderMode',
                'limitStart' => 'myLimitStart',
                'limitFinal' => 'myLimitFinal',
                'postData' => 'myPostData',
                'putData' => 'myPutData',
                'deleteData' => 'myDeleteData',
                'dataType' => 'myDataType',
                'htmlSelect' => 'myHtmlSelect',
                'htmlMulti' => 'myHtmlMulti',
                'multiValue' => 'myMultiValue',
            ];
    
            $result = functionApi::queryParams($params);
    
            $this->assertEquals($expectedResult, $result);
        }
    }
