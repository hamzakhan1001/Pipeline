/**
 * Copyright (C) InnoCraft Ltd - All rights reserved.
 *
 * NOTICE:  All information contained herein is, and remains the property of InnoCraft Ltd.
 * The intellectual and technical concepts contained herein are protected by trade secret
 * or copyright law. Redistribution of this information or reproduction of this material is
 * strictly forbidden unless prior written permission is obtained from InnoCraft Ltd.
 *
 * You shall use this code only in accordance with the license agreement obtained from
 * InnoCraft Ltd.
 *
 * @link https://www.innocraft.com/
 * @license For license details see https://www.innocraft.com/license
 */

export interface Pattern {
  key: string;
  name: string;
}

export interface AvailableRule {
  key: string;
  name: string;
  example: string;
  patterns: Pattern[];
}

export type FormRule = AvailableRule;
export type PageRule = AvailableRule;

export interface Status {
  name: string;
  value: string;
}

export interface Rule {
  attribute: string;
  pattern: string;
  value: string;
}

export interface FormField {
  name: string;
  type: string;
  displayName: string;
}

export interface ConversionRuleOption {
  key: string;
  name: string;
}

export interface Form {
  auto_created: boolean;
  conversion_rules: Rule[];
  created_date: string;
  description: string;
  fields: FormField[];
  idsite: number;
  idsiteform: number;
  in_overview: number;
  match_form_rules: Rule[];
  match_page_rules: Rule[];
  conversion_rule_option: string;
  name: string;
  status: string;
  updated_date: string;
}
