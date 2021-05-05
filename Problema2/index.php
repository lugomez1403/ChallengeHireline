<?php
$areglo = array();
$body = "";
$jugadores = [];
$jugador1 = 0;
$jugador2 = 0;
$cantJ1 = 0;
$cantJ2 = 0;
$ganador = "###";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

  $archivo = fopen("./archivo.txt", "w");
  fclose($archivo);
} else {



  if ($fp = fopen($_FILES['fileTXT']['tmp_name'], "r")) {

    while (!feof($fp)) {
      $linea = fgets($fp);
      if (!empty($linea)) {
        array_push($areglo, $linea);
      }
    }
    for ($i = 1; $i < sizeof($areglo); $i++) {
      $resultado = explode(" ", $areglo[$i]);
      $jugador1  = (int)$resultado[0];
      $jugador2  = (int)$resultado[1];
      if ($jugador1 > $jugador2) {

        $jugadores['jugador1'][] = abs($jugador1 - $jugador2);
      } else {

        $jugadores['jugador2'][] = abs($jugador1 - $jugador2);
      }

      $lider = $jugador1 > $jugador2 ? 'jugador1' : 'jugador2';
      $ventaja = abs($jugador1 - $jugador2);
      $body .= "<tr><td align='center'>$i</td> <td align='center'>$jugador1</td> <td align='center'>$jugador2</td><td align='center'>$lider</td><td align='center'>$ventaja</td><tr>";
    }
    $cantJ1 = array_sum($jugadores['jugador1']);
    $cantJ2 = array_sum($jugadores['jugador2']);
    $ganador = $cantJ1 > $cantJ2 ? "Jugador 1" : "Jugador 2";

    $archivo = fopen("archivo.txt", "w");
    fclose($archivo);

    $file = fopen("archivo.txt", "a+");
    $salida = $ganador . " " . ($cantJ1 > $cantJ2 ? $cantJ1 : $cantJ2);
    fputs($file, $salida);
    fclose($file);

    fclose($fp);
  } else {
    echo "<script> alert('No se encontro el archivo'); </script>";
  }
}

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Competencia</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Kaushan+Script|Poiret+One" rel="stylesheet">
</head>

<body>
  <div class="container" align="center">

    <div class="container">
      <br><br><br>
      <div class="col-sm-6">
        <form class="" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" accept-charset="iso-8859-1">
          <label for="" class="etiqueta">Selecionar Archivo</label>
          <div class="input-group">
            <input type="file" class="form-control col-sm-3" name="fileTXT" id="fileTXT" style="display: inline;" accept="text/plain" required>
            <button class="input-group-text" type="submit" name="btn btn-primary">iniciar</burron>
          </div>
        </form>

      </div></br>

      <div class="col-sm-4">
        <form class="row">
          <h3>Ganador</h3>
          <h4><?php echo $ganador; ?></h4>
          <h3>ventaja total</h3>
          <h4><?php echo $cantJ1 > $cantJ2 ? $cantJ1 : $cantJ2; ?></h4>
          <h3>Descargar resultado</h3>
          <a href="./archivo.txt" style="color:black;" download> Resultado</a>
        </form>

      </div>
    </div>
    <br><br><br><br>
    <div class="col-sm-12">

      <table class="table">
        <thead>

          <tr>
            <td align="center">Ronda</td>
            <td align="center">Jugador 1</td>
            <td align="center">Jugador 2</td>
            <td align=center>Lider</td>
            <td align="center">Ventaja</td>
          </tr>
        </thead>
        <tbody>
          <?php echo $body; ?>
        </tbody>
      </table>

    </div>

  </div>


</body>
<style media="screen">
  body {
    background-color: #C4DFE6;
    overflow-x: hidden;
    font-family: 'Poiret One', cursive;
  }

  table {
    color: #003B46;
  }

  table tr td {
    align-items: center;
  }

  td {
    align-items: center;
  }

  h4 {
    color: #003B46;
  }

  h3 {
    color: #07575B;
    font-family: negrita;
  }

  input {
    padding-right: 0;
    background-color: #1CC0FE;
  }
</style>

</html>