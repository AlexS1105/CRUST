import DOMPurify from 'isomorphic-dompurify';
import {marked} from 'marked';

document.querySelectorAll('div.markdown').forEach(function(div) {
  div.innerHTML = marked.parse(DOMPurify.sanitize(div.innerHTML))
});
