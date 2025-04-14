/*!
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */
window.SEOWebVitals = {
    setupUrls: function () {
        var ajaxRequest = new ajaxHelper();
        $('#seowebvitals-setup-urls').remove();
        ajaxRequest.setLoadingElement('#seowebvitals-working');
        ajaxRequest.addParams({
            module: 'API',
            method: 'SEOWebVitals.configureTopPageUrls',
            format: 'JSON'
        }, 'get');
        ajaxRequest.setCallback(
            function (response) {
                $('#seowebvitals-success').fadeIn();
                $('#seowebvitals-reload').fadeIn();
            }
        );
        ajaxRequest.send();
    },

    reloadPage: function () {
        window.location.reload();
    }
};
