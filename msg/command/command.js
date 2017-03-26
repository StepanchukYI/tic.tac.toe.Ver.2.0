var glClientName;
var tmp;
var glOpponentName;
var glInGame;

function Auth(login, password){

    var reqest = new XMLHttpRequest();
    reqest.open("GET", "msg/auth/auth.php?login=" + login + "&password=" + password + "&from=xo", true);
    reqest.onreadystatechange = function () {
        if (reqest.readyState == 4) {
            var ans = reqest.responseText;
            //logs();
            Auth_Valid(ans);
        }
    };

    glInGame = "false";
    localStorage.setItem('glInGame', glInGame);
    reqest.send(null);
}
function Auth_Valid(ans) {
    tmp = document.getElementById("pass_msg");
    switch (ans) {
        case "OK":
            document.location.href = 'client.html';
            break;
        case "User already online":
            tmp.innerHTML = ans;
            localStorage.setItem('glInGame', glInGame);
            localStorage.setItem('glOpponentName', "");
            break;
        case "Failed password":
            tmp.innerHTML = ans;
            localStorage.setItem('glInGame', glInGame);
            localStorage.setItem('glOpponentName', "");
            break;
        case "Failed login":
            tmp.innerHTML = ans;
            localStorage.setItem('glInGame', glInGame);
            localStorage.setItem('glOpponentName', "");
            break;
    }
}

function Reg(login, email, password1, password2) {

        var request = new XMLHttpRequest();
    request.open("GET", "msg/reg/reg.php?login=" + login + "&password1=" + password1 + "&password2=" + password2 + "&email=" + email, true);

        request.onreadystatechange = function () {
            if (request.readyState == 4) {
            //document.getElementById("result").innerHTML += request.responseText;
            //console.log(request.responseText);
            var anser = request.responseText;
            Reg_Valid(anser);
                console.log(anser);
            }
        };

        request.send(null);
}
function Reg_Valid(anser){

    tmp = document.getElementById("msg_regist");
    switch (anser) {
        case "User created":
            document.location.href = 'index.php';
            break;
        case "Email already using":
            tmp.innerHTML = anser;
            break;
        case "Login already using":
            tmp.innerHTML = anser;
            break;
        case "Passwords are different":
            tmp.innerHTML = anser;
            break;
        case "Incorrect email":
            tmp.innerHTML = anser;
            break;
        case "Incorrect login":
            tmp.innerHTML = anser;
            break;
        case "Incorrect password":
            tmp.innerHTML = anser;
            break;
    }
}

function getCookie(name) {
    var r = document.cookie.match("(^|;) ?" + name + "=([^;]*)(;|$)");
    if (r) return r[2];
    else return "";
}

function GetClients() {

    glClientName = getCookie('xo_auth_log');
    //console.log(glClientName);
    var msg = document.getElementById("lbLoginL");
    msg.innerHTML = glClientName;

    var r = new XMLHttpRequest();
    tmp = document.getElementById("clients");

    r.open("GET", "msg/profile/clients.php?login=" + glClientName, true);

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            if (r.responseText != "") {
                //console.log(r.responseText);
                var json = JSON.parse(r.responseText);
                //console.log(json);

                var ih = "";
                for (i = 0; i < json.length; i++) {
                    ih += "<tr><td>" + json[i] + "</td>" + '<td><input type="button" ' + 'value="Invite" onclick=Invite("' + json[i] + '")></td>';
                }
                tmp.innerHTML = ih;
            }
            else {
                tmp.innerHTML = "No users found";
            }

            var m = document.getElementById("lbLoginL");
            m.innerHTML = glClientName;
        }
    };

    r.send(null);
    //console.log("updating list of clients");
}
function ToClients() {

    reset();

}

function Quit() {

    var r = new XMLHttpRequest();

    r.open("GET", "msg/auth/quit.php?login=" + glClientName + "&from=xo", true);

    glInGame = "false";
    localStorage.setItem('glInGame', glInGame);
    localStorage.setItem('glOpponentName', "");
    localStorage.setItem('key', "");

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var anss = r.responseText;
            Quit_Valid(anss);
            //console.log(r.responseText);
        }
    };
    r.send(null);
}
function Quit_Valid(anss) {

    if (anss == "Logout") {

        document.location.href = 'index.php';
    }
}

function Receive() {

    var r = new XMLHttpRequest();
    r.open("GET", "msg/receive.php?receiver=" + glClientName, true);

    r.onreadystatechange = function () {
        //console.log(r.readyState);
        if (r.readyState == 4 && r.responseText != 0) {

            //console.log(r.responseText);
            var json = JSON.parse(r.responseText);

            console.log(json);
            for (var i = 0; i < json.length; i++) {
                var sender = json[i].sender;
                var header = json[i].header;
                var body = json[i].body;

                console.log(sender + " " + header + " " + body);
                //console.log("parsing done");

                switch (header) {
                    case "invite":
                        glInGame = localStorage.getItem('glInGame');
                        if (glInGame == "false") {
                            if (confirm(sender + " wants to play with You...")) {

                                //console.log(sender + " is lucky today...");

                                Approve(sender);

                                Game_start(glClientName, sender);


                                //alert(glInGame + " " + glTurn + " " + glFaction + " " + glOpponentName);

                            }
                            else {
                                Deny(sender);
                            }
                        }
                        else {
                            Deny(sender);
                        }

                        break;
                    case "denial":

                        alert(sender + " doesn`tmp want to play with You");

                        break;

                    case "approval":

                        alert(sender + " wants to play with You too...");

                        Game_start(sender, glClientName);

                        //alert(glInGame + " " + glTurn + " " + glFaction + " " + glOpponentName);

                        break;

                    case "game":

                        WaitTurn(body);

                        break;
                }
            }
        }
    };

    r.send(null);
    //console.log("receiving new messages");
}

