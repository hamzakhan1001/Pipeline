## Changelog

5.0.8
- Added cover image for marketplace

5.0.7
- Added 1 retry when deadlock is found during insert/update of logMedia

5.0.6
- Updated README.md

5.0.5
- Added code to track audio player for JWPlayer

5.0.4
- Added code to not set row URL if row is summary row

5.0.3
- Reverses change from 5.0.2 as the root issue was addressed in core

5.0.2
- Fixed permission issue with the getting started widget

5.0.1
- Compatibility with Matomo 5.0.0-b4

5.0.0
- Compatibility with Matomo 5

4.2.1
- Fixed regression due to ranking query change

4.2.0
- Implemented ranking query to allow limiting the data to avoid running out of memory during archiving.
To learn more, refer to https://matomo.org/faq/media-analytics/how-do-i-fix-an-allowed-memory-size-exhausted-error-in-media-analytics/#if-above-does-not-fix-your-issue

4.1.6
- Fixed issue where installer overrode cloud default config

4.1.5
- Fixed typos for marketplace listing

4.1.4
- Updated code to respect max execution time during Archiving

4.1.3
- Added code to support fv_title to set MediaTitle for FlowPlayer

4.1.2
- Fixed regression bug due to getOriginalString not available in lower Matomo version

4.1.1
- Code changes to prevent sending the same progress request when it is not required

4.1.0
- Started limiting maximum media events that can be triggered per media per tracker per page view.
Limits are play:50, pause: 25, resume:25, finish:50 and seek:50. To learn more refer - https://matomo.org/faq/rate-limits-when-tracking-media-events/
- Added option to disable rate limiting media events via JS tracker (MediaAnalytics::disableRateLimit())

4.0.17
- Started loading YouTube iframe script even when windowAlias.onYouTubeIframeAPIReady is defined

4.0.16
- Started passing segment during audience archive for country mao

4.0.15
- Added config option to not track media events by default

4.0.14
- Disabled sort feature in Media Details popup

4.0.13
- Fixed recursive search not working for audio and video resources

4.0.12
- Added view flat report option for Video Resource URLs
- Fixed Video Resource URLs export with flatten option enabled

4.0.11
- Removed some unneeded `console.log` from tracker.min.js

4.0.10
- Fixed issue with JWPlayer, where fullscreen mode and width/height were not tracked correctly
- Fixed media type in action tooltip
- Translation updates

4.0.9
- Throw meaningful exception when API is used with secondary dimension and multiple dates or sites. Support for this may be added later.

4.0.8
- Improve archiving performance for player name report

4.0.7
- Fix scanForMedia on specific elements

4.0.6
- Improve compatibility with scheduled reports
- Add Portuguese translations

4.0.5
- Add category help text

4.0.4
- Fix live report 24 hours used more than 24 hours
- Improve performance of live queries

4.0.3
- Add possibility to force a media title on vimeo

4.0.2
- Compatibility with Matomo 4

4.0.1
- Support more vimeo URLs

4.0.0
- Compatibility with Matomo 4

3.4.14
- Detect more vimeo URLs

3.4.13
- Prevent possible errors on some PHP versions

3.4.12
- Improve YouTube tracking

3.4.11
- Improve tracking performance for media progress updates

3.4.10
- Disable tracking should Plyr with youtube media be used since they are not compatible with each other.

3.4.9
- Internal tweaks

3.4.8
- More efficient tracking

3.4.7
- Fix possible error in API

3.4.6
- Fix notice when a report has many different resource urls

3.4.5
- Fix media heatmap shows error

3.4.4
- Improvements for Matomo 3.12 to support faster segment archiving
- Support more languages

3.4.3
- Support usage of a reader DB when configured

3.4.2
- Internal tracker performance improvements

3.4.1
- Add Turkish translations
- Better support for JWPlayer 8

3.4.0
- Show a heatmap for each video
- Queue tracking requests when possible for better performance
- Internal change: Use a shorter ID for each view to optimise storage

3.3.1
- SoundCloud playlist support

3.3.0
- Support SoundCloud

3.2.13
- Improve compatibility with tag manager
- Truncate media title if needed

3.2.12
- Trim values if needed before writing them into the database
- Support more translations
- Video "details" modal now supplies an export feature.

3.2.11
- Show Media Title and Media Resource URL report on same page

3.2.10
- Improve Paella/Opencast support
- Internal changes

3.2.9
- Limit the number of rows to archive for each report to improve memory usage

3.2.8
- Improve Opencast with Paella integration
- Better detection of the player name
- Limit tracking to 3 hours by default after the first media tracking request

3.2.7
- Improve archiving performance by no longer needing to process media analytics segment for all reports but only location reports

3.2.6
- Improve detection of Youtube API availability

3.2.5
- Make sure noCookie works when loading the iframe API async

3.2.4
- Support for YouTube NoCookie

3.2.3
- Improve detection of seek events

3.2.2
- Improve tracking of YouTube media progress.

3.2.1
- Fix possible error in Live.getLastVisitDetails that causes no output

3.2.0
- Show media interactions in the visitor log and visitor profile
- Support `matomo` keyword in attributes and properties when customizing the tracking

3.1.0
- Track position witin media when a video was played, paused, resumed, or seeked.
- Track new event when a user seeks to a different position (not supported by YouTube)

3.0.19
- Piwik is now Matomo

3.0.18
- Ensure correct data is shown when an action segment is applied

3.0.17
- Improve archiving speed
- Fix media title was not kept when a video finished playing and the same video was played again
- Fix Youtube Player did not support to scan for videos on only a subset of the page, only the full page.

3.0.16
- Add possibility to set a callback method via the tracker method `MediaAnalytics::setMediaTitleFallback` to detect a custom title if no title cannot be detected automatically
- Improved detection of custom titles and resource URLs for JWplayer 5 

3.0.15
- Better support for OpenCast
- Better support for older versions of JWplayer (eg version 5)
- Fix some events for HTML5 players were not tracked under circumstances (for example resume)
- HTML5 Player. Better detection of duration, width, and height

3.0.14
- Automatically detect media titles for Opencast.

3.0.13
- Prevent possible error if a method jwplayer is defined which is not the actual jwplayer but a custom implementation

3.0.12
- Removed the need for some custom tracking code in rare cases
- Better flowplayer detection of media and flowplayer splash support

3.0.11
- Added support for Custom Reports
- Better differentiation between seek and pause for YouTube and Vimeo.

3.0.10
- HTML5 Player: Fix play event might be triggered too often, eg after a loop
- HTML5 Player: Fix pause / resume event is triggered when user is actually seeking
- Increase tracking interval over time

3.0.9
- Apply selected segment in Audience Log correctly

3.0.8
- Possibility to define custom video title to be used only for tracking when using JW Player or flowplayer.

3.0.7
- Add support for Flowplayer (only HTML5 so far)
- Add possibility to track custom resource with JW Player
- Better detection of JW Player and Flowplayer videos when they are embedded after the load event.

3.0.6
- HTML5 Player: When source changes, check if title changed as well instead of only clearing the title
- HTML5 Player: Track play event only if the player actually starts playing
- HTML5 Player: When source (video or audio) was changed, it may have missed to record updated src under circumstances

3.0.5
- Fix Unique Visitors is zero when Media Analytics is installed

3.0.4
- Full support for JW Player including Flash and M3U8
- Fixed a bug where a real time report was not updated automatically

3.0.3
- Improved support for jwplayer by detecting video title automatically

3.0.2
- Fix Overview page may require admin access

3.0.1
- Added compatibility with Roll-Up Reporting
- Better JSON object detection

3.0.0
- Initial version
