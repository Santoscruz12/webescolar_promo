<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - WebEscolar</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        
        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
        }
        
        .subtitle {
            font-size: 1.2em;
            text-align: center;
            margin-bottom: 40px;
            color: #7f8c8d;
        }
        
        .description {
            text-align: center;
            margin-bottom: 40px;
            font-size: 1.1em;
            line-height: 1.8;
        }
        
        .contact-form {
            background-color: #f9f9f9;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .form-row {
            display: flex;
            margin-bottom: 20px;
            gap: 20px;
        }
        
        .form-group {
            flex: 1;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #2c3e50;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="tel"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }
        
        .submit-btn {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            display: block;
            margin: 30px auto 0;
            transition: background-color 0.3s;
        }
        
        .submit-btn:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <h1>Contáctanos</h1>
    <p class="subtitle">Cotiza con nosotros</p>
    
    <p class="description">
        En WebEscolar, diseñamos la solución perfecta para optimizar la gestión de tu institución, 
        impulsando el éxito con tecnología, calidad e innovación.
    </p>
    
    <div class="contact-form">
        <div class="form-row">
            <div class="form-group">
                <label for="nombre">Nombre completo</label>
                <input type="text" id="nombre" placeholder="_____">
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="tel" id="telefono" placeholder="_____">
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" placeholder="_____">
            </div>
            <div class="form-group">
                <label for="empresa">Nombre de tu empresa</label>
                <input type="text" id="empresa" placeholder="_____">
            </div>
        </div>
        
        <button type="submit" class="submit-btn">ENVIA TU INFORMACIÓN</button>
    </div>
</body>
</html>