function Invite(opponentName) {
    var r = new XMLHttpRequest();

    r.open("GET", "msg/send.php?sender=" + glClientName + "&receiver=" + opponentName + "&header=invite" + "&body=you received invitation", true);

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            //console.log(r.responseText);
        }
    };
    r.send(null);
}
function Approve(opponentName) {

    var r = new XMLHttpRequest();

    r.open("GET", "msg/send.php?sender=" + glClientName + "&receiver=" + opponentName + "&header=approval" + "&body=you received approval", true);

    r.onreadystatechange = function () {

        //console.log(r.responseText);
    };

    r.send(null);
}
function Deny(opponentName) {

    var r = new XMLHttpRequest();

    r.open("GET", "msg/send.php?sender=" + glClientName + "&receiver=" + opponentName + "&header=denial" + "&body=you received denial", true);

    r.onreadystatechange = function () {

        //console.log(r.responseText);
    };

    r.send(null);
}

function Mail(email) {
    var btn = document.getElementById('btn_recover');
    btn.disable = true;
    var r = new XMLHttpRequest();
    r.open("GET", "msg/command/mail2.php?email=" + email, true);
        
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var ase = r.responseText;
            Mail_valid(ase);
            //logs();
        }
    };
    r.send(null);

}
function Mail_valid(ase) {
    if (ase == "send") {
        document.location.href = 'index.php';
    }
    else {
        alert("incorrect email");
        btn.disable = false;
    }

}

function Game_start(glClientName,glOpponentName) {
    var r = new XMLHttpRequest();

    r.open("GET", "msg/command/game_start.php?who=" + glClientName + "&opponent=" + glOpponentName, true);

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.responseText != 0) {

            var ansers = JSON.parse(r.responseText);
            //console.log(ansers);

                    localStorage.setItem('glInGame', "true");
                    localStorage.setItem('glOpponentName', ansers.opponent);

                    document.location.href = 'game.html';

                    var str =  "Your fraction is "+ ansers.who_fract;

                    //console.log(str);



        }
    };
    r.send(null);
}
function Game_make(sqrId) {

    glOpponentName = localStorage.getItem('glOpponentName');
    glClientName = getCookie('xo_auth_log');

    var r = new XMLHttpRequest();
    console.log("msg/command/game_make.php?who=" + glClientName + "&opponent=" + glOpponentName + "&block=" + sqrId);

    r.open("GET", "msg/command/game_make.php?who=" + glClientName + "&opponent=" + glOpponentName + "&block=" + sqrId, true);

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.responseText != 0) {
            alert(r.responseText);
        }
    }

    r.send(null);
}
function Game_check() {

    glOpponentName = localStorage.getItem('glOpponentName');
    glClientName = getCookie('xo_auth_log');


    var sqr1 = document.getElementById(sqr1);
    var sqr2 = document.getElementById(sqr2);
    var sqr3 = document.getElementById(sqr3);
    var sqr4 = document.getElementById(sqr4);
    var sqr5 = document.getElementById(sqr5);
    var sqr6 = document.getElementById(sqr6);
    var sqr7 = document.getElementById(sqr7);
    var sqr8 = document.getElementById(sqr8);
    var sqr9 = document.getElementById(sqr9);

    var r = new XMLHttpRequest();

    r.open("GET", "msg/command/game_check.php?who=" + glClientName + "&opponent=" + glOpponentName, true);

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.responseText != 0) {
            //console.log(r.responseText);
            var ansers = JSON.parse(r.responseText);

            document.tic.sqr1.value = " " +ansers.sqr1+ " ";
            document.tic.sqr2.value = " " +ansers.sqr2+ " ";
            document.tic.sqr3.value = " " +ansers.sqr3+ " ";
            document.tic.sqr4.value = " " +ansers.sqr4+ " ";
            document.tic.sqr5.value = " " +ansers.sqr5+ " ";
            document.tic.sqr6.value = " " +ansers.sqr6+ " ";
            document.tic.sqr7.value = " " +ansers.sqr7+ " ";
            document.tic.sqr8.value = " " +ansers.sqr8+ " ";
            document.tic.sqr9.value = " " +ansers.sqr9+ " ";


            var game_res = ansers.game_res;
            if(game_res != ""){
                alert(game_res);
                reset()
            }
        }
    };
    r.send(null);
}
function Game_end() {

    glOpponentName = localStorage.getItem('glOpponentName');
    glClientName = getCookie('xo_auth_log');

    var r = new XMLHttpRequest();

    r.open("GET", "msg/command/game_end.php?who=" + glClientName + "&opponent=" + glOpponentName, true);

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.responseText != 0) {
            //console.log(r.responseText);
        }
    };
    r.send(null);

}

function reset() {
    Game_end();
    document.tic.sqr1.value = "     ";
    document.tic.sqr2.value = "     ";
    document.tic.sqr3.value = "     ";
    document.tic.sqr4.value = "     ";
    document.tic.sqr5.value = "     ";
    document.tic.sqr6.value = "     ";
    document.tic.sqr7.value = "     ";
    document.tic.sqr8.value = "     ";
    document.tic.sqr9.value = "     ";

    glInGame = "false";

    localStorage.setItem('glInGame', glInGame);
    document.location.href = 'client.html';
}
