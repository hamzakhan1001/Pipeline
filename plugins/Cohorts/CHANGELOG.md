## Changelog

5.0.9
- Added cover image for marketplace

5.0.8
- Started hiding icon to change visualisation
- Fixed background color of gradient to start from #3450A3

5.0.7
- Improving the algorithm that converts time strings back to numeric values for comparison

5.0.6
- Fixed hover for first columns to show required info

5.0.5
- Updated README.md
- Adjustments to the color gradient logic

5.0.4
- Archiving: Ensure parameter is provided in correct type

5.0.3
- Minor UI fixes

5.0.2
- Fix issue with evolution graph not always loading correctly

5.0.1
- Compatibility with Matomo 5.0.0-b4

5.0.0
- Compatibility with Matomo 5

4.0.8
- Fix issue with Matomo 4.14

4.0.7
- Added semantics type for metrics
- Widening narrow select

4.0.6
- Added translation using Weblate (Bulgarian)

4.0.5
- Fixes to handle notices 

4.0.4
- Fixed userID not getting archived for non day report
- Fixed encoding issue for graph labels

4.0.3
- Add category help text

4.0.2
- Fix archiving error

4.0.1
- Rearchive reports on activation

4.0.0
- Compatibility with Matomo 4

3.0.11
 - Fix SQL error when fetching one day as a range
 
3.0.10
 - Add segment even if no idSite is specified, but idSites (witth the ending "s") is specified so API.getSegmentsMetadata will show the segment.

3.0.9
 - Fix archiving issue where archiving ranges caused broken SQL. (Archiving ranges for Cohorts should only trigger day archiving, nothing else.)

3.0.8
 - Add code to disable comparison in anticipation of 3.12.
 - Fix for showing nb_users along w/ nb_uniq_visitors when enabled.
 - Changes to README.

3.0.7
 - Move Cohorts menu item to Visitors menu.
 - Fix bug in naming of ecommerce goal metrics.

3.0.6
 - Fix bug if no data in evolution graph, no rows are selectable.
 - Fix bug that doubled selectable rows each time a new row was selected in evolution graph.
 - Fix bug in detection of date for cohort tooltip.

3.0.5
 - Fix warning when computing cell background and cell tooltip.

3.0.4
 - Fix unique visitors calculation for year periods.

3.0.3
 - Disable report metadata since scheduled reports/mobile app cannot handle cohort reports yet.

3.0.2
 - Bug fix affecting controller actions that do not require an idSite parameter.
 - Bug fix affecting cohorts INI config if already present when installing plugin.

3.0.1
 - Bug fix for cohort table translations.
 - Bug fix for viewing cohorts w/ range periods.

3.0.0
 - Initial public release
