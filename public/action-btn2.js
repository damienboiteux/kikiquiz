// function removeClasse() {
//     console.log( 'ok' );
// }

// document.querySelectorAll( '.action-btn' ).forEach(
//     ( btn ) => {
//         btn.addEventListener( 'click', ( event ) => {
//             const func = new Function( event.target.dataset.action + '(event)' );
//             func( event );
//         } );
//     }
// )


// const actions = function ( event ) {
//     let func = event.target.dataset.action;
//     // func.apply( null, { event } );
//     // const func = new Function( event.target.dataset.action );
//     // console.log( func() );
//     // func( event );
//     ( eval( func ) )( event );
//     // console.log( event.target.dataset.action );
//     // ( new Function( func ) )( event );

// }

document.querySelectorAll( '.action-btn' ).forEach(
    ( btn ) => {
        btn.addEventListener( 'click', ( event ) => {
            let func = event.target.dataset.action;
            ( eval( func ) )( event );
        } );
    }
);



