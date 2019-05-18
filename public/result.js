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
                document.getElementById('chooseSubject').setAttribute('hidden', "true"); //TODO, inak to zrobit
                createTable(data, 'user')
            }
        })
    }
}

function createTable(data, userRole){
    let body = document.getElementById('tables');
    let mainTitle = document.createElement("h1");
    body.innerText = '';
    if (data.length === 0){
        mainTitle.innerText = 'Ziadne vysledky'
        body.appendChild(mainTitle);
        return;
    }
    let keys = Object.getOwnPropertyNames(data[1].resutlts[0]); //ech, ale proste len  {labe, resulr} ..... alebo []
    userRole === 'admin' ? mainTitle.innerText = data[0].subject : mainTitle.innerText = 'Predmety';
    body.appendChild(mainTitle);
    data.forEach(
        function (subjectTable) {
            let table = document.createElement('table');
            let tableName = document.createElement("h5");
            userRole === 'admin' ? tableName.innerText = subjectTable.name : tableName.innerText = subjectTable.subject = subjectTable.subject;

            table.setAttribute('border', '1');
            let tbody = document.createElement('tbody');
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
                    tbody.appendChild(tr);
                }
            )
            table.appendChild(tbody);
            body.append(tableName);
            body.appendChild(table);
            body.appendChild(document.createElement("hr")); //ech
        }
    )
}

function printDiv() {
    console.log("MAMA MIA");
    window.frames["print_frame"].document.body.innerHTML = document.getElementById("tables").innerHTML;
    window.frames["print_frame"].window.focus();
    window.frames["print_frame"].window.print();
}