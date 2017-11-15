(function($) {
  $(window).on('load', function() {
    $('.switch-tabs').switchTabs();

    $(".switch-tabs-nav li a").click(function(){
      localStorage.setItem("friend", $(this).attr("id"));
    });
    var active = localStorage.getItem("friend") || "local-collection";//<default
    $(".switch-tabs-nav li").each(function(){
      $(this).removeClass("active");
    });
    $("#"+active).parent().addClass("active");

    $('.switch-tabs').each(function() {
      $(this).each(function() {
        var el = $(this).children('.switch-tabs-nav'),
        switchBody = el.siblings('.switch-tabs-body');
        switchBody.children('.switch-content').hide();
        var activeTab = $("#"+active).attr('href');
        $(activeTab).show();
        return false;

      });
    });
  });
  $.fn.switchTabs = function() {
    $(this).each(function() {
      var el = $(this).children('.switch-tabs-nav'),
        switchBody = el.siblings('.switch-tabs-body');

      // Click switch tab
      switchBody.children('.switch-content:not(:first)').hide();
      el.on('click', 'a', function() {
        el.children().removeClass('active');
        $(this).parent().addClass('active');
        switchBody.children('.switch-content').hide();

        var activeTab = $(this).attr('href');
        $(activeTab).show();
        return false;
      });

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
