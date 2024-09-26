## Changelog

5.2.1 - 2024-10-23
- Improved tooltip message for HyperLogLog metric

5.2.0 - 2024-09-02
- Added an option to use HyperLogLog to calculate estimated unique visitors instead of unique visitors to improve archiving performance

5.1.4 - 2024-08-26
- Pricing updated

5.1.3
- Add cover image for marketplace
- Added code to skip setting campaign parameters instead of initializing environment

5.1.2
- Fixed errors thrown when enabling the MarketingCampaignsReporting plugin

5.1.1
- Fixed warnings due to no variations defined when determining count to set filter_limit

5.1.0
- Added option to forward campaign URL parameters when redirecting
- Allow more than 10 variations to show in experiment reports

5.0.6
- Updated README.md

5.0.5
- Fixes issue with report preferences not being specific to each experiment

5.0.4
- Reverses change from 5.0.3 as the root issue was addressed in core

5.0.3
- Fixes access error for users with write permission, when viewing manage screen

5.0.2
- Compatibility with Matomo 5.0.0-b4

5.0.1
- Compatibility with Matomo 5

5.0.0
- Remove all references to AngularJS.

4.2.6
- Fixed wrong duration being displayed in summary

4.2.5
- Fixed HTML injection possibility

4.2.4
- Fix incompatibility with Matomo 4.14.0

4.2.3
- Added semantic type metadata for ABTesting metrics

4.2.2
- Fixed deprecation warnings for PHP 8.1

4.2.1
- Stopped using timezone to aggregate day report

4.2.0
- Migrate AngularJS code to Vue

4.1.7
- Fixed date range error bug in view report
- 
4.1.6
- Fixed deprecation warnings for PHP 8.1

4.1.5
- Fix orders abtesting metrics not aggregating properly after orders removed as success metric from experiment

4.1.4
- Improve archiving of unique visitor metrics

4.1.3
- Improve archiving of unique visitor metrics

4.1.2
- Fix unique visitor metrics in evolution chart
- Add Czech translations

4.1.1
- Improve archiving for Roll-Up reporting

4.1.0
- More effiecient unique visitors processing
- Reports can now be only viewed for the entire experiment date range when using the API

6.0.8
- jQuery compatibility w/ wordpress
- fix possible error SignificanceRate::setDataTableWithSamples() must be an instance of Piwik for nb_orders_revenue
- add category help texts

4.0.7
- Fix version constraint

4.0.6
- Performance improvement

4.0.5
- Compatibility with PHP 8

4.0.2
- Compatibility with Matomo 4.x

4.0.1
- Compatibility with Matomo 4.x

4.0.0
- Compatibility with Matomo 4.x

3.2.18
- Better support for Safari's new ITP
- Added new tracker methods `AbTesting::disableWhenItp`, `AbTesting::disable`, `AbTesting::enable`, `AbTesting::isEnabled`

3.2.17
- Ensure to set samesite flag when setting a cookie

3.2.16
- Fix a possible notice in RemainingVisitors calculation

3.2.15
- Prevent possible notice during archiving
- Added new language
- Better support for Matomo 3.12.0

3.2.14
- Use Reader DB in all archiver queries when configured

3.2.13
- Improvements for Matomo 3.12 to support faster segment archiving

3.2.12
- Show search box for entities
- Support usage of a reader DB when configured

3.2.11
- Adjust help text for page targeting
- Fix opacity for drop downs
- Added new language

3.2.10
- title-text of JavaScript Tracking option help box shows HTML
- Fix unsupported operand notice might appear under circumstances in the overview report

3.2.9
- Added various new languages
- Removed configuration for original redirect url as it should be configured and could lead to issues if it is.

3.2.8
- Improve compatibility with Matomo 3.9

3.2.7
- Ensure the color of a warning in the test is readable

3.2.6
- Improve compatibility with Tag Manager

3.2.5
- Support more languages
- Use new brand colors

3.2.4
- Add possibility to force multiple variations through a URL parameter when multiple tests are running on the same page

3.2.3
- Use API requests internally
- View user can now request the experiment configuration

3.2.2
- Support new Write role

3.2.1
- Show experiment participation in visitor log 

3.2.0
- Rename Experiments to A/B tests

3.1.11
- Prevent possible fatal error when opening manage screen for all websites
- Validate any entered regular expression when configuring an experiment
- Ignore URL parameters "pk_abe" and "pk_abv" in page URLs
- When tracking an A/B test, do not validate the target page server side

3.1.10
- Renamed Piwik to Matomo

3.1.9
- Fix only max 100 experiments where loaded when managing experiments for one specific site.
- Use better random number generators if available when using server side redirects feature.

3.1.8
 - Make sure to find all matches for a root folder when "equals simple" is used
 
3.1.7
- Fix typo in example embed code
- Improve variation detection by ignoring case

3.1.6
- Fix a possible notice during tracking
- Make sure HTML entities can be used in page targets

3.1.5
- When using an "equals exactly" comparison, ignore a trailing slash when there is no path set

3.1.4
- Fix a server side redirect issue where a stored cookie value might be ignored for the original version

3.1.3
- Enrich System Summary widget

3.1.2
- Show manage experiments in reporting menu

3.1.1
- Show summary row in overview report

3.1.0
- Added possibility to define redirects in UI
- Fix preview images was not shown

3.0.2
- Added new feature to force a specific variation via URL

3.0.1
- Added Experiments overview page
- When creating a new experiment for an ecommerce shop, pre-select Ecommerce Orders and Ecommerce Revenue success metric automatically
- Make sure A/B Test reports work when range dates are disabled 

3.0.0 
- Initial version
