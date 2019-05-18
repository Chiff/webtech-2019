import { combo } from '../assets/js/combo.js';

let idSubject;

$(document).ready(() => {
    combo({
        queryString: '#subject-list',
        isAsync: true,
        codeTableUrl: 'api/codetable.php?table=subject'
    });

    $('#chooseSubject').submit((e) => {
        e.preventDefault();
        // console.warn($this.find('button[name="chooseSubject"]').val());
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

    $('#deleteButton').click(function () {
        const $this = $('#chooseSubject');

        const data = {
            project: $this.find('input[name="project"]').val(),
            subject: $this.find('input[name="subject"]').attr('data-id'),
            addProject: ''
        };

        idSubject=data.subject;
        $.post({
            url: '',
            data: data,
            success: function () {
                // $('#responseMessage').text('Uspesne ste vymazali predmet');
                // $('#responseMessage').addClass('alert alert-dismissible alert-danger');
                location.href = location.protocol + '//' + location.host + location.pathname + '?subjectToDelete=' + data.subject;
            },
            error: function (error) {
                const response = JSON.parse(error.responseText);
                location.href = location.protocol + '//' + location.host + location.pathname + '?type=alert-danger&form=addProject&message=' + encodeURI(response.error.detail);
            }
        });
        return false;
    });
});
