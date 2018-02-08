(function ($) {
    $.fn.flexVerticalCenter = function (onAttribute) {
        return this.each(function () {
            var $this = $(this);
            var attribute = onAttribute || 'margin-top';
            var resizer = function () {
                $this.css(attribute, (($this.parent().height() - $this.height()) / 2));
            };
            resizer();
            $(window).resize(resizer);
            $this.find('img').load(resizer);
        });
    };
})(jQuery);