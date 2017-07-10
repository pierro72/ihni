<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Sylia</title>

    <!-- Bootstrap -->
    <link href="assets/vendor/AdminLTE/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<iframe src="iframe/qb_menu_simple.php" style="width: 100%; height: 50px; " frameborder="0"></iframe>
<div class="container">
    <div class="row">
        <h1 id="titre">Bienvenue dans {module}</h1>
    </div>
    <div class="row list">
        <h3>apiKey
            <small id="apiKey"></small>
        </h3>
        <h3>Utilisateur
            <small id="user">{user.name}</small>
        </h3>
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
    <div id="api_form" class="row">
        <select name="methode" id="methode">
            <option value="" disabled selected hidden>Please Choose...</option>
            <option id="get_user">Get User</option>
            <option id="get_equipe">Get Team</option>
        </select>

    </div>

    <div class="row">
        <div class="col-md-8">
            <div id="address" class="well">/api/</div>
        </div>
        <button id="sendbtn" type="button" class="btn btn-primary" disabled="disabled">Envoyer la requête</button>
    </div>


</div>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="assets/vendor/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="assets/vendor/AdminLTE/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">
    var post = <?php echo json_encode($_POST); ?>;
    var userTeams;
    var userInfo;
    var teamUsers;

    var $userTab = $('')

    function fillData() {
        $('.list small').each(function () {
            var id = $(this).attr("id");
            $(this).html(post[id]);
        });
        $('#titre').html("Bienvenue dans " + $(document).attr('title'));

    }
    function fillTeamForm() {
        $('#equipe option').remove();
        $('#equipe').append('<option value="" disabled selected hidden>Please Choose...</option>');
        userTeams.forEach(function (team) {

            $('#equipe').append('<option value="' + team.equipe.id + '">' + team.equipe.name + '</option>');
        });
    }
    function fillUsersForm() {
        $('#users option').remove();
        $('#users').append('<option value="" disabled selected hidden>Please Choose...</option>');

        teamUsers.users.forEach(function (user) {

            $('#users').append('<option value="' + user.user.id + '">' + user.user.prenom + ' ' + user.user.nom + '</option>');
        })
    }
    function getUser(id) {
        $.ajax({
            method: "GET",
            datatype: "json",
            url: "https://box.dmetthey.fr/api/user/" + id,

            data: {
                apikey: post.apiKey
            }
        }).done(function (data) {
            userTeams = data.equipes_role;
            userInfo = data.info;

        });
    }
    function getTeam(id) {
        $.ajax({
            method: "GET",
            datatype: "json",
            url: "https://box.dmetthey.fr/api/team/" + id,
            data: {
                apikey: post.apiKey
            }
        }).done(function (data) {
            teamUsers = data;
            $('#users').remove;

            fillUsersForm();

        })
    }
    function refreshForm() {
        fillTeamForm();
    }


    $(function () {

        fillData();
        getUser(post.id_user);


    });


    $('#methode').change(function () {
        $('#result').remove();
        var id = $(this).find('option:selected').attr("id");

        switch (id) {
            case "get_user":
                $('#equipe').remove();
                $('#address').html('/api/user/');
                $('#api_form').append('<select name="equipe" id="equipe"></select>');
                fillTeamForm();
                $('#equipe').change(function () {
                    $('#result').remove();
                    $('#api_form').append('<select name="users" id="users"></select>');
                    getTeam($(this).find('option:selected').val());


                    $('#users').change(function () {
                        $('#result').remove();
                        $('#address').html($('#address').html().slice(0, 10) + $(this).find('option:selected').val() + "?apikey=f3a7da7e66b0");
                        $('#sendbtn').removeAttr("disabled");
                    });

                });

                break;
            case "get_equipe":
                $('#users').remove();
                $('#equipe').remove();
                $('#address').html('/api/team/');
                $('#api_form').append('<select name="equipe" id="equipe"></select>');
                fillTeamForm();
                $('#equipe').change(function () {
                    $('#sendbtn').removeAttr("disabled");
                    $('#address').html($('#address').html().slice(0, 10) + $(this).find('option:selected').val() + "?apikey=" + post.apiKey);
                });

                break;
        }


    });
    $('#sendbtn').click(function () {
        $('#result').remove();
        $.get('https://box.dmetthey.fr' + $('#address').html()).done(function (data) {

            if ($('#address').html().slice(5, 9) === "user") {

                $('.container').append(
                    "<div id='result' class='row'>" +
                    "<div id='info' class='col-md-4'>" +
                    "<h4>Nom :</h4>" +
                    "<h4>Mail :</h4>" +
                    "<h4>Créé le :</h4>" +
                    "<h4>Actif :</h4>" +
                    "</div>" +
                    "<div class='col-md-8'>" +
                    "<table id='equipes_role' class='table'>" +
                    "<tr>" +
                    "<th>Equipe</th>" +
                    "<th>Rôle</th>" +
                    "</tr>" +
                    "</table>" +
                    "</div>" +
                    "</div>");
                $('#info :nth-child(1)').append("<small> " + data.info.prenom + " " + data.info.nom + "</small>");
                $('#info :nth-child(2)').append("<small> " + data.info.mail + "</small>");
                $('#info :nth-child(3)').append("<small> " + data.info.createdAt.date.slice(0, 16) + "</small>");
                $('#info :nth-child(4)').append("<small> " + data.info.active + "</small>");


                var equipes = data.equipes_role;
                equipes.forEach(function (team) {
                    $('#equipes_role').append(
                        '<tr>' +
                        '<td>' + team.equipe.name + '</td>' +
                        '<td>' + team.role + '</td>' +
                        '</tr>'
                    )
                })

            }
            else if ($('#address').html().slice(5, 9) === "team"){
                $('.container').append(
                    "<div id='result' class='row'>" +
                    "<div id='info' class='col-md-4'>" +
                    "<h4>Nom :</h4>" +
                    "<h4>Pilote :</h4>" +
                    "<h4>Créé le :</h4>" +
                    "<h4>Modules :</h4>" +
                    "</div>" +
                    "<div class='col-md-8'>" +
                    "<table id='equipes_role' class='table'>" +
                    "<tr>" +
                    "<th>Nom</th>" +
                    "<th>Rôle</th>" +
                    "</tr>" +
                    "</table>" +
                    "</div>" +
                    "</div>"
                );
                $('#info :nth-child(1)').append("<small> " + data.info.name + "</small>");
                $('#info :nth-child(2)').append("<small> " + data.info.pilote.prenom + " " + data.info.pilote.nom + "</small>");
                $('#info :nth-child(3)').append("<small> " + data.info.createdAt.date.slice(0, 16) + "</small>");
                data.info.modules.forEach(function (module) {

                    $('#info :nth-child(4)').append("<small> "+module.nom+"</small>");
                })
                ;


                data.users.forEach(function (teamRole) {
                    $('#equipes_role').append(
                        "<tr>" +
                            "<td>" + teamRole.user.prenom + " " + teamRole.user.nom + "</td>" +
                            "<td>" + teamRole.role + "</td>" +
                        "</tr>"
                    )
                })
            }
        })
    })


</script>
</body>
</html>