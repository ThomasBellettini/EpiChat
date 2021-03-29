<!DOCTYPE html>
<html lang="fr">

<?php
session_start();
if (!isset($_SESSION['name'])) {
    header('Location: https://jam.shurisko.fr');
    return;
}

$pdo = new PDO('mysql:host=localhost;dbname=web;charset=utf8', 'web_api', '123456789',
    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
if ($pdo) {
    $requests = $pdo->prepare("SELECT * FROM jam_account WHERE username='" . $_SESSION['name'] . "'");
    $requests->execute(array($_SESSION['name']));

    $rank = 2;
    while ($donner = $requests->fetch()) {
        $_SESSION['rank'] = $donner['Rank'];
    }
    if (!isset($_SESSION['rank']))
        $_SESSION = $rank;
    if (isset($_SESSION['guest']) == true)
        $_SESSION['rank'] = 2;
    echo "<script> console.log(".$_SESSION['rank'] .")</script>";
    $requests->closeCursor();
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

        <label style="text-align: center; margin: 50px auto"></label>
        <div class="form-row">
            <in class="form-group col-md-12">
                <textarea id="usermsg" class="form-control" aria-describedby="usernameHelp" maxlength="100" <?php echo 'placeholder="'; echo $_SESSION['name']; echo ' Type Here"'?> rows="1"></textarea>
                <button name="submitMsg" type="button" id="clicksend" onclick="writeLog()" class="btn btn-success" style="margin: 5px auto;width: 1155px;"><b>Send</b></button>
                <button name="logout" type="button" id="logout" onclick="logout_client()" class="btn btn-danger" style="margin: 5px auto;width: 1155px;"><b>Logout</b></button>
        </div>
        </div>
    </div>
</form>

<audio class="my_audio" controls preload="none" hidden>
    <source src="./audio/song.mp3" type="audio/mpeg">
</audio>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript">

    var stopsong = false;

    $(".my_audio").trigger('load');

    document.getElementById("usermsg").addEventListener("keyup", function (event) {
        if (event.keyCode == 13) {
            if (document.getElementById("usermsg").value.replace(/(\r\n|\n|\r)/gm, "").length <= 0 || document.getElementById("usermsg").value.length >= 100) {
                document.getElementById("usermsg").value=null;
            } else {
                writeLog();
            }
        }
    })

    $(document).ready(function () {
        setInterval (loadLog, 1000);
    });

    function logout_client() {
        $.ajax({
            url: "https://jam.shurisko.fr/chat/disconnect.php",
            cache: false
        });
        document.location.reload();
    }

    function writeLog() {
        let msg = document.getElementById("usermsg").value;
        if (msg.toLowerCase().startsWith("stopsong")) {
            stopsong = true;
            $(".my_audio").trigger('pause');
            document.getElementById("usermsg").value=null;
            return;
        }
        if (msg.length > 0 && msg.length < 100) {
            sendData(msg);
            if (!stopsong)
                play_audio('play');
        }
        document.getElementById("usermsg").value=null;
        return false;
    }

    function play_audio(task) {
        if(task == 'play'){
            $(".my_audio").trigger('play');
        }
        if(task == 'stop'){
            $(".my_audio").trigger('pause');
            $(".my_audio").prop("currentTime",0);
        }
    }

    function sendData(string) {
        $.ajax({
            url: "https://jam.shurisko.fr/chat/postlog.php",
            cache: false,
            data: {text: string},
            type: 'POST',
            dataType: "json",
            success: function (l) {
                loadLog();
            }
        });
    }

    function loadLog(){
        var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20;
        $.ajax({
            url: "log.html",
            cache: false,
            success: function(html){
                $("#chatbox").html(html);

                //Auto-scroll
                var newscrollHeight = $("#chatbox").attr("scrollHeight") - 20;
                if(newscrollHeight > oldscrollHeight){
                    $("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal');
                }
            },
        });
    }
</script>



</body>
</html>

