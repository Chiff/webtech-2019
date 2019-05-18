function updateTeamData() {
    $.ajax({
        url: "../api/teams.php",
        type: "get", //send it through get method
        data: {
            project: 24
        },
        success: function (response) {
            console.log(response);

            updateTables([
                {
                    "ok": "10",
                    "nok": "10",
                    "nope": "10"
                },
                {
                    "ok": "26",
                    "nok": "36",
                    "nope": "6"
                }
            ]);

            studentConfig.data.datasets.forEach(function (dataset) {
                dataset.data = [
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                ];
            });

            teamConfig.data.datasets.forEach(function (dataset) {
                dataset.data = [
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
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