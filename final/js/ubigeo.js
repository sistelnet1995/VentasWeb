$('#Departamento').change(function (e) {
    e.preventDefault();
    IdDepartamento = $(this).val();
    $('#Distrito').find('option').remove().end().append('<option value="0">Seleccione</option>');
    $('#Departamento').each(function () {
        $.post("../php/getProvincias.php", {
                IdDepartamento: IdDepartamento
            },
            function (data) {
                $('#Provincia').html(data);
            });
    });
});

$('#Provincia').change(function (e) {
    e.preventDefault();
    $("#Provincia").each(function () {
        IdProvincia = $(this).val();
        $.post("../php/getDistritos.php", {
            IdProvincia: IdProvincia
        }, function (data) {
            $("#Distrito").html(data);
        });
    });
});