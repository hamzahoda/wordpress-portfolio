export function getAuth() {
  return window.childFrameConnection.promise.then(child =>
    child.leadinGetAuth()
  );
}

export function searchForms(searchQuery = '') {
  return window.childFrameConnection.promise.then(child =>
    child.leadinSearchForms(searchQuery)
  );
}

export function getForm(formId) {
  return window.childFrameConnection.promise.then(child =>
    child.leadinGetForm(formId)
  );
}
