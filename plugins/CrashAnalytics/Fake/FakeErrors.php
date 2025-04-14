<?php
/**
 * Copyright (C) InnoCraft Ltd - All rights reserved.
 *
 * NOTICE:  All information contained herein is, and remains the property of InnoCraft Ltd.
 * The intellectual and technical concepts contained herein are protected by trade secret or copyright law.
 * Redistribution of this information or reproduction of this material is strictly forbidden
 * unless prior written permission is obtained from InnoCraft Ltd.
 *
 * You shall use this code only in accordance with the license agreement obtained from InnoCraft Ltd.
 *
 * @link https://www.innocraft.com/
 * @license For license details see https://www.innocraft.com/license
 */

namespace Piwik\Plugins\CrashAnalytics\Fake;

class FakeErrors
{
    public static $errors = [
        [
            'message' => 'window.querySelectors is not a function',
            'crash_type' => 'SyntaxError',
        ],

        [
            'message' => 'JSON.parse: unexpected character at line 1 column 13 of the JSON data',
            'crash_type' => 'SyntaxError',
        ],

        [
            'message' => 'delta is null',
            'crash_type' => 'TypeError',
        ],

        [
            'message' => 'Script error',
            'crash_type' => 'unknown',
        ],

        [
            'message' => 'precision -2 out of range',
            'crash_type' => 'RangeError',
        ],

        [
            'message' => 'Cannot read property \'length\' of undefined',
            'crash_type' => 'TypeError',
        ],

        [
            'message' => 'Cannot set \'value\' of undefined',
            'crash_type' => 'TypeError',
        ],

        [
            'message' => 'dashboard is not defined',
            'crash_type' => 'ReferenceError',
        ],

        [
            'message' => 'Cannot read properties of null (reading \'length\')',
            'crash_type' => 'TypeError',
        ],

        [
            'message' => 'Unknown period type \'cycle\'.',
            'crash_type' => 'Error',
        ],

        [
            'message' => 'NetworkError when attempting to fetch resource.',
            'crash_type' => 'TypeError',
        ],

        // two custom errors
        [
            'message' => 'Error returned from API: invalid value specified for user ID: user not found',
            'crash_type' => 'ApiError',
        ],

        [
            'message' => 'Error returned from API: SQLSTATE[42S22]: Column not found: 1054 Unknown column \'description\' in \'where clause\'',
            'crash_type' => 'ApiError',
        ],
    ];

