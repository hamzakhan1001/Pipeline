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
