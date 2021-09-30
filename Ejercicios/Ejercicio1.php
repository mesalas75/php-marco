<?php

    //crear un archivo csv de los datos /data/estatos_diccionario.json
    // en el archivo se encuentra el estado y combinaciones que hacen referencia al estado
    // se requiere realizar un sumarizado por estado para ver cuantas combinaciones existen
    // por cada estado, se require que se crea un csv con el sumarizado de la siguiente manera
    /*
        edo_id,      edo_nombre,      total_combinaciones
        4,           Campeche,        9
    */


    function jsonToCSV($jfilename, $cfilename){

        if (($json = file_get_contents($jfilename)) == false)
            die('Error reading json file...');
    
        $data = json_decode($json, true);
        $hay = count($data["rows"]);
        $estados = $data["rows"];
        //print_r($hay);
        $fp = fopen($cfilename, 'w');
        
        echo "<table>";
        echo "<thead>";
            echo "<tr>";
                echo "<th>edo_id</th>";
                echo "<th>edo_nombre</th>";
                echo "<th>total combinaciones</th>";
            echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        // guarda los encabezados de las columnas en el archivo csv
        $linea = array('edo_id', 'edo_nombre', 'total combinaciones');
        fputcsv($fp, $linea);
        fclose($fp);

        // abre nuevamente el archivo csv para agregar las lineas de los registros
        $fp = fopen($cfilename, 'a');

            $cta_edo=0;
            $compara_edo = 1;
            $edo_id = null;
            $edo_nombre = null;
            foreach($estados as $estado){

                if ($compara_edo == $estado["edo_id"]){
                    $edo_id = $estado["edo_id"];
                    $edo_nombre = $estado["edo_nombre"];
                    $cta_edo += 1;
                }
                else{
                    echo "<tr>";
                    echo "<td>$edo_id</td>";
                    echo "<td>$edo_nombre</td>";
                    echo "<td>$cta_edo</td>";
                    echo "</tr>";
                    
                    $linea = array( $edo_id, $edo_nombre, $cta_edo);
                    fputcsv($fp, $linea);

                    $compara_edo = $estado["edo_id"];
                    $cta_edo=1;
                }
            }

        echo "</tbody>";
        echo "</table>";
        
        fclose($fp);
    return;
    }

    $json_filename = '../data/estados_diccionario.json';
    $csv_filename = '../data/estados_diccionario.csv';
    jsonToCSV($json_filename, $csv_filename);
    echo 'Successfully converted json to csv file. <a href="' . $csv_filename . '" target="_blank">Click here to open it.</a>';

    

?>