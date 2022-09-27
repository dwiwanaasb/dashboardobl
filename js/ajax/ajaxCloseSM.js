$(function () {
    $('#keyword').on('keyup', function () {
        $('#content-table').load(
            './ajax/ajaxCloseSM.php?keyword=' +
                $('#keyword').val() +
                '&witel=' +
                $('#dataWitel').val() +
                '&tahun=' +
                $('#dataTahun').val() +
                '&mitra=' +
                $('#dataMitra').val() +
                '&pelanggan=' +
                $('#dataPelanggan').val() +
                '&segmen=' +
                $('#dataSegmen').val() +
                '&status=' +
                $('#dataStatus').val(),
        );
    });
});
