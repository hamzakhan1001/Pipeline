window.addEventListener('DOMContentLoaded', function () {
    function removeLogoPiwikTitle(){
        $('#logo').find('[title]').attr('title', '');
        $('.loginSection #piwik').remove();
        $('.loginSection #matomo').remove();
    }

    function removePiwikBrowserTitle()
    {
        var title = $('title').text();
        if (title) {
            title = (''+ title);
            title = $.trim(title);
            var index = title.lastIndexOf('Piwik');

            if (index === (title.length - 5)) {
                $('title').text(title.substring(0, index));
            }

            index = title.lastIndexOf('Matomo');

            if (index === (title.length - 6)) {
                $('title').text(title.substring(0, index));
            }
        }
    }

    $(document).ready(function() {
        removeLogoPiwikTitle();
        removePiwikBrowserTitle();

        if ('object' === typeof piwik && 'GhostBrandRemoveLinks' in piwik && piwik.GhostBrandRemoveLinks) {
            $('body').addClass('GhostBrandRemoveLinks');
        }
    });

    $(window).on('load', function () {
        removeLogoPiwikTitle();
    });

});
