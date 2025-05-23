<?php

/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */
namespace Matomo\Dependencies\SearchEngineKeywordsPerformance\Google\Service\SearchConsole;

class ApiDimensionFilter extends \Matomo\Dependencies\SearchEngineKeywordsPerformance\Google\Model
{
    public $dimension;
    public $expression;
    public $operator;
    public function setDimension($dimension)
    {
        $this->dimension = $dimension;
    }
    public function getDimension()
    {
        return $this->dimension;
    }
    public function setExpression($expression)
    {
        $this->expression = $expression;
    }
    public function getExpression()
    {
        return $this->expression;
    }
    public function setOperator($operator)
    {
        $this->operator = $operator;
    }
    public function getOperator()
    {
        return $this->operator;
    }
}
// Adding a class alias for backwards compatibility with the previous class name.
class_alias(ApiDimensionFilter::class, 'Matomo\\Dependencies\\SearchEngineKeywordsPerformance\\Google_Service_SearchConsole_ApiDimensionFilter');
