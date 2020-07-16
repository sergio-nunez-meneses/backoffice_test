const handlerTab = getID('handler-tab'),
  ajaxForm = getID('ajax-form'),
  mailForm = getID('ajax-mail-form'),
  infoText = getID('ajaxResponse');

function ajaxSuccess() {
  let response = JSON.parse(this.responseText);
  console.log(this.responseText, response);

  if (response['form'] === 'ajax-mail-form') {
    infoText.innerHTML = response['info'];
  } else {
    infoText.innerHTML = response['action'];
    getID('title-' + response['id']).innerHTML = response['title'];
    getID('image-' + response['id']).innerHTML = response['image'];
    getID('date-' + response['id']).innerHTML = response['date'];
    getID('text-' + response['id']).innerHTML = response['text'];
  }
}

function ajaxSend(oFormElement) {
  if (!oFormElement.action) {
    return;
  }

  let oReq = new XMLHttpRequest();
  oReq.onload = ajaxSuccess;

  if (oFormElement.method.toLowerCase() === 'post') {
    oReq.open('post', oFormElement.action);
    oReq.send(new FormData(oFormElement));
  } else {
    let oField, sFieldType, nFile, sSearch = '';

    for (let nItem = 0; nItem < oFormElement.elements.length; nItem++) {
      oField = oFormElement.elements[nItem];
      if (!oField.hasAttribute('name')) {
        continue;
      }
      sFieldType = oField.nodeName.toUpperCase() === 'INPUT' ?
        oField.getAttribute("type").toUpperCase() : 'TEXT';
      if (sFieldType === 'FILE') {
        for (nFile = 0; nFile < oField.files.length; sSearch += '&' + escape(oField.name) + '=' + escape(oField.files[nFile++].name));
      } else if ((sFieldType !== 'RADIO' && sFieldType !== 'CHECKBOX') || oField.checked) {
        sSearch += '&' + escape(oField.name) + '=' + escape(oField.value);
      }
    }

  }
}

function displayAjaxForm() {
  if (ajaxForm.classList.contains('hidden')) {
    ajaxForm.classList.remove('hidden');
    handlerTab.innerHTML = 'hide';
  } else {
    ajaxForm.classList.add('hidden');
    handlerTab.innerHTML = 'edit';
  }
}

handlerTab.addEventListener('click', displayAjaxForm);
