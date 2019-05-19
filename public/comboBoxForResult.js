import { combo } from '../assets/js/combo.js';

let idSubject;

$(document).ready(() => {

    combo({
        queryString: '#subject-list',
        isAsync: true,
        codeTableUrl: 'api/codetable.php?table=subject'
    });

    combo({
        queryString: '#subject-list-import',
        isAsync: true,
        codeTableUrl: 'api/codetable.php?table=subject'
    });

    $('#subject-import').focusout(function () {
        const $this = $(this);
        const $project = $("#project-import");

        const prevVal = $this.val();
        setTimeout(function () {
            if ($this.val() === prevVal) return;

            if (!$this.val()) {
                $project.attr('disabled', true);
            } else {
                $project.attr('disabled', false);
                $project.val('').parent().removeClass('is-filled');

                combo({
                    queryString: '#project-list-import',
                    isAsync: true,
                    codeTableUrl: 'api/codetable.php?table=project&subject=' + $this.attr('data-id')
                });
            }
        }, 200)
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
                printSubjectTables(login, data.subject);
                // location.href = location.protocol + '//' + location.host + location.pathname + '?subject=' + data.subject +'&type=alert-success&form=addProject&message=' + encodeURI('Operacia uspesna!');
            },
            error: function (error) {
                const response = JSON.parse(error.responseText);
                location.href = location.protocol + '//' + location.host + location.pathname + '?type=alert-danger&form=addProject&message=' + encodeURI(response.error.detail);
            }
        });

        return false;
    });

    $('#chooseProject').submit((e) => {
        e.preventDefault();

        console.log("waaaaaaaaw");
        const $this = $('#chooseProject');

        const data = {
            project: $this.find('input[name="project"]').attr('data-id'),
            // subject: $this.find('input[name="subject"]').attr('data-id'),
            // addProject: ''
        };

        console.log(data);
        $.post({
            url: '',
            data: data,
            success: function () {
                printProjectTables(login, data.project);
                // location.href = location.protocol + '//' + location.host + location.pathname + '?subject=' + data.subject +'&type=alert-success&form=addProject&message=' + encodeURI('Operacia uspesna!');
            },
            error: function (error) {
                // const response = JSON.parse(error.responseText);
                // location.href = location.protocol + '//' + location.host + location.pathname + '?type=alert-danger&form=addProject&message=' + encodeURI(response.error.detail);
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
