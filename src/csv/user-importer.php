<?php
require_once('csv-importer.php');

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
            $this->message = json_encode($this->data);
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
    function insert($project, $conn){
        if (!is_numeric($project)) {
            return false;
        }

        foreach ($this->data as $key => $row) {
            $team = $row['tim'];
            $teammate = $row['id'];
// TODO
//            $query = "SELECT id  FROM team WHERE project_id=$project and team_number=$team;";
//            $result = $conn->query($query);
//            $res = [];
//
//            if ($result->num_rows > 0) {
//                while ($row = $result->fetch_assoc())
//                    $res[] = $row;
//
//                echo json_encode($res);
//            } else {
//                $query = "INSERT INTO `team`(`project_id`, `captain_id`, `team_number`) VALUES ($project, $teammate, $team)";
//                $result = $conn->query($query);
//            }

        }

        $conn->close();
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
