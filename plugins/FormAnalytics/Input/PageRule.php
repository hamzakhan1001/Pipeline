<?php

/**
 * Copyright (C) InnoCraft Ltd - All rights reserved.
 *
 * NOTICE:  All information contained herein is, and remains the property of InnoCraft Ltd.
 * The intellectual and technical concepts contained herein are protected by trade secret or copyright law.
 * Redistribution of this information or reproduction of this material is strictly forbidden
 * unless prior written permission is obtained from InnoCraft Ltd.
 *
 * You shall use this code only in accordance with the license agreement obtained from InnoCraft Ltd.
 *
 * @link https://www.innocraft.com/
 * @license For license details see https://www.innocraft.com/license
 */

namespace Piwik\Plugins\FormAnalytics\Input;

use Piwik\Plugins\FormAnalytics\Tracker\RuleMatcher as RuleForm;

class PageRule extends Rule
{
    public function __construct($titlePlural, $rule, $index)
    {
        parent::__construct($titlePlural, $rule, $index);
        $this->allowedAttributes = array(RuleForm::ATTRIBUTE_URL, RuleForm::ATTRIBUTE_PATH, RuleForm::ATTRIBUTE_QUERY);
    }
}
