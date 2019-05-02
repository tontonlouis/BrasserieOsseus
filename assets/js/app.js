/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.css');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
// const $ = require('jquery');


$('.carousel').carousel({
    interval: 5000
});

// Lorsque le DOM est chargé on applique le Javascript $(document).ready(function() {
// On ajoute la classe "js" à la liste pour mettre en place par la suite du code CSS uniquement dans le cas où le Javascript est activé
$('ul.notes-echelle').addClass('js');
// On passe chaque note à l'état grisé par défaut
$("ul.notes-echelle li").addClass("note-off");
// Au survol de chaque note à la souris
$("ul.notes-echelle li").mouseover(function() {
    // On passe les notes supérieures à l'état inactif (par défaut)
    $(this).nextAll("li").addClass("note-off");
    // On passe les notes inférieures à l'état actif
    $(this).prevAll("li").removeClass("note-off");
    // On passe la note survolée à l'état actif (par défaut)
    $(this).removeClass("note-off");
});
// Lorsque l'on sort du sytème de notation à la souris
$("ul.notes-echelle").mouseout(function() {
    // On passe toutes les notes à l'état inactif
    $(this).children("li").addClass("note-off");
    // On simule (trigger) un mouseover sur la note cochée s'il y a lieu
    $(this).find("li input:checked").parent("li").trigger("mouseover");
});


$("ul.notes-echelle input")
// Lorsque le focus est sur un bouton radio
    .focus(function() {
        // On supprime les classes de focus
        $(this).parents("ul.notes-echelle").find("li").removeClass("note-focus");
        // On applique la classe de focus sur l'item tabulé
        $(this).parent("li").addClass("note-focus");
        // [...] cf. code précédent
    })
    // Lorsque l'on sort du sytème de notation au clavier
    .blur(function() {
        // On supprime les classes de focus
        $(this).parents("ul.notes-echelle").find("li").removeClass("note-focus");
        // [...] cf. code précédent
    })
    // Lorsque la note est cochée
    .click(function() {
        // On supprime les classes de note cochée
        $(this).parents("ul.notes-echelle").find("li").removeClass("note-checked");
        // On applique la classe de note cochée sur l'item choisi
        $(this).parent("li").addClass("note-checked");
    });

    // On simule un survol souris des boutons cochés par défaut
    $("ul.notes-echelle input:checked").parent("li").trigger("mouseover");
    // On simule un click souris des boutons cochés
    $("ul.notes-echelle input:checked").trigger("click");

// Suppression des éléments
document.querySelectorAll('[data-delete]').forEach(a => {
    a.addEventListener('click', e => {
        e.preventDefault()
        fetch(a.getAttribute('href'), {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type' : 'application/json'
            },
            body: JSON.stringify({'_token': a.dataset.token})
        }).then(response => response.json())
            .then(data => {
                if(data.success){
                    a.parentNode.parentNode.removeChild(a.parentNode)
                }else{
                    alert(data.error)
                }
            })
            .catch(e => alert(e))
    })
});


console.log('Hello Webpack Encore! Edit me in assets/js/app.js');
