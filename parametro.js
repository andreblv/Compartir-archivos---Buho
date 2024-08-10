// URL actual
const urlActual = window.location.href;

// Url final 
var carpetaNombre = window.location.pathname.split('/').pop();

if (!carpetaNombre) {
    // Genera un nombre aleatorio si no existe
    carpetaNombre = generarCadenaAleatoria();
    window.location.href = `${window.location.origin}${window.location.pathname}${carpetaNombre}`;
}

// Función para generar una cadena aleatoria
function generarCadenaAleatoria() {
    const caracteres = 'abcdefghijklmnopqrstuvwxyz0123456789';
    let cadenaAleatoria = '';
    for (let i = 0; i < 3; i++) {
        const caracterAleatorio = caracteres.charAt(Math.floor(Math.random() * caracteres.length));
        cadenaAleatoria += caracterAleatorio;
    }
    return cadenaAleatoria;
}

// Función para crear la carpeta
function crearCarpeta(carpetaNombre) {
    $.ajax({
        url: 'crearCarpeta.php',
        type: 'POST',
        data: { nombreCarpeta: carpetaNombre },
        success: function(response) {
            console.log('Carpeta creada con éxito:', response);
        },
        error: function(xhr, status, error) {
            console.error('Error al crear la carpeta:', error);
        }
    });
}

// Función para manejar el evento de envío del formulario
Form.addEventListener('submit', (e) => {
    e.preventDefault();
    const fileInput = Form.querySelector('#archivo');
    const file = fileInput.files[0];
    if (file) {
        // Puedes enviar el archivo al servidor para su procesamiento aquí
        console.log('Subir archivo:', file.name);
    } else {
        alert('Por favor, seleccione un archivo primero.');
    }
});


// Función para generar un número aleatorio de 3 dígitos
function generarCadenaAleatoria() {
    const caracteres = 'abcdefghijklmnopqrstuvwxyz0123456789';
    let cadenaAleatoria = '';
    for (let i = 0; i < 3; i++) {
        const caracterAleatorio = caracteres.charAt(Math.floor(Math.random() * caracteres.length));
        cadenaAleatoria += caracterAleatorio;
    }
    return cadenaAleatoria;
}


// //BARRA DE PROGRESO 
// function uploadFile(carpetaRuta, inputId) {
//   var archivoInput = document.getElementById(inputId);
//   var archivo = archivoInput.files[0];
//   var progressBar = document.getElementById('progressBar');

//   var formData = new FormData();
//   formData.append('archivo', archivo);

//   var xhr = new XMLHttpRequest();

//   xhr.upload.onprogress = function (event) {
//       if (event.lengthComputable) {
//           var percentComplete = (event.loaded / event.total) * 100;
//           progressBar.value = percentComplete;
//       }
//   };

//   xhr.onload = function () {
//       if (xhr.status === 200) {
//           console.log('Archivo subido con éxito');
//           // Puedes realizar acciones adicionales después de la carga aquí
//       } else {
//           console.error('Error al subir el archivo');
//       }
//   };

//   xhr.open('POST', 'upload.php', true);
//   xhr.send(formData);
// }


//DROP AREA

// Obtén la zona de arrastre y el formulario
const dropArea = document.getElementById('drop-area');
const Form = document.getElementById('form');

// Agrega los siguientes eventos a la zona de arrastre
dropArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropArea.classList.add('drag-over');
});

dropArea.addEventListener('dragleave', () => {
    dropArea.classList.remove('drag-over');
});

dropArea.addEventListener('drop', (e) => {
    e.preventDefault();
    dropArea.classList.remove('drag-over');
    const file = e.dataTransfer.files[0];
    handleFile(file);
});

// Función para manejar el archivo seleccionado
function handleFile(file) {
    if (file) {
        // Realiza alguna acción, como mostrar el nombre del archivo
        console.log('Archivo seleccionado:', file.name);

        // También puedes realizar otras acciones, como subir el archivo al servidor
        // Puedes agregar aquí el código para subir el archivo si lo deseas
    }
}

// Agrega esta función para manejar el evento de envío del formulario
Form.addEventListener('submit', (e) => {
    e.preventDefault();
    const fileInput = Form.querySelector('#archivo');
    const file = fileInput.files[0];
    if (file) {
        // Puedes enviar el archivo al servidor para su procesamiento aquí
        console.log('Subir archivo:', file.name);
    } else {
        alert('Por favor, seleccione un archivo primero.');
    }
});

//progres bar 
