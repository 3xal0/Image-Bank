<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="Chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Image Bank</title>
  <FONT face="arial">
    <style>
      * {
        box-sizing: border-box;
      }

      .popup {
        width: 300px;
        height: 300px;
        background-color: lightblue;
        border-radius: 20px;
        position: fixed;
        top: 50%;
        transform: translate(-50%, -50%);
        left: 50%;
        display: none;
      }

      .alert {

        background-color: lightblue;
        border-radius: 20px;
        position: fixed;
        top: 50%;
        transform: translate(-50%, -50%);
        left: 50%;
        display: none;
      }

      .head {
        z-index: 1;
        width: 100%;
        position: fixed;
        display: flex;
        justify-content: space-evenly;
        align-items: baseline;
        background-color: lightblue;
      }

      h1 {
        margin-right: 190px;
        display: inline-flex;
        order: 2;
      }

      .search {
        display: inline-flex;
        order: 3;
      }

      .upload {
        display: inline-flex;
        order: 1;
      }

      .sugg {
        position: fixed;
        top: 5.8%;
        right: 16%;
        font-size: small;
        /*display: none;*/
        background-color: white;
      }

      .js-data-example-ajax {
        width: 200px;
      }

      .boxpop {
        display: flex;
        margin: 20px;
        flex-direction: column;
        row-gap: 30px;
      }

      .image {

        max-height: max-content;
        display: flex;
        max-width: 500px;
        height: 300px;
      }

      .img {
        display: flex;
        flex-direction: column;
        margin: 20px;
        justify-content: center;
        gap: 10px;
        width: 500px;
        height: auto;
        position: relative;
      }

      .parameters {
        justify-content: center;
        text-align: center;
        display: flex;
        width: 30px;
        height: 30px;
      }

      .articles {
        list-style: none;
        margin: 70px;
        display: flex;
        flex-wrap: wrap;
        box-sizing: border-box;
        align-content: flex-start;
      }

      .search-content {

        position: fixed;
        width: 175px;
        height: auto;
        top: 7%;
        right: 10.8%;
        background-color: white;
        border-radius: 2px;

      }

      .predict {
        display: flex;
        flex-direction: column;
      }

      .aff {
        justify-content: center;
        align-items: center;
        display: flex;
        flex-direction: column;
        box-sizing: border-box;


      }

      .long {
        flex-direction: column;
        gap: 30px 10px;
      }

      .rad {
        display: flex;
        gap: 30px 10px;
      }

      .dl:hover {
        opacity: 0.6;

      }

      .file {

        cursor: pointer;
      }

      .screw {
        width: 26px;
        height: 26px;
      }

      .video {
        margin: 20px;
        width: 100%;
        height: 100%;
        vertical-align: middle;

      }

      .picture {
        display: flexbox;
        margin: 20px;
        width: 500;
        height: 300px;
      }

      .pages {
        width: 100%;
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
      }

      .prev {
        background-color: lightblue;
        text-decoration: none;
        font-size: x-large;
        color: black;
      }

      .prev:hover {
        opacity: 0.6;
      }

      .next:hover {
        opacity: 0.6;
      }

      .next {
        background-color: lightblue;
        text-decoration: none;
        font-size: x-large;
        color: black;
      }

      .change {
        display: flex;
        justify-content: space-around;
        background-color: lightblue;
        width: 230px;

      }

      li.vfile {
        height: 300px;
        width: 500px;
        margin: 30px;
      }
    </style>


    <meta charset="UTF-8">

    <!-- Script -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
      var data, search
      var page = 0
      //Jquery function who had advantage to don't refresh the page
      $(function() {

        //Jquery button function who redirect to the SearchController with the url who is completed by the router
        $("#button").click(function(e) {
          e.preventDefault();
          search=document.getElementById("SearchTag").value
          $.ajax({
            url: "../Search/tag=" + document.getElementById("SearchTag").value + "&" + page,
            type: "GET",

            success: function(data) {
              //reset all searching widgets
              document.getElementById("SearchTag").value = ""
              const list = document.getElementById("search-content");
              if (list != null) {
                while (list.hasChildNodes()) {
                  list.removeChild(list.firstChild);
                }
              }
              $(".articles").empty();

              //on success he was create some div who containg images
              while (document.getElementById('aff').hasChildNodes()) {
                document.getElementById('aff').removeChild(document.getElementById('aff').firstChild);
              }

              var contain = document.getElementById('aff');
              var newTH = document.createElement('div');
              if (data == null) {
                return
              }

              newTH.innerHTML = data;
              if (contain != null) {
                contain.prepend(newTH);
              }
              
              
            },
          });

        });


        //Jquery button function who redirect to the UploadController with the url who is completed by the router
        $("#Add").click(function(e) {
          var file_data = document.getElementById("avatar").files[0];
          var form_data = new FormData();
          form_data.append("file", file_data);
          // this treatment get the file who been update
          e.preventDefault();
          $.ajax({
            beforeSend:function(){document.getElementById("alert").style.display= "block"},
            url: "../Upload/tag=" + document.getElementById("T").value + "|url=" + (document.getElementById("avatar").value).substr(12),
            type: "POST",
            processData: false,
            contentType: false,
            data: form_data,
            success: function(data) {
              console.log(data)
              alert("Upload Effectué")
              document.getElementById("T").value=""
            },
            complete: function(){document.getElementById("alert").style.display= "none"},
          });
        });

        //Jquery button function who do predict during the research to help users (use the json file)

        $("#SearchTag").keypress(function() {
          search = $.ajax({
            url: "../Data.json",
            type: "GET",
            dataType: 'json',
            data: {
              return: data
            }, // search term

            success: function(data) {
              var numberpredict = 0
              //if other predict exists, delete it.
              const list = document.getElementById("search-content");
              if (list != null) {
                while (list.hasChildNodes()) {
                  list.removeChild(list.firstChild);
                }
              }
              var tag = []
              var searching = document.getElementById("SearchTag").value
              if (searching == null || searching == '') {
                return
              }
              for (i = 0; i < data.length; i++) {
                if (data[i].toLowerCase().indexOf(searching.toLowerCase()) != -1 && searching != '') { //compare the information get on json than letters taped
                  tag.push(data[i])
                }

              }

              tag.forEach(function(elem) {
                if (numberpredict <= 5) {
                  numberpredict++
                  //for each element correponding, spawn a little select who onclick write automatcally the word
                  var parent = document.getElementById('search-content');
                  if (elem == null) {
                    return
                  }
                  var newTH = document.createElement('div');
                  newTH.innerHTML = elem;

                  newTH.onclick = function() {
                    document.getElementById("SearchTag").value = elem
                    while (parent.hasChildNodes()) {
                      parent.removeChild(parent.firstChild);
                    }
                  };
                  if (parent != null) {
                    parent.appendChild(newTH);
                  }
                }
              });

            }

          });
        });



      $(".prev").click(function() {
        page--
        if(page<1){page=1}
        $.ajax({
          url: "../Pagedown/tag=" + search + "&" + page ,
          type: "GET",

          success: function(data) {
            //reset all searching widgets
            document.getElementById("SearchTag").value = ""
            const list = document.getElementById("search-content");
            if (list != null) {
              while (list.hasChildNodes()) {
                list.removeChild(list.firstChild);
              }
            }

            //on success he was create some div who containg images
            while (document.getElementById('aff').hasChildNodes()) {
              document.getElementById('aff').removeChild(document.getElementById('aff').firstChild);
            }

            var contain = document.getElementById('aff');
            var newTH = document.createElement('div');
            if (data == null) {
              return
            }

            newTH.innerHTML = data;
            if (contain != null) {
              contain.prepend(newTH);
            }
          },
        });
      });

      $(".next").click(function() { //show the next page
        page++
        $.ajax({
          url: "../Pageup/tag=" + search + "&" + page ,
          type: "GET",

          success: function(data) {
            //reset all searching widgets
            document.getElementById("SearchTag").value = ""
            const list = document.getElementById("search-content");
            if (list != null) {
              while (list.hasChildNodes()) {
                list.removeChild(list.firstChild);
              }
            }

            //on success he was create some div who containg images
            while (document.getElementById('aff').hasChildNodes()) {
              document.getElementById('aff').removeChild(document.getElementById('aff').firstChild);
            }

            var contain = document.getElementById('aff');
            var newTH = document.createElement('div');
            if (data == null) {
              return
            }

            newTH.innerHTML = data;
            if (contain != null) {
              contain.prepend(newTH);
            }
          },
        });
      });
    


      });
    </script>

