<?php
/**
 * @param $head array of head data
 * @param $rows array of row data
 * @param $ID string id
 * @param $TIDs array of thesis ids
 */
function genTable($head, $rows, $ID)
{
    echo "<table id='$ID' class=\"table table-hover\"><thead><tr class='table-light'>";
    foreach ($head as $item) {
        genTableHeadRow($item);
    }
    echo "</tr></thead><tbody>";
    for ($i = 0; $i < count($rows); $i++) {
        genTableRow($rows[$i]);
    }
    echo "</tbody></table>";
}

/**
 * @param $row array
 * @param $tID string
 */
function genTableRow($row)
{
    echo "<tr class='table-dark'>";
    for ($i = 0; $i < count($row); $i++) {
        echo "<td>$row[$i]</td>";
    }
    echo "</tr>";
}

/**
 * @param $row
 */
function genTableHeadRow($row)
{
    echo "<tr class='table-light'>";
    foreach ($row as $item) {
        echo "<th scope=\"col\">$item</th>";
    }
    echo "</tr>";
}

?>
    <!DOCTYPE html>
    <html lang="sk">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="google-site-verification" content="MSF8nltigNlCWnsp5OzxANLiQrnyKkkAKl-DhoW6GuU"/>
        <title>Štatistiky odoslaných mailov</title>
        <link rel="stylesheet" type="text/css" media="screen" href="../../assets/css/main.css">
        <!-- data tables-->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
        <!-- jQuery UI -->
        <link rel="stylesheet"
              href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    </head>
    <body>
    <div class="mainContainer">
        <?php

        ?>
    </div>
    <!-- jQuery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- jQuery UI -->
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <!-- data tables-->
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script>
        const table = $('#ResultTable').DataTable({
            autoWidth: true,
            ordering: true,
            columnDefs: [{
                orderable: false,
                targets: "no-sort"
            }],
            orderCellsTop: true,
            paging: true,
            processing: true,
            searching: false,
            stateSave: true,
            language:
                {
                    "sEmptyTable": "Nie sú k dispozícii žiadne dáta",
                    "sInfo": "Záznamy _START_ až _END_ z celkom _TOTAL_",
                    "sInfoEmpty": "Záznamy 0 až 0 z celkom 0 ",
                    "sInfoFiltered": "(vyfiltrované spomedzi _MAX_ záznamov)",
                    "sInfoPostFix": "",
                    "sInfoThousands": ",",
                    "sLengthMenu": "Zobraz _MENU_ záznamov",
                    "sLoadingRecords": "Načítavam...",
                    "sProcessing": "Spracúvam...",
                    "sSearch": "Hľadať:",
                    "sZeroRecords": "Nenašli sa žiadne vyhovujúce záznamy",
                    "oPaginate": {
                        "sFirst": "Prvá",
                        "sLast": "Posledná",
                        "sNext": "Nasledujúca",
                        "sPrevious": "Predchádzajúca"
                    },
                    "oAria": {
                        "sSortAscending": ": aktivujte na zoradenie stĺpca vzostupne",
                        "sSortDescending": ": aktivujte na zoradenie stĺpca zostupne"
                    }
                },
            select: true
        });
    </script>
    </body>
    </html>
<?php
