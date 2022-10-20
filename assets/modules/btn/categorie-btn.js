const addCategorie = ( event ) => {
    async function add_categorie() {
        try {
            const reponse = await fetch( '/api/categories', {
                method: "POST",
                body: new FormData( event.target.closest( 'form' ) ),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            } );
            const retour = await reponse.json();

            if ( retour.code === 'success' ) {
                const newCategorie = document.createElement( 'tr' );
                newCategorie.dataset.id = retour.categorie.id;
                newCategorie.innerHTML = `
                    <td>${retour.categorie.id}</td>
                    <td>${retour.categorie.label}</td>
                    <td>
                        <button class="btn btn-danger action-btn">Supprimer</button>
                    </td>   
                `;
                document.querySelector( 'tbody' ).appendChild( newCategorie );
                newCategorie.querySelector( '.action-btn' ).addEventListener( 'click', removeCategorie );
                event.target.closest( 'form' ).reset();

            }

            addFlash( retour.msg );

        } catch ( error ) {
            console.log( error );
        }
    }

    add_categorie();
}

const removeCategorie = ( event ) => {
    async function remove_categorie() {
        try {
            const reponse = await fetch( 'api/categories/' + event.target.closest( 'tr' ).dataset.id, {
                method: "DELETE"
            } );
            const retour = await reponse.json();
            if ( retour.code === 'success' ) {
                event.target.closest( 'tr' ).remove();
            }
            addFlash( retour.msg );
        } catch ( error ) {
            console.log( error );
        }
    }

    remove_categorie();
};



window.addCategorie = addCategorie;
window.removeCategorie = removeCategorie;
