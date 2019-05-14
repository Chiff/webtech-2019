<?php
//require_once "../helpers.php";
require_once "MailSender.php";

$csv_array = [];

$server_csv = "server_info.csv";
$sender = "xbencot@stuba.sk";
$sender_pass = "FEIstuba2018";

// user data
$number_of_people = 0;
if (isset($_POST['rows']))
    $number_of_people = $_POST['rows'];
$delimiter = ";";
if (isset($_POST['delimiter']))
    $delimiter = $_POST['delimiter'];
$data = array_map('str_getcsv', file($server_csv, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));
for ($i = 0; $i < count($data); $i++) {
    if ($i == 0)
        continue;
    $csv_array[] = explode($delimiter, $data[$i][0]);
}

// mail data
$subject = "";
if (isset($_POST['subject']))
    $subject = $_POST["subject"]; //subject for the email

if (isset($_POST['sender_pass']))
    $sender_pass = $_POST['sender_pass'];

if (isset($_POST['sender_email']))
    $sender = $_POST['sender_email'];

// html editor bool
$html = false;
if (isset($_POST['html']))
    $html = $_POST['html'];

$mail = new MailSender($sender, $sender_pass);

// Create connection
$conn = new mysqli($hostname, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8");
$sql = "SELECT * FROM sablona";

if ($html) {
    $result = $conn->query($sql);

    for ($i = 0; $i < $number_of_people; $i++) {
        if ($result->num_rows > 0) {
            // output data of each row
            $message = "";
            while ($row = $result->fetch_assoc()) {
                $message = $row["oslovenie"] . "<br><br>" .
                    $row["uvod"] . "<br><br>" .
                    $row["verejnaIP"] . " " . $csv_array[$i][5] . "<br>" .
                    $row["login"] . " " . $csv_array[$i][3] . "<br>" .
                    $row["heslo"] . " " . $csv_array[$i][4] . "<br><br>" .
                    $row["http"] . $csv_array[$i][5] . ":" . $csv_array[$i][8] . "<br><br>" .
                    $row["pozdrav"] . "<br><br>" . $sender;
            }

            if (isset($_FILES['attachment'])) {

                //Get uploaded file data using $_FILES array
                $tmp_name = $_FILES['attachment']['tmp_name']; // get the temporary file name of the file on the server
                $name = $_FILES['attachment']['name'];  // get the name of the file
                $size = $_FILES['attachment']['size'];  // get size of the file for size validation
                $error = $_FILES['attachment']['error']; // get the error (if any)

                //validate form field for attaching the file
                if ($error > 0) {
                    die('Upload error or No files uploaded');
                }
                if ($size >= 10000000) { // 10MB
                    die('Upload error or No files uploaded');
                }

                $mail->sendHTML_attachment($csv_array[$i][2], $subject, $message, $tmp_name, $name);
            } else {
                //$mail->send($csv_array[$i][2],$subject,$message);
                $mail->sendHTML("t.benco@gmail.com", $subject, $message);
            }
        } else {
            echo "0 results";
        }
    }
} else {
    $result = $conn->query($sql);

    for ($i = 0; $i < $number_of_people; $i++) {


        if ($result->num_rows > 0) {
            $message = "";
            while ($row = $result->fetch_assoc()) {
                $message = $row["oslovenie"] . "\n\n" .
                    $row["uvod"] . "\n\n" .
                    $row["verejnaIP"] . " " . $csv_array[$i][5] . "\n" .
                    $row["login"] . " " . $csv_array[$i][3] . "\n" .
                    $row["heslo"] . " " . $csv_array[$i][4] . "\n\n" .
                    $row["http"] . $csv_array[$i][5] . ":" . $csv_array[$i][8] . "\n\n" .
                    $row["pozdrav"] . "\n\n" . $sender;
            }

            if (isset($_FILES['attachment'])) {
                $tmp_name = $_FILES['attachment']['tmp_name']; // get the temporary file name of the file on the server
                $name = $_FILES['attachment']['name'];  // get the name of the file
                $size = $_FILES['attachment']['size'];  // get size of the file for size validation
                $type = $_FILES['attachment']['type'];  // get type of the file
                $error = $_FILES['attachment']['error']; // get the error (if any)

                //validate form field for attaching the file
                if ($error > 0) {
                    die('Upload error or No files uploaded');
                }

                //$mail->send_attachment($csv_array[$i][2], $subject, $message, $tmp_name, $name);
                $mail->send_attachment("t.benco@gmail.com", $subject, $message, $tmp_name, $name);
            } else {
                //$mail->send($csv_array[$i][2],$subject,$message);
                $mail->send("t.benco@gmail.com", $subject, $message);
            }
        } else {
            echo "0 results";
        }
    }
}

$conn->close();
