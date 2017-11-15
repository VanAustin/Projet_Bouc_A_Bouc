var autoclose = {
  init: function() {
    autoclose.close();
  },
  close: function() {
    setTimeout(function() {
      $(".alert").alert('close')
    }, 3000);
  },
};

$(autoclose.init());
