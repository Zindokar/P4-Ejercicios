// eliminar bebida usando ajax
function borrarBebida(id) {
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var responseDiv = document.getElementById('ajaxResponse');
            var datos = JSON.parse(ajax.responseText);
            
            responseDiv.style.display = "";
            responseDiv.className = "mal";
            
            if (datos.borrado) {
                document.getElementById('fila' + id).style.display = "none";  
                responseDiv.className = "bien";
            }
            
            responseDiv.innerHTML = datos.mensaje;
            
            // Ocultamos el div que nos sale al editar bebida
            var divPHP = document.getElementById('mensajePHP');
            if (divPHP !== null) {
                divPHP.style.display = "none";
            }
        }
    }
    ajax.open("post", "ajax_borrarBebida.php");
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=UTF-8");
    ajax.send("bebidaID=" + encodeURIComponent(id));
}

// comprobacion de campos en javascript
function comprobarEditarBebida() {
    var marca = document.getElementById('bebidaMarca');
    var stock = document.getElementById('bebidaStock');
    var pvp = document.getElementById('bebidaPVP');
    var divError = document.getElementById('errorEditar');
    divError.className = "mal";
    
    if (marca.value.length < 2) {
        divError.style.display = "";
        divError.innerHTML = "La marca debe tener 2 caracteres o más.";
        return;
    }
    
    if (parseInt(stock.value, 10) < 0) {
        divError.style.display = "";
        divError.innerHTML = "El stock debe ser positivo.";
        return;
    }
    
    
    if (parseFloat(pvp.value) < 0) {
        divError.style.display = "";
        divError.innerHTML = "El PVP debe ser positivo.";
        return;
    }
    
    document.getElementById('editarBebidaForm').submit();
}