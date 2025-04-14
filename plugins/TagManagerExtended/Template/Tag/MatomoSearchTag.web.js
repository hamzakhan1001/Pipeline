(function () {
  return function (parameters, TagManager) {
    this.fire = function () {

      var searchKeyword = parameters.get("search_keyword");
      var searchCategory = parameters.get("search_category");
      var searchTotal = parameters.get("search_total");

      window._paq = window._paq || [];
      window._paq.push(["trackSiteSearch", searchKeyword, searchCategory, searchTotal]);

    };
  };
})();
