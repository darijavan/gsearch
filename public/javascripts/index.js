var selectAll = document.querySelector('#selectAll');
var allCheckboxes = document.querySelectorAll('input[type=checkbox]:not(#selectAll)');

allCheckboxes.forEach(e => e.addEventListener('change', function () {
  if (!e.checked)
    selectAll.checked = false;
  else {
    let isAllChecked = true;
    for (let i = 0; i < allCheckboxes.length; i++) {
      if (!allCheckboxes[i].checked) {
        isAllChecked = false;
        break;
      }
    }
    if (isAllChecked)
      selectAll.checked = true;
  }
}));

selectAll.addEventListener('change', function () {
  if (selectAll.checked)
    document.querySelectorAll('input[type=checkbox]').forEach(e => e.checked = true);
  else
    document.querySelectorAll('input[type=checkbox]').forEach(e => e.checked = false);
});

var exportBtn = document.querySelector('#export');
var form = document.querySelector('#form');

exportBtn.addEventListener('click', function (event) {
  event.preventDefault();

  let placeholder = exportBtn.querySelector('span').innerHTML;
  exportBtn.querySelector('span').innerHTML = 'En cours...';

  let i = 0;
  if (i < allCheckboxes.length) {
    let e = allCheckboxes[i];
    post(form.action, {
      list: e.name
    });
    i++;
  }
  let handle = setInterval(() => {
    if (i < allCheckboxes.length) {
      let e = allCheckboxes[i];
      post(form.action, {
        list: e.name
      });
      i++;
    }
    if (i >= allCheckboxes.length) {
      clearInterval(handle);
      exportBtn.querySelector('span').innerHTML = placeholder;
    }
  }, 2000);
});

function post(url, params, method = 'POST') {
  // The rest of this code assumes you are not using a library.
  // It can be made less wordy if you use one.
  const form = document.createElement('form');
  form.method = method;
  form.action = url;

  for (const key in params) {
    if (params.hasOwnProperty(key)) {
      const hiddenField = document.createElement('input');
      hiddenField.type = 'hidden';
      hiddenField.name = key;
      hiddenField.value = params[key];

      form.appendChild(hiddenField);
    }
  }

  document.body.appendChild(form);
  form.submit();
}