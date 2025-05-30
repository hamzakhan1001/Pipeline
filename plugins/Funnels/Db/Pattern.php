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

namespace Piwik\Plugins\Funnels\Db;

use Piwik\Common;
use Piwik\Date;
use Piwik\Db;
use Piwik\Piwik;
use Piwik\Plugin;
use Piwik\Tracker\Action;
use Piwik\Tracker\PageUrl;

class Pattern
{
    public const TYPE_URL_CONTAINS = 'url_contains';
    public const TYPE_URL_EQUALS = 'url_equals';
    public const TYPE_URL_REGEXP = 'url_regexp';
    public const TYPE_URL_STARTS_WITH = 'url_startswith';
    public const TYPE_URL_ENDS_WITH = 'url_endswith';

    public const TYPE_PATH_CONTAINS = 'path_contains';
    public const TYPE_PATH_STARTS_WITH = 'path_startswith';
    public const TYPE_PATH_ENDS_WITH = 'path_endswith';
    public const TYPE_PATH_EQUALS = 'path_equals';
    public const TYPE_PATH_REGEXP = 'path_regexp';

    public const TYPE_PAGE_TITLE_CONTAINS = 'pagetitle_contains';
    public const TYPE_PAGE_TITLE_STARTS_WITH = 'pagetitle_startswith';
    public const TYPE_PAGE_TITLE_ENDS_WITH = 'pagetitle_endswith';
    public const TYPE_PAGE_TITLE_EQUALS = 'pagetitle_equals';
    public const TYPE_PAGE_TITLE_REGEXP = 'pagetitle_regexp';

    public const TYPE_EVENT_CATEGORY_CONTAINS = 'eventcategory_contains';
    public const TYPE_EVENT_CATEGORY_STARTS_WITH = 'eventcategory_startswith';
    public const TYPE_EVENT_CATEGORY_ENDS_WITH = 'eventcategory_endswith';
    public const TYPE_EVENT_CATEGORY_EQUALS = 'eventcategory_equals';
    public const TYPE_EVENT_CATEGORY_REGEXP = 'eventcategory_regexp';

    public const TYPE_EVENT_NAME_CONTAINS = 'eventname_contains';
    public const TYPE_EVENT_NAME_STARTS_WITH = 'eventname_startswith';
    public const TYPE_EVENT_NAME_ENDS_WITH = 'eventname_endswith';
    public const TYPE_EVENT_NAME_EQUALS = 'eventname_equals';
    public const TYPE_EVENT_NAME_REGEXP = 'eventname_regexp';

    public const TYPE_EVENT_ACTION_CONTAINS = 'eventaction_contains';
    public const TYPE_EVENT_ACTION_STARTS_WITH = 'eventaction_startswith';
    public const TYPE_EVENT_ACTION_ENDS_WITH = 'eventaction_endswith';
    public const TYPE_EVENT_ACTION_EQUALS = 'eventaction_equals';
    public const TYPE_EVENT_ACTION_REGEXP = 'eventaction_regexp';

    public const TYPE_QUERY_CONTAINS = 'query_contains';

    public const TYPE_GOAL_EQUALS = 'goal_equals';

