var response = [{
    "ok": "9",
    "nok": "Alon",
    "nope": "5"
},
    {
        "ok": "6",
        "content": "Tala",
        "UID": "6"
    }];


function updateTables(response) {
    $('<tr>').append(
        $('<td>').text(response[0].ok),
        $('<td>').text(response[0].nok),
        $('<td>').text(response[0].nope)
    ).appendTo('#teamTable');
    // $('#records_table').append($tr);
    //console.log($tr.wrap('<p>').html());

    $('<tr>').append(
        $('<td>').text(response[1].ok),
        $('<td>').text(response[1].nok),
        $('<td>').text(response[1].nope)
    ).appendTo('#studentTable');
    // $('#records_table').append($tr);
    //console.log($tr.wrap('<p>').html());
}