    public static $stacks = [
        [
            'stack' => 'at Proxy.mounted (ContentBlock.vue?./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1:45:12)
    at callWithErrorHandling (vue.global.js?cb=2596:8407:24)
    at callWithAsyncErrorHandling (vue.global.js?cb=2596:8416:23)
    at hook.__weh.hook.__weh (vue.global.js?cb=2596:3770:31)
    at flushPostFlushCbs (vue.global.js?cb=2596:8602:49)
    at render (vue.global.js?cb=2596:6587:11)
    at mount (vue.global.js?cb=2596:4966:27)
    at app.mount (vue.global.js?cb=2596:10812:25)
    at HTMLDivElement.<anonymous> (piwikHelper.js?cb=2596:251:31)
    at Function.each (jquery.min.js?cb=2596:2:2861)',
            'uri' => 'ContentBlock.vue?./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1',
            'line' => 45,
            'column' => 12,
        ],
        [
            'stack' => '    at Proxy.mounted (index.php?module=Proxy&action=getUmdJs&chunk=0&cb=73e78c2f446833c0eb04c3a0c709f1a2:178:5272)
    at Rr (index.php?module=Proxy&action=getCoreJs&cb=73e78c2f446833c0eb04c3a0c709f1a2:41:56622)
    at Fr (index.php?module=Proxy&action=getCoreJs&cb=73e78c2f446833c0eb04c3a0c709f1a2:41:56700)
    at t.__weh.t.__weh (index.php?module=Proxy&action=getCoreJs&cb=73e78c2f446833c0eb04c3a0c709f1a2:41:25440)
    at Xr (index.php?module=Proxy&action=getCoreJs&cb=73e78c2f446833c0eb04c3a0c709f1a2:41:58017)
    at Y (index.php?module=Proxy&action=getCoreJs&cb=73e78c2f446833c0eb04c3a0c709f1a2:41:46401)
    at mount (index.php?module=Proxy&action=getCoreJs&cb=73e78c2f446833c0eb04c3a0c709f1a2:41:31676)
    at t.mount (index.php?module=Proxy&action=getCoreJs&cb=73e78c2f446833c0eb04c3a0c709f1a2:41:118262)
    at HTMLDivElement.<anonymous> (index.php?module=Proxy&action=getCoreJs&cb=73e78c2f446833c0eb04c3a0c709f1a2:357:612)
    at Function.each (index.php?module=Proxy&action=getCoreJs&cb=73e78c2f446833c0eb04c3a0c709f1a2:4:2861)',
            'uri' => 'index.php?module=Proxy&action=getUmdJs&chunk=0&cb=73e78c2f446833c0eb04c3a0c709f1a2',
            'line' => 178,
            'column' => 5272,
        ],
        [
            'stack' => '    at eval (zenMode.ts:41:13)
    at c (mousetrap.min.js?cb=759:5:35)
    at k._handleKey (mousetrap.min.js?cb=759:7:211)
    at d.handleKey (mousetrap.min.js?cb=759:10:402)
    at HTMLDocument.e (mousetrap.min.js?cb=759:5:260)',
            'uri' => 'zenMode.ts',
            'line' => 41,
            'column' => 13,
        ],
        [
            'stack' => '    at index.php?module=Proxy&action=getUmdJs&chunk=0&cb=75e78c2f446833c0eb04c3a0c709f1a2:96:495
    at c (index.php?module=Proxy&action=getCoreJs&cb=75e78c2f446833c0eb04c3a0c709f1a2:83:35)
    at k._handleKey (index.php?module=Proxy&action=getCoreJs&cb=75e78c2f446833c0eb04c3a0c709f1a2:85:211)
    at d.handleKey (index.php?module=Proxy&action=getCoreJs&cb=75e78c2f446833c0eb04c3a0c709f1a2:88:402)
    at HTMLDocument.e (index.php?module=Proxy&action=getCoreJs&cb=75e78c2f446833c0eb04c3a0c709f1a2:83:260)',
            'uri' => 'index.php?module=Proxy&action=getUmdJs&chunk=0&cb=75e78c2f446833c0eb04c3a0c709f1a2',
            'line' => 96,
            'column' => 495,
        ],

        [
            'stack' => '    at e.value (http://anothersite.com/src/ReportMetadata.store.ts:54:21)
    at e.value (http://anothersite.com/src/ReportingPage.store.ts:157:35)
    at Proxy.renderPage (http://anothersite.com/src/ReportingPage.vue?96fe:146:34)
    at http://anothersite.com/src/ReportingPage.vue?96fe:86:12
    at callWithErrorHandling (http://anothersite.com/src/vue.global.js?cb=6953:8407:24)
    at callWithAsyncErrorHandling (http://anothersite.com/src/vue.global.js?cb=6953:8416:23)
    at Array.job (http://anothersite.com/src/vue.global.js?cb=6953:8791:19)
    at flushPreFlushCbs (http://anothersite.com/src/vue.global.js?cb=6953:8575:47)
    at flushJobs (http://anothersite.com/src/vue.global.js?cb=6953:8615:7)',
            'uri' => 'http://anothersite.com/src/ReportMetadata.store.ts',
            'line' => 54,
            'column' => 21,
        ],
        [
            'stack' => 'TypeError: this.performDecode is not a function
    at e.value (http://anothersite.com/dist/bundle.min.js?cb=73e78c2f446843c0eb04c3a0c709f1a2:250:485)
    at e.value (http://anothersite.com/dist/bundle.min.js?cb=73e78c2f446843c0eb04c3a0c709f1a2:256:1644)
    at Proxy.renderPage (http://anothersite.com/dist/bundle.min.js?cb=73e78c2f446843c0eb04c3a0c709f1a2:256:3771)
    at http://anothersite.com/dist/bundle.min.js?cb=73e78c2f446843c0eb04c3a0c709f1a2:256:2959
    at Rr (http://anothersite.com/dist/bundle.min.js?cb=73e78c2f446843c0eb04c3a0c709f1a2:41:56622)
    at Fr (http://anothersite.com/dist/bundle.min.js?cb=73e78c2f446843c0eb04c3a0c709f1a2:41:56700)
    at Array.f (http://anothersite.com/dist/bundle.min.js?cb=73e78c2f446843c0eb04c3a0c709f1a2:41:58883)
    at Qr (http://anothersite.com/dist/bundle.min.js?cb=73e78c2f446843c0eb04c3a0c709f1a2:41:57818)
    at es (http://anothersite.com/dist/bundle.min.js?cb=73e78c2f446843c0eb04c3a0c709f1a2:41:58093)',
            'uri' => 'http://anothersite.com/dist/bundle.min.js?cb=73e78c2f446843c0eb04c3a0c709f1a2',
            'line' => 250,
            'column' => 485,
        ],

        [
            'stack' => '    at initializeWidgets (index.php?module=CoreHome&action=index&idSite=1&period=day&date=yesterday:375:36)
    at setUpPage (index.php?module=CoreHome&action=index&idSite=1&period=day&date=yesterday:383:21)
    at index.php?module=CoreHome&action=index&idSite=1&period=day&date=yesterday:386:17
    at index.php?module=CoreHome&action=index&idSite=1&period=day&date=yesterday:387:15',
            'uri' => 'index.php?module=CoreHome&action=index&idSite=1&period=day&date=yesterday',
            'line' => 375,
            'column' => 36,
        ],
    ];

    public static $categories = [
        'ContentDelivery',
        'ContentAuthoring',
        'ContentViewer',
        'ContentStore',
        'ContentCheckout',
    ];
}