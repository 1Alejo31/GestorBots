function iniciar_sesion(event){
    // Prevenir el envío del formulario
    if (event) {
        event.preventDefault();
        event.stopPropagation();
    }
    
    //recuerdame();
    let usu = document.querySelector("#text_usuario").value;
    let pass = document.querySelector("#text_pass").value;

    if(usu.length == 0 || pass.length == 0){
        return Swal.fire("Mensaje de advertencia" ,"Por favor llenar campos vacios", "warning");
    }

    return new Promise(() => {
        const data = {
            user: usu,
            password: pass
        }

        const requestOptions = {
            method: 'POST',
            headers: {
                'Content-type': 'application/json'
            },
            body: JSON.stringify(data)
        }

        const url = 'controller/login/loginController.php';

        fetch(url, requestOptions)
            .then(response => {
                if (!response.ok) {
                    throw new Error('El archivo no fue encontrado!');
                }
                return response.json();
            })
            .then(jsonResponse => {
                if (jsonResponse.status == 0) {
                    window.location = "view/index.php";
                } else if (jsonResponse.status == 1) {
                    Swal.fire({
                        icon: 'warning',
                        title: "¡Usuario y/o contraseña incorrectos!",
                        heightAuto: false,
                    }
                    );
                    return;
                } else {
                    console.log(jsonResponse);
                }
            })
            .catch(function (error){
                alert(error.message);
                console.log(error);
            });
    
    });

}

function recuerdame(){
    if(rmcheck.checked && usuarioImput.value != "" && passImput.value != ""){
        localStorage.user = usuarioImput.value;
        localStorage.pass = passImput.value;
        localStorage.checkbox = rmcheck.value;
    }else{
        localStorage.user = "";
        localStorage.pass = "";
        localStorage.checkbox = "";
    }
}