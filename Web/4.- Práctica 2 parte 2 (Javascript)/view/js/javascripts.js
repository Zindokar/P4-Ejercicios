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

function addItemOrder() {
    var cantidad = parseInt(document.getElementById("drinkQuantity").value)
    if (Number.isInteger(cantidad) && cantidad > 0) {
        document.getElementById("drinkQuantityDiv").style.display = "none";
        var ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function() {
            if (this.readyState== 4 && this.status == 200) {
                var res = JSON.parse(this.responseText); //resultado formato JSON {deleted:lógico}
                if(res.added === true){
                    var tabla = document.getElementById("itemOrderTable");
                    var fila = tabla.insertRow(-1);
                    var celdaId = fila.insertCell(0);
                    celdaId.innerHTML = res.id;
                    var celdaBebida = fila.insertCell(1);
                    celdaBebida.innerHTML = res.bebida;
                    var celdaUnidades = fila.insertCell(2);
                    celdaUnidades.innerHTML = res.unidades;
                    var celdaPvp = fila.insertCell(3);
                    celdaPvp.innerHTML = res.pvpbebida;
                    var celdaAccion = fila.insertCell(4);
                    celdaAccion.innerHTML = "<input type='button' value='Eliminar' onclick='deleteItemByID(" + res.id + ",\'" + res.bebida + "\')' />";
                    //var fila = document.querySelector('#fila'+id); //Se usa id por la clausura
                    //fila.parentNode.removeChild(fila); //Eliminamos la fila del juego
                    document.getElementById('pvpTotal').innerHTML = res.pvp;
                }
            }
        };
        ajax.open("post", "ajaxAddItemOrder.php", true);
        ajax.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
        ajax.send(JSON.stringify({"idbebida":document.getElementById("drinkID").value,"unidades":document.getElementById("drinkQuantity").value}));
    } else {
        document.getElementById("drinkQuantityDiv").innerHTML = "Introduce un número entero positivo";
        document.getElementById("drinkQuantityDiv").style.display = "";
    }
}

var flag = 0;

function checkEditUser() {
    flag = 0;
    if (document.getElementById("passwd").value != "" && document.getElementById("passwd").value.length < 4) {
        document.getElementById("passdiv").innerHTML = "4 caracteres o más";
        document.getElementById("passdiv").style.display = "";
        flag++;
    } else {
        document.getElementById("passdiv").style.display = "none";
        flag--;
    }
    if (document.getElementById("nombre").value.length < 4) {
        document.getElementById("nombrediv").innerHTML = "4 caracteres o más";
        document.getElementById("nombrediv").style.display = "";
        flag++;
    } else {
        document.getElementById("nombrediv").style.display = "none";
        flag--;
    }
    if (document.getElementById("tipoUsuario").value == 2) {
        if (document.getElementById("pobla").value.length < 4) {
            document.getElementById("pobladiv").innerHTML = "4 caracteres o más";
            document.getElementById("pobladiv").style.display = "";
            flag++;
        } else {
            document.getElementById("pobladiv").style.display = "none";
            flag--;
        }
        if (document.getElementById("direc").value.length < 4) {
            document.getElementById("direcdiv").innerHTML = "4 caracteres o más";
            document.getElementById("direcdiv").style.display = "";
            flag++;
        } else {
            document.getElementById("direcdiv").style.display = "none";
            flag--;
        }
    } else { // Si no es tipo de usuario cliente
        flag -= 2;
    }
    alert('flag: ' + flag);
    // Estado en el que se han ejecutado todos los else
    if (flag <= -4) {
        document.forms["editUserForm"].submit();
    }
}

function checkNewUser()  {
    flag = 0;
    if (document.getElementById("username").value.length < 4) {
        document.getElementById("usernamediv").innerHTML = "4 caracteres o más";
        document.getElementById("usernamediv").style.display = "";
        flag++;
    } else {
        document.getElementById("usernamediv").style.display = "none";
        flag--;
    }
    if (document.getElementById("passwd").value.length < 4)  {
        document.getElementById("passdiv").innerHTML = "4 caracteres o más";
        document.getElementById("passdiv").style.display = "";
        flag++;
    } else {
        document.getElementById("passdiv").style.display = "none";
        flag--;
    }
    if (document.getElementById("nombre").value.length < 4) {
        document.getElementById("nombrediv").innerHTML = "4 caracteres o más";
        document.getElementById("nombrediv").style.display = "";
        flag++;
    } else {
        document.getElementById("nombrediv").style.display = "none";
        flag--;
    }
    if (document.getElementById("tipoUsuario").value == 2) {
        if (document.getElementById("pobla").value.length < 4) {
            document.getElementById("pobladiv").innerHTML = "4 caracteres o más";
            document.getElementById("pobladiv").style.display = "";
            flag++;
        } else {
            document.getElementById("pobladiv").style.display = "none";
            flag--;
        }
        if (document.getElementById("direc").value.length < 4) {
            document.getElementById("direcdiv").innerHTML = "4 caracteres o más";
            document.getElementById("direcdiv").style.display = "";
            flag++;
        } else {
            document.getElementById("direcdiv").style.display = "none";
            flag--;
        }
    } else { // Si no es tipo de usuario cliente
        flag -= 2;
    }
    // Estado en el que se han ejecutado todos los else
    if (flag <= -5) {
        document.forms["createUserForm"].submit();
    }
}

function showOrHideAdress() {
    if (document.getElementById("tipoUsuario").value == 2) {
        document.getElementById("poblacion").style.display = "";
        document.getElementById("direccion").style.display = "";
    } else {
        document.getElementById("poblacion").style.display = "none";
        document.getElementById("direccion").style.display = "none";
        flag = 0; // Por si crea un administrador y tiene pobla y direc en flag = 1
    }
}