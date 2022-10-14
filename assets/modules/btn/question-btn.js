const addQuestion = ( event ) => {
    async function add_question() {
        try {
            let data = new FormData( event.target.closest( 'form' ) );
            console.log( data );
            const reponse = await fetch( '/api/questions', {
                method: "POST",
                body: data,
            } );
            const retour = await reponse.json();

            if ( retour.code === 'success' ) {
                const newQuestion = document.createElement( 'tr' );
                newQuestion.dataset.id = retour.question.id;
                newQuestion.innerHTML = `
                    <td>${retour.question.id}</td>  
                    <td>${retour.question.label}</td>  
                    <td>${retour.question.active ? 'Oui' : 'Non'}</td>
                    <td>${retour.question.type}</td>
                    <td>
                        <a href="./questions/${retour.question.id}" class="btn btn-warning">Modifier</a>
                        <button class="btn btn-danger action-btn" data-action="removeQuestion">Supprimer</button>
                    </td>
                `;
                document.querySelector( 'tbody' ).appendChild( newQuestion );
                newQuestion.querySelector( '.action-btn' ).addEventListener( 'click', removeQuestion );
                event.target.closest( 'form' ).reset();

                addFlash( retour.msg );

            }

        } catch ( error ) {
            console.log( error );
        }
    }
    add_question();
}

const removeQuestion = ( event ) => {
    async function remove_question() {
        try {
            const reponse = await fetch( 'api/questions/' + event.target.closest( 'tr' ).dataset.id, {
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
    remove_question();
}

window.addQuestion = addQuestion;
window.removeQuestion = removeQuestion;
