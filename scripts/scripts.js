
const form = document.getElementById('formulario');
// Evita que el formulario se envíe automáticamente
form.addEventListener('submit', (event) => {
  event.preventDefault(); 

  /**
   * Quitamos los espacios en blanco de los elementos y guardamos 
   * los valores del formulario en constantes
   */
  const nombre = form.elements['nombre'].value.trim();
  const apellido = form.elements['apellidos'].value.trim();
  const email = form.elements['correo'].value.trim();
  const password = form.elements['password'].value.trim();

  /**
   * En caso de estar vacio el campo nombre o apellidos enviamos un
   * mensaje de error
   */
  if (nombre === '' || apellido === '') {
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Por favor, ingrese su nombre y apellidos.',        
      });
    return;
  }

  /**
   * En caso de no haber una coincidencia entre la expresion regular
   *  y la constante email llamamos la alerta de error
   */
  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Por favor, ingrese un correo valido.',        
      });
    return;
  }

  /**
   * Se valida que la contraseña tenga un minimo de 8 caracteres
   */
  if (password.length < 8) {
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'La contraseña debe tener al menos 8 caracteres',        
      });
    return;
  }

  // Realiza la petición AJAX
  $.ajax({
    url: 'paginas/guardar.php', // Archivo PHP que maneja la solicitud HTTP
    type: 'post',
    data: {
      nombre: nombre,
      apellido: apellido,
      email: email,
      password: password
    },
    success: function(response) {
      // Maneja la respuesta del servidor
      console.log(response);
      Swal.fire({
        icon: 'success',
        title: 'Buen trabajo',
        text: 'Registro Exitoso',        
      });
    },
    error: function(xhr, status, error) {
      // Maneja los errores de la petición
      console.log('Error: ' + error);
    }
  });
  
});

  
