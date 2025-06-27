function validar() {
        var nom = document.getElementById("nombre").value;
        var apelli = document.getElementById("apellido").value;
        var doc = document.getElementById("dni").value;
        var leg = document.getElementById("legajo").value;
        var tel = document.getElementById("telefono").value;
        var ema = document.getElementById("email").value;

        if (
          nom === "" ||
          apelli === "" ||
          doc === "" ||
          leg === "" ||
          tel === "" ||
          ema === ""
        ) {
          alert("Falta completar alguno de los campos.");
          return false;
        } else if (!Number.isInteger(Number(doc))) {
          alert('El campo "N° DNI" debe ser un número entero.');
          return false;
        } else if (!Number.isInteger(Number(tel))) {
          alert('El campo "Telefono" debe ser un número entero.');
          return false;
        } else if (Number.isInteger(Number(nom))) {
          alert('El campo "Nombre" no debe ser un número.');
          return false;
        } else if (Number.isInteger(Number(apelli))) {
          alert('El campo "Apellido" no debe ser un número.');
          return false;
        } else {
          return true;
        }
      }