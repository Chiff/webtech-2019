function updateTable(response) {
    $.each(response, function (index, project) {
        var link = null;
        if (uid !== project.captain_id) {
            link = "<a href=\"eval-teammate.php?project_name=" + getProjectName(project.project_id) + "&project_id=" + project.project_id + "\" class=\"btn btn-outline-primary\">" + getProjectName(project.project_id) + "</a>";
        } else {
            link = "<a href=\"eval-captain.php?project_name=" + getProjectName(project.project_id) + "&project_id=" + project.project_id + "\" class=\"btn btn-outline-primary\">" + getProjectName(project.project_id) + "</a>";
        }
        $('<tr>').append(
            $('<td>').html(link)
        ).appendTo('#projectTable');
    });
}

function getProjectName(project_id) {
    let name = null;
    $.ajax({
        url: "get-project-name.php",
        type: "get",
        async: false,
        cache: false,
        timeout: 30000,
        data: {project_id: project_id},
        success: function (response) {
            console.log("project id: " + response);
            name = response;
        },
        error: function (xhr) {
            console.log("something went terribly wrong, but I dunno what...")
        }
    });
    return name;
}

function updateTeam(team) {
    $('#teamTable tbody tr').remove();

    $.each(team, function (index, student) {
        if (uid == student.student_id) {
            $('<tr>').append(
                $('<td>').text(student.student[0].name),
                $('<td>').text(student.result != null ? student.result : 0),
                $('<td>').html("<button id='nopeBtn' class=\"btn btn-outline-secondary\">Nesúhlasím</button>\n" +
                    "<button id='okBtn' data-toggle=\"modal\" data-target=\"#agreeModal\" class=\"btn btn-outline-primary\">Súhlasím</button>")
            ).appendTo('#teamTable');
        } else {
            $('<tr>').append(
                $('<td>').text(student.student[0].name),
                $('<td>').text(student.result != null ? student.result : 0),
                $('<td>').html("")
            ).appendTo('#teamTable');
        }
    });
}

function agreeResult() {

}

function agreeResult(student_id) {

}