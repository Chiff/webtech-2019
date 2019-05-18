import { combo } from '../../assets/js/combo.js';

$(document).ready(() => {
	combo({
		queryString: '#subject-list',
		isAsync: true,
		codeTableUrl: '../api/codetable.php?table=subject'
	});

	combo({
		queryString: '#subject-list-import',
		isAsync: true,
		codeTableUrl: '../api/codetable.php?table=subject'
	});

	combo({
		queryString: '#subject-list-import-results',
		isAsync: true,
		codeTableUrl: '../api/codetable.php?table=subject'
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
					codeTableUrl: '../api/codetable.php?table=project&subject=' + $this.attr('data-id')
				});
			}
		}, 200)
	});

	$('#addProject').submit((e) => {
		e.preventDefault();
		const $this = $('#addProject');

		const data = {
			project: $this.find('input[name="project"]').val(),
			subject: $this.find('input[name="subject"]').attr('data-id'),
			addProject: ''
		};

		$.post({
			url: 'add-project.php',
			data: data,
			success: function () {
				location.href = location.protocol + '//' + location.host + location.pathname + '?type=alert-success&form=addProject&message=' + encodeURI('Operacia uspesna!');
			},
			error: function (error) {
				const response = JSON.parse(error.responseText);
				location.href = location.protocol + '//' + location.host + location.pathname + '?type=alert-danger&form=addProject&message=' + encodeURI(response.error.detail);
			}
		});

		return false;
	});

	$('#user-import').submit(() => {
		const $this = $('#user-import');

		const $project = $this.find('#project-import');
		$project.val($project.attr('data-id'));

		const $subject = $this.find('#subject-import');
		$subject.val($subject.attr('data-id'));
	});

	$('#result-import').submit(() => {
		const $this = $('#result-import');

		const $subject = $this.find('#subject-import-results');
		$subject.val($subject.attr('data-id'));
	});

	$('#inputGroupFile02').change(function (e) {
		$(this).next('.custom-file-label').html(e.target.files[0].name);
	});
});
