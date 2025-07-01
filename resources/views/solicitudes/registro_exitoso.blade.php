<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Registro Exitoso</title>
<style>
    body {
        font-family: 'Roboto', Arial, sans-serif;
        font-size: 12px;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0px;
        text-align: center;
    }
    .checkmark {
        font-size: 100px;
        color: #4CAF50;
    }
    .checkmark svg {
        width: 150px; /* Ajustar el ancho del SVG */
        height: auto; /* Mantener la proporción */
    }
    .title {
        color: #333333;
        margin-top: 0px;
        font-size: 50px;
    }
    p {
        color: #333333;
        margin-top: 20px;
        font-size: 18px;
    }

    .button {
        font-size: 18px;
        border-radius: 15px;
        background-color: #4CAF50; 
        border: none;
        color: white;
        padding: 10px 20px;
        text-align: center;
        display: inline-block;
        margin-top: 20px; 
        cursor: pointer; 
        text-decoration: none;
    }
    .container {
        margin: 20px;
        max-width: 850px;
        padding: 50px;
        border: 1px solid #ccc;
        border-radius: 15px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }
</style>
</head>
<body>

<div class="container">
    <div class="checkmark">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11.0026 16L6.75999 11.7574L8.17421 10.3431L11.0026 13.1716L16.6595 7.51472L18.0737 8.92893L11.0026 16Z"></path>
        </svg>
    </div>
    <h1 class="title">Registro exitoso.</h1>
    <p class="message">Su solicitud se ha registrado exitosamente. Nos pondremos en contacto con usted lo más pronto posible para dar seguimiento a su proceso de certificación de mezcal.</p>
    <a class="button" href="{{ route('login') }}">Ir al inicio de sesión</a> <!-- Enlace al login usando la ruta de Laravel -->
</div>

</body>
</html>
