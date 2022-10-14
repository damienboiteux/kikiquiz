const addClasse = ( event ) => {
    async function add_classe() {
        try {
            let data = new FormData( event.target.closest( 'form' ) );
            const reponse = await fetch( '/api/classes', {
                method: "POST",
                body: data,
            } );
            const retour = await reponse.json();

            if ( retour.code === 'success' ) {
                const newClasse = document.createElement( 'tr' );
                newClasse.dataset.id = retour.classe.id;
                newClasse.classList = 'text-center';
                newClasse.innerHTML = `
                    <td>${document.querySelectorAll( '.action-btn' ).length}</td>
                    <td>${retour.classe.id}</td>  
                    <td>${retour.classe.label}</td>  
                    <td>0</td>
                    <td>0</td>
                    <td>${retour.classe.active ? 'Oui' : 'Non'}</td>
                    <td>
                        <button class="btn btn-danger action-btn" data-action="removeClasse">Supprimer</button>
                    </td>
                `;
                document.querySelector( 'tbody' ).appendChild( newClasse );
                newClasse.querySelector( '.action-btn' ).addEventListener( 'click', removeClasse );
                event.target.closest( 'form' ).reset();

                addFlash( retour.msg );

            }

        } catch ( error ) {
            console.log( error );
        }
    }
    add_classe();
}

const removeClasse = ( event ) => {
    async function remove_classe() {
        try {
            const reponse = await fetch( 'api/classes/' + event.target.closest( 'tr' ).dataset.id, {
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
    remove_classe();
}

window.addClasse = addClasse;
window.removeClasse = removeClasse;
