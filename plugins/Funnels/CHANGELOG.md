## Changelog

5.3.3
- Fixed issue where yesterday didn't archive when a funnel was updated
- Fixed issue with report metadata preventing Matomo mobile app from loading specific reports

5.3.2
- Fixed issue where new funnels archived incorrectly for recent days

5.3.1
- Fixed checkmark alignment for goal funnels

5.3.0
- Funnels overview table redesigned
- Fixed rounding error in funnel report
- Added code to always make lasts step as require for a non goal funnel

5.2.2
- Performance improvement by forcing an index to make the VisitAction query faster

5.2.1
- Minor improvements and bug fixes
- Updated translations

5.2.0
- Redesigned funnels visualisation
- Added new data table below visualisation
- Various UI improvements
- Misc. bug fixes

5.1.2
- Corrected Ecommerce funnels to behave like goal funnels
- Moved goal equals to the top step pattern option
- Fixed bug where updating existing step to goal equals pattern sometimes failed
- Updated some report metadata to account for non-goal funnel changes

5.1.1
- Fixed issue where goal name is displayed as encoded
- Added cover image for marketplace
- Added code to auto scroll to funnel section, when editing a goal funnel from manage funnel section 

5.1.0
- Funnel add/edit redesign
- Allow creating funnels not tied to a goal

5.0.4
- Updated README.md

5.0.3
- Fixes recent regression in invalidation/archiving

5.0.2
- New release with skip archiving for rollup site patch

5.0.1
- Compatibility with Matomo 5.0.0-b4

5.0.0
- Compatibility with Matomo 5

4.1.6
- Fixed incorrect semantic type for abandoned rate

4.1.5
- Fix incompatibility with Matomo 4.14.0 

4.1.4
- Added semantics type for metrics

4.1.3
- Fixed a couple regressions. One was in the UI and the other was preventing some sites from archiving

4.1.2
- Improved the accuracy of archived funnel data

4.1.1
- Forcing the funnel overview to be full width.

4.1.0
- Migrating angularjs to Vue.

4.0.11
- Removed duplicate contains filter from getAvailablePatternMatches

4.0.10
- Started re-archiving only when steps are updated on edit

4.0.9
- Prevent error site does not exist when no site given

4.0.8
- Fixed export not working with flatten

4.0.7
- Minor performance improvement

4.0.6
- Improve archiving with roll up reporting

4.0.4
- Add category help texts
- Prevent extra pointless archiving and bug where archives are not generated when editing a funnel multiple times before a core:archive kicks off.

4.0.3
- Compatibility with PHP 8

4.0.2
- Rearchive data when needed

4.0.1
- Compatibility with Matomo 4.x

4.0.0
- Compatibility with Matomo 4.x

3.1.22
- Fix possible error in an API when a certain period/date combination is used

3.1.21
- Improve lock creation when archiving

3.1.20
- Fix exits were not always calculated correctly

3.1.19
- Rearchive some previously archived data for better accuracy

3.1.18
- Fix possible notice in row evolution

3.1.17
- Improve compatibility with Matomo 3.12
- Add new language

3.1.16
- Reuse transaction level from core when possible

3.1.15
- Make query that populates funnel data non-locking by setting different transaction level 

3.1.14
- Support usage of a reader DB when configured

3.1.13
- Archiving improvements
- Translation updates

3.1.12
- Improve adding primary key if there are some duplicate keys

3.1.11
- Add primary key to funnel log table for better replication

3.1.10
- Performance improvements when generating reports

3.1.9
- Support more translations
- Use new brand colors

3.1.8
- Added social media support
- Internal changes

3.1.7
- Fix possible error in sales funnel

3.1.6
- Support new "Write" role

3.1.5
- When a user reloads a page that is part of funnel, do not show it as an exit page
- Improve archiver to let more archivers run in parallel

3.1.4
- Validate any entered regular expression when configuring a funnel

3.1.3
- Changed the default type for a DB column to unsigned

3.1.2
- Renamed Piwik to Matomo

3.1.1
- Faster archiving

3.1.0
- Support matching of page titles, event categories, event names, and event actions

3.0.4
- Make sure validating URL funnel works correctly with HTML entities

3.0.3
- Add possibility to define sales funnel

3.0.2
- Make sure HTML entities can be used in patterns

3.0.1
- Performance improvement in Archiver

3.0.0 

- Initial version
