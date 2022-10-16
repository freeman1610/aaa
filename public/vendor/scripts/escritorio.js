function cambiarModo() {

    const Toast = Swal.mixin({
        toast: true,
        position: 'bottom-start',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    })


    let cuerpoweb = document.body
    cuerpoweb.classList.toggle("dark-mode")
    if (document.body.classList.contains('dark-mode')) { //cuando el cuerpo tiene la clase 'dark' actualmente
        localStorage.setItem('dark-mode', 'enabled'); //almacenar estos datos si el modo oscuro está activado
        Toast.fire({
            icon: 'info',
            title: 'Modo Oscuro',
            background: '#343a40'
        })
    } else {
        localStorage.setItem('dark-mode', 'disabled'); //almacenar estos datos si el modo oscuro está desactivado
        Toast.fire({
            icon: 'info',
            title: 'Modo Normal'

        })
    }
}
if (localStorage.getItem('dark-mode') == 'enabled') {
    document.body.classList.toggle('dark-mode');
}