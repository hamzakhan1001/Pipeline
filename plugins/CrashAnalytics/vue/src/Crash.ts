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

interface Crash {
  idlogcrash: number;
  idsite: number;
  message: string;
  crash_type: string;
  category: string|null;
  resource_uri: string|null;
  resource_line: number|null;
  resource_column: number|null;
  stack_trace: string|null;
  datetime_first_seen: string;
  datetime_first_seen_pretty: string;
  date_first_seen: string;
  date_first_seen_pretty: string;
  datetime_last_seen: string;
  datetime_last_seen_pretty: string;
  date_last_seen: string;
  date_last_seen_pretty: string;
  datetime_last_reappeared?: string;
  datetime_last_reappeared_pretty?: string;
  date_last_reappeared?: string;
  date_last_reappeared_pretty?: string;
  crash_page_url?: string;
  datetime_ignored_error: string|null;
  datetime_ignored_error_pretty?: string;
  date_ignored_error?: string;
  date_ignored_error_pretty?: string;
  group_idlogcrash: number|null;
}

export default Crash;
