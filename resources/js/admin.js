window.$ = window.Jquery = require('jquery');
window.Bootstrap = require('./bootstrap.bundle');
window.Swal = require('./sweetalert2.all.min');
import select2 from 'select2';
import 'select2/dist/css/select2.css';

require('./batch');

window.swAlert = function (level, message) {
    Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    }).fire({
        icon: level,
        title: message
    });
};

$('.btn-delete').on('click', function (e) {
    if (!confirm("مورد برای همیشه حذف می‌شود. این عمل قابل بازگشت نیست. ادامه می‌دهید؟")) {
        e.preventDefault();
    }
});
