
import DOMPurify from 'dompurify';
import marked from 'marked';

document.querySelectorAll('div.markdown').forEach(function(div) {
  div.innerHTML = marked(DOMPurify.sanitize(div.innerHTML))
});
