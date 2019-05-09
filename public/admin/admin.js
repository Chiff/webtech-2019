import { combo } from '../../assets/js/combo.js';

$(document).ready(() => {
	combo({
		queryString: '#subject-list',
		isAsync: true,
		codeTableUrl: '../codetable.php?table=subject'
	});

	combo({
		queryString: '#subject-list-import',
		isAsync: true,
		codeTableUrl: '../codetable.php?table=subject'
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
					codeTableUrl: '../codetable.php?table=project&subject=' + $this.attr('data-id')
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
			success: function (data) {
				location.href = location.protocol + '//' + location.host + location.pathname + '?type=success&form=addProject&message=' + encodeURI('Operacia uspesna!');
			},
			error: function (error) {
				const response = JSON.parse(error.responseText);
				location.href = location.protocol + '//' + location.host + location.pathname + '?type=error&form=addProject&message=' + encodeURI(response.error.detail);
			}
		});

		return false;
	});
});
