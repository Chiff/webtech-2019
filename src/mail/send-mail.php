<?php
//require_once "../helpers.php";
require_once "../../src/mail/MailSender.php";
require_once "../../config/config.php";

$csv_array = [];
$mail_sql = "INSERT INTO `mail_statistics`(`student_name`, `subject`, `template_id`) VALUES (?,?,?)";


$server_csv = "../../uploaded/server_info.csv";
$sender = "Feri";
$sender_pass = "";

// user data
$number_of_people = 0;

$delimiter = ";";
if (isset($_POST['delimiter']))
    $delimiter = $_POST['delimiter'];
echo "delim: ", $delimiter, "<br>";

$row = 0;
if (($handle = fopen($server_csv, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
        if ($row == 0) {
            $row++;
            continue;
        }
        $csv_array[] = $data;
        $number_of_people++;
    }
    fclose($handle);
}


// mail data
$subject = "";
if (isset($_POST['subject']))
    $subject = $_POST["subject"]; //subject for the email
echo "sub: ", $subject, "<br>";

if (isset($_POST['sender_pass']))
    $sender_pass = $_POST['sender_pass'];

if (isset($_POST['sender_email'])) {
    $sender = $_POST['sender_email'];
    $sender = explode("@", $sender)[0];
}
// html editor bool
$html = false;
if (isset($_POST['html']))
    $html = $_POST['html'];
echo "html: ";
var_dump($html);
echo "<br>";

$mail = new MailSender($sender, $sender_pass);

// Create connection
$conn = new mysqli($hostname, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8");
$sql = "SELECT * FROM sablona";

if ($html === "1") {
    $result = $conn->query($sql);
    for ($i = 0; $i < $number_of_people; $i++) {

        // output data of each row
        $message = "";
        if (isset($_POST['noise']))
            $message = $_POST['noise'];

        $message = str_replace("((ip))", $csv_array[$i][5], $message);
        $message = str_replace("((login))", $csv_array[$i][3], $message);
        $message = str_replace("((url))", $csv_array[$i][4], $message);
        $message = str_replace("((port))", $csv_array[$i][5], $message);
        $message = str_replace("((sender))", $sender, $message);

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
            echo "mail attch html num: ", $i, "<br>";
            $stmt = $conn->prepare($mail_sql);
            $stmt->bind_param();
            $mail->sendHTML_attachment($csv_array[$i][2], $subject, $message, $tmp_name, $name);
        } else {
            $mail->sendHTML($csv_array[$i][2], $subject, $message);
            echo "mail html num: ", $i, "<br>";
        }
    }
} else {
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        $oslovenie = $row["oslovenie"] . "\n\n";
        $uvod = $row["uvod"] . "\n\n";
        $ip = $row["verejnaIP"] . " ";
        $login = $row["login"] . " ";
        $heslo = $row["heslo"] . " ";
        $http = $row["http"];
        $pozdrav = $row["pozdrav"] . "\n\n" . $sender;
    }

    for ($i = 0; $i < $number_of_people; $i++) {


        if ($result->num_rows > 0) {
            $message = $oslovenie . $uvod .
                $ip . $csv_array[$i][5] . "\n" .
                $login . $csv_array[$i][3] . "\n" .
                $heslo . $csv_array[$i][4] . "\n\n" .
                $http . $csv_array[$i][5] . ":" . $csv_array[$i][8] . "\n\n" .
                $pozdrav;


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
                if ($size >= 10000000) { // 10MB
                    die('Upload error or No files uploaded');
                }

                echo "mail attch num: ", $i, "<br>";

                $mail->send_attachment($csv_array[$i][2], $subject, $message, $tmp_name, $name);
            } else {
                echo "mail num: ", $i, "<br>";
                $mail->send($csv_array[$i][2], $subject, $message);
            }
        } else {
            echo "0 results";
        }
    }
}

$conn->close();
header("location: ../../public/admin/server-data-generator.php");
