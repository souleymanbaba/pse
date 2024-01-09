


//Load Data Function tables
function loadDataListMissions(empID) {
    $.ajax({
        url: "/Employe/ListMissions/" + empID,
        type: "GET",
        contentType: "application/json;charset=utf-8",
        dataType: "json",
        success: function (result) {
            var html = '';
            $.each(result, function (key, item) {
                html += '<tr>';
                html += '<td>' + item.type + '</td>';
                html += '<td>' + item.titre + '</td>';
                html += '<td>' + ToJavaScriptDate(item.dateDebut) + '</td>';
                html += '<td>' + ToJavaScriptDate(item.dateFin) + '</td>';
                html += '<td>' + item.commentaire + '</td>';
                html += '<td><a href="#" onclick="return getbyID(' + item.id + ')"> <img src="../images/edit.gif"/></a> | <a href="#" onclick="Delele(' + item.id + ')"><img src="../images/delete.gif"/></a></td>';
                html += '</tr>';
            });
            $('.tbodyStages').html(html);
        },
        error: function (errormessage) {
            alert(errormessage.responseText);
        }
    });
}
function loadDataListMandats(empID) {
    $.ajax({
        url: "/Employe/ListMandats/" + empID,
        type: "GET",
        contentType: "application/json;charset=utf-8",
        dataType: "json",
        success: function (result) {
            var html = '';
            $.each(result, function (key, item) {
                html += '<tr>';
                html += '<td>' + item.type + '</td>';
                html += '<td>' + ToJavaScriptDate(item.dateDebut) + '</td>';
                html += '<td>' + ToJavaScriptDate(item.dateFin) + '</td>';
                html += '<td><a href="#" onclick="return getbyID(' + item.id + ')"> <img src="../images/edit.gif"/></a> | <a href="#" onclick="Delete(' + item.id + ')"><img src="../images/delete.gif"/></a></td>';
                html += '</tr>';
            });
            $('.tbodyMandats').html(html);
        },
        error: function (errormessage) {
            alert(errormessage.responseText);
        }
    });
}
function loadData()
{
    $.ajax({
        url: "/Employe/List/",
        type: "GET",
        contentType: "application/json;charset=utf-8",
        dataType: "json",
        success: function (result) {
            var html = '';
            $.each(result, function (key, item) {
                html += '<tr>';
                html += '<td>' + item.matricule + '</td>';
                html += '<td>' + item.nni + '</td>';
                html += '<td>' + item.prenom + '</td>';
                html += '<td>' + item.prenomPere + '</td>';
                html += '<td>' + item.nomFamille + '</td>';
                html += '<td>' + ToJavaScriptDate(item.dateNaissance) + '</td>';
                html += '<td>' + item.corps + '</td>';
                html += '<td><a href="#" onclick="return getbyID(' + item.id + ')"> <img src="../images/edit.gif"/></a> | <a href="#" onclick="Delete(' + item.id + ')"><img src="../images/delete.gif"/></a></td>';
                html += '</tr>';
            });
            $('.tbody').html(html);
        },
        error: function (errormessage) {
            alert(errormessage.responseText);
        }
    });
}

//Load Data Function dropdown
function loadDataListTypeMission() {
    var ddltarget = "#idType";
    var url = "/Shared/GetTypeMissions";

    $.getJSON(url, {  },
                function (data) {
                    $(ddltarget).empty();
                    $(ddltarget).append($('<option/>', {
                        value: '',
                        text: "Sélectionner le type"
                    }));
                    $.each(data, function (index, optionData) {
                        $(ddltarget).append("<option value='" + optionData.Value + "'>" + optionData.Text + "</option>");
                    });
                });
}
function loadDataListCorps() {
    var ddltarget = "#idCorps";
    var url = "/Shared/GetCorps";

    $.getJSON(url, {},
                function (data) {
                    $(ddltarget).empty();
                    $(ddltarget).append($('<option/>', {
                        value: '',
                        text: "Sélectionner le corps"
                    }));
                    $.each(data, function (index, optionData) {
                        $(ddltarget).append("<option value='" + optionData.Value + "'>" + optionData.Text + "</option>");
                    });
                });
}
function loadDataListPosition() {
    var ddltarget = "#idPosition";
    var url = "/Shared/GetPositions";

    $.getJSON(url, {},
                function (data) {
                    $(ddltarget).empty();
                    $(ddltarget).append($('<option/>', {
                        value: '',
                        text: "Sélectionner la position"
                    }));
                    $.each(data, function (index, optionData) {
                        $(ddltarget).append("<option value='" + optionData.Value + "'>" + optionData.Text + "</option>");
                    });
                });
}
function loadDataListFonction() {
    var ddltarget = "#idFonction";
    var url = "/Shared/GetFonctions";

    $.getJSON(url, {},
                function (data) {
                    $(ddltarget).empty();
                    $(ddltarget).append($('<option/>', {
                        value: '',
                        text: "Sélectionner la fonction"
                    }));
                    $.each(data, function (index, optionData) {
                        $(ddltarget).append("<option value='" + optionData.Value + "'>" + optionData.Text + "</option>");
                    });
                });
}
function loadDataListTypeMandat() {
    var ddltarget = "#idTypeMandat";
    var url = "/Shared/GetTypeMandats";

    $.getJSON(url, {},
                function (data) {
                    $(ddltarget).empty();
                    $(ddltarget).append($('<option/>', {
                        value: '',
                        text: "Sélectionner type"
                    }));
                    $.each(data, function (index, optionData) {
                        $(ddltarget).append("<option value='" + optionData.Value + "'>" + optionData.Text + "</option>");
                    });
                });
}

