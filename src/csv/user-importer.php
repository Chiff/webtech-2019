<?php
require_once('csv-importer.php');

class UserImporter extends CsvImporter {

    function autoPilot($delimiter, $verbose = false) {
        $this->saveCSV();

        if (isset($this->uploadFile)) {
            $this->readCSV($this->uploadFile, $delimiter);
        }

        if (isset($this->data) && $verbose && $this->isCsvValid()) {
            echo json_encode($this->data);
//            echo print_r($this->data);
        } else if ($verbose) {
            echo "Data sa nepodarilo ziskat alebo nastala chyba vo validacii CSV";
        }
    }

    function isCsvValid() {
        $valid = true;

        echo "<div class='import-log errors-only'>";
        foreach ($this->data as $key => $row) {
            if (stringExists($row['ID']) && stringExists($row['meno']) && stringExists($row['email']) && stringExists($row['tim'])) {
                echo "<div class='row-valid'><span style='color: lime'>ROW VALID </span><br>";
            } else {
                echo "<div class='row-invalid'><span style='color: red'>ROW INVALID </span><br>";
                $valid = false;
            }

            foreach ($row as $label => $value)
                echo $label . " : " . $value . "<br>";

            echo "</div>";
        }
        echo "</div>";

        return $valid;
    }
}
