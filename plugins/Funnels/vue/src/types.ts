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

export interface FunnelStep {
  name: string;
  pattern_type: string;
  patternComparison: string;
  pattern: string;
  required: boolean;
}

export interface Funnel {
  activated: boolean;
  created_date: string;
  final_step_position: string|number;
  idfunnel: string|number;
  idgoal: string|number;
  idsite: string|number;
  name: string;
  steps: FunnelStep[];
  pattern: string;
  pattern_type: string;
  position: number|string;
  required: boolean;
  isSalesFunnel: boolean|null;
}
