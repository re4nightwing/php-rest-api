<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Jquery test</title>
</head>
<body>
  <div id="user_invitation_new"></div>
  <table border="1" id="table">
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Body</th>
      <th>Author</th>
      <th>Category</th>
      <th>Action</th>
    </tr>
  </table>
  <form action="index.php" method="post" id="formsub">
    <br><br>
    <input type="hidden" name="id" id="post_id">
    <label for="title">title</label>
    <input type="text" name="title" id="title"><br><br>
    <label for="body">body</label>
    <textarea name="body" id="body" cols="30" rows="10"></textarea><br><br>
    <label for="author">author</label>
    <input type="text" name="author" id="author"><br><br>
    <label for="Category">Category ID</label>
    <input type="number" name="category_id" id="Category"><br><br>
    <input type="submit" value="submit" name="sub" id="create">
    <button type="button" id="update" onclick="updateThis()" hidden>Update</button>
  </form>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script>
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: 'http://localhost/rest-api-php/api/post/read.php',
      data: $('#user_invitation_new').serialize(),
      success: function(response) {
        var data = response.data;
        $.each(data, function(index, element){
          var dimensions = $.map( data[index], function( value, index ) {
            return value;
          });
          $('#table').append("<tr><td>"+dimensions[0]+"</td><td>"+dimensions[1]+"</td><td>"+dimensions[2]+"</td><td>"+dimensions[3]+"</td><td>"+dimensions[5]+"</td><td><a href='' onclick='deleteThis("+dimensions[0]+")'>Delete</a><br><a href='#' onclick='getRow("+dimensions[0]+")'>Edit</a></td><tr>");
        });
      }
    });

    function getRow(itemId){
      $.getJSON('http://localhost/rest-api-php/api/post/read_single.php?id=' + itemId, function(json_data){
        var values = $.map( json_data, function( value, index ) {
          return value;
        });
        
        $('#post_id').val(values[0]);
        $('#title').val(values[1]);
        $('#body').val(values[2]);
        $('#author').val(values[3]);
        $('#Category').val(values[4]);

        $('#create').attr('hidden', true);
        $('#update').attr('hidden', false);
      });
    }

    function deleteThis(itemId){
      $.ajax({
        type: "DELETE",
        url: "http://localhost/rest-api-php/api/post/delete.php",
        data: JSON.stringify({id: itemId}),// now data come in this function
        contentType: "application/json; charset=utf-8",
        crossDomain: true,
        dataType: "json",
        success: function (result) {
          alert(result['message']);
        },
        error: function (result) {
          alert(result['message']);
        }
      });
    }

    function submitform(itemId){
      $.ajax({
        type: "POST",
        url: "http://localhost/rest-api-php/api/post/create.php",
        data: JSON.stringify(itemId),// now data come in this function
        contentType: "application/json; charset=utf-8",
        crossDomain: true,
        dataType: "json",
        success: function (data, status, jqXHR) {
          console.log("success");
          alert("success");
        },
        error: function (jqXHR, status) {
          console.log(jqXHR);
          alert('fail' + status.code);
        }
      });
    }

    function updateThis(){
      var arr = $("#formsub").serializeArray();
      var json_arr = {};

      $.map(arr, function(key, val){
        json_arr[key['name']] = key['value'];
      });

      $.ajax({
        type: "PUT",
        url: "http://localhost/rest-api-php/api/post/update.php",
        data: JSON.stringify(json_arr),// now data come in this function
        contentType: "application/json; charset=utf-8",
        crossDomain: true,
        dataType: "json",
        success: function (result) {
          alert(result['message']);
        },
        error: function (result) {
          alert(result['message']);
        }
      });
    }

    $( "#formsub" ).submit(function( event ) {
      event.preventDefault();

      var arr = $("#formsub").serializeArray();
      var json_arr = {};

      $.map(arr, function(key, val){
        json_arr[key['name']] = key['value'];
      });

      submitform(json_arr);
    });
  </script>
</body>
</html>