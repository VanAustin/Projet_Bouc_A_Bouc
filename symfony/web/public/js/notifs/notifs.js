var notifs = {
  'count': 0,
  init: function() {
    notifs.getFriendNotifs();
    notifs.getLoanNotifs();
  },
  getFriendNotifs: function() {
    $.ajax({
      url: Routing.generate('friend_notifs'),
      method: 'POST'
    })
    .done(function(data) {
      if(data.friendNotifs > 0) {
        $('#friend-notifs').text(data.friendNotifs);
        $('#friend-notifs2').text(data.friendNotifs);
        notifs.count += data.friendNotifs;
        notifs.burgerMenu();
      }
    });
  },
  getLoanNotifs: function() {
    $.ajax({
      url: Routing.generate('loan_notifs'),
      method: 'POST'
    })
    .done(function(data) {
      if(data.loanRequests > 0) {
        $('#loan-notifs').text(data.loanRequests);
        $('#loan-notifs2').text(data.loanRequests);
        notifs.count += data.loanRequests;
        notifs.burgerMenu();
      }
    })
  },
  burgerMenu: function() {
    if (notifs.count > 0) {
      $('#burger-notifs').text(notifs.count);
    }
  }
}

$(notifs.init);