let tipo_comprobante = document.getElementById("tipo_comprobante");
$("#div_nro_recibo").hide();
$("#div_nro_factura").hide();
tipo_comprobante.addEventListener("change", (e) => {
    if (tipo_comprobante.value === "R") {
        $("#div_nro_factura").hide();
        $("#div_nro_recibo").show();
    } else if (tipo_comprobante.value === "F") {
        $("#div_nro_recibo").hide();
        $("#div_nro_factura").show();
    } else if (tipo_comprobante.value === "S") {
        $("#div_nro_recibo").hide();
        $("#div_nro_factura").hide();
    }
});

const csrfToken = document.head.querySelector(
    "[name~=csrf-token][content]"
).content;
let proveedor = document.getElementById("proveedor");
let nombre_producto = document.getElementById("nombre_producto");
let cantidad = document.getElementById("cantidad");
let subtotal = document.getElementById("subtotal");
let precio = document.getElementById("precio");
var total_compra = 0;
let agregar_detalle = document.getElementById("agregar_detalle");
let producto = document.getElementById("producto");

let registrar_compra = document.getElementById("registrar_compra");
let proveedorid = document.getElementById("proveedor");
let cancelar = document.getElementById("cancelar");
let nro_recibo = document.getElementById("nro_recibo");
let nro_factura = document.getElementById("nro_factura");
let nro_autorizacion = document.getElementById("nro_autorizacion");
let cod_control = document.getElementById("cod_control");

/*OBTENER PRODUCTOS CON FETCH*/
proveedor.addEventListener("change", (e) => {
    fetch(ruta_obtenerproductos, {
        method: "POST",
        body: JSON.stringify({
            proveedor_id: e.target.value,
        }),
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-Token": csrfToken,
        },
    })
        .then((response) => {
            return response.json();
        })
        .then((data) => {
            var opciones = "<option> Seleccionar Producto</option>";
            for (let i in data.lista) {
                opciones +=
                    '<option value="' +
                    data.lista[i].id +
                    '">' +
                    data.lista[i].nombre +
                    "</option>";
            }

            document.getElementById("producto").innerHTML = opciones;
        })
        .catch((error) => console.error(error));
    proveedor.disabled = "readonly";
});
   /*OBTENER PRECIO DE PRODUCTO CON FETCH*/
    producto.addEventListener("change", (e) => {
        //console.log("sfsdf");
        fetch(ruta_obtenerprecios, {
                method: "POST",
                body: JSON.stringify({
                    producto_id: e.target.value,
                    proveedor_id: proveedor.value,
                }),
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-Token": csrfToken,
                },
            })
            .then((response) => {
                return response.json();
            })
            .then((data) => {
                var opciones = "";
                for (let i in data.lista) {
                    opciones +=
                        '<option value="' +
                        data.lista[i].id +
                        '">' +
                        data.lista[i].nombre +
                        "</option>";
                }
                let precio_pro = data.precio[0].precio;
                console.log(precio_pro);
                document.getElementById("precio").value = precio_pro;
            })
            .catch((error) => console.error(error));
    });


cantidad.addEventListener("keyup", (e) => {
    subtotal.value = (cantidad.value * precio.value).toFixed(4);
});

