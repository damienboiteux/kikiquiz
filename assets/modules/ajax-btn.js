/**
 * 
 * AFFICHAGE DES MESSAGES : inspiré du addFalsh de Symfony
 * 
 * @param {string} msg   Texte du message 
 * @param {string} code  Type de message (success, warning, danger, ...)
 * @param {number} duree Temps d'affichage en ms
 */
function addFlash( msg, code = 'success', duree = 3000 ) {
    let message = document.createElement( 'div' );
    message.innerHTML = `<div class="alert alert-${code}">${msg}</div>`;
    document.querySelector( '#messages' ).appendChild( message );
    setTimeout( () => { message.remove(); }, duree );
}

window.addFlash = addFlash;

/** 
 *  MODULES A IMPORTER
 */

import './btn/categorie-btn.js';
import './btn/classe-btn.js';
import './btn/question-btn.js';


/** 
 * CHARGEMENT
 */

document.querySelectorAll( '.action-btn' ).forEach(
    ( btn ) => {
        btn.addEventListener( 'click', ( event ) => {
            let func = event.target.dataset.action;
            ( eval( func ) )( event );
        } );
    }
);
const ajax = document.querySelector( 'form.auto' );
if ( ajax ) {
    ajax.addEventListener( 'submit', ( event ) => {
        event.preventDefault();
        document.querySelector( 'form .action-btn' ).dispatchEvent( new Event( 'click' ) );
    } );

}