    public static function getSupportedPatterns()
    {
        $url = Piwik::translate('Funnels_PatternAttributeURL');
        $path = Piwik::translate('Funnels_PatternAttributePath');
        $query = Piwik::translate('Funnels_PatternAttributeSearchQuery');
        $pageTitle = Piwik::translate('Goals_PageTitle');
        $eventCategory = Piwik::translate('Events_EventCategory');
        $eventName = Piwik::translate('Events_EventName');
        $eventAction = Piwik::translate('Events_EventAction');
        $goal = Piwik::translate('General_Goal');

        $patterns = [
          'goal' => [
              'comparisonName' => Piwik::translate('Funnels_ComparisonNameGoal'),
              'conditions' => [
                  [
                      'key' => self::TYPE_GOAL_EQUALS,
                      'value' => Piwik::translate('Funnels_ConditionEquals'),
                      'example' => '4'
                  ],
              ]
          ],
            'url' => [
                'comparisonName' => Piwik::translate('Funnels_ComparisonNameUrl'),
                'conditions' => [
                    [
                        'key' => self::TYPE_URL_EQUALS,
                        'value' => Piwik::translate('Funnels_ConditionEquals'),
                        'example' => 'example.com/cart/web/'
                    ],
                    [
                        'key' => self::TYPE_URL_CONTAINS,
                        'value' => Piwik::translate('Funnels_ConditionContains'),
                        'example' => 'example.com/cart'
                    ],
                    [
                        'key' => self::TYPE_URL_STARTS_WITH,
                        'value' => Piwik::translate('Funnels_ConditionStartsWith'),
                        'example' => 'example.co./cart/'
                    ],
                    [
                        'key' => self::TYPE_URL_ENDS_WITH,
                        'value' => Piwik::translate('Funnels_ConditionEndsWith'),
                        'example' => '/web/'
                    ],
                    [
                        'key' => self::TYPE_URL_REGEXP,
                        'value' => Piwik::translate('Funnels_ConditionMatchesTheExpression'),
                        'example' => '^example.*cart.*'
                    ]
                ]
            ],
            'path' => [
                'comparisonName' => Piwik::translate('Funnels_ComparisonNamePath'),
                'conditions' => [
                    [
                        'key' => self::TYPE_PATH_EQUALS,
                        'value' => Piwik::translate('Funnels_ConditionEquals'),
                        'example' => '/cart/web/'
                    ],
                    [
                        'key' => self::TYPE_PATH_CONTAINS,
                        'value' => Piwik::translate('Funnels_ConditionContains'),
                        'example' => 'cart'
                    ],
                    [
                        'key' => self::TYPE_PATH_STARTS_WITH,
                        'value' => Piwik::translate('Funnels_ConditionStartsWith'),
                        'example' => '/cart/web/'
                    ],
                    [
                        'key' => self::TYPE_PATH_ENDS_WITH,
                        'value' => Piwik::translate('Funnels_ConditionEndsWith'),
                        'example' => '/web/page.html'
                    ]
                ]
            ],
            'query' => [
                'comparisonName' => Piwik::translate('Funnels_ComparisonNameQuery'),
                'conditions' => [
                    [
                        'key' => self::TYPE_QUERY_CONTAINS,
                        'value' => Piwik::translate('Funnels_ConditionContains'),
                        'example' => 'page=cart'
                    ]
                ]
            ],
            'pagetitle' => [
                'comparisonName' => Piwik::translate('Funnels_ComparisonNamePageTitle'),
                'conditions' => [
                    [
                        'key' => self::TYPE_PAGE_TITLE_EQUALS,
                        'value' => Piwik::translate('Funnels_ConditionEquals'),
                        'example' => 'title'
                    ],
                    [
                        'key' => self::TYPE_PAGE_TITLE_CONTAINS,
                        'value' => Piwik::translate('Funnels_ConditionContains'),
                        'example' => 'title'
                    ],
                    [
                        'key' => self::TYPE_PAGE_TITLE_STARTS_WITH,
                        'value' => Piwik::translate('Funnels_ConditionStartsWith'),
                        'example' => 'title'
                    ],
                    [
                        'key' => self::TYPE_PAGE_TITLE_ENDS_WITH,
                        'value' => Piwik::translate('Funnels_ConditionEndsWith'),
                        'example' => 'title'
                    ]
                ]
            ]
        ];

        if (Plugin\Manager::getInstance()->isPluginActivated('Events')) {
            $patterns['eventcategory'] = [
                'comparisonName' => Piwik::translate('Funnels_ComparisonNameEventCategory'),
                'conditions' => [
                    [
                        'key' => self::TYPE_EVENT_CATEGORY_EQUALS,
                        'value' => Piwik::translate('Funnels_ConditionEquals'),
                        'example' => 'category'
                    ],
                    [
                        'key' => self::TYPE_EVENT_CATEGORY_CONTAINS,
                        'value' => Piwik::translate('Funnels_ConditionContains'),
                        'example' => 'category'
                    ],
                    [
                        'key' => self::TYPE_EVENT_CATEGORY_STARTS_WITH,
                        'value' => Piwik::translate('Funnels_ConditionStartsWith'),
                        'example' => 'category'
                    ],
                    [
                        'key' => self::TYPE_EVENT_CATEGORY_ENDS_WITH,
                        'value' => Piwik::translate('Funnels_ConditionEndsWith'),
                        'example' => 'category'
                    ]
                ]
            ];

            $patterns['eventname'] = [
                'comparisonName' => Piwik::translate('Funnels_ComparisonNameEventName'),
                'conditions' => [
                    [
                        'key' => self::TYPE_EVENT_NAME_EQUALS,
                        'value' => Piwik::translate('Funnels_ConditionEquals'),
                        'example' => 'name'
                    ],
                    [
                        'key' => self::TYPE_EVENT_NAME_CONTAINS,
                        'value' => Piwik::translate('Funnels_ConditionContains'),
                        'example' => 'name'
                    ],
                    [
                        'key' => self::TYPE_EVENT_NAME_STARTS_WITH,
                        'value' => Piwik::translate('Funnels_ConditionStartsWith'),
                        'example' => 'name'
                    ],
                    [
                        'key' => self::TYPE_EVENT_NAME_ENDS_WITH,
                        'value' => Piwik::translate('Funnels_ConditionEndsWith'),
                        'example' => 'name'
                    ]
                ]
            ];

            $patterns['eventaction'] = [
                'comparisonName' => Piwik::translate('Funnels_ComparisonNameEventAction'),
                'conditions' => [
                    [
                        'key' => self::TYPE_EVENT_ACTION_EQUALS,
                        'value' => Piwik::translate('Funnels_ConditionEquals'),
                        'example' => 'action'
                    ],
                    [
                        'key' => self::TYPE_EVENT_ACTION_CONTAINS,
                        'value' => Piwik::translate('Funnels_ConditionContains'),
                        'example' => 'action'
                    ],
                    [
                        'key' => self::TYPE_EVENT_ACTION_STARTS_WITH,
                        'value' => Piwik::translate('Funnels_ConditionStartsWith'),
                        'example' => 'action'
                    ],
                    [
                        'key' => self::TYPE_EVENT_ACTION_ENDS_WITH,
                        'value' => Piwik::translate('Funnels_ConditionEndsWith'),
                        'example' => 'action'
                    ]
                ]
            ];
        }
        return $patterns;
    }