/*AGREGAR DETALLE DE COMPRA CON FETCH*/
agregar_detalle.addEventListener("click", (e) => {
    fetch(ruta_guardardetalle, {
        method: "POST",
        body: JSON.stringify({
            detalleCompra: {
                cantidad: cantidad.value,
                subtotal: subtotal.value,
                precio: precio.value,
                producto_id: producto.value,
            },
        }),
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-Token": csrfToken,
        },
    })
        .then((response) => {
            return response.json();
        })
        .then((data) => {
            total_compra = 0;
            var opciones = "";
            for (let i in data.lista_compra) {
                total_compra += parseFloat(data.lista_compra[i].subtotal);
                opciones += "<tr>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_compra[i].producto_nombre["nombre"] +
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_compra[i].precio +
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_compra[i].cantidad +
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_compra[i].subtotal +
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    '<button class="btn btn-danger" onclick="eliminar(' +
                    i +
                    ');"><i class="fas fa-trash"></i></button>' +
                    "</td>";
                opciones += "</tr>";
            }
            opciones +=
                "<tr>" +
                '<td colspan="1" style="text-align: center;">TOTAL A PAGAR </td>' +
                '<td colspan="4" style="text-align: center;">Bs.' +
                total_compra +
                "</td>" +
                "</tr>";

            document.getElementById("tbody").innerHTML = opciones;
            cantidad.value = 0;
            subtotal.value = 0;
        })
        .catch((error) => console.error(error));
});
/*REGISTRAR COMPRA CON FETCH*/
registrar_compra.addEventListener("click", (e) => {
    console.log(tipo_comprobante.value);
    if (tipo_comprobante.value === "R") {
        fetch(ruta_registrarCompra, {
            method: "POST",
            body: JSON.stringify({
                proveedor_id: proveedorid.value,
                compra_total: total_compra,
                t_comprobante: tipo_comprobante.value,
                recibo: nro_recibo.value,
            }),
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-Token": csrfToken,
            },
        })
            .then((response) => {
                return response.json();
            })
            .then((data) => {
                if (data.success == true) {
                    window.location.href = ruta_compras_index;
                }
            })
            .catch((error) => console.error(error));
    } else if (tipo_comprobante.value === "F") {
        fetch(ruta_registrarCompra, {
            method: "POST",
            body: JSON.stringify({
                proveedor_id: proveedorid.value,
                compra_total: total_compra,
                t_comprobante: tipo_comprobante.value,
                factura: nro_factura.value,
                autorizacion: nro_autorizacion.value,
                control: cod_control.value,
            }),
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-Token": csrfToken,
            },
        })
            .then((response) => {
                return response.json();
            })
            .then((data) => {
                if (data.success == true) {
                    window.location.href = ruta_compras_index;
                }
            })
            .catch((error) => console.error(error));
    } else if (tipo_comprobante.value === "S") {
        fetch(ruta_registrarCompra, {
            method: "POST",
            body: JSON.stringify({
                proveedor_id: proveedorid.value,
                compra_total: total_compra,
                t_comprobante: tipo_comprobante.value,
            }),
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-Token": csrfToken,
            },
        })
            .then((response) => {
                return response.json();
            })
            .then((data) => {
                if (data.success == true) {
                    window.location.href = ruta_compras_index;
                }
            })
            .catch((error) => console.error(error));
    }
});

/*ELIMINAR UN DETALLE DE COMPRA CON FETCH*/
function eliminar(i) {
    fetch(ruta_eliminardetalle, {
        method: "POST",
        body: JSON.stringify({
            data: i,
        }),
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-Token": csrfToken,
        },
    })
        .then((response) => {
            return response.json();
        })
        .then((data) => {
            total_compra = 0;
            var opciones = "";
            for (let i in data.lista_compra) {
                total_compra += parseFloat(data.lista_compra[i].subtotal);
                opciones += "<tr>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_compra[i].producto_nombre["nombre"] +
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_compra[i].precio +
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_compra[i].cantidad +
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_compra[i].subtotal +
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    '<button class="btn btn-danger" onclick="eliminar(' +
                    i +
                    ');"><i class="fas fa-trash"></i></button>' +
                    "</td>";
                opciones += "</tr>";
            }

            opciones +=
                "<tr>" +
                '<td colspan="1" style="text-align: center;">TOTAL A PAGAR </td>' +
                '<td colspan="4" style="text-align: center;">Bs.' +
                total_compra +
                "</td>" +
                "</tr>";

            document.getElementById("tbody").innerHTML = opciones;
        });
}

cancelar.addEventListener("click", (e) => {
    window.location.href = ruta_compras_index;
});

