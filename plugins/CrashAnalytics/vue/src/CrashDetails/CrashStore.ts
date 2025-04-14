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

import { AjaxHelper, Matomo } from 'CoreHome';
import Crash from '../Crash';

class CrashStore {
  fetchCrash(idLogCrash: number, overrideParams: QueryParameters = {}): Promise<Crash> {
    return AjaxHelper.fetch<Crash>({
      method: 'CrashAnalytics.getCrashSummary',
      idSite: Matomo.idSite,
      idLogCrash,
      ...overrideParams,
    });
  }
}

export default new CrashStore();
