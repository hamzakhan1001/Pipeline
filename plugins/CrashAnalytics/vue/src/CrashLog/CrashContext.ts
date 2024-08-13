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

interface ActionInfo {
  type: string;
  icon?: string;
  iconSVG?: string;
  title: string;
  subtitle: string;
}

interface PluginIcon {
  pluginIcon: string;
  pluginName: string;
}

interface VisitInfo {
  browser: string;
  browserIcon?: string;
  operatingSystem: string;
  operatingSystemIcon?: string;
  deviceType: string;
  deviceTypeIcon?: string;
  deviceModel: string;
  resolution: string;
  languageCode: string;
  plugins: string;
  pluginsIcons: PluginIcon[];
  userId?: string;
  visitIp: string;
  countryFlag?: string;
  country?: string;
  region?: string;
  city?: string;
  siteCurrency: string;
  sessionReplayUrl?: string;
  serverTimePretty: string;
  serverDatePretty: string;
}

interface CrashContext {
  crashEventId: number;
  crashId: number;
  message: string;
  crashType: string;
  resourceUri: string;
  timestamp: number;
  serverTimePretty: string;
  category?: string;
  resourceLine?: number;
  resourceColumn?: number;
  stackTrace?: string;
  idVisit: number;
  visit?: VisitInfo;
  actionsBeforeCrash?: ActionInfo[];
  pageUrl?: string;
}

export default CrashContext;
