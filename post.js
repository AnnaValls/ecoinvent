//POST data using javascript
function post(action,data,target) {
  target=target ? "_blank":false; //open form in a new window (by default not)
  
  //new form
  var form = document.createElement("form");
  form.setAttribute("target", target);
  form.setAttribute("method", 'POST');
  form.setAttribute("action", action);
  form.style.display='none';

  //new input field
  var input = document.createElement("input");
  input.setAttribute("name", 'input');
  input.setAttribute("type", 'hidden');
  input.setAttribute("value", data);

  //send data
  form.appendChild(input);
  document.body.appendChild(form);
  form.submit();
}
