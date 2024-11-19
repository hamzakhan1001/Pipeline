## Changelog

__5.2.0__ - 2024-11-18
* Security improvements around token save and display
* Added option to not anonymise click IDs via SystemSetting

__5.1.5__ - 2024-11-04
* Updated README.md

__5.1.4__ - 2024-10-08
* Fixes GoogleAds returning only 1 row for some on-premise install

__5.1.3__ - 2024-08-26
* Pricing updated

__5.1.2__
* Added code to allow setting consent status via SystemSetting for Google export

__5.1.1__
* Added FAQ link to setup Google conversion export in description

__5.1.0__
* Added 3 new form options (External attributed conversion, Attribution Model, Attributed Credit) for Google Ads

__5.0.11__
* Added 2 new empty columns(Ad User Data and Ad Personalization) in Google export

__5.0.10__
* Added distinct to SQL query to prevent duplicate records

__5.0.9__
* Added code to post event on max_execution_time exceeded

__5.0.8__
* Updated README.md
* Added code to apply max_execution_time along with limits for enabling export via config

__5.0.7__
* Fixed failing tracking requests due to URL being an array

__5.0.6__
* Changed logged type to info instead of error.

__5.0.5__
* Fixes icon placement in visitors real-time widget
* Added code to add campaign tracking parameters for all links within Matomo app that link to matomo.org

__5.0.4__
* Fixes version update

__5.0.3__
* Added code to sanitise alias name to prevent possible XSS

__5.0.2__
* New release with timezone offset calculation patch

__5.0.1__
* New release with UI patch

__5.0.0__
* Compatibility with Matomo 5

__4.1.4__
* Fix validation for the number of days to export

__4.1.3__
* Updated README.md to mention the fb tracking as anonymized

__4.1.2__
* Added a fix to determine isEcommerce if variable type is different

__4.1.1__
* Started excluding anonymized clickIds from export.

__4.1.0__
* Migrate angularjs code to Vue.

__4.0.12__
* Added check to log clickIDs only if corresponding export is configured

__4.0.11__
* Fixed timezone determination bug for Microsoft export file

__4.0.10__
* Fixed compatibility issue for MySql 5.5

__4.0.9__
* Updated download URL generation. 

__4.0.8__
* Fixed CSV header for Yandex offline conversion 
* Fixed Microsoft upload error due to header

__4.0.7__
* Fixed file format upload error for Microsoft Advertising

__4.0.6__
* Fixed Deprecation warnings for PHP 8.1

__4.0.5__
* Fix to make DB connection only when needed

__4.0.4__

* Fix timezone parameter in Microsoft Ads exports

__4.0.3__

* Added Turkish translations
* Fixed timezone issue in Google exports

__4.0.2__

* Minor code and UI improvements
* Added Albanian translations

__4.0.1__

* Mark plugin as compatibile with Matomo for WordPress

__4.0.0__

Initial Release
* automatic tracking of click ids (Google, Facebook, Bing, Yandex)
* configurable conversions exports for
  * Google Ads
  * Microsoft Advertising
  * Yandex Ads
