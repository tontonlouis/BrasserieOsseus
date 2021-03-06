/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.css');
require('../scss/style.scss');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
// const $ = require('jquery');

/********************************************
 *          Carousel image show             *
 *******************************************/
$('.carousel').carousel({
    interval: 5000
});

/***********************************************
 *          Suppression des éléments            *
 ***********************************************/
document.querySelectorAll('[data-delete]').forEach(a => {
    a.addEventListener('click', e => {
        e.preventDefault();
        fetch(a.getAttribute('href'), {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({'_token': a.dataset.token})
        }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    a.parentNode.parentNode.removeChild(a.parentNode)
                } else {
                    alert(data.error);
                }
            })
            .catch(e => alert(e))
    })
});

/********************************************************
 *              Ajout dans le paniers                   *
 *******************************************************/

document.querySelectorAll('[data-reserve]').forEach(a => {
    a.addEventListener('click', e => {
        e.preventDefault();
        fetch(a.getAttribute('href'), {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({'qteReserve': $('#qteReserve').val(), '_token': a.dataset.token})
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    $('#orderProd').text(data.success);
                    $('[data-reserve]').hide();
                    $('#qteReserve').hide();
                } else {
                    alert(data.error)
                }
            })
    })
});

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');
