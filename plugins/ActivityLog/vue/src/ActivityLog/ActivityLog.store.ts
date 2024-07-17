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

import {
  reactive,
  computed,
  readonly,
} from 'vue';
import { AjaxHelper, Matomo, translate } from 'CoreHome';
import { Entry } from '../types';

interface Option {
  key: string;
  value: string;
}

interface ActivityLogStoreState {
  activities: Entry[];
  searchTerm: string;
  busy: boolean;
  pageSize: number;
  currentPage: number;
  offsetStart: number;
  offsetEnd: number;
  hasPrev: boolean;
  hasNext: boolean;
  totalNumberOfSites: number;
  availableUsers: Option[];
  filter: {
    userLogin: string;
    activityType: string;
  };
}

class ActivityLogStore {
  private privateState = reactive<ActivityLogStoreState>({
    activities: [],
    searchTerm: '',
    busy: false,
    pageSize: 10,
    currentPage: 0,
    offsetStart: 0,
    offsetEnd: 10,
    hasPrev: false,
    hasNext: false,
    totalNumberOfSites: 0,
    availableUsers: [],
    filter: {
      userLogin: '',
      activityType: '',
    },
  });

  readonly state = computed(() => readonly(this.privateState));

  init() {
    const promises: Promise<void>[] = [];

    promises.push(this.fetchActivityCount());

    if (Matomo.hasSuperUserAccess) {
      promises.push(this.fetchAvailableUsers());
    } else {
      this.privateState.availableUsers = [
        { key: Matomo.userLogin!, value: Matomo.userLogin! },
      ];
    }

    return Promise.all(promises);
  }

  fetchActivityCount() {
    return AjaxHelper.fetch<{ value: number }>({
      method: 'ActivityLog.getEntryCount',
      filterByUserLogin: this.state.value.filter.userLogin,
      filterByActivityType: this.state.value.filter.activityType,
    }).then((count) => {
      if (!count || !count.value) {
        return;
      }

      this.privateState.totalNumberOfSites = count.value;
    });
  }

  fetchAvailableUsers(): Promise<void> {
    return AjaxHelper.fetch<string[]>({
      method: 'UsersManager.getUsersLogin',
      filter_limit: -1,
    }).then((userLogins) => {
      if (!userLogins || !Array.isArray(userLogins)) {
        return;
      }

      const availableUsers = [
        {
          key: '',
          value: translate('General_All'),
        },
        {
          key: 'Console Command',
          value: translate('ActivityLog_ConsoleCommand'),
        },
        {
          key: 'Matomo System',
          value: translate('ActivityLog_System'),
        },
        ...userLogins.map((login) => ({
          key: login,
          value: login,
        })),
      ];

      this.privateState.availableUsers = availableUsers;
    });
  }

  onError(): void {
    this.setActivities([]);
  }

  setActivities(activities: Entry[]): void {
    this.privateState.activities = activities;

    const numSites = activities.length;
    this.privateState.offsetStart = this.state.value.currentPage * this.state.value.pageSize;
    this.privateState.offsetEnd = this.state.value.offsetStart + numSites;
    this.privateState.hasPrev = this.state.value.currentPage >= 1;
    this.privateState.hasNext = numSites === this.state.value.pageSize;
  }

  setCurrentPage(page: number): void {
    this.privateState.currentPage = page < 0 ? 0 : page;
  }

  previousPage(): void {
    this.setCurrentPage(this.state.value.currentPage - 1);
    this.fetchActivityLog();
  }

  nextPage(): void {
    this.setCurrentPage(this.state.value.currentPage + 1);
    this.fetchActivityLog();
  }

  applyFilter(userLogin?: string) {
    if (userLogin) {
      this.privateState.filter.userLogin = userLogin;
    }

    this.privateState.currentPage = 0;
    this.fetchActivityCount();
    this.fetchActivityLog();
  }

  fetchActivityLog(): Promise<void> {
    if (this.privateState.busy) {
      return Promise.resolve();
    }

    this.privateState.busy = true;

    const limit = this.privateState.pageSize;
    const offset = this.privateState.currentPage * this.privateState.pageSize;

    return AjaxHelper.fetch<Entry[]>({
      method: 'ActivityLog.getEntries',
      offset,
      limit,
      filterByUserLogin: this.privateState.filter.userLogin,
      filterByActivityType: this.privateState.filter.activityType,
    }).then((activities) => {
      if (!activities) {
        this.onError();
        return;
      }

      this.setActivities(activities);
    }).catch(
      () => this.onError(),
    ).finally(() => {
      this.privateState.busy = false;
    });
  }
}

export default new ActivityLogStore();
