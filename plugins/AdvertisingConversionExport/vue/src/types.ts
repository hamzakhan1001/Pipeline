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

export interface ExportGoal {
  idgoal: string|number|null;
  name: string;
  revenue: string;
  revenueValue?: string|number;
}

export interface ConversionExportParams {
  clickIdAttribution?: string;
  daysToExport?: string|number;
  daysToLookBack?: string|number;
  goals?: ExportGoal[];
  onlyDirectAttribution?: string|number;
  segment?: string;
  externalAttributedConversion?: string|number;
  attributionModel?: 'dataDriven' | 'lastClick';
  attributedCredit?: string|number;
}

export interface ConversionExport {
  access_token: string;
  deleted: string|number;
  description: string;
  idexport: string|number;
  idsite: string|number;
  name: string;
  parameters?: ConversionExportParams;
  ts_created: string;
  ts_modified: string;
  ts_requested: null|string;
  ts_requested_pretty: null|string;
  type: string;
}
