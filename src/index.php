<!DOCTYPE html>
<html lang="fr">

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <meta charset="UTF-8">
    <title>Chat %name%</title>
</head>

<body style="background-color: darkgray">
<form>

    <div id="chat" class="form-group alert alert-dark" role="alert" style="margin: 20px auto; width: 1200px;">
        <div data-spy="scroll" data-target="#chat">
        </div>

        <div id="chatbox"></div>


        <form name="message" action="">
        </form>

        <label for="send" style="text-align: center; margin: 300px auto"></label>
        <div class="form-row">
            <div class="form-group col-md-12">
                <textarea name="usermsg" id="send" class="form-control" aria-describedby="usernameHelp" placeholder="%name% type here !" rows="1"></textarea>
                <button type="submit" class="btn btn-success" style="margin: 5px auto;width: 1155px;"><b>Send</b></button>
            </div>
        </div>
    </div>
</form>



</body>
</html>

