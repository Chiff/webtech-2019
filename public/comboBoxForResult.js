import { combo } from '../assets/js/combo.js';


$(document).ready(() => {
    combo({
        queryString: '#subject-list',
        isAsync: true,
        codeTableUrl: 'api/codetable.php?table=subject'
    });

    $('#chooseSubject').submit((e) => {
        e.preventDefault();
        const $this = $('#chooseSubject');

        const data = {
            project: $this.find('input[name="project"]').val(),
            subject: $this.find('input[name="subject"]').attr('data-id'),
            addProject: ''
        };

        $.post({
            url: '',
            data: data,
            success: function () {
                printTables(login, data.subject);
                // location.href = location.protocol + '//' + location.host + location.pathname + '?subject=' + data.subject +'&type=alert-success&form=addProject&message=' + encodeURI('Operacia uspesna!');
            },
            error: function (error) {
                const response = JSON.parse(error.responseText);
                location.href = location.protocol + '//' + location.host + location.pathname + '?type=alert-danger&form=addProject&message=' + encodeURI(response.error.detail);
            }
        });

        return false;
    });
});
