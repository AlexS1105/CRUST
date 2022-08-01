window.DOMPurify = require('dompurify');
window.marked = require('marked');

document.querySelectorAll('div.markdown').forEach(function(div) {
  div.innerHTML = window.marked.marked(window.DOMPurify.sanitize(div.innerHTML))
});
