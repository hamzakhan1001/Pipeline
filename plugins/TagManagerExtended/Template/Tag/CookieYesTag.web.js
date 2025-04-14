(function () {
  return function (parameters, TagManager) {
    this.fire = function () {

      var websiteKey = parameters.get("cookiebotWebsiteKey");

      var src = "https://cdn-cookieyes.com/client_data/";
      src += websiteKey;
      src += "/script.js";

      (function (d, s) {
        var t = d.getElementsByTagName(s)[0], e = d.createElement(s);
        e.id = "cookieyes";
        e.type = "text/javascript";
        e.src = src;
        t.parentNode.insertBefore(e, t);
      })(document, "script");

    };
  };
})();
