import DOMPurify from 'isomorphic-dompurify';
import {marked} from 'marked';

var currentElement;

window.preview = function(element) {
  if (!element.previewWindow) {
    if (currentElement) {
      hidePreview(currentElement);
    }

    element.style.height = (25 + element.scrollHeight) + 'px'
    element.previewWindow = element.parentElement.appendChild(document.createElement('div'));
    element.previewWindow.className = 'mt-2 prose'

    element.previewWindow.header = element.previewWindow.appendChild(document.createElement('div'));
    element.previewWindow.header.className = 'block mb-2 uppercase text-xs text-gray-700'
    element.previewWindow.header.innerHTML = previewText

    element.previewWindow.text = element.previewWindow.appendChild(document.createElement('div'));

    element.previewWindow.text.innerHTML = marked.parse(DOMPurify.sanitize(element.value));
    element.addEventListener('input', update);

    currentElement = element;
  }
}

function update(event) {
  event.target.previewWindow.text.innerHTML = marked.parse(DOMPurify.sanitize(event.target.value));
}

function hidePreview(element) {
  if (element.previewWindow) {
    element.previewWindow.remove();
    element.previewWindow = null;
    element.style.height = null;
  }
}
