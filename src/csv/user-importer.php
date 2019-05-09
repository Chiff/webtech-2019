<?php
require_once('csv-importer.php');

class UserImporter extends CsvImporter {
    public $message = null;

    function autoPilot($delimiter, $verbose = false) {
        $this->saveCSV();

        if (isset($this->uploadFile)) {
            $this->readCSV($this->uploadFile, $delimiter);
        }

        if (isset($this->data) && $verbose && $this->isCsvValid()) {
            $this->message = json_encode($this->data);
        } else if ($verbose) {
            $this->message = "Data sa nepodarilo ziskat alebo nastala chyba vo validacii CSV" . $this->message;
        }
    }

    function isCsvValid() {
        $valid = true;

        $this->message = "<div class='import-log errors-only'>";
        foreach ($this->data as $key => $row) {
            if (stringExists($row['ID']) && stringExists($row['meno']) && stringExists($row['email']) && stringExists($row['tim'])) {
                $this->message .= "<div class='row-valid'><span style='color: lime'>ROW VALID </span><br>";
            } else {
                $this->message .= "<div class='row-invalid'><span style='color: red'>ROW INVALID </span><br>";
                $valid = false;
            }

            foreach ($row as $label => $value)
                $this->message .= $label . " : " . $value . "<br>";

            $this->message .= "</div>";
        }
        $this->message .= "</div>";

        return $valid;
    }

    public function getMessage() {
        return $this->message;
    }
}
