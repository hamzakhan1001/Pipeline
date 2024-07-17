(function () {
    return function (parameters, TagManager) {
        this.fire = function () {

          var APP_ID = parameters.get("app_id");

          window.intercomSettings = {
            api_base: parameters.get("api_base"),
            app_id: APP_ID,
            user_id: parameters.get("user_id"),
            name: parameters.get("user_name"),
            email: parameters.get("user_email"),
            created_at: parameters.get("user_created_at"),
            alignment: parameters.get("alignment"),
            horizontal_padding: parameters.get("horizontal_padding"),
            vertical_padding: parameters.get("vertical_padding")
          };

          (function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('update',w.intercomSettings);}else{var d=document;var i=function(){i.c(arguments);};i.q=[];i.c=function(args){i.q.push(args);};w.Intercom=i;var l=function(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/' + APP_ID;var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s, x);};if(document.readyState==='complete'){l();}else if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();

        };
    };
})();