    public static function getTranslationsForPatternTypes()
    {
        $patterns = Pattern::getSupportedPatterns();

        $translations = array();
        foreach ($patterns as $pattern) {
            if (!empty($pattern['conditions'])) {
                foreach ($pattern['conditions'] as $condition) {
                    $translations[$condition['key']] = $pattern['comparisonName'] . ' ' . $condition['value'];
                }
            }
        }

        return $translations;
    }

    public static function isSupportedPatternType($type)
    {
        $supported = self::getSupportedPatternTypes();

        return in_array($type, $supported, $strict = true);
    }

    public static function getSupportedPatternTypes()
    {
        $supported = self::getSupportedPatterns();

        $allowed = array();
        foreach ($supported as $pattern) {
            if (!empty($pattern['conditions'])) {
                foreach ($pattern['conditions'] as $condition) {
                    $allowed[] = $condition['key'];
                }
            }
        }

        return $allowed;
    }

    private function esacpePatternForLike($pattern)
    {
        return str_replace(array('%', '_'), array('\%', '\_'), $pattern);
    }

    public function findMatchingUrls($patternType, $pattern, $idSite, $limit = 50)
    {
        $actionTable = Common::prefixTable('log_action');
        $visitActionTable = Common::prefixTable('log_link_visit_action');

        $dbColInfo = $this->getActionTypeAndColumnName($patternType);
        $actionType = (int) $dbColInfo['actionType'];
        $actionColumn = $dbColInfo['actionColumn'];

        $pattern = $this->getMysqlQuery('`name`', $patternType, $pattern);
        $query = $pattern['query'];
        $bind = array($pattern['bind']);

        // we only check for recently visited urls
        $fromDateTime = Date::now()->subDay(60)->getDatetime();

        $sql = "SELECT distinct `log_action`.`name` 
                FROM $actionTable log_action 
                LEFT JOIN $visitActionTable log_link 
                  ON log_link." . $actionColumn . " = log_action.idaction
                WHERE $query AND `log_action`.`type` = $actionType
                     AND log_link.idsite = ?
                     AND log_link.server_time >= ?
                LIMIT " . (int) $limit;

        $bind[] = $idSite;
        $bind[] = $fromDateTime;

        $rows = Db::fetchAll($sql, $bind);

        $urls = array();
        foreach ($rows as $row) {
            $urls[] = $row['name'];
        }

        return array_unique($urls);
    }

