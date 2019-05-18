function updateTables(response) {
    $('#teamTable tbody tr:last').remove();
    $('#studentTable tbody tr:last').remove();

    $('<tr>').append(
        $('<td>').text(response[0].all),
        $('<td>').text(response[0].ok),
        $('<td>').text(response[0].nok),
        $('<td>').text(response[0].nope)
    ).appendTo('#studentTable');

    $('<tr>').append(
        $('<td>').text(response[1].all),
        $('<td>').text(response[1].ok),
        $('<td>').text(response[1].nok),
        $('<td>').text(response[1].nope)
    ).appendTo('#teamTable');
}