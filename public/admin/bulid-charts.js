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
const ctx = document.getElementById("studentChart").getContext('2d');

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
const ctx2 = document.getElementById("teamChart").getContext('2d');

$(document).ready(function () {
    window.studentChart = new Chart(ctx, studentConfig);
    window.teamChart = new Chart(ctx2, teamConfig);
});