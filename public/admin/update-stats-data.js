let csvData = [];
let $idown;

var randomScalingFactor = function () {
    return Math.round(Math.random() * 100);
};

var studentConfig = {
    type: 'doughnut',
    data: {
        datasets: [{
            data: [
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
            ],
            backgroundColor: [
                'rgba(0, 120,0, 0.3)',
                'rgba(120, 0, 0, 0.3)',
                'rgba(0, 0, 120, 0.3)',
            ],
            borderColor: [
                'rgba(0, 120,0, 1)',
                'rgba(120, 0, 0, 1)',
                'rgba(0, 0, 120, 1)',
            ],
            label: 'Dataset 1'
        }],
        labels: [
            "Počet súhlasiacich študentov",
            "Počet nesúhlasiacich študentov",
            "Počet študentov, ktorí sa nevyjadrili",
        ],
    },
    options: {
        responsive: true,
        legend: {
            position: 'top',
        },
        title: {
            display: true,
            text: 'Počet študentov v predmete'
        },
        animation: {
            animateScale: true,
            animateRotate: true
        }
    }
};
const studentCtx = document.getElementById("studentChart").getContext('2d');

var teamConfig = {
    type: 'doughnut',
    data: {
        labels: ["počet uzavretých tímov", "počet tímov, ku ktorým sa treba vyjadriť", "počet tímov s nevyjadrenými študentami"],
        datasets: [{
            label: 'Počet tímov',
            data: [
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor()
            ],
            backgroundColor: [
                'rgba(0, 120,0, 0.3)',
                'rgba(120, 0, 0, 0.3)',
                'rgba(0, 0, 120, 0.3)'
            ],
            borderColor: [
                'rgba(0, 120,0, 1)',
                'rgba(120, 0, 0, 1)',
                'rgba(0, 0, 120, 1)'
            ],
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        legend: {
            position: 'top'
        },
        title: {
            display: true,
            text: 'Počet tímov v predmete'
        },
        animation: {
            animateScale: true,
            animateRotate: true
        }
    }
};
const teamCtx = document.getElementById("teamChart").getContext('2d');

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

$(document).ready(function () {
    window.studentChart = new Chart(studentCtx, studentConfig);
    window.teamChart = new Chart(teamCtx, teamConfig);
});

function downloadURL(url) {
    if ($idown) {
        $idown.attr('src', url);
    } else {
        $idown = $('<iframe>', {id: 'idown', src: url}).hide().appendTo('body');
    }
}

function updateTeamData(projectID) {
    $.ajax({
        url: "../api/teams.php",
        type: "get", //send it through get method
        data: {
            project: projectID
        },
        success: function (response) {
            csvData = [];

            let students_num = 0;
            let students_ok_num = 0;
            let students_nok_num = 0;
            let students_nope_num = 0;

            let teams_num = 0;
            let teams_ok_num = 0;
            let teams_nok_num = 0;
            let teams_nope_num = 0;

            $.each(response, function (i, team) {
                    teams_num++;
                    if (team.admin_agree != null) {
                        if (team.admin_agree) {
                            teams_ok_num++;
                        } else teams_nok_num++;
                    }
                    const team_studnets = team.teammates.length;
                    let student_agree = 0;
                    $.each(team.teammates, function (i, student) {
                        students_num++;
                        if (student.agree != null) {
                            if (student.agree) {
                                students_ok_num++;
                                student_agree++;
                            } else {
                                students_nok_num++;
                            }
                        } else {
                            students_nope_num++;
                        }
                        csvData.push({ais: student.ais_id, name: student.name, points: student.result});
                    });
                    if (student_agree < team_studnets) {
                        teams_nope_num++;
                    }
                }
            );

            updateTables([
                {
                    "all": students_num,
                    "ok": students_ok_num,
                    "nok": students_nok_num,
                    "nope": students_nope_num
                },
                {
                    "all": teams_num,
                    "ok": teams_ok_num,
                    "nok": teams_nok_num,
                    "nope": teams_nope_num
                }
            ]);

            studentConfig.data.datasets.forEach(function (dataset) {
                dataset.data = [
                    students_ok_num,
                    students_nok_num,
                    students_nope_num,
                ];
            });

            teamConfig.data.datasets.forEach(function (dataset) {
                dataset.data = [
                    teams_ok_num,
                    teams_nok_num,
                    teams_nope_num,
                ];
            });

            window.studentChart.update();
            window.teamChart.update();
        },
        error: function (xhr) {
            console.log("something went terribly wrong, but I dunno what...")
        }
    });
}

function downloadStats() {
    $.post("../../src/stats/download-stats.php",
        {
            data: JSON.stringify(csvData)
        },
        function (result) {
            downloadURL(result);
        });
}