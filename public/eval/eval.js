const nopoints = "Neudelené";
const noresp = "Bez odpovede";
const ok = "Súhlas";
const nok = "Nesúhlas";


function updateTable(response) {
    $.each(response, function (index, project) {
        var link = null;
        if (uid != project.captain_id) {
            link = "<a href=\"eval-teammate.php?project_name=" + getProjectName(project.project_id) + "&project_id=" + project.project_id + "&team_id=" + project.id + "&project_points=" + (project.points != null ? project.points : nopoints) + "\" class=\"btn btn-outline-primary\">" + getProjectName(project.project_id) + "</a>";
        } else {
            link = "<a href=\"eval-captain.php?project_name=" + getProjectName(project.project_id) + "&project_id=" + project.project_id + "&team_id=" + project.id + "&project_points=" + (project.points != null ? project.points : nopoints) + "\" class=\"btn btn-outline-primary\">" + getProjectName(project.project_id) + "</a>";
        }
        $('<tr>').append(
            $('<td>').html(link)
        ).appendTo('#projectTable');
    });
}

function getProjectName(project_id) {
    let name = null;
    $.ajax({
        url: "../../src/eval/get-project-name.php",
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
        if (uid == student.student_id && student.agree == null) {
            let td1 = $('<td>').text(student.result != null ? student.result : nopoints);
            td1.attr("data-translate", "");
            let td2 = $('<td>').html(student.result != null ? "<button id='nopeBtn' data-toggle=\"modal\" data-target=\"#disagreeModal\" class=\"btn btn-outline-secondary\">Nesúhlasím</button>\n" +
                "<button id='okBtn' data-toggle=\"modal\" data-target=\"#agreeModal\" class=\"btn btn-outline-primary\">Súhlasím</button>" : noresp)
            td2.attr("data-translate", "");

            $('<tr>').append(
                $('<td>').text(student.name), td1, td2
            ).appendTo('#teamTable');
        } else {
            let td1 = $('<td>').text(student.result != null ? student.result : nopoints);
            td1.attr("data-translate", "");
            let td2 = $('<td>').html(student.agree != null ? (student.agree ? ok : nok) : noresp);
            td2.attr("data-translate", "");

            $('<tr>').append(
                $('<td>').text(student.name), td1, td2
            ).appendTo('#teamTable');
        }
    });
}

function updateTeamCaptain(team) {
    $('#teamTable tbody tr').remove();

    $.each(team, function (index, student) {
        if (uid == student.student_id && student.agree == null) {
            $('<tr>').append(
                $('<td>').text(student.name),
                $('<td>').html("<input type=\"number\" class='form-control' name=\"points[]\" value=\"0\">"),
                $('<td>').html()
            ).appendTo('#teamTable');
        } else {
            $('<tr>').append(
                $('<td>').text(student.name),
                $('<td>').html("<input type=\"number\" class='form-control' name=\"points[]\" value=\"0\">"),
                $('<td>').html(student.agree != null ? (student.agree ? ok : nok) : noresp)
            ).appendTo('#teamTable');
        }
    });
}

function agreeResult(agree, team) {

    $.ajax({
        url: "../../src/eval/update-student-agreement.php",
        type: "post",
        async: false,
        cache: false,
        timeout: 30000,
        data: {agree: agree, team: team},
        success: function (response) {
            console.log("Updated succesfully...");
            location.reload();
        },
        error: function (xhr) {
            console.log("something went terribly wrong, but I dunno what...\n" + xhr)
        }
    });
}

function isValid() {
    let sum = 0;
    $('.form-control').each(
        function () {
            sum += Number($(this).val());
        });
    console.log(sum);
    console.log(total_points);

    return sum === total_points;
}