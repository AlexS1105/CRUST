import jQuery from 'jquery';
window.$ = jQuery;

var skinsList = $('#skins-list')
var card = skinsList.children().first()

$('#skins\\[\\]').change(function() {
    var files = $('#skins\\[\\]').prop('files')

    for (var file of files) {
        addSkinCard(file, card.clone())
    }
})

function addSkinCard(file, card) {
    card.find('#skin').attr('src', URL.createObjectURL(file))

    var input = card.find('input')
    input.val(fancyPrefix(file.name))
    input.attr('name', 'prefix[]')

    card.removeClass('hidden')
    skinsList.append(card)
}

function fancyPrefix(filename) {
    return filename.split('.').shift().toLowerCase().replaceAll(/[-\s.]/g, '_')
}
