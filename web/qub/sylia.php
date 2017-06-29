<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Sylia</title>

    <!-- Bootstrap -->
    <link href="../assets/vendor/AdminLTE/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<iframe src="../iframe/qb_menu_simple.php" style="width: 100%; height: 50px; " frameborder="0"></iframe>
<div class="container">
    <div class="row">
        <h1 id="titre">Bienvenue dans {module}</h1>
    </div>
    <div class="row list">
        <h3>Utilisateur <small id="user">{user.name}</small></h3>
        <h3>Id Utilisateur
            <small id="id_user"></small>
        </h3>
        <h3>Admin
            <small id="admin">{admin}</small>
        </h3>
        <h3>Equipe
            <small id="team">{team.name}</small>
        </h3>
        <h3>Id Equipe
            <small id="id_team">{team.id}</small>
        </h3>
        <h3>role
            <small id="role">{role}</small>
        </h3>

    </div>
    <div class="row api_call">
        <select name="methode" id="methode">
            <option value="get_user">Get User</option>
            <option value="get_equipe">Get Team</option>
        </select>
    </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="../assets/vendor/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../assets/vendor/AdminLTE/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">
    var post = <?php echo json_encode($_POST); ?>;
    function fillData() {
       $('.list small').each(function () {
           var id = $(this).attr("id");
           $(this).html(post[id]);
       });
        $('#titre').html("Bienvenue dans " + $(document).attr('title'));

    }
    function getUser(id){

        $.ajax({
            method: "GET",
            url: "https://box.dmetthey.fr/api/user/"+id,
            data: {
                apikey : post.apiKey
            },
            dataType : "json"
        }).done(function (result) {
            return result;
        })
    }

    $(function () {

        fillData();
        console.log(getUser(2));


    });

</script>
</body>
</html>