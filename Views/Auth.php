<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <FONT face="arial">
    <style>
        body{
            background-color: gray;

        }
        .contain{
        display: flex;
        width: 300px;
        height: 530px;
        background-color: lightblue;
        border-radius: 20px;
        position: fixed;
        top: 50%;
        transform: translate(-50%, -50%);
        left: 50%;
        flex-direction: column;
        justify-content:space-evenly;
        text-align: center;

        }

        h3{
            font-size:xx-large;
            justify-content: center;
            cursor: pointer;
        }

        .Connexion{
            width:100px;
            height: auto;
        }
        .Username{
            border-radius: 5px;
        }
        .Password{
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <div class="contain">
        <div><h3>Username</h3></div>
        <div><input type="text" class="Username" id="Username"></div>
        <div><h3>Password</h3></div>
        <div><input type="text" class="Password" id="Password"></div>
        <div><a id="link" target="_blank" onclick="connexion()" ><h3>Connexion</h3> </a></div>
       
    </div>

    <script>
        //Get input password and username and redirect to the home with the parameters to check the permissions
        function connexion(){
            window.location.href="Home/user="+ document.getElementById("Username").value +",pass="+ document.getElementById("Password").value;
        }
    </script>
</body>
</html>