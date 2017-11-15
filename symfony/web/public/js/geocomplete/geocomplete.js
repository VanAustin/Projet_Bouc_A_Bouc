var app = {
  init: function() {
    app.$geolocField = $('.autocomplete');
    app.$geolocField.focusin(app.initGeoComplete);
    app.$geolocField.focusout(app.checkLatLng);
    app.$geolocField.keydown(app.checkTabulation);
  },
  initGeoComplete: function() {
    app.$geolocField.geocomplete({
      details: "#fos_user_registration_form",
      detailsAttribute: "data-geo",
      find: "app.$geolocField.val()"
    });
  },
  checkLatLng: function() {
    if(app.$geolocField.val() === '') {
      $('#fos_user_registration_form_lat').val('');
      $('#fos_user_registration_form_lng').val('');
      $('#fos_user_profile_form_lat').val('');
      $('#fos_user_profile_form_lng').val('');
    }
  },
  checkTabulation: function(evt) {
    if (evt.keyCode == 9) {
      app.$geolocField.geocomplete("find", app.$geolocField.val());
    }
  }
};

$(app.init);
