<html>
    <title></title>
    <head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-grid.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    </head>
    <body>
        <style>
        .modal-header .close {
            margin: 0px !important;
        }
        </style>
    <div class="container">
    <h1>Ticket system</h1>
    <button type="button" class="btn btn-light">Retrive Mail box</button>

    <form action="index.php" method="post">
        <div class="input-group mb-3">
        <input type="text" name="ticket_id" class="form-control" placeholder="Enter mail subject to check ticket is exists or not" aria-label="Recipient's username" aria-describedby="basic-addon2">
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" name='submit' type="submit">Search Ticket in mail box</button>
        </div>
</div>
    </form>
    <!-- <input type="submit" name="search_close"  id="submit"  style="display: 
 none;" value="Create New Ticket"> -->
    <?php
    $submit_value = 0;
        if(isset($_POST['submit']) && isset($_POST['ticket_id']) && !empty($_POST['ticket_id'])){
            // var_dump($_POST['ticket_id']); exit;
            
            $ticket_id = $_POST['ticket_id']; //As Mail subject
            // var_dump($ticket_id); exit;
            if (! function_exists('imap_open')) {
                echo "IMAP is not configured.";
                exit();
            } else {
                ?>
        <div id="listData" class="list-form-container">
            <?php
                
                /* Connecting Gmail server with IMAP */
                //Please update email id and pawwword before test
                $connection = imap_open("{imap.gmail.com:993/ssl/novalidate-cert}INBOX", "yourmailid@example.com", "yourpassword");
                $emailData = imap_search($connection, 'SUBJECT " '.$ticket_id.' "');
                
                if (! empty($emailData)) {
                    $inform_vendor = 1;
                    ?>
            <table>
                <?php
                    foreach ($emailData as $emailIdent) {
                        
                        $overview = imap_fetch_overview($connection, $emailIdent, 0);
                        $message = imap_fetchbody($connection, $emailIdent, '1.1');
                        $messageExcerpt = substr($message, 0, 150);
                        $partialMessage = trim(quoted_printable_decode($messageExcerpt)); 
                        $date = date("d F, Y", strtotime($overview[0]->date));
                        ?>
                <tr>
                    <h2>Ticket Details</h2>
                    <td><span class="column">
                            <?php echo $overview[0]->from; ?>
                    </span></td>
                    <td class="content-div"><span class="column">
                            <?php echo $overview[0]->subject; ?> - <?php echo $partialMessage; ?>
                    </span><span class="date">
                            <?php echo $date; ?>
                    </span></td>
                </tr>
                <?php
                    } // End foreach
                    ?>
            </table>
            <?php
                }// end if
                else{
                    echo 'Ticket Not found! Please create new Ticket';
                    $submit_value = 1;
                } 
                
                imap_close($connection);
            }  
        }else{
            // $submit_value = 1;
            echo "Please enter Ticket Id to Search in Mailbox";
            // var_dump($submit_value); exit;
        }
        ?>
    </div>
    
 <!-- Trigger the modal with a button -->
<!-- <button type="button" class="btn btn-info btn-lg" >Open Modal</button> -->

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Sending message to vendor</h4>
      </div>
      <div class="modal-body">
        <p>Hi, Your Ticket <?php echo $overview[0]->subject;  ?>has been recived!</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<div class="input-group mb-3">
<input type="submit" name="search_close"  id="submit"  style="display: 
 none;" value="Create New Ticket" onClick="document.location.href='creat_ticket.php'">
</div>

<div class="input-group mb-3">
     <input type="submit" style="display: 
 none;"name="inform_vendor"  value="Inform Vendor" id="inform_vendor" data-toggle="modal" data-target="#myModal">
</div>

</div>
<script type="text/javascript">
<?php 
if($submit_value == 1){ ?>
    document.getElementById('submit').style.display = "block";   
   <?php } else if($inform_vendor == 1) { ?>
    document.getElementById('inform_vendor').style.display = "block";   
   <?php } ?>   

//    <?php 
// if($inform_vendor == 1){ ?>
//     document.getElementById('inform_vendor').style.display = "block";   
//    <?php //} ?>

</script>        
    </body>
</html>