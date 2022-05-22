$(document).ready(function() {
    $('#proveedor_id').select2();
    $('#sucursal_id').select2();
});

const csrfToken = document.head.querySelector(
    "[name~=csrf-token][content]"
).content;
$('#cerrar_modal2').on('click', () => {
    $('#exampleModal2').modal('close');
});
$('#cerrar_modal1').on('click', () => {
    $('#exampleModal1').modal('close');
});


/* let btnFiltrar = document.getElementById("filtrar");
btnFiltrar.addEventListener("click", (e) => {
    $("#table").DataTable({
        pageLength: 5,
        ajax: {
            url: ruta_filtrarCompras,
            type: "POST",
            headers: {
                "X-CSRF-Token": csrfToken,
            },
            data: {
                fecha_inicial: $(
                    document.getElementById("fecha_inicial")
                ).val(),
                fecha_final: $(document.getElementById("fecha_final")).val(),
                proveedor_id: $(document.getElementById("proveedor_id")).val(),
                sucursal_id: $(document.getElementById("sucursal_id")).val(),
            },
        },
        columnDefs: [
            {
                targets: [0],
                className: "text-center",
            },
            {
                targets: [1],
                className: "text-center",
            },
            {
                targets: [2],
                className: "text-center",
            },
            {
                targets: [3],
                className: "text-center",
            },

            {
                targets: "_all",
                defaultContent: "N/A",
            },
        ],
        columns: [
            {
                data: "sucursal_nombre",
            },
            {
                data: "proveedor_nombre",
            },
            {
                data: "fecha_compra",
            },
            {
                data: "total",
            },
        ],
    });
}); */