//Add Data Function
/*===================identification==================*/
function addIdentificatuion() {
    var res = validate();
    if (res == false) {
        return false;
    }
    var empObj = {
        matricule: $('#matricule').val(),
        nni: $('#nni').val(),
        prenom: $('#prenom').val(),
        prenomPere: $('#prenomPere').val(),
        nomFamille: $('#nomFamille').val(),
        // sexe: $('#sexe').val(),
        dateNaissance: $('#dateNaissance').val(),
        lieuNaissance: $('#lieuNaissance').val(),
        //idSituationMatrimoniale: $('#idSituationMatrimoniale').val(),
        nbEnfants: $('#nbEnfants').val()
    };
    $.ajax({
        url: "/Employe/Add",
        data: JSON.stringify(empObj),
        type: "POST",
        contentType: "application/json;charset=utf-8",
        dataType: "json",
        success: function (result) {
            $('#idEmploye').val(result.id);
            $('#btnUpdateEmploye').show();
            $('#btnAddEmploye').hide();
        },
        error: function (errormessage) {
            alert(errormessage.responseText);
        }
    });
}
/*===================situation administratif=======================*/
function addSituationAdmin() {
    //var res = validate();
    //if (res == false) {
    //    return false;
    //}
    var empObj = {
        id: $('#idEmploye').val(),
        dateRecrutement: $('#dateRecrutement').val(),
        dateTitularisation: $('#dateTitularisation').val(),
        idCorps: $('#idCorps').val(),
        idGrade: $('#idGrade').val(),
        echelon: $('#echelon').val(),
        idPosition: $('#idPosition').val(),
        datePosition: $('#datePosition').val(),
        idFonction: $('#idFonction').val(),
        dateFonction: $('#dateFonction').val()
    };
    $.ajax({
        url: "/Employe/AddSituationAdm",
        data: JSON.stringify(empObj),
        type: "POST",
        contentType: "application/json;charset=utf-8",
        dataType: "json",
        success: function (result) {
            $('#btnUpdateSitAdm').show();
            $('#btnAddSitAdm').hide();
        },
        error: function (errormessage) {
            alert(errormessage.responseText);
        }
    });
}
/*===================mission=======================*/
function addMission() {
    //var res = validate();
    //if (res == false) {
    //    return false;
    //}
    var empObj = {
        idEmploye: $('#idEmploye').val(),
        idType: $('#idType').val(),
        dateDebut: $('#dateDebut').val(),
        dateFin: $('#dateFin').val(),
        titre: $('#titre').val(),
        commentaire: $('#commentaire').val(),
        //idPays: $('#idPays').val(),
        //ville: $('#ville').val()
    };
    $.ajax({
        url: "/Employe/AddMission",
        data: JSON.stringify(empObj),
        type: "POST",
        contentType: "application/json;charset=utf-8",
        dataType: "json",
        success: function (result) {
            loadDataListMissions(empObj.idEmploye);
            $('#myModalStage').modal('hide');
        },
        error: function (errormessage) {
            alert(errormessage.responseText);
        }
    });
}
function addMandat() {
    //var res = validate();
    //if (res == false) {
    //    return false;
    //}
    var empObj = {
        idEmploye: $('#idEmploye').val(),
        idType: $('#idTypeMandat').val(),
        dateDebut: $('#dateDebut').val(),
        dateFin: $('#dateFin').val(),
        //idPays: $('#idPays').val(),
        //ville: $('#ville').val()
    };
    $.ajax({
        url: "/Employe/AddMandatElectif",
        data: JSON.stringify(empObj),
        type: "POST",
        contentType: "application/json;charset=utf-8",
        dataType: "json",
        success: function (result) {
            loadDataListMandats(empObj.idEmploye);
            $('#myModalMandat').modal('hide');
        },
        error: function (errormessage) {
            alert(errormessage.responseText);
        }
    });
}



