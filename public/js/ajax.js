const HANDLER_TAB = getID('handler-tab'),
  INFO_TEXT = getID('ajaxResponse');

function ajaxSuccess() {
  let response = JSON.parse(this.responseText);
  console.log(response);
  // console.log(this.responseText);

  if (response['form'] === 'ajax-element-form') {
    if (response['action'] === 'edit') {
      if (response['element'] === 'about') {
        getID('aboutTitle').innerHTML = response['title'];
        getID('aboutImage').setAttribute('src', response['image']); // path is missing
        getID('aboutText').innerHTML = response['text'];
      } else {
        getID('title-' + response['id']).innerHTML = response['title'];
        getID('image-' + response['id']).setAttribute('src', response['image']);
        getID('date-' + response['id']).innerHTML = response['date'];
        getID('text-' + response['id']).innerHTML = response['text'];
      }

      INFO_TEXT.innerHTML = response['action_message'];

    } else if (response['action'] === 'delete') {
      getID('title-' + response['id']).innerHTML = '';
      getID('image-' + response['id']).innerHTML = '';
      getID('date-' + response['id']).innerHTML = '';
      getID('text-' + response['id']).innerHTML = '';

      INFO_TEXT.innerHTML = response['action_message'];
    } else if (response['action'] === 'create') {
      let sec = document.createElement('SECTION'),
        btnImgTitleDiv = document.createElement('HEADER'),
        btn = document.createElement('BUTTON'),
        image = document.createElement('IMG'),
        title = document.createElement('H2'),
        dateAuthorDiv = document.createElement('DIV'),
        date = document.createElement('P'),
        author = document.createElement('P'),
        text = document.createElement('ARTICLE');

      sec.setAttribute('id', 'container-' + response['id']);
      btn.setAttribute('id', 'handler-tab');
      btn.innerHTML = 'edit';
      title.setAttribute('id', 'title-' + response['id']);
      title.innerHTML = response['title'];
      image.setAttribute('id', 'image-' + response['id']);
      image.setAttribute('src', response['image']);
      date.setAttribute('id', 'date-' + response['id']);
      date.innerHTML = response['date'];
      author.setAttribute('id', 'author-' + response['id']);
      author.innerHTML = response['author'];
      text.setAttribute('id', 'text-' + response['id']);
      text.innerHTML = response['text'];

      dateAuthorDiv.appendChild(date);
      dateAuthorDiv.appendChild(author);
      btnImgTitleDiv.appendChild(btn);
      btnImgTitleDiv.appendChild(title);
      btnImgTitleDiv.appendChild(image);
      btnImgTitleDiv.appendChild(dateAuthorDiv);
      sec.appendChild(btnImgTitleDiv);
      sec.appendChild(text);
      getID('newArticleContainer').prepend(sec);

      INFO_TEXT.innerHTML = response['action_message'];

      getID('handler-tab').addEventListener('click', displayAjaxForm);
    }
  } else if (response['form'] === 'ajax-mail-form') {
    if (response['info'].length > 0) {
      INFO_TEXT.innerHTML = response['info'];
    } else {
      INFO_TEXT.innerHTML = response['error'];
    }
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
  if (getID('ajax-form').classList.contains('hidden')) {
    getID('ajax-form').classList.remove('hidden');
    getID('handler-tab').innerHTML = 'hide';
  } else {
    getID('ajax-form').classList.add('hidden');
    getID('handler-tab').innerHTML = 'edit';
  }
}

function changeContactForm() {
  if (getID('ajax-recover-form').classList.contains('hidden')) {
    getID('ajax-recover-form').classList.remove('hidden');
    getID('ajax-mail-form').classList.add('hidden');
    getID('mail-tab').innerHTML = 'contact me';
  } else {
    getID('ajax-recover-form').classList.add('hidden');
    getID('ajax-mail-form').classList.remove('hidden');
    getID('mail-tab').innerHTML = 'recover password';
  }
}

if (HANDLER_TAB !== null) HANDLER_TAB.addEventListener('click', displayAjaxForm);
if (getID('mail-tab') !== null) getID('mail-tab').addEventListener('click', changeContactForm);