    public function isValidPattern($patternType, $pattern)
    {
        if (
            $patternType === self::TYPE_URL_REGEXP
            || $patternType === self::TYPE_PATH_REGEXP
            || $patternType === self::TYPE_EVENT_ACTION_REGEXP
            || $patternType === self::TYPE_EVENT_CATEGORY_REGEXP
            || $patternType === self::TYPE_EVENT_NAME_REGEXP
            || $patternType === self::TYPE_PAGE_TITLE_REGEXP
            || strpos($patternType, 'regexp') !== false
        ) {
            try {
                $this->matchesUrl('https://www.example.com', $patternType, $pattern);
                return true;
            } catch (\Exception $e) {
                // if a mysql error occurs, the pattern must be wrong
                return false;
            }
        }

        if ($patternType === self::TYPE_GOAL_EQUALS) {
            return (is_int($pattern) || ctype_digit($pattern)) && $pattern > 0;
        }
        return true;
    }

    public function matchesUrl($url, $patternType, $pattern)
    {
        $url = $this->removeUrlPrefix($url);
        $column = '$$$COLUMN$$$';

        $pattern = $this->getMysqlQuery($column, $patternType, $pattern);
        $query = $pattern['query'];

        $bind = array();
        $count = substr_count($query, $column);
        for ($i = 0; $i < $count; $i++) {
            $bind[] = $url;
        }

        $query = str_replace($column, '?', $query); // replace all occurences of $column with ? so we can bind the value

        $bind[] = $pattern['bind'];

        $sql = "SELECT if($query,1,0)";

        $matches = Db::fetchOne($sql, $bind);

        return !empty($matches);
    }

    protected function removeUrlPrefix($url)
    {
        foreach (PageUrl::$urlPrefixMap as $prefix => $v) {
            $pos = strpos($url, $prefix);
            if ($pos === 0) {
                return substr($url, strlen($prefix));
            }
        }

        return $url;
    }

    public function getActionTypeAndColumnName($patternType)
    {
        $actionType = Action::TYPE_PAGE_URL;
        $column = 'idaction_url';

        if (strpos($patternType, 'eventcategory') === 0) {
            $actionType = Action::TYPE_EVENT_CATEGORY;
            $column = 'idaction_event_category';
        } elseif (strpos($patternType, 'eventaction') === 0) {
            $actionType = Action::TYPE_EVENT_ACTION;
            $column = 'idaction_event_action';
        } elseif (strpos($patternType, 'eventname') === 0) {
            $actionType = Action::TYPE_EVENT_NAME;
            $column = 'idaction_name';
        } elseif (strpos($patternType, 'pagetitle') === 0) {
            $actionType = Action::TYPE_PAGE_TITLE;
            $column = 'idaction_name';
        }

        return array(
            'actionType' => (int) $actionType,
            'actionColumn' => $column
        );
    }

