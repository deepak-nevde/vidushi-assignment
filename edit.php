<?php
include "db_config.php";

// var_dump($_REQUEST['issue_id']); exit;
if(isset($_REQUEST['ticket_id'])){
    $req_issue_id = $_REQUEST['ticket_id'];
    $result = mysqli_query($conn,"SELECT * from ticket_info where id= '$req_issue_id'" );
    // var_dump($result); exit;

    $name = isset($_POST['name'])?$_POST['name']:'';
    $agent_name = isset($_POST['agent_name'])?$_POST['agent_name']:'';
    $priority = isset($_POST['priority'])?$_POST['priority']:'';
    $query = isset($_POST['query'])?$_POST['query']:'';

    if(isset($_POST['update'])){
        $sql = "UPDATE ticket_info SET 
        customer_name	= '$name', 
        agent_name = '$agent_name', 
        query = '$query', 
        priority = '$priority'
         WHERE id = '$req_issue_id'";
 
         if ($conn->query($sql) === TRUE) {
             echo "New record created successfully";
             header('Location:list_ticket.php');
         } else {
             echo "Error: " . $sql . "<br>" . $conn->error;
         }
    }
    
  }

?>

<!DOCTYPE html>
<html>

<head>
  <title>Create Ticket</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />
</head>

<body class="container">
  <div class="row mt-3">
    <div class="col-md-6">
      <h4 class="mb-3">Update Ticket</h4>
      <form id="form" method="post" action="">
      <?php while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) { 

                            ?>
        <div class="form-group">
          <label for="name">Customer Name</label>
          <input type="text" class="form-control" name="name" id="name" value="<?php echo $row['customer_name']; ?>">
        </div>
        <div class="form-group">
          <label for="name">Agent Name</label>
          <input type="text" class="form-control" name="agent_name" id="agent_name" value="<?php echo $row['agent_name']; ?>">
        </div>

        <label for="name">Prioritisation/Status</label>
        <div class="form-check">
        <input class="form-check-input" type="radio" name="priority" id="priorityRadios1" value="72 hours"  <?php echo ($row['priority']== '72 hours') ?  "checked" : "" ;  ?>>
        <label class="form-check-label" for="priorityRadios1" >
        72 hours
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="priority" id="priorityRadios1" value="48 hours" <?php echo ($row['priority']== '48 hours') ?  "checked" : "" ;  ?>>
        <label class="form-check-label" for="priorityRadios1">
        48 hours
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="priority" id="priorityRadios1" value="12 hours" <?php echo ($row['priority']== '12 hours') ?  "checked" : "" ;  ?>>
        <label class="form-check-label" for="priorityRadios1">
        12 hours
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="priority" id="priorityRadios1" value="6 hours" <?php echo ($row['priority']== '6 hours') ?  "checked" : "" ;  ?>>
        <label class="form-check-label" for="priorityRadios1">
        6 hours
        </label>
      </div>
      <br>
        <div class="form-group">
        <label for="exampleFormControlTextarea1">Query</label>
        <textarea class="form-control" name="query" id="exampleFormControlTextarea1" rows="3" ><?php echo $row['query']; ?></textarea>
      </div>
        <input type="submit" class="btn btn-primary" value="Submit" name="update"/>
        <?php } ?>
      </form>
    </div>
  </div>
</body> 
<style>
  .error {
    color: red;
  }
</style>
<script>
  $(document).ready(function () {
    $('#form').validate({
      rules: {
        name: {
          required: true
        },
        agent_name: {
          required: true
        },
      },
      messages: {
        name: 'Please enter Name.',
        agent_name: 'Please enter Agent Name.'
      },
      submitHandler: function (form) {
        form.submit();
      }
    });
  });
</script>

</html>