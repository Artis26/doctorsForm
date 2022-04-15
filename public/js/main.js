function openForm(name) {
    document.getElementById(name).style.display = "block";
}

function closeForm(name) {
    document.getElementById(name).style.display = "none";
}

function sendJSON() {

    if ($("#validation").val() !== "true") {
        alert("Nepareizs personas koda formāts. Jābūt[X = cipars]: XXXXXX-XXXXX");
        return;
    }

    let result = document.querySelector('.result');
    let one = document.querySelector('#one');
    let two = document.querySelector('#two');
    let three = document.querySelector('#three');
    let four = document.querySelector('#four');
    let five = document.querySelector('#five');
    let six = document.querySelector('#six');
    let seven = document.querySelector('#seven');
    let eight = document.querySelector('#eight');

    if ($("#eight").val() === "") {
        alert("Deguna ārējā froma ir obligāts lauks");
        return;
    }

    let xhr = new XMLHttpRequest();
    let url = "/insert";

    xhr.open("POST", url, true);

    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {

            result.innerHTML = this.responseText;

        }
    };

    var data = JSON.stringify({
        "1": one.value, "2": two.value, "3": three.value, "4": four.value,
        "5": five.value, "6": six.value, "7": seven.value, "8": eight.value,
    });

    xhr.send(data);
    closeForm('myForm');
    openForm('myFormTwo')
}

function sendJSONTwo() {

    let result = document.querySelector('.result');
    let nine = document.querySelector('#nine');
    let ten = document.querySelector('#ten');
    let eleven = document.querySelector('#eleven');
    let twelve = document.querySelector('#twelve');
    let thirteen = document.querySelector('#thirteen');
    let fourteen = document.querySelector('#fourteen');
    let fifteen = document.querySelector('#fifteen');

    let xhr = new XMLHttpRequest();
    let url = "/insertTwo";

    xhr.open("POST", url, true);

    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {

            result.innerHTML = this.responseText;

        }
    };

    var data = JSON.stringify({
        "9": nine.value, "10": ten.value, "11": eleven.value, "12": twelve.value,
        "13": thirteen.value, "14": fourteen.value, "15": fifteen.value
    });

    xhr.send(data);
    window.location.replace("/");
}

function updateInput() {
    var val1 = $('#nine1').val();
    var val2 = $('#nine2').val();
    var output = val1 + ',' + val2
    $('#nine').val(output);
}

function updateInputTwo() {
    var val1 = $('#fourteen1').val();
    var val2 = $('#fourteen2').val();
    var output = val1 + ',' + val2
    $('#fourteen').val(output);
}

function updateInputThree() {
    var val1 = $('#fifteen1').val();
    var val2 = $('#fifteen2').val();
    var output = val1 + ',' + val2
    $('#fifteen').val(output);
}

$(function () {
    enable_cb();
    $("#eleven").click(enable_cb);
});

function enable_cb() {
    if (this.checked) {
        $("input.eleven").attr("disabled", true);
        $("input.eleven").val('');
    } else {
        $("input.eleven").removeAttr("disabled");
    }
}

function autoSetNine() {
    var text = $('#eight').val();
    var compare = "taisna";
    var output1 = "bāla";
    var output2 = "hipertrofiska";
    var output3 = "sašaurinātas";
    if (text === compare) {
        $('#nine1').val(output1);
        $('#nine2').val(output2);
        $("#nine").val(output1 + ',' + output2);
    } else {
        $("#ten").val(output3);
    }
}

function validateFour() {
    var input = document.getElementById('four').value;
    var regex = /^(\d{6})-[012]\d{4}$/;
    var result = regex.test(input);
    $("#validation").val(result.toString());
}

function more() {

    var typingTimer;
    var doneTypingInterval = 2000;

    $('#person').keyup(function () {
        clearTimeout(typingTimer);
        if ($('#person').val()) {
            typingTimer = setTimeout(doneTyping, doneTypingInterval);
        }
    });

    function doneTyping() {
        var p = $('#person').val();
        $.post('search', {id: p}, function (data) {
            console.log('success', data);
            $("#person").autocomplete({
                source: data.map(one => one['4']),
            });
        })
    }
}

function simpleDelete(id) {
    var p = $("#" + id).attr('id');
    console.log('id', p);
    $.post('simple/delete', {value: p});
    $('#myList').empty();
    searchByPersonsId()
}

function fullDelete(id) {
    var p = $("#" + id).attr('id');
    console.log('id', p);
    $.post('full/delete', {value: p});
    $('#myList').empty();
    searchByPersonsId()
}

function searchByPersonsId() {
    $('#myList').empty();
    var p = $('#person').val();
    let list = document.getElementById("myList")
    $.post('search/full', {id: p}, function (data) {
        console.log('success', data);
        data.forEach((item) => {
            var date = new Date(item['created_at']);
            var day = date.getDate();
            if (day < 10) {
                day = '0' + day;
            }
            var month = date.getMonth() + 1;
            if (month < 10) {
                month = '0' + month;
            }
            var year = date.getFullYear();
            var full = day + '.' + month + '.' + year;

            let li = document.createElement("li");
            var a = document.createElement("a");
            let btn = document.createElement("button");
            let btn2 = document.createElement("button");

            a.textContent = (item['4'] + " Date:" + full);
            a.setAttribute('href', 'person/' + item['id'])
            btn.innerHTML = "Delete";
            btn.setAttribute('onclick', 'confirm(\'Ieraksts tiks izdzēsts no saraksta!\');simpleDelete(this.id)');
            btn2.innerHTML = "Full Delete";
            btn2.setAttribute('onclick', 'confirm(\'Ieraksts tiks pilnībā idzēsts!\');fullDelete(this.id)');
            li.appendChild(a);
            li.appendChild(btn);
            li.appendChild(btn2);
            li.setAttribute('id', 'list_' + item['id']);
            btn.setAttribute('id', 'list_' + item['id']);
            btn2.setAttribute('id', 'list_' + item['id']);
            list.appendChild(li);
        })
    })
}

function checkInput() {
    var inp = $('#person').val();
    var len = inp.length;
    var lastChar = inp.substr(inp.length - 1); // => "1"
    var ret = inp.slice(0, -1);
    if (len !== 7) {
        if (isNaN(lastChar) === true) {
            $('#person').val(ret)
            return document.getElementById('errorname').innerHTML="this is an invalid name";
        }
    } else {
        if (lastChar !== '-') {
            $('#person').val(ret);
            return document.getElementById('errorname').innerHTML="this is an invalid name";
        }
    }
}
