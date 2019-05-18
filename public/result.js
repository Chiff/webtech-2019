let skuska = 'lala';
function printTables(userName, subjectID) {
    if (userName === "admin"){
        console.log('TODO:' + userName);
        $.get({
            url: 'http://147.175.121.210:8153/Zaver/DNT/public/api/results.php?subject='+subjectID,
            error: function(){console.log(arguments)},
            success: function(data){
                createTable(data, 'admin')
            }
        })
    } else {
        console.log('TODO:' + userName);
        //wtf data[0] niekto sa hral
        $.get({
                url: 'http://147.175.121.210:8153/Zaver/DNT/public/api/results.php?',
            error: function(){console.log(arguments)},
            success: function(data){
                createTable(data, 'user')
            }
        })
    }
}

function createTable(data, userRole){
    let body = document.getElementById('tables');
    let mainTitle = document.createElement("h1");
    body.innerText = '';
    $('#deleteButton').removeAttr('hidden');
    $('#printButton').removeAttr('hidden');
    $('#printButton2').removeAttr('hidden');

    if (data.length === 0){
        mainTitle.innerText = ''
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
    // let deleteButton = document.createElement("button");
    // deleteButton.innerText = 'Delete Subject';
    // deleteButton.setAttribute('class', 'btn btn-primary');
    // body.appendChild(deleteButton);

    data.forEach(
        function (subjectTable) {
            let table = document.createElement('table');
            let tableName = document.createElement("h5");
            tableName.setAttribute('class', 'mt-3');
            userRole === 'admin' ? tableName.innerText = subjectTable.name : tableName.innerText = subjectTable.subject = subjectTable.subject;

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
                    )

                    if (counter % 2 == 0){
                        tr.setAttribute('class', 'table-dark');
                    } else {
                        tr.setAttribute('class', 'table-light');
                    }
                    ++counter;

                    tbody.appendChild(tr);
                }
            )
            table.appendChild(tbody);
            body.append(tableName);
            body.appendChild(table);
        }
    )
}

function printDiv() {
    window.frames["print_frame"].document.body.innerHTML = document.getElementById("tables").innerHTML;
    window.frames["print_frame"].window.focus();
    window.frames["print_frame"].window.print();
}

function printAll() {
    window.frames["print_frame"].document.body.innerHTML = '';
    allClasses = document.getElementsByClassName("printableTable");
    for (let i = 0; i < allClasses.length; i++){
        window.frames["print_frame"].document.body.innerHTML += allClasses[i].innerHTML;
    }
    // window.frames["print_frame"].document.body.innerHTML = document.getElementsByClassName("printableTable")[0].innerHTML;
    window.frames["print_frame"].window.focus();
    window.frames["print_frame"].window.print();
}