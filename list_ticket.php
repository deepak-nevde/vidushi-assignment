<html>
    <title></title>
    <head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-grid.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="js/3.4.1/js/bootstrap.min.js"></script>
    </head>
    <body>
        
    <div class="container">
    <h1>List of Tickets</h1>   
    <div class="input-group mb-3">
        <input type="submit" name="search_ticket"  id="submit" value="Search Ticket in Mailbox" onClick="document.location.href='index.php'">
      </div>
<?php
include 'db_config.php';
 $tickets = mysqli_query($conn,"select * from ticket_info;");
 // fetch data in array format
 ?>
  <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Customer Name</th>
      <th scope="col">Agent Name</th>
      <th scope="col">Priority</th>
      <th scope="col">Query</th>
    </tr>
  </thead>
  <?php
 while ($tickets_row = mysqli_fetch_array($tickets, MYSQLI_ASSOC)) {
    // var_dump($tickets_row);
?>

  <tbody>
    <tr>
    <th scope="row"><a type="submit" href="edit.php?ticket_id=<?php echo $tickets_row['id']; ?>" value="update" style="text-decoration:underline"><?php echo $tickets_row['id']; ?></a><?php //echo $tickets_row['id'];?></th>  
    <!-- <td class=" "><a type="submit" href="edit.php?issue_id=<?php //echo $row['id']; ?>" value="update" style="text-decoration:underline"><?php //echo $row['issue_id']; ?></a></td> -->
      <td><?php echo $tickets_row['customer_name'];?></td>
      <td><?php echo $tickets_row['agent_name'];?></td>
      <td><?php echo $tickets_row['priority'];?></td>
      <td><?php echo $tickets_row['query'];?></td>
    </tr>
  </tbody>

<?php } ?>
</table>

 </div>
 <style>
 .green{
  background-color:lightgreen;
}
.solamon{
  background-color:red;
}
.yellow{
  background-color:yellow;
}
.orange{
  background-color:orange;
}
 </style>
 <script>
  $(document).ready(function () {

      //var priority = $(".form-check-input").val();
      $("tr").each(function(){
        var col_val = $(this).find("td:eq(2)").text();
        console.log(col_val);
        if (col_val === "72 hours"){
          $(this).addClass('green');  //the selected class colors the row green//
        } else if(col_val ==="48 hours") {
          $(this).addClass('orange');
        }else if(col_val === "12 hours"){
          $(this).addClass('yellow');
        }else if(col_val === "6 hours"){
          $(this).addClass('solamon');
        }
      });
  });
</script>
 </body>
</html>