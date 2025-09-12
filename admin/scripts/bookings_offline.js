let booking_form = document.getElementById("booking-form");

document.getElementById("room_type").addEventListener("change", function () {
    document.getElementById("room_id").value = this.value;
});

//nouvelle reservation
booking_form.addEventListener('submit', function (e) {
    e.preventDefault();

    let data = new FormData();
    data.append('client_name', booking_form.elements['client_name'].value);
    data.append('address', booking_form.elements['client_address'].value);
    data.append('nationalite', booking_form.elements['nationalite'].value);
    data.append('profession', booking_form.elements['profession'].value);
    data.append('motif', booking_form.elements['motif'].value);
    data.append('phone', booking_form.elements['client_phone'].value);
    data.append('arrival_date', booking_form.elements['arrival_date'].value);
    data.append('departure_date', booking_form.elements['departure_date'].value);
    data.append('room_type', booking_form.elements['room_type'].value);
    data.append('room_id', booking_form.elements['room_id'].value);
    data.append('room_number', booking_form.elements['room_number'].value);
    data.append('total_amount', booking_form.elements['total_amount'].value);
    data.append('book_room', '');

    var myModal = document.getElementById('addBookingModal');
    var modal = bootstrap.Modal.getInstance(myModal);
    modal.hide();

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/bookings_offline.php", true);

    xhr.onload = function () {
        if (this.responseText == 1) {
            alert('success', "Réservation enrégistrée!");
            booking_form.reset();
            get_bookings();
        } else {
            alert('error', "Erreur lors de l'enrégistrement!");
        }
    }
    xhr.send(data);
});

//check availability
let pay_info = document.getElementById('pay_info');

function check_availability() {
    let checkin_val = booking_form.elements['arrival_date'].value;
    let checkout_val = booking_form.elements['departure_date'].value;

    if (checkin_val != '' && checkout_val != '') {
        pay_info.classList.add('d-none');
        pay_info.classList.replace('text-dark', 'text-danger');

        let data = new FormData();

        data.append('check_availability', '');
        data.append('check_in', checkin_val);
        data.append('check_out', checkout_val);
        data.append('room_id', booking_form.elements['room_id'].value);

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/bookings_offline.php", true);

        xhr.onload = function () {
            let data = JSON.parse(this.responseText);

            if (data.status == 'check_in_out_equal') {
                pay_info.innerText = "S'il s'agit d'une réservation d'une journée ou nuit, veuillez choisir comme date de sortie la date suivante à celle d'entrée!";
            }
            else if (data.status == 'check_out_earlier') {
                pay_info.innerText = "La date de sortie est antérieur à celle d'entrée!";
            }
            else if (data.status == 'check_in_earlier') {
                pay_info.innerText = "La date d'entrée est antérieur à la date d'aujourd'hui!";
            }
            else if (data.status == 'unavailable') {
                pay_info.innerText = "La chambre ou salle n'est pas disponible pour cette date!";
            }
            pay_info.classList.remove('d-none');
        }
        xhr.send(data);
    }

}

//get bookings
function get_bookings(search = '', page = 1) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/bookings_offline.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        let data = JSON.parse(this.responseText);
        document.getElementById('table-data').innerHTML = data.table_data;
        document.getElementById('table-pagination').innerHTML = data.pagination;
    }

    xhr.send('get_bookings&search=' + search + '&page=' + page);
}

function change_page(page) {
    get_bookings(document.getElementById('search_input').value, page);
}

function download(id) {
    window.location.href = 'generateoffline_pdf.php?gen_pdf&id=' + id;
}

window.onload = function () {
    get_bookings();
}