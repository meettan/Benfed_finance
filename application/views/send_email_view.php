<!DOCTYPE html>
<html>
<head>
    <title>Send Financial Report</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body { font-family: Arial; text-align: center; margin-top: 100px; }
        button { padding: 10px 20px; font-size: 16px; }
        #status { margin-top: 20px; font-weight: bold; }
    </style>
</head>
<body>

    <h2>📊 Send Financial Report</h2>
    <button id="sendBtn">Send Report via Email</button>

    <div id="status"></div>

    <script>
        $(document).ready(function() {
            $("#sendBtn").click(function() {
                $("#status").html("⏳ Sending report, please wait...");
                $.ajax({
                    url: "<?php echo site_url('SendReport/sendmail'); ?>",
                    type: "POST",
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {
                            $("#status").html("<span style='color:green;'>" + response.message + "</span>");
                        } else {
                            $("#status").html("<span style='color:red;'>" + response.message + "</span>");
                            console.log(response.debug || '');
                        }
                    },
                    error: function() {
                        $("#status").html("<span style='color:red;'>❌   Error connecting to server.</span>");
                    }
                });
            });
        });
    </script>

</body>
</html>
