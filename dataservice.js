import 'google-apps-script';
function doGet(request) {
  return HtmlService.createTemplateFromFile('food').evaluate();
  
}

function include(filename){
  return HtmlService.createHtmlOutputFromFile(filename).getContent();
}

function processForm(formObject){
  var url="https://docs.google.com/spreadsheets/d/16lMDLqFMDgv9YB0C2WOd3osE1AB7W_UCCCf4xX2U0jI/edit#gid=0";
  var ss= SpreadsheetApp.openByUrl(url); //csak a szerveren
  var ws=ss.getSheetByName("Data");

  ws.appendRow([
    formObject.Date,
    formObject.Day,
    formObject.Team,
    formObject.Activity,
    formObject.Where,
    formObject.Nop,
    formObject.When,
    formObject.What,
    formObject.Email+','+formObject.Email2+','+formObject.Email3

  ]);
}