//Function for getting the Data Based upon Employee ID
function getbyID(EmpID) {
    $('#Name').css('border-color', 'lightgrey');
    $('#Age').css('border-color', 'lightgrey');
    $('#State').css('border-color', 'lightgrey');
    $('#Country').css('border-color', 'lightgrey');
    $.ajax({
        url: "/Home/getbyID/" + EmpID,
        typr: "GET",
        contentType: "application/json;charset=UTF-8",
        dataType: "json",
        success: function (result) {
            $('#EmployeeID').val(result.EmployeeID);
            $('#Name').val(result.Name);
            $('#Age').val(result.Age);
            $('#State').val(result.State);
            $('#Country').val(result.Country);
            $('#myModal').modal('show');
            $('#btnUpdate').show();
            $('#btnAdd').hide();
        },
        error: function (errormessage) {
            alert(errormessage.responseText);
        }
    });
    return false;
}
//function for updating employee's record
function Update() {
    var res = validate();
    if (res == false) {
        return false;
    }
    var empObj = {
        EmployeeID: $('#EmployeeID').val(),
        Name: $('#Name').val(),
        Age: $('#Age').val(),
        State: $('#State').val(),
        Country: $('#Country').val(),
    };
    $.ajax({
        url: "/Home/Update",
        data: JSON.stringify(empObj),
        type: "POST",
        contentType: "application/json;charset=utf-8",
        dataType: "json",
        success: function (result) {
            loadData();
            $('#myModal').modal('hide');
            $('#EmployeeID').val("");
            $('#Name').val("");
            $('#Age').val("");
            $('#State').val("");
            $('#Country').val("");
        },
        error: function (errormessage) {
            alert(errormessage.responseText);
        }
    });
}
//function for deleting employee's record
function Delele(ID) {
    var ans = confirm("Are you sure you want to delete this Record?");
    if (ans) {
        $.ajax({
            url: "/Home/Delete/" + ID,
            type: "POST",
            contentType: "application/json;charset=UTF-8",
            dataType: "json",
            success: function (result) {
                loadData();
            },
            error: function (errormessage) {
                alert(errormessage.responseText);
            }
        });
    }
}
//Function for clearing the textboxes
function clearTextBoxStage() {
    $('#idType').val("");
    $('#dateDebut').val("");
    $('#dateFin').val("");
    $('#titre').val("");
    $('#commentaire').val("");
    $('#btnUpdateMission').hide();
    $('#btnAddMission').show();
    $('#idType').css('border-color', 'lightgrey');
    $('#dateDebut').css('border-color', 'lightgrey');
    $('#dateFin').css('border-color', 'lightgrey');
    $('#titre').css('border-color', 'lightgrey');
    $('#commentaire').css('border-color', 'lightgrey');
}
function clearTextBoxMandat() {
    $('#idTypeMandat').val("");
    $('#dateDebut').val("");
    $('#dateFin').val("");
    $('#btnUpdateMandat').hide();
    $('#btnAddMandat').show();
    $('#idTypeMandat').css('border-color', 'lightgrey');
    $('#dateDebut').css('border-color', 'lightgrey');
    $('#dateFin').css('border-color', 'lightgrey');
}



//Valdidation using jquery
function validateIdentificatuion() {
    var isValid = true;
    if ($('#nni').val().trim() == "") {
        $('#nni').css('border-color', 'Red');
        isValid = false;
    }
    else {
        $('#nni').css('border-color', 'lightgrey');
    }
    if ($('#prenom').val().trim() == "") {
        $('#prenom').css('border-color', 'Red');
        isValid = false;
    }
    else {
        $('#prenom').css('border-color', 'lightgrey');
    }
    if ($('#prenomPere').val().trim() == "") {
        $('#prenomPere').css('border-color', 'Red');
        isValid = false;
    }
    else {
        $('#prenomPere').css('border-color', 'lightgrey');
    }
    if ($('#nomFamille').val().trim() == "") {
        $('#nomFamille').css('border-color', 'Red');
        isValid = false;
    }
    else {
        $('#nomFamille').css('border-color', 'lightgrey');
    }
    return isValid;
}
function validate() {
    var isValid = true;
    if ($('#nni').val().trim() == "") {
        $('#nni').css('border-color', 'Red');
        isValid = false;
    }
    else {
        $('#nni').css('border-color', 'lightgrey');
    }
    if ($('#prenom').val().trim() == "") {
        $('#prenom').css('border-color', 'Red');
        isValid = false;
    }
    else {
        $('#prenom').css('border-color', 'lightgrey');
    }
    if ($('#prenomPere').val().trim() == "") {
        $('#prenomPere').css('border-color', 'Red');
        isValid = false;
    }
    else {
        $('#prenomPere').css('border-color', 'lightgrey');
    }
    if ($('#nomFamille').val().trim() == "") {
        $('#nomFamille').css('border-color', 'Red');
        isValid = false;
    }
    else {
        $('#nomFamille').css('border-color', 'lightgrey');
    }
    return isValid;
}
function ToJavaScriptDate(value) {
    var pattern = /Date\(([^)]+)\)/;
    var results = pattern.exec(value);
    var dt = new Date(parseFloat(results[1]));
    return dt.getDate() + "/" + (dt.getMonth() + 1) + "/" + dt.getFullYear();
}