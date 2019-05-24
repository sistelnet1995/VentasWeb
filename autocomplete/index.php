<?php

    $conn = mysqli_connect('localhost', 'root', '', 'prueba');

    $query= "select * from colores"; 
    $res = mysqli_query($conn, $query);
    $valores = '{';
    if($res->num_rows>0){
        while($row = $res->fetch_assoc()){
            $valores .= $row["nombre"].': null, ';
        }
    }
    $valores = substr($valores,0,-2)."}";
    echo $valores;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <div class="row">
        <div class="col s12">
            <div class="row">
                <div class="input-field col s12">
                    <i class="material-icons prefix">textsms</i>
                    <input type="text" id="autocomplete-input" class="autocomplete">
                    <label for="autocomplete-input">Autocomplete</label>
                </div>
            </div>
        </div>
    </div>
    <div class="container" id="resp"></div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        $(document).ready(function(){    
            $('input.autocomplete').autocomplete({
                data: <?php echo $valores; ?>,
                onAutocomplete: function(Producto) {
                    $.ajax({
                        type: "POST",
                        url: "auto.php",
                        data: {Producto: `${Producto}`},
                        success: function (response) {
                            $('#resp').html(response);
                        }
                    });
                    // console.log(`${Producto}`);
                }
            });
        });
    </script>
</body>
</html>