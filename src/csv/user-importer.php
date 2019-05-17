<?php
require_once('csv-importer.php');
require_once(dirname(__DIR__, 1) . '/helpers.php');

class UserImporter extends CsvImporter {
    private $message = null;

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
     * @param $project integer
     * @param $conn mysqli
     * @return bool
     */
    function insert($project, $conn): bool {
        if (!is_numeric($project)) {
            $this->message = "<div class='alert alert-danger'>ID projektu nie je spravne. Upload sa rusi!</div>" . $this->message;
            return false;
        }

	    $insertWarnings = "<div class='alert alert-warning'><h4 class='alert-heading'>Varovania pri importe</h4><hr>";
	    $hasWarnings = false;

        foreach ($this->data as $key => $row) {
            $id = $conn->escape_string($row['ID']);
            $name = $conn->escape_string($row['meno']);

            $mail = $conn->escape_string($row['email']);
            $login = explode("@", $mail)[0];

            $pass = $conn->escape_string($row['heslo']);
            if (!stringExists($pass))
                $pass = null;
            else $pass = password_hash($pass, PASSWORD_DEFAULT);

            $team = $conn->escape_string($row['tim']);

            // IMPORT UZIVATELOV - POKIAL USER EXISTUJE VYPISE SA WARNING HLASKA (USER SA NEUPDATUJE)
            $query = "INSERT INTO `student`(`ais_id`, `email`, `login`, `password`, `name`) VALUES ($id, '$mail', '$login', '$pass', '$name')";
            $conn->query($query);

            if ($conn->error)
                $insertWarnings .= "<p class='mb-0'>Chyba pri vkladani uzivatela do DB. Warning: $conn->error</p>";
	            $hasWarnings = true;

	        // NAJDENIE TIMU
            $query = "SELECT id  FROM team WHERE project_id=$project and team_number=$team;";
            $result = $conn->query($query);

            // AK TIM NEEXISTUJE VYTVORI SA NOVY TIM A JEHO KAPITAN JE AKTUALNY UZIVATEL
            if ($result->num_rows < 1) {
                $query = "INSERT INTO `team` (`project_id`, `captain_id`, `team_number`) VALUES ($project, $id, $team)";
                $conn->query($query);

                if ($conn->error)
                    $this->message .= "<p class='mb-0'>Chyba pri vytvarani timu. Warning: $conn->error</p>";
	                $hasWarnings = true;
            }

            // PRIRADENIE DO TIMU
            $query = "SELECT id  FROM team WHERE project_id=$project and team_number=$team;";
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $teamID = $row['id'];

                $query = "INSERT INTO `teammate`(`student_id`, `team_id`) VALUES ($id, $teamID)";
                $conn->query($query);

                if ($conn->error)
                    $insertWarnings .= "<p class='mb-0'>Chyba pri priradeni uzivatela do timu. Error: $conn->error</p>";
                    $hasWarnings = true;
            }
        }

        $conn->close();

	    if($hasWarnings)
		    $this->message = $insertWarnings . "</div>" . $this->message;

        $this->message = "<div class='alert alert-success'>Update DB sa ukoncil uspesne! Chyby ktore nastali cez update su vypisane nizsie.</div>" . $this->message;
        return true;
    }

    function isCsvValid() {
        $valid = true;

	    $invalidMessage = "<div class='alert alert-danger'><h4 class='alert-heading'>Chybne riadky pri validacii</h4><hr><p class='mb-0'>";
        foreach ($this->data as $key => $row) {
            if (stringExists($row['ID']) && stringExists($row['meno']) && stringExists($row['email']) && stringExists($row['tim'])) {
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
