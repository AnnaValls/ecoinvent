
//POST data using javascript
function post(action,data) {

  //new form
  var form = document.createElement("form");
  form.setAttribute("target", '_blank');
  form.setAttribute("method", 'POST');
  form.setAttribute("action", action);

  //new input
  var hiddenField = document.createElement("input");
  hiddenField.setAttribute("name", 'input');
  hiddenField.setAttribute("type", 'hidden');
  hiddenField.setAttribute("value", data);

  //send data
  form.appendChild(hiddenField);
  document.body.appendChild(form);
  form.submit();
}
