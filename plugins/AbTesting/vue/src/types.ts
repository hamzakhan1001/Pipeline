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

export interface TargetAttributeType {
  value: string;
  name: string;
}

export interface AvailableTargetAttribute {
  example: string;
  name: string;
  types: TargetAttributeType[];
  value: string;
}

export interface ExperimentTarget {
  attribute: string;
  inverted: string|number;
  type: string;
  value: string;
}

export interface ExperimentMetric {
  metric: string;
}

export interface Variation {
  idvariation?: string|number;
  name: string;
  percentage?: number|string|null;
  redirect_url?: string|null;
}

export interface Experiment {
  confidence_threshold: string;
  date_range_string: null|string;
  description: string;
  duration: string|null;
  end_date: string|null;
  end_date_site_timezone: string|null;
  excluded_targets: ExperimentTarget[];
  hypothesis: string;
  idexperiment: string;
  idsite: string;
  included_targets: ExperimentTarget[];
  mde_relative: string;
  modified_date: string;
  name: string;
  original_redirect_url: string|null;
  percentage_participants: string;
  start_date: string|null;
  start_date_site_timezone: string|null;
  status: string;
  success_metrics: ExperimentMetric[];
  variations: Variation[];
  forward_utm_params: boolean;
}

interface AbTestingTarget {
  location: URL;

  matchesTargets(included: unknown, excluded: unknown): boolean;
}

declare global {
  interface Window {
    piwikAbTestingTarget: AbTestingTarget;
  }
}
