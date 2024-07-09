// assets/js/functions.js

function eliminarPersona(id, url) {
    swal({
        title: "¿Estás seguro de eliminar este producto del carrito?",
        text: "Una vez eliminado, no podrás recuperar este producto.",
        icon: "warning",
        buttons: {
            cancel: {
                text: "Cancelar",
                visible: true,
                closeModal: true,
            },
            confirm: {
                text: "Eliminar",
                value: true,
                visible: true,
                className: "btn-danger",
                closeModal: false // No cierra la alerta hasta que se hace clic en Eliminar
            }
        },
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            swal({
                title: "¡Producto eliminado exitosamente!",
                icon: "success",
            }).then(() => {
                window.location.href = url; // Redirige al URL después de confirmar la eliminación
            });
        } else {
            swal("¡Producto no eliminado!", "El producto sigue en tu carrito.", {
                icon: "info",
            });
        }
    });
}

function confirmarDetalleCompra(event) {
    event.preventDefault(); // Prevenir el envío del formulario

    swal({
        title: "¿Estás seguro?",
        text: "¿Deseas confirmar la compra?",
        icon: "warning",
        buttons: ["Cancelar", "Confirmar"],
        dangerMode: true,
    })
    .then((willConfirm) => {
        if (willConfirm) {
            event.target.form.submit(); // Enviar el formulario
        }
    });
}

function confirmarRetroceso(event) {
    event.preventDefault(); // Prevenir el comportamiento predeterminado del enlace

    swal({
        title: "¿Deseas volver al carrito?",
        text: "Los cambios no guardados se perderán.",
        icon: "warning",
        buttons: ["No", "Sí"],
        dangerMode: true,
    })
    .then((willConfirm) => {
        if (willConfirm) {
            window.location.href = '../../Views/carrito/cart.php'; // Redirigir al carrito
        }
    });
}

function confirmarRetrocesoTienda(event) {
    event.preventDefault(); // Prevenir el comportamiento predeterminado del enlace

    swal({
        title: "¿Deseas volver a la tienda?",
        text: "¿Estás seguro?",
        icon: "warning",
        buttons: ["No", "Sí"],
        dangerMode: true,
    })
    .then((willConfirm) => {
        if (willConfirm) {
            window.location.href = '../../index.php'; // Redirigir a la tienda
        }
    });
}

function exito() {
    swal({
        title: "¡Buen trabajo!",
        text: message,
        icon: "success",
        button: "¡Genial!",
    });
}

function error(event, message) {
    swal({
        title: "Error",
        text: message,
        icon: "error",
        button: "Intentar de nuevo",
    });
}