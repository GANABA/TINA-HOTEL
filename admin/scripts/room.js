let add_room_form = document.getElementById('add_room_form');
// Add Rooms
add_room_form.addEventListener('submit', function (e) {
    e.preventDefault();
    add_rooms();
});

function add_rooms() {
    let data = new FormData();
    data.append('name', add_room_form.elements['name'].value);
    data.append('type', add_room_form.elements['type'].value);
    data.append('area', add_room_form.elements['area'].value);
    data.append('price', add_room_form.elements['price'].value);
    data.append('quantity', add_room_form.elements['quantity'].value);
    data.append('adult', add_room_form.elements['adult'].value);
    data.append('children', add_room_form.elements['children'].value);
    data.append('desc', add_room_form.elements['desc'].value);
    data.append('add_rooms', '');

    let features = [];
    add_room_form.elements['features'].forEach(el => {
        if (el.checked) {
            features.push(el.value);
        }
    });

    let facilities = [];
    add_room_form.elements['facilities'].forEach(el => {
        if (el.checked) {
            facilities.push(el.value);
        }
    });

    data.append('features', JSON.stringify(features));
    data.append('facilities', JSON.stringify(facilities));

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms.php", true);

    xhr.onload = function () {
        var myModal = document.getElementById('add-room');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.responseText == 1) {
            alert('success', 'Nouvelle chambre ajouté !');
            add_room_form.reset();
            get_all_rooms();

        } else {
            alert('error', 'Erreur serveur !');
        }
    }
    xhr.send(data);
}

function get_all_rooms() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        document.getElementById('room-data').innerHTML = this.responseText;
    }

    xhr.send('get_all_rooms');
}

// Edit Rooms
let edit_room_form = document.getElementById('edit_room_form');

function edit_details(id) {

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        let data = JSON.parse(this.responseText);
        //console.log(data);
        edit_room_form.elements['name'].value = data.roomdata.name;
        edit_room_form.elements['area'].value = data.roomdata.area;
        edit_room_form.elements['type'].value = data.roomdata.type;
        edit_room_form.elements['price'].value = data.roomdata.price;
        edit_room_form.elements['quantity'].value = data.roomdata.quantity;
        edit_room_form.elements['adult'].value = data.roomdata.adult;
        edit_room_form.elements['children'].value = data.roomdata.children;
        edit_room_form.elements['desc'].value = data.roomdata.description;
        edit_room_form.elements['room_id'].value = data.roomdata.id;

        edit_room_form.elements['features'].forEach(el => {
            if (data.features.includes(Number(el.value))) {
                el.checked = true;
            }
        });

        edit_room_form.elements['facilities'].forEach(el => {
            if (data.facilities.includes(Number(el.value))) {
                el.checked = true;
            }
        });
    }
    xhr.send('get_room=' + id);
}

edit_room_form.addEventListener('submit', function (e) {
    e.preventDefault();
    submit_edit_rooms();
});

function submit_edit_rooms() {
    let data = new FormData();
    data.append('name', edit_room_form.elements['name'].value);
    data.append('area', edit_room_form.elements['area'].value);
    data.append('type', edit_room_form.elements['type'].value);
    data.append('price', edit_room_form.elements['price'].value);
    data.append('quantity', edit_room_form.elements['quantity'].value);
    data.append('adult', edit_room_form.elements['adult'].value);
    data.append('children', edit_room_form.elements['children'].value);
    data.append('desc', edit_room_form.elements['desc'].value);
    data.append('edit_rooms', '');
    data.append('room_id', edit_room_form.elements['room_id'].value);

    let features = [];
    edit_room_form.elements['features'].forEach(el => {
        if (el.checked) {
            features.push(el.value);
        }
    });

    let facilities = [];
    edit_room_form.elements['facilities'].forEach(el => {
        if (el.checked) {
            facilities.push(el.value);
        }
    });

    data.append('features', JSON.stringify(features));
    data.append('facilities', JSON.stringify(facilities));

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms.php", true);

    xhr.onload = function () {
        var myModal = document.getElementById('edit-room');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.responseText == 1) {
            alert('success', 'Données de la chambre modifiées !');
            edit_room_form.reset();
            get_all_rooms();

        } else {
            alert('error', 'Erreur serveur!');
        }
    }
    xhr.send(data);
}

function toggle_status(id, val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        if (this.responseText == 1) {
            alert('success', 'Status changé!');
            get_all_rooms();
        } else {
            alert('error', 'Erreur serveur!');
        }
    }
    xhr.send('toggle_status=' + id + '&value=' + val);
}

add_image_form = document.getElementById('add_image_form');

add_image_form.addEventListener('submit', function (e) {
    e.preventDefault();
    add_image();
});

function add_image() {
    let data = new FormData();
    data.append('image', add_image_form.elements['image'].files[0]);
    data.append('room_id', add_image_form.elements['room_id'].value);
    data.append('add_image', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms.php", true);

    xhr.onload = function () {
        if (this.responseText == 'inv_img') {
            alert('error', 'Seul les images JPG, WEBP ou PNG sont acceptées!', 'image-alert');
        } else if (this.responseText == 'inv_size') {
            alert('error', 'La taille de l\'image doit être inférieur à 2MB!', 'image-alert');
        } else if (this.responseText == 'upd_failed') {
            alert('error', 'Echec du chargement de l\'image. Erreur serveur !', 'image-alert')
        } else {
            alert('success', 'Nouvelle image ajoutée !', 'image-alert');
            room_images(add_image_form.elements['room_id'].value, document.querySelector("#room-images .modal-title").innerText)
            add_image_form.reset();
        }
    }
    xhr.send(data);
}

function room_images(id, rname) {
    //changement du titre de la modal avec le nom de la chambre (room)
    document.querySelector("#room-images .modal-title").innerText = rname;
    add_image_form.elements['room_id'].value = id;
    add_image_form.elements['image'].value = '';

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        document.getElementById('room-image-data').innerHTML = this.responseText;
    }
    xhr.send('get_room_images=' + id);
}

function rem_image(img_id, room_id) {
    let data = new FormData();
    data.append('image_id', img_id);
    data.append('room_id', room_id);
    data.append('rem_image', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms.php", true);
    //xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        if (this.responseText == 1) {
            alert('success', 'Image supprimée !', 'image-alert');
            room_images(room_id, document.querySelector("#room-images .modal-title").innerText)
        } else {
            alert('error', 'Echec de suppression de l\'image !', 'image-alert');
        }
    }
    xhr.send(data);
}

function thumb_image(img_id, room_id) {
    let data = new FormData();
    data.append('image_id', img_id);
    data.append('room_id', room_id);
    data.append('thumb_image', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms.php", true);
    //xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        if (this.responseText == 1) {
            alert('success', 'Image Thumbnail changé !', 'image-alert');
            room_images(room_id, document.querySelector("#room-images .modal-title").innerText)
        } else {
            alert('error', 'Echec de la mise à jour de l\'image Thumbnail !', 'image-alert');
        }
    }
    xhr.send(data);
}

function remove_room(room_id) {
    if (confirm("Etes-vous sur, vous voulez supprimer cette chambre?")) {
        let data = new FormData();
        data.append('room_id', room_id);
        data.append('remove_room', '');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/rooms.php", true);
        //xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function () {
            if (this.responseText == 1) {
                alert('success', 'Chambre supprimée !');
                get_all_rooms();
            } else {
                alert('error', 'Echec de la suppression de la chambre !');
            }
        }
        xhr.send(data);
    }
}

window.onload = function () {
    get_all_rooms();
}