</head>

<body>
  <div class="head">
    <h1> Banque d'Image Axomedia</h1>

    <form method="post" class="search">
      <div class="predict">
        <input type="text" id="SearchTag" name="SearchTag" class="input">
        <div id="search-content" class="search-content">
        </div>
      </div>
      <button type="submit" class="button" id="button">Search</button>
    </form>
    <form method="POST" class="upload" enctype="multipart/form-data">
      <input type="file" src="file.png" name="avatar" id="avatar" class="file">
      <input type="text" id="T" name="T" class="input">
      <button type="submit" id="Add" name="Add" class="button">Add</button>
    </form>
  </div>
  <div id="aff" class="aff"></div>
  <div class="popup" id="popup">
    <div class="boxpop">
      <div class="long"><label>LONGUEUR: <input type="text" name="l" id="l"></label></div>
      <div class="rad"> <label for="radio">PNG</label><input type="radio" name="test" id="radio"></div>
      <div class="rad"><label for="radio2">JPG</label><input type="radio" name="test" id="radio2"></div>
      <div class="rad"><label for="radio3">WEBP</label><input type="radio" name="test" id="radio3"></div>
      <div class="dl"><a id="link" target="_blank" onclick="hrefgenerate()">DOWNLOAD </a></div>
      <div class="dl"><a id="link" target="_blank" onclick="Suppr()">SUPPRIMER </a></div>
    </div>
  </div>
  <div id="footer" class="pages">
    <div class="change">
      <span><a class="prev" href="#">Previous</a></span>
      <span><a class="next" href="#">Next</a></span>
    </div>
  </div>
  <div class="alert" id="alert"><label>CHARGEMENT...</label></div>


  <script>
    x = 0;
    save = 0;

    function spawn(url, info) {
      //this function complete automatcally the popup with the original informations
      cut = info.indexOf(','),
        largeur = info.substr(0, cut);
      type = info.substr(cut + 7);

      document.getElementById("l").value = largeur;
      document.getElementById("popup").name = url;

      switch (type) { // get original type 
        case "jpeg":
          document.getElementById("radio2").checked = true;
          break;
        case "png":
          document.getElementById("radio").checked = true;
          break;
        case "webp":
          document.getElementById("radio3").checked = true;
          break;
      }
      if (!save) {
        //to get or not the popup on the screen and switch between different images popup's
        save = url;
        document.getElementById("popup").style.display = 'block';
        x = 1;
      } else if (save != url && x == 1) {
        save = url;
        this.x = x;
      } else if (save = url) {
        if (x == 0) {
          document.getElementById("popup").style.display = 'block';
          x = 1;
        } else {
          document.getElementById("popup").style.display = 'none';
          x = 0;
        }
      }

    }

    function hrefgenerate() {
      // this function send to the router an URL who redirect in ImageController to DL an image with differentes caracteristics entered in the popup
      par = ""
      if (document.getElementById("radio2").checked) {
        par = "jpeg"
      } else if (document.getElementById("radio").checked) {
        par = "png"
      } else if (document.getElementById("radio3").checked) {
        par = "webp"
      };

      window.open("../Image/param=" + document.getElementById("l").value + "," + par + "," + document.getElementById("popup").name);
    }

    function Suppr() {
      var answer = window.confirm("Voulez vous vraiment le SUPPRIMER ? (La suppression sera effective à la prochaine recherche)");
if (answer) {
  window.open("../Suppr/param=" + document.getElementById("popup").name);
}
else {
   return
}
     
    }

    function trueimg(loc) {
      // Show the true size of an image onclick
      console.log(loc);
      window.open(loc);
    }

  </script>

</body>

</html>