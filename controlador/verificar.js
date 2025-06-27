function verificar() {
    var clave = document.getElementById('clave').value;
    var usuario = document.getElementById('usuario').value;

    if (usuario === '' || clave === '') {
      alert('Algun campo esta vacio. Por favor, completar con los datos requeridos.');
    } else if (clave.length < 4) {
      alert('La clave no puede ser menor a 4 caracteres.');
    } else if (usuario == "admin" && clave == "admin") {
      alert('Bienvenido administrador.');
      location.href = "../vista/admin.html";
    } else if (usuario == "usuario" && clave == "usuario") {
      alert('Bienvenido empleado.');
      location.href = "empleado.html";
    } else {
      alert('Usuario o contrasena incorrecto.');
    }
  }