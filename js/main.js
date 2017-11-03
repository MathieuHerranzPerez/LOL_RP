/**
 * Passe la photo de couleur/grisée à grisée/couleur et decoche/coche la checkbox correspondante
 * @param id
 */
function togglePhoto(id) {
    var classId = '#' + id;
    var idClass = '#check' + id;
    $(classId).toggleClass('inactiveChamp activeChamp');
    if($(idClass).is(':checked')) {
        $(idClass).removeAttr('checked');
    }
    else {
        $(idClass).prop('checked', true);
    }
}

function toutDeselectionner() {
    $('.imgChamp').removeClass('activeChamp').addClass('inactiveChamp');
    $('.checkChamp').removeAttr('checked');
}

function toutSelectionner() {
    $('.imgChamp').removeClass('inactiveChamp').addClass('activeChamp');
    $('.checkChamp').prop('checked', true);
}

function copyUrl(id) {
    var elem = $('#'+id)[0];
    elem.focus();
    elem.setSelectionRange(0, elem.value.length);

    try {
        document.execCommand("copy");
    } catch(e) {
        console.log('Failed to copy to clipboard.')
    }

    elem.blur();
    $('#checked').show();
    $('#checked').fadeOut(2500);
}