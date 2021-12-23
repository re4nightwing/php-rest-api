<?php
$url = "http://localhost/rest-api-php/api/post/read.php";
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, 4);
$json = curl_exec($ch);

if(!$json) {
  echo curl_error($ch);
}

curl_close($ch);
$return_data = json_decode($json,true);

if(isset($_POST['sub'])){
  $title = $_POST['title'];
  $body = $_POST['body'];
  $author = $_POST['author'];
  $category_id = $_POST['category_id'];

  $url = 'http://localhost/rest-api-php/api/post/create.php';
  $data = array('title' => $title, 'body' => $body, 'author' => $author, 'category_id' => $category_id);
  print_r($data);
  $options = array(
    'http' => array(
      'method'  => 'POST',
      'content' => json_encode( $data ),
      'header'=>  "Content-Type: application/json\r\n" .
                  "Accept: application/json\r\n"
      )
  );
  print_r($options);
  $context  = stream_context_create( $options );
  $result = file_get_contents( $url, false, $context );
  $response = json_decode( $result );
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>API test</title>
</head>
<body>
  <table border="1">
    <tr>
      <th><?php echo 'id';?></th>
      <th><?php echo 'title';?></th>
      <th><?php echo 'body';?></th>
      <th><?php echo 'author';?></th>
      <th><?php echo 'category_id';?></th>
      <th><?php echo 'category_name';?></th>
    </tr>
  <?php
  //for json object array
  /* foreach($return_data->data as $item){
    foreach($item as $key=>$val){
      echo $key." => ";
      echo $val;
      echo "<br>";
    }
    echo "<br>";
  } */
  //for array
  foreach($return_data as $data){
    foreach($data as $row){
      ?>
      <tr>
        <td><?php echo $row['id'];?></td>
        <td><?php echo $row['title'];?></td>
        <td><?php echo $row['body'];?></td>
        <td><?php echo $row['author'];?></td>
        <td><?php echo $row['category_id'];?></td>
        <td><?php echo $row['category_name'];?></td>
      </tr>
      <?php
    }
  }
  ?>
  </table>
  <form action="index.php" method="post">
    <label for="">title</label>
    <input type="text" name="title" id="">
    <label for="">body</label>
    <textarea name="body" id="" cols="30" rows="10"></textarea>
    <label for="">author</label>
    <input type="text" name="author" id="">
    <label for="">Category ID</label>
    <input type="number" name="category_id" id="">
    <input type="submit" value="submit" name="sub">
  </form>
</body>
</html>