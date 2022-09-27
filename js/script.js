$(function () {
    const togglePassword = $('#togglePassword');
    const password = $('#id_password');
    const toggleCPassword = $('#toggleCPassword');
    const cpassword = $('#id_cpassword');

    const rupiah = document.getElementById('nilaiKB');

    function formatRupiah(angka, prefix) {
        let number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : rupiah ? 'Rp. ' + rupiah : '';
    }

    if (rupiah) {
        rupiah.addEventListener('keyup', function (e) {
            rupiah.value = formatRupiah(this.value, 'Rp. ');
        });
    }

    if (togglePassword) {
        togglePassword.on('click', function (e) {
            const type = password.attr('type') === 'password' ? 'text' : 'password';
            password.attr('type', type);
            $(this).toggleClass('fa-eye-slash');
        });
    }
    if (toggleCPassword) {
        toggleCPassword.on('click', function () {
            const type = cpassword.attr('type') === 'password' ? 'text' : 'password';
            cpassword.attr('type', type);
            $(this).toggleClass('fa-eye-slash');
        });
    }

    $('.deleteHref').on('click', function (e) {
        e.preventDefault();
        const href = $(this).attr('href');

        Swal.fire({
            title: 'Apakah anda yakin?',
            text: 'Data ini akan masuk ke bagian cancel',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, setuju!',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                document.location.href = href;
            }
        });
    });
});
