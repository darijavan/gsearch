var selectAll = document.querySelector('#selectAll');
var allCheckboxes = document.querySelectorAll('input[type=checkbox]:not(#selectAll):not(:disabled)');

// Track checkbox state change so that 
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

// Add change listener to 'select-all' checkbox
selectAll.addEventListener('change', function () {
  if (selectAll.checked)
    allCheckboxes.forEach(e => e.checked = true);
  else
    allCheckboxes.forEach(e => e.checked = false);
});

var exportBtn = document.querySelector('#export');
var form = document.querySelector('#form');

// Init export button click listener
exportBtn.addEventListener('click', function (event) {
  event.preventDefault();

  let placeholder = exportBtn.querySelector('span').innerHTML;
  exportBtn.querySelector('span').innerHTML = 'En cours...';
  exportBtn.classList.add('disabled');

  // Sequencial download
  // let i = 0;
  // if (i < allCheckboxes.length) {
  //   let e = allCheckboxes[i];
  //   console.log(e.name);
  //   post(form.action, {
  //     list: e.name
  //   });
  //   i++;
  // }
  // let handle = setInterval(() => {
  //   if (i < allCheckboxes.length) {
  //     let e = allCheckboxes[i];
  //     post(form.action, {
  //       list: e.name
  //     });
  //     i++;
  //   }
  //   if (i >= allCheckboxes.length) {
  //     clearInterval(handle);
  //     exportBtn.querySelector('span').innerHTML = placeholder;
  //     exportBtn.classList.remove('disabled');
  //   }
  // }, 3000);

  // For multiple file, download a zip
  let checked = [];
  for (let i = 0; i < allCheckboxes.length; i++) {
    if (allCheckboxes[i].checked)
      checked.push(allCheckboxes[i].name);
  }
  let list = checked.join(';');
  let startDate = document.querySelector('#startDate').value;

  post(form.action, {
    list,
    startDate
  });

  setTimeout(() => {
    exportBtn.querySelector('span').innerHTML = placeholder;
    exportBtn.classList.remove('disabled');
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

// init dropdown
// var dropdownElements = document.querySelectorAll('.dropdown-trigger');
// var dropdowns = M.Dropdown.init(dropdownElements, {
//   hover: true,
//   constrainWidth: false
// });

// init datepicker
var pickerElements = document.querySelectorAll('.datepicker');
var pickers = M.Datepicker.init(pickerElements, {
  autoClose: true,
  format: 'dd/mm/yyyy',
  defaultDate: new Date(2020, 0, 1),
  setDefaultDate: true,
  container: document.querySelector('.modal-container'),
  i18n: {
    cancel: 'Annuler',
    clear: 'Effacer',
    months: [
      'Janvier',
      'Février',
      'Mars',
      'Avril',
      'Mai',
      'Juin',
      'Juillet',
      'Août',
      'Septembre',
      'Octobre',
      'Novembre',
      'Decembre'
    ],
    monthsShort: [
      'Jan',
      'Fév',
      'Mar',
      'Avr',
      'Mai',
      'Jun',
      'Jul',
      'Aug',
      'Sep',
      'Oct',
      'Nov',
      'Dec'
    ],
    weekdaysShort: [
      'Dim',
      'Lun',
      'Mar',
      'Mer',
      'Jeu',
      'Ven',
      'Sam'
    ]
  }
});