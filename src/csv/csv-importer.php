<?php

class CsvImporter {
    protected $uploadDir = '/home/xfilom/public_html/Zaver/uploaded/';
    protected $uploadFile = null;
    protected $data = null;

    function autoPilot($delimiter, $verbose = false) {
        $this->saveCSV();

        if (isset($this->uploadFile)) {
            $this->readCSV($this->uploadFile, $delimiter);
        }

        if (isset($this->data) && $verbose) {
            echo json_encode($this->data);
        } else if ($verbose) {
            echo "Data sa nepodarilo ziskat";
        }
    }

    function saveCSV(): string {
        if ($_FILES["file"]["error"] > 0) {
            echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
            return null;
        }

        $uploadFile = $this->uploadDir . basename($_FILES['file']['name']);

        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
            $this->uploadFile = $uploadFile;
            return $uploadFile;
        } else {
            echo "Upload failed";
            return null;
        }
    }

    function readCSV($uploadFile, $delimiter = ";") {
        if (!($file = fopen($uploadFile, 'r')))
            return null;

        $firstLine = fgets($file, 4096);
        $itemCount = strlen($firstLine) - strlen(str_replace($delimiter, "", $firstLine)) + 1;

        $fields = explode($delimiter, $firstLine, $itemCount);

        $i = 0;
        $line = array();
        $newData = array();
        while ($line[$i] = fgets($file, 4096)) {
            $row = explode($delimiter, $line[$i], $itemCount);

            $newData[$i] = array();
            for ($j = 0; $j < $itemCount; $j++) {
                $key = trim(preg_replace('/\s\s+/', '', $fields[$j]));
                $value = trim(preg_replace('/\s\s+/', '', $row[$j]));
                $newData[$i][$key] = $value;
            }

            $i++;
        }

        fclose($file);

        $this->data = $newData;
        return $newData;
    }

    public function getData(): array {
        return $this->data;
    }
}
