<?php
require_once('csv-importer.php');

class ResultsImporter extends CsvImporter {
    public $message = null;

    function autoPilot($delimiter, $verbose = false): bool {
        $this->saveCSV();

        if (isset($this->uploadFile)) {
            $this->readCSV($this->uploadFile, $delimiter);

            if (!isset($this->data))
                return false;
        } else return false;


        if (isset($this->data) && $verbose && $this->isCsvValid()) {
            $this->message = "Validacia prebehla bez chyby!<br>" . $this->message;
        } else if ($verbose) {
            $this->message = "Data sa nepodarilo ziskat alebo nastala chyba vo validacii CSV" . $this->message;
            return false;
        }

        return true;
    }

    /**
     * @param $subject integer
     * @param $conn mysqli
     * @return bool
     */
    function insert($subject, $conn): bool {
        if (!is_numeric($subject)) {
            $this->message = "ID projektu nie je spravne. Upload sa rusi!<br>" . $this->message;
            return false;
        }

        $subject = $conn->escape_string($subject);

        foreach ($this->data as $key => $row) {
            $id = $conn->escape_string($row['ID']);
            $meno = $conn->escape_string($row['meno']);

            // NAJDENIE STUDENT_SUBJECT
            $query = "SELECT id FROM `student_subject` WHERE student_id=$id and subject_id=$subject;";
            $result = $conn->query($query);

            // AK STUDENT_SUBJECT NEEXISTUJE VYTVORI SA NOVY STUDENT_SUBJECT
            if ($result->num_rows < 1) {
                $query = "INSERT INTO `student_subject`(`student_id`, `subject_id`) VALUES ($id, $subject)";
                $conn->query($query);

                if ($conn->error)
                    $this->message = "<div class='warning'>Chyba pri vytvarani student_subject. Warning: $conn->error</div>" . $this->message;
            }

            // PRIRADENIE DO RESULT CEZ STUDENT_SUBJECT
            $query = "SELECT id FROM `student_subject` WHERE student_id=$id and subject_id=$subject;";
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                $subjectRow = $result->fetch_assoc();
                $SSID = $subjectRow['id'];

                $query = "INSERT INTO `result`(`student_subject_id`, `label`, `result`) VALUES";
                foreach ($row as $resultKey => $resultValue) {
                    if ($resultKey == 'ID' || $resultKey == 'meno') continue;

                    $r1 = $conn->escape_string($resultKey);
                    $r2 = $conn->escape_string($resultValue);

                    $query .= "($SSID, '$r1', '$r2'),";
                }
                $query = substr($query, 0, -1);
                $conn->query($query);

                if ($conn->error)
                    $this->message = "<div class='warning'>Chyba pri priradeni vysldeku pre uzivatela. Warning: $conn->error</div>" . $this->message;
            }
            echo "<hr>";
        }

        $conn->close();
        $this->message = "Update DB sa ukoncil uspesne! Chyby ktore nastali cez update su vypisane nizzsie.<br>" . $this->message;
        return true;
    }

    function isCsvValid() {
        $valid = true;

        $this->message = "<div class='import-log errors-only'>";
        foreach ($this->data as $key => $row) {
            if (stringExists($row['ID']) && stringExists($row['meno']) && isset($row['Znamka']) && isset($row['Spolu'])) {
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
