let csvData = [];
let $idown;

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
    console.log(csvData);
    csvData.push({ais: 85274, name: "Jano", points: 69});
    csvData.push({ais: 96385, name: "Feri", points: 96});
    $.post("download-stats.php",
        {
            data: JSON.stringify(csvData)
        },
        function (result) {
            downloadURL(result);
        });
}