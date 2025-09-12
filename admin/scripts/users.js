
function get_users() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/users.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        document.getElementById('users-data').innerHTML = this.responseText;
    }

    xhr.send('get_users');
}

function toggle_status(id, val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/users.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        if (this.responseText == 1) {
            alert('success', 'Status changé!');
            get_users();
        } else {
            alert('error', 'Erreur serveur!');
        }
    }
    xhr.send('toggle_status=' + id + '&value=' + val);
}

function remove_user(user_id) {
    if (confirm("Etes-vous sur, vous voulez supprimer ce client?")) {
        let data = new FormData();
        data.append('user_id', user_id);
        data.append('remove_user', '');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/users.php", true);
        //xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function () {
            if (this.responseText == 1) {
                alert('success', 'Client supprimée !');
                get_users();
            } else {
                alert('error', 'Echec de la suppression de l\'utilisateur !');
            }
        }
        xhr.send(data);
    }
}

function search_user(username){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/users.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        document.getElementById('users-data').innerHTML = this.responseText;
    }

    xhr.send('search_user&name='+username);
}

window.onload = function () {
    get_users();
}