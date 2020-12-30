<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>

    <form method="post" id="paymentForm">
        <div class="container">
            <h1>Jpesa Payment</h1>
            <p>Please fill in this form to make the payment.</p>
            <hr>

            <label for="phone"><b>Phone Number</b></label>
            <input type="text" placeholder="Enter Phone Number e.g 256700000000" name="phone" required>

            <label for="amount"><b>Amount</b></label>
            <input type="number" placeholder="Enter Amount" name="amount" id="amount" required>

            <button type="submit" class="registerbtn" name="make-payment-online" id="register"></button>
            <center><div class="loader" id="loader" style="display: none;"></div></center>
        </div>

    </form>

</body>

</html>
<script src="https://system.kessd.org/primary/js/jquery.min.js"></script>
<script src="https://system.kessd.org/primary/js/popper.min.js"></script>
<script src="https://system.kessd.org/primary/js/bootstrap.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#paymentForm').on('submit',function(e) {
    	e.preventDefault();
    	// alert($("#paymentForm").serialize());
    	$("#loader").fadeIn();
        $.ajax({
            type: "POST",
            url: "make-payment.php",
            data: $("#paymentForm").serialize()+"&make-payment-online",
            cache: false,
            success: function(res) {
            	console.log(res);
            	var response = JSON.parse(res);
            	if (response.api_status === "success") {
            		console.log(response.api_status);
            		//add bootstrap alert notifications, having the messages
            		var checker = window.setInterval(function(){
						checkStatus(response.tid, checker);
					}, 4000);
            	}else if(response.api_status === "error"){
            		console.log(response.api_status);
            		$("#loader").fadeOut();
            		//add bootstrap alert notifications, having the messages
            	}
            }
        });
    });
});
function checkStatus(val, intervalHolder){
	var tid = val;
	console.log(tid);
	// tid = "56E462DB563856EFBF50D5B21A651A7E";
	$.ajax({
        type: "POST",
        url: "check-payment.php",
        data: ({
        	tid: tid
        }),
        cache: false,
        success: function(res) {
        	console.log(res);
        	var response = JSON.parse(res);
        	if (response.status === "approved") {
        		console.log("The Order has been completed");
        		$("#loader").fadeOut();
        		clearInterval(intervalHolder);
        		//add bootstrap alert notifications, having the messages
        	}else if(response.status === "pending"){
        		console.log("The Order is still processing");
        		//add bootstrap alert notifications, having the messages
        	}
        	else if(response.status === "error"){
        		console.log("The Order has failed");
        		clearInterval(intervalHolder);
        		//add bootstrap alert notifications, having the messages
        	}
        }
    });
}
</script>

<!-- 56E462DB563856EFBF50D5B21A651A7E -->