import './bootstrap';

import Swal from 'sweetalert2'
import 'sweetalert2/dist/sweetalert2.min.css'

window.Swal = Swal;

window.Toast = Swal.mixin({
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 2500,
    timerProgressBar: false,
});