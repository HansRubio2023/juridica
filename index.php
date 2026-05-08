<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Iconos de Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
   
</head>
<body class="login-background">
    <div class="clearfix-padding"></div>
    <div class="clearfix-padding"></div>
    <div class="login-container"style="margin-top: -50px;">
      <h1>Iniciar Sesión</h1>

      <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger" style="border-radius:8px; font-size:0.95rem;">
          <?php if ($_GET['error'] === 'usuario'): ?>
            <i class="fas fa-user-times me-2"></i> El usuario ingresado no existe.
          <?php elseif ($_GET['error'] === 'contrasena'): ?>
            <i class="fas fa-lock me-2"></i> La contraseña es incorrecta.
          <?php endif; ?>
        </div>
      <?php endif; ?>

      <form id="loginForm" action="login.php" method="POST">
        <div class="input-group">
          <label for="user">Usuario</label>
          <input
            type="text"
            id="user"
            name="user"
            placeholder="Tu email aquí"
            required
          />
        </div>
        <div class="input-group">
          <label for="pass">Contraseña</label>
          <input type="password" id="pass" name="pass" placeholder="Tu contraseña" required />
        </div>
        <button type="submit" class="btn btn-success btn-lg px-4">Iniciar Sesión</button>
      </form>
    
    </div>
    
</body>
</html>
