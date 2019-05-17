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
            $this->message = "<div class='alert alert-success'>Validacia prebehla bez chyby!</div>" . $this->message;
        } else if ($verbose) {
            $this->message = "<div class='alert alert-danger'>Data sa nepodarilo ziskat alebo nastala chyba vo validacii CSV</div>" . $this->message;
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
            $this->message = "<div class='alert alert-danger'>ID projektu nie je spravne. Upload sa rusi!</div>" . $this->message;
            return false;
        }

        $subject = $conn->escape_string($subject);

        $insertWarnings = "<div class='alert alert-warning'><h4 class='alert-heading'>Chybne riadky pri validacii</h4><hr>";
        $hasWarnings = false;

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

                if ($conn->error){
	                $insertWarnings .= "<p class='mb-0'>Chyba pri vytvarani student_subject: $conn->error</p>";
	                $hasWarnings = true;
                }
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

                if ($conn->error){
	                $insertWarnings .= "<p class='mb-0'>Chyba pri priradeni vysldeku pre uzivatela: $conn->error</p>";
	                $hasWarnings = true;
                }
            }
        }

        $conn->close();

        if($hasWarnings)
        	$this->message = $insertWarnings . "</div>" . $this->message;

        $this->message = "<div class='alert alert-success'>Update DB sa ukoncil uspesne!</div>" . $this->message;
        return true;
    }

    function isCsvValid() {
        $valid = true;

        $invalidMessage = "<div class='alert alert-danger'><h4 class='alert-heading'>Chybne riadky pri validacii</h4><hr><p class='mb-0'>";
        foreach ($this->data as $key => $row) {
            if (stringExists($row['ID']) && stringExists($row['meno']) && isset($row['Znamka']) && isset($row['Spolu'])) {
            } else {
	            $invalidMessage .= "$key, ";
                $valid = false;
            }
        }
	    $invalidMessage .= "</p></div>";

        if (!$valid) $this->message .= $invalidMessage;

        return $valid;
    }

    public function getMessage() {
        return $this->message;
    }
}
