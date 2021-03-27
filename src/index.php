<!DOCTYPE html>
<html lang="fr">

<?php
session_start();
if (!isset($_SESSION['name'])) {
    header('Location: https://jam.shurisko.fr');
    return;
}

?>

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <meta charset="UTF-8">
    <title>EpiChat (<?php echo $_SESSION['name']; ?>)</title>
</head>

<body style="background-color: darkgray">
<form>

    <div id="chat" class="form-group alert alert-dark" role="alert" style="margin: 20px auto; width: 1200px;">
        <div data-spy="scroll" data-target="#chat">
        </div>

        <div id="chatbox">
            <?php
            if(file_exists("./log.html") && filesize("./log.html") > 0){
                $handle = fopen("log.html", "r");
                $contents = fread($handle, filesize("./log.html"));
                fclose($handle);

                echo $contents;
            }
            ?>
        </div>

        <label style="text-align: center; margin: 300px auto"></label>
        <div class="form-row">
            <div class="form-group col-md-12">
                <textarea id="usermsg" class="form-control" aria-describedby="usernameHelp" <?php echo 'placeholder="'; echo $_SESSION['name']; echo ' Type Here"'?> rows="1"></textarea>
                <button name="submitMsg" type="button" onclick="writeLog()" class="btn btn-success" style="margin: 5px auto;width: 1155px;"><b>Send</b></button>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js">

    $(document).ready(function () {
        setInterval (loadLog, 2500);
    });

    function writeLog() {
        let msg = document.getElementById("usermsg").value;
        console.log(msg);
        sendData(msg);
        document.getElementById("usermsg").value=null;
        return false;
    }

    function sendData(string) {
        $.ajax({
            url: "post_log.php",
            data: 'text:' + string,
            type: 'POST'
        });
    }

    function loadLog(){

        $.ajax({
            url: "./log.html",
            cache: false,
            success: function(html){
                $("#chatbox").html(html); //Insert chat log into the #chatbox div
            },
        });
    }
</script>



</body>
</html>

