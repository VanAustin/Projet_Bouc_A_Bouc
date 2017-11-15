function handleResponse(response) {
  for (var i = 0; i < response.items.length; i++) {
    var item = response.items[i];
    console.info(i);
    document.getElementById("content").innerHTML +=
      "<br> TITRE : " + item.volumeInfo.title
    ;
    if (item.volumeInfo.authors) {
      item.volumeInfo.authors.forEach(function(author) {
        document.getElementById("content").innerHTML +=
          "<br> AUTEUR : " + author;
        }
      );
    }
    document.getElementById("content").innerHTML +=
      "<br> EDITEUR : " + item.volumeInfo.publisher +
      "<br> DATE DE PUBLICATION : " + item.volumeInfo.publishedDate +
      "<br> DESCRIPTION : " + item.volumeInfo.description +
      "<br> NB DE PAGES : " + item.volumeInfo.pageCount
    ;
    if (item.volumeInfo.industryIdentifiers) {
      item.volumeInfo.industryIdentifiers.forEach(function(isbn) {
        document.getElementById("content").innerHTML +=
          "<br>" + isbn.type + " : " + isbn.identifier;
        }
      );
    }
    item.volumeInfo.imageLinks ? document.getElementById("content").innerHTML += "<br>" + "<img src=\"" + item.volumeInfo.imageLinks.thumbnail + "\"><hr>" : document.getElementById("content").innerHTML += "<hr>"
  }
}
