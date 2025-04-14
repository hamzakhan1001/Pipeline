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

export interface EntryParameterItem {
  type: string;
  data: Record<string, string|number|boolean>;
}

export interface EntryParameters {
  component: string;
  items: EntryParameterItem[];
  version: string;
}

export interface Entry {
  avatar: string;
  country: string;
  country_flag: string;
  country_name: string;
  datetime: string;
  datetime_pretty: string;
  description: string;
  id: string|number;
  ip: string;
  parameters: []|EntryParameters;
  time_relative_pretty: string;
  type: string;
  user_login: string;
}
