const NAVBAR_TAB = getID('navbarTab'),
  NAVBAR_CONTAINER = getID('navbarContainer'),
  TEXT = getID('presentationText');

function collapsibleAccordion() {
  if (TEXT.style.maxHeight && NAVBAR_CONTAINER.style.maxHeight) {
    NAVBAR_CONTAINER.style.maxHeight = null;
    TEXT.style.maxHeight = null;
  } else {
    NAVBAR_CONTAINER.style.maxHeight = NAVBAR_CONTAINER.scrollHeight + 'px';
    TEXT.style.maxHeight = TEXT.scrollHeight + 'px';
  }
}

NAVBAR_TAB.addEventListener('click', collapsibleAccordion);
