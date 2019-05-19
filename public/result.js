function printSubjectTables(userName, subjectID) {
	if (userName === "admin") {
		console.log('TODO:' + userName);
		$.get({
			url: window.rootUrl + '/public/api/results.php?subject=' + subjectID,
			error: function () {
				console.log(arguments)
			},
			success: function (data) {
				createSubjectTable(data, 'admin')
			}
		})
	} else {
		console.log('TODO:' + userName);
		//wtf data[0] niekto sa hral
		$.get({
			url: window.rootUrl + '/public/api/results.php?',
			error: function () {
				console.log(arguments)
			},
			success: function (data) {
				createSubjectTable(data, 'user')
			}
		})
	}
}

function createSubjectTable(data, userRole) {
	let body = document.getElementById('tables');
	let mainTitle = document.createElement("h1");
	body.innerText = '';
	$(body).removeAttr('hidden');
	$('#deleteButton').removeAttr('hidden');
	$('#printButton').removeAttr('hidden');
	if (data.length === 0) {
		mainTitle.innerText = '';
		$('#responseMessage').text('Ziadne výsledky');
		$('#responseMessage').addClass('alert alert-dismissible alert-danger');
		body.appendChild(mainTitle);
		return;
	}
	$('#responseMessage').text('');
	$('#responseMessage').removeAttr('class');

	let keys = Object.getOwnPropertyNames(data[0].resutlts[0]); //ech, ale proste len  {labe, resulr} ..... alebo []
	userRole === 'admin' ? mainTitle.innerText = data[0].subject : mainTitle.innerText = 'Predmety';
	body.appendChild(mainTitle);
	data.forEach(
		function (subjectTable) {
			let table = document.createElement('table');
			let tableName = document.createElement("h5");
			tableName.setAttribute('class', 'mt-3');
			userRole === 'admin' ? tableName.innerText = subjectTable.name : tableName.innerText = subjectTable.subject;

			table.setAttribute('border', '1');
			let tbody = document.createElement('tbody');
			let counter = 0;
			keys.forEach(
				function (value) {
					let tr = document.createElement('tr');
					subjectTable.resutlts.forEach(
						function (element) {
							let td = document.createElement('td');
							td.innerText = element[value];
							tr.appendChild(td);
						}
					);

					if (counter % 2 === 0) {
						tr.setAttribute('class', 'table-dark');
					} else {
						tr.setAttribute('class', 'table-light');
					}
					++counter;

					tbody.appendChild(tr);
				}
			);
			table.appendChild(tbody);
			body.append(tableName);
			body.appendChild(table);
		}
	)
}

function printDiv(name) {
	window.frames["print_frame"].document.body.innerHTML = document.getElementById(name).innerHTML;
	window.frames["print_frame"].window.focus();
	window.frames["print_frame"].window.print();
}

function printProjectTables(userName, subjectID) {
	if (userName === "admin") {
		$.get({
			url: window.rootUrl + '/public/api/teams.php?project=' + subjectID,
			error: function () {
				console.log(arguments)
			},
			success: function (data) {
				//   console.log(data);//create table project(data);
				createProjectTables(data, 'admin');
			}
		})
	} else { //TODO dat prec :D
		$.get({
			url: window.rootUrl + '/public/api/results.php?',
			error: function () {
				console.log(arguments)
			},
			success: function (data) {
				createSubjectTable(data, 'user');
			}
		})
	}
}

function createProjectTables(data, userRole) {
	let body = document.getElementById('tables-proj');
	let mainTitle = document.createElement("h1");
	mainTitle.setAttribute('class', 'mt-3');
	body.innerText = '';
	$(body).removeAttr('hidden');
	$('#deleteButton-proj').removeAttr('hidden');
	$('#printButton-proj').removeAttr('hidden');
	if (data.length === 0) {
		mainTitle.innerText = '';
		$('#responseMessage').text('Ziadne výsledky');
		$('#responseMessage').addClass('alert alert-dismissible alert-danger');
		body.appendChild(mainTitle);
		return;
	}
	$('#responseMessage').text('');
	$('#responseMessage').removeAttr('class');

	let keys = Object.getOwnPropertyNames(data[0].teammates[0]); //ech, ale proste len  {labe, resulr} ..... alebo []

	mainTitle.innerText = "Tímy";
	body.appendChild(mainTitle);
	data.forEach(
		function (projectTable) {
			let table = document.createElement('table');
			let tableName = document.createElement("h4");
			tableName.setAttribute('class', 'mt-3');
			tableName.innerText = 'tím ' + projectTable.team_number;

			table.setAttribute('border', '1');
			let tbody = document.createElement('tbody');
			let counter = 0;

			let trHead = document.createElement('tr');
			keys.forEach(function (key) {
				let tdHead = document.createElement('td');
				tdHead.innerText = key;
				trHead.appendChild(tdHead);
			});
			tbody.appendChild(trHead);

			projectTable.teammates.forEach(
				function (element) {
					let tr = document.createElement('tr');
					keys.forEach(
						function (value) {
							let td = document.createElement('td');
							if (element[value] == null) element[value] = 'null';
							td.innerText = element[value];
							tr.appendChild(td);
						}
					);
					if (counter % 2 === 0) {
						tr.setAttribute('class', 'table-dark');
					} else {
						tr.setAttribute('class', 'table-light');
					}
					++counter;
					tbody.appendChild(tr);
				}
			);
			table.appendChild(tbody);
			body.append(tableName);
			body.appendChild(table);
		}
	)
}