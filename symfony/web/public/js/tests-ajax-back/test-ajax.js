var api = {
  init: function() {
    $('#ajax').on('click', api.getUserCollection);
    $('#ajax-create').on('click', api.createBook);
  },
  getUserCollection: function(evt) {
    evt.preventDefault();
    console.info('je clique...');
    $.ajax({
      url: Routing.generate('user_getcollection'),
      method: 'POST'
    })
    .done(function(data) {
      console.info(data.collection);
    })
  },
  createBook: function(evt) {
    evt.preventDefault();
    var book = {
      title: 'Test',
      description: 'Test',
      page_count: 200,
      // published_at: '2017-01_01',
      published_at: null,
      editor: 'Test',
      picture: '',
      isbn13: 9782203007673,
      isbn10: 2203007672,
    };
    $.ajax({
      dataType: "json",
      url: Routing.generate('book_create'),
      method: 'POST',
      data: { book: JSON.stringify(book)},
    })
    .done(function(data) {
      console.info(data.message);
    })
  },
}

$(api.init);
