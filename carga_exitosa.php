<?php include 'asesor_navbar.php';?>
  <br>
  <div class="container">
  <h4 class="display-4 text-center">Asesoría cargada con éxito</h4>
  <br>
    <div class="row justify-content-center">
      <div class="col-md-4">
        <div class="row">
            <button class="btn-b blue-gradient btn-block p-3" onclick="window.location.href='asesor_dashboard.php?inputMail=<?php echo $_GET['mail']; ?>'">Regresar al menu principal</button><br>
        </div>
      </div>
    </div>
  </div>
</body>
</html>