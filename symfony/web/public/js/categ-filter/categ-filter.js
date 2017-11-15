var filter = {
  init: function() {
    filter.loadFilter();
    $('.filter-choice').on('click', filter.changeFilter);
  },
  loadFilter: function() {
    var filter = localStorage.getItem('filter') || 'all';//<default
    $('#' + filter + '').parent().addClass('active');
    $('.all').hide();
    $('.' + filter + '').show();
  },
  changeFilter: function(evt) {
    evt.preventDefault();
    $('.all').hide();
    var filter = $(this).attr('id');
    $('.filter-choice').parent().removeClass('active');
    $(this).parent().addClass('active');
    $('.' + filter + '').show();
    localStorage.setItem('filter', $(this).attr('id'));
  }
}

$(filter.init);

(function($) {
  $(window).on('load', function() {
    $('.switch-tabs').switchTabs();
  });
  $.fn.switchTabs = function() {
    $(this).each(function() {
      var el = $(this).children('.switch-tabs-nav');
      var totalWidth = 0;
      el.children().each(function() {
        var width = $(this).outerWidth();
        totalWidth += width;
      });
      $(window).resize(function() {
        var widthWrap = el.outerWidth();
        if (widthWrap <= totalWidth) {
          el.addClass('responsive');
        } else {
          el.removeClass('responsive');
        }
      }).trigger('resize');
    });
  }
})(jQuery);