import { combo } from '../../assets/js/combo.js';

$(document).ready(() => {
	combo({
		queryString: '#subject-list',
		isAsync: true,
		codeTableUrl: '../codetable.php?table=subject'
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
				console.log(data);
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
