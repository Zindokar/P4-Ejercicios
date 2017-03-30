function checkLogin() {
    var user = document.getElementById('userLogin').value;
    var pass = document.getElementById('passLogin').value;
    if (user.length >= 3 && pass.length >= 1) {
        document.forms["loginForm"].submit();
    } else {
        var div = document.getElementById("message");
        div.style.display = 'block';
        div.innerHTML = "Debe introducir 3 caracteres o más";
    }
}

function deleteItemByID(id, name) {
    if (!confirm("Desea borrar la bebida: " + name + "?")) {
        return;
    }
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function() {
        if (this.readyState== 4 && this.status == 200) {
            var res = JSON.parse(this.responseText); //resultado formato JSON {deleted:lógico}
            if(res.deleted === true){
                var fila = document.querySelector('#fila'+id); //Se usa id por la clausura
                fila.parentNode.removeChild(fila); //Eliminamos la fila del juego
                document.getElementById('pvpTotal').innerHTML = res.pvp;
            }
        }
    };
    ajax.open("post", "ajaxDeleteItemOrder.php", true);
    ajax.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    ajax.send(JSON.stringify({"id":id}));
}