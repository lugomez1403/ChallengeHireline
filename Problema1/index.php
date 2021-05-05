<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $btn = "";
} else {
  $btn = "<button type='button' class='btn btn-default' name='button'><a href='./archivo.txt' style='color:white;' download> Resultado</a></button>";
  $resultado = "No se encontro ninguna instrucción";
  if ($fp = fopen($_FILES['fileTXT']['tmp_name'], "r")) {
    $i = 1;
    $lista = [];
    $instrucciones = "";
    while (!feof($fp)) {
      $linea = fgets($fp);

      if (!empty($linea)) {
        if ($i == 1) {
          $longCaden = $linea;
        } elseif ($i == 4) {
          $mensaje = $linea;
        } else {
          array_push($lista, trim($linea));
        }
      }
      $i++;
    }
    $tamano = explode(" ", $longCaden);
    $deco_str = preg_replace("/(.)\\1+/", "$1", $mensaje);

    if (strlen($lista[0]) == $tamano[0]) {

      if (strlen($lista[1]) == $tamano[1]) {

        for ($i = 0; $i < sizeof($lista); $i++) {

          if (strpos($deco_str, preg_replace("/(.)\\1+/", "$1", $lista[$i]))) {
            $resultado = "Si se encontro la instruccion: " . $lista[$i] . " \n" ." Si Existe el mensaje ";

            break;
          } else {
            $resultado = "El mensaje no contiene instrucciones";
          }
        }
        $archivo='./archivo.txt';
        $file = fopen($archivo, 'ab') ;
        fwrite ($file, $resultado);
        fclose($file);

      } else {
        $resultado = "La cantidad de caracteres de la segunda instruccion, no es igual a la logitud proporcionada";
      }
    } else {
      $resultado = "La cantidad de caracteres de la primera instruccion, no es igual a la logitud proporcionada";
    }
  } else {
    echo "<script> alert('No se encontro el archivo'); </script>";
   
  }
}


?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Mensaje</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
</head>

<body>

  <br><br><br>
  <div class="container" align="center">

    <br><br><br>
    <div class="col-sm-6">
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" accept-charset="iso-8859-1">
        <h3>Selecionar Archivo</h3>
        <div class="input-group">
          <input type="file" class="form-control col-sm-3" name="fileTXT" id="fileTXT" style="display: inline;" accept="text/plain" required>
          <button class="input-group-text" type="submit" name="btn btn-primary">iniciar</burron>
        </div>
      </form>
      <h4>Resultado de la busqueda</h4>
      <h3><?php echo empty($resultado) ? ".... .... .... .... .... .... .... ...." : $resultado; ?></h3>
      <?php echo $btn;?>
      <br><br><br>
    </div>

  </div>



</body>
<style media="screen">
  body {
    background-color: #90AFC5;
    overflow-x: hidden;
    font-family: 'Poiret One', cursive;
  }

  .container {
    background-color: #336B87;
    padding: 2px 16px;
  }

  h3 {
    color: white;
    font-family: 'Kaushan Script', cursive;
  }

  h4 {
    font-family: 'Kaushan Script', cursive;
    color: #2A3132;
  }
</style>

</html>