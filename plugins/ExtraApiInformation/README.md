# Matomo Extra Api Information

## Description

Exposes some core information via API that is normally not available in Matomo API.

Please note that the information is only available for super users (admin role).

| API                | Information        | Options            |
| ------------------ | ------------------ | ------------------ |
| `ExtraApiInformation.getArchivingStatus` | Shows status of archiving (last started and finished) | human date format (human=1) |
| `ExtraApiInformation.getInvalidationsCount` | Get number of invalidations (total, queued, in progress) | - |

## Use cases

Why expose this information? There are couple of use cases:

- Automation: Having this metrics available opens up for more automation around Matomo.
- Matomo Exporter: Using the [Matomo Prometheus exporter](https://github.com/Digitalist-Open-Cloud/Matomo-CLI?tab=readme-ov-file#prometheus-exporter), you could activate this metrics.
- Why not? ❤️

## License

Copyright (C) 2024 Digitalist Open Cloud <cloud@digitalist.com>

This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see <https://www.gnu.org/licenses/>.