    public function getMysqlQuery($column, $patternType, $pattern)
    {
        $operator = '';

        switch ($patternType) {
            case self::TYPE_PAGE_TITLE_CONTAINS:
            case self::TYPE_EVENT_CATEGORY_CONTAINS:
            case self::TYPE_EVENT_NAME_CONTAINS:
            case self::TYPE_EVENT_ACTION_CONTAINS:
                $operator = $column . ' LIKE ?';
                $pattern = '%' . $this->esacpePatternForLike($pattern) . '%';
                break;
            case self::TYPE_PAGE_TITLE_STARTS_WITH:
            case self::TYPE_EVENT_CATEGORY_STARTS_WITH:
            case self::TYPE_EVENT_NAME_STARTS_WITH:
            case self::TYPE_EVENT_ACTION_STARTS_WITH:
                $operator = $column . ' LIKE ?';
                $pattern = $this->esacpePatternForLike($pattern) . '%';
                break;
            case self::TYPE_PAGE_TITLE_ENDS_WITH:
            case self::TYPE_EVENT_CATEGORY_ENDS_WITH:
            case self::TYPE_EVENT_NAME_ENDS_WITH:
            case self::TYPE_EVENT_ACTION_ENDS_WITH:
                $operator = $column . ' LIKE ?';
                $pattern = '%' . $this->esacpePatternForLike($pattern);
                break;
            case self::TYPE_PAGE_TITLE_EQUALS:
            case self::TYPE_EVENT_CATEGORY_EQUALS:
            case self::TYPE_EVENT_NAME_EQUALS:
            case self::TYPE_EVENT_ACTION_EQUALS:
                $operator = $column . ' = ?';
                break;
            case self::TYPE_PAGE_TITLE_REGEXP:
            case self::TYPE_EVENT_CATEGORY_REGEXP:
            case self::TYPE_EVENT_NAME_REGEXP:
            case self::TYPE_EVENT_ACTION_REGEXP:
                $operator = $column . ' REGEXP ?';
                break;
        }

        if (!empty($operator)) {
            return array(
                'query' => $operator,
                'bind' => $pattern
            );
        }

        $pathName = "SUBSTR(SUBSTRING_INDEX(SUBSTRING_INDEX($column, '#', 1), '?', 1), LOCATE('/', $column))";
        $queryName = "SUBSTR(SUBSTRING_INDEX($column, '#', 1), LOCATE('?', $column))";
        $patternWithoutUrlPrefix = $this->removeUrlPrefix($pattern);

        if ($patternType === self::TYPE_PATH_CONTAINS) {
            $operator = $pathName . ' LIKE ?';
            $pattern = rtrim($pattern, '/');
            $pattern = '%' . $this->esacpePatternForLike($pattern) . '%';
        } elseif ($patternType === self::TYPE_PATH_STARTS_WITH) {
            $operator = "TRIM(BOTH '/' FROM " . $pathName . ') LIKE ?';
            $pattern = $this->esacpePatternForLike(trim($pattern, '/')) . '%';
        } elseif ($patternType === self::TYPE_PATH_ENDS_WITH) {
            $operator = "TRIM(TRAILING '/' FROM " . $pathName . ') LIKE ?';
            $pattern = '%' . $this->esacpePatternForLike(rtrim($pattern, '/'));
        } elseif ($patternType === self::TYPE_PATH_EQUALS) {
            $operator = "TRIM(BOTH '/' FROM " . $pathName . ') = ?';
            $pattern = trim($pattern, '/');
        } elseif ($patternType === self::TYPE_QUERY_CONTAINS) {
            $operator = $queryName . ' LIKE ?';
            $pattern = '%' . $this->esacpePatternForLike($pattern) . '%';
        } elseif ($patternType === self::TYPE_URL_STARTS_WITH) {
            // no leading trimming needed, always has to start with domain
            $operator = "TRIM(TRAILING '/' FROM " . $column . ') LIKE ?';
            $pattern = $this->esacpePatternForLike(rtrim($patternWithoutUrlPrefix, '/')) . '%';
        } elseif ($patternType === self::TYPE_URL_ENDS_WITH) {
            $operator = "TRIM(TRAILING '/' FROM " . $column . ') LIKE ?';
            $pattern = '%' . $this->esacpePatternForLike(rtrim($patternWithoutUrlPrefix, '/'));
        } elseif ($patternType === self::TYPE_URL_CONTAINS) {
            $operator = $column . ' LIKE ?';
            $pattern = rtrim($patternWithoutUrlPrefix, '/');
            $pattern = '%' . $this->esacpePatternForLike($pattern) . '%';
        } elseif ($patternType === self::TYPE_URL_EQUALS) {
            $operator = "TRIM(TRAILING '/' FROM " . $column . ') = ?';
            $pattern = rtrim($patternWithoutUrlPrefix, '/');
        } elseif ($patternType === self::TYPE_URL_REGEXP) {
            $operator = $column . ' REGEXP ?';
        }

        return array(
            'query' => $operator,
            'bind' => $pattern
        );
    }
}
