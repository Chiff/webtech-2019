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
            $this->message = "Validacia prebehla bez chyby!<br>" . $this->message;
        } else if ($verbose) {
            $this->message = "Data sa nepodarilo ziskat alebo nastala chyba vo validacii CSV" . $this->message;
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
            $this->message = "ID projektu nie je spravne. Upload sa rusi!<br>" . $this->message;
            return false;
        }

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
                $this->message = "<div class='warning'>Chyba pri vkladani uzivatela do DB. Warning: $conn->error</div>" . $this->message;

            // NAJDENIE TIMU
            $query = "SELECT id  FROM team WHERE project_id=$project and team_number=$team;";
            $result = $conn->query($query);

            // AK TIM NEEXISTUJE VYTVORI SA NOVY TIM A JEHO KAPITAN JE AKTUALNY UZIVATEL
            if ($result->num_rows < 1) {
                $query = "INSERT INTO `team` (`project_id`, `captain_id`, `team_number`) VALUES ($project, $id, $team)";
                $conn->query($query);

                if ($conn->error)
                    $this->message = "<div class='warning'>Chyba pri vytvarani timu. Warning: $conn->error</div>" . $this->message;
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
                    $this->message = "<div class='warning'>Chyba pri priradeni uzivatela do timu. Error: $conn->error</div>" . $this->message;
            }
        }

        $conn->close();
        $this->message = "Update DB sa ukoncil uspesne! Chyby ktore nastali cez update su vypisane nizzsie.<br>" . $this->message;
        return true;
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
