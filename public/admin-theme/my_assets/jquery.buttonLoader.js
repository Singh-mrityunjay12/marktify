/*A jQuery plugin which add loading indicators into buttons
* By Minoli Perera
* MIT Licensed.
*/
(function ($) {
    $('.has-spinner').attr("disabled", false);
    $.fn.buttonLoader = function (action) {
        var self = $(this);
        if (action == 'start') {
            if ($(self).attr("disabled") == "disabled") {
                return false;
            }
            $('.has-spinner').attr("disabled", true);
            $(self).attr('data-btn-text', $(self).text());
            var text = 'Loading';
            if ($(self).attr('data-load-text') != undefined && $(self).attr('data-load-text') != "") {
                var text = $(self).attr('data-load-text');
            }
            $(self).html('<div class="spinner123"><i class="fa fa-spinner fa-spin" title="button-loader"></i></div> ' + text);
            $(self).addClass('active');
        }
        if (action == 'stop') {
            $(self).html($(self).attr('data-btn-text'));
            $(self).removeClass('active');
            $('.has-spinner').attr("disabled", false);
        }
    }
})(jQuery);

(function ($) {
    $('.has-spinner').attr("disabled", false);
    $.fn.buttonLoaderwithhtml = function (action) {
        var self = $(this);
        if (action == 'start') {
            if ($(self).attr("disabled") == "disabled") {
                return false;
            }
            $('.has-spinner').attr("disabled", true);
            $(self).attr('data-btn-text', $(self).html());
            var text = 'Loading';
            console.log($(self).attr('data-load-text'));
            if ($(self).attr('data-load-text') != undefined && $(self).attr('data-load-text') != "") {
                var text = $(self).attr('data-load-text');
            }
            $(self).html('<div class="spinner"><i class="fa fa-spinner fa-spin" title="button-loader"></i></div> ' + text);
            $(self).addClass('active');
        }
        if (action == 'stop') {
            $(self).html($(self).attr('data-btn-text'));
            $(self).removeClass('active');
            $('.has-spinner').attr("disabled", false);
        }
    }
})(jQuery);

