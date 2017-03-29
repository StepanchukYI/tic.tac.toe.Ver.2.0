var glClientName;
var tmp;
var glOpponentName;
var glInGame;
var flag = true;
var ans = "";
var path = "";

function Auth(login, password){

    path = "msg/auth/auth.php?login=" + login + "&password=" + password + "&from=xo";
    Request(path);
    console.log(ans);
    //Auth_Valid(ans[0]);

    localStorage.setItem('glInGame', "false");
}
function Auth_Valid(ans) {
    tmp = document.getElementById("pass_msg");
    if(ans == "OK"){
        document.location.href = 'client.html';
    } else {
        tmp.innerHTML = ans;
        localStorage.setItem('glInGame', "false");
        localStorage.setItem('glOpponentName', "");
    }
}

function Reg(login, email, password1, password2) {

    path ="msg/auth/reg.php?login=" + login + "&password1=" + password1 + "&password2=" + password2 + "&email=" + email;
    ans = Request(path);
    Reg_Valid(ans);

}
function Reg_Valid(anser) {

    tmp = document.getElementById("msg_regist");

    if (anser == "User created") {
        document.location.href = 'index.php';
    } else {
        tmp.innerHTML = anser;
    }
}

function getCookie(name) {
    var tmp = document.cookie.match("(^|;) ?" + name + "=([^;]*)(;|$)");
    if (tmp) return r[2];
    else return "";
}

function GetClients() {

    glClientName = getCookie('xo_auth_log');
    var login = document.getElementById("lbLoginL");
    login.innerHTML = glClientName;
    tmp = document.getElementById("clients");

    var path = "msg/profile/clients.php?login=" + glClientName;

    ans = Request(path);

    if (ans != "") {
        var json = JSON.parse(ans);

        var ih = "";
        for (i = 0; i < json.length; i++) {
            ih += "<tr><td>" + json[i] + "</td>" + '<td><input type="button" ' + 'value="Invite" onclick=Invite("' + json[i] + '")></td>';
        }
        tmp.innerHTML = ih;
    }
    else {
        tmp.innerHTML = "No users found";
    }
    login.innerHTML = glClientName;
}
function ToClients() {
    reset();
}

function Quit() {

    path = "msg/auth/quit.php?login=" + glClientName + "&from=xo";
    ans = Request(path);

    localStorage.setItem('glInGame', "false");
    localStorage.setItem('glOpponentName', "");
    localStorage.setItem('key', "");


    Quit_Valid(ans);
}
function Quit_Valid(ans) {

    if (ans == "Logout") {

        document.location.href = 'index.php';
    }
}

function Receive() {
    path = "msg/receive.php?receiver=" + glClientName;
    ans = Request(path);

    var json = JSON.parse(ans);
    var sender;
    var header;
    var body;

    for (var i = 0; i < json.length; i++) {
        sender = json[i].sender;
        header = json[i].header;
        body = json[i].body;

        console.log(sender + " " + header + " " + body);

        switch (header) {
            case "invite":
                glInGame = localStorage.getItem('glInGame');
                if (glInGame == "false") {
                    if (confirm(sender + " wants to play with You...")) {

                        Approve(sender);

                        Game_start(glClientName, sender);

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
                break;
            case "game":
                WaitTurn(body);
                break;
        }
    }
}

function Invite(opponentName) {

    path = "msg/send.php?sender=" + glClientName + "&receiver="
        + opponentName + "&header=invite" + "&body=you received invitation";
    Request(path);
}
function Approve(opponentName) {

    path = "msg/send.php?sender=" + glClientName + "&receiver="
        + opponentName + "&header=approval" + "&body=you received approval";
    Request(path);
    }
function Deny(opponentName) {

    path = "msg/send.php?sender=" + glClientName + "&receiver="
        + opponentName + "&header=denial" + "&body=you received denial";
    Request(path);
}

function Mail(email) {

    path = "msg/command/mail2.php?email=" + email;
    ans = Request(path);
    Mail_valid(ans);
}
function Mail_valid(ase) {
    if (ase == "send") {
        document.location.href = 'index.php';
    }
    else {
        alert("incorrect email");
    }
}

function Game_start(glClientName,glOpponentName) {

    path = "msg/command/game_start.php?who=" + glClientName + "&opponent=" + glOpponentName;
    ans = Request(path);

    var ansers = JSON.parse(ans);

    localStorage.setItem('glInGame', "true");
    localStorage.setItem('glOpponentName', ansers.opponent);

    document.location.href = 'game.html';

    var str = "Your fraction is " + ansers.who_fract;
}
function Game_make(sqrId) {

    glOpponentName = localStorage.getItem('glOpponentName');
    glClientName = getCookie('xo_auth_log');

    path = "msg/command/game_make.php?who=" + glClientName + "&opponent=" + glOpponentName + "&block=" + sqrId;
    ans = Request(path);

    alert(ans);

}
function Game_check() {

    if(flag) {
        glOpponentName = localStorage.getItem('glOpponentName');
        glClientName = getCookie('xo_auth_log');

        path = "msg/command/game_check.php?who=" + glClientName + "&opponent=" + glOpponentName;
        ans = Request(path);

        var arr_btn = document.getElementsByClassName("tictac");
        var game_res = "";

        var ansers = JSON.parse(ans);

        for (var i = 0; i < 10; i++) {
            arr_btn[i].value = " " + ansers[/'sqr'/+[i+1]] + " ";
            game_res = ansers.game_res;
        }
        if (game_res != "") {
            alert(game_res);
            var flag = false;
            reset()
        }
    }

}
function Game_end() {

    glOpponentName = localStorage.getItem('glOpponentName');
    glClientName = getCookie('xo_auth_log');

    path = "msg/command/game_check.php?who=" + glClientName + "&opponent=" + glOpponentName;
    ans = Request(path);
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

function Request(path) {
    ans = "";
    var request = new XMLHttpRequest();
    request.open("GET", path , true);
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.responseText != 0){
            ans =  request.responseText;
            console.log(ans);
        }
    };
    request.send(null);

}