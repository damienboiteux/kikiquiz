const addQuestionnaire = ( event ) => {
    async function add_questionnaire() {
        try {
            const reponse = await fetch( '/api/questionnaires', {
                method: "POST",
                body: new FormData( event.target.closest( 'form' ) )
            } );
            const retour = await reponse.json();

            if ( retour.code === 'success' ) {
                const newQuestionnaire = document.createElement( 'tr' );
                newQuestionnaire.dataset.id = retour.questionnaire.id;
                newQuestionnaire.innerHTML = `
                    <td>${retour.questionnaire.id}</td>  
                    <td>${retour.questionnaire.code}</td>  
                    <td>
                        <button class="btn btn-danger action-btn" data-action="removeQuestionnaire">Supprimer</button>
                    </td>
                `;
                document.querySelector( 'tbody' ).appendChild( newQuestionnaire );
                newQuestionnaire.querySelector( '.action-btn' ).addEventListener( 'click', removeQuestionnaire );
                event.target.closest( 'form' ).reset();
            }


            addFlash( retour.msg );
        } catch ( error ) {
            console.log( error );
        }
    }
    add_questionnaire();
};

const removeQuestionnaire = ( event ) => {
    async function remove_questionnaire() {
        try {
            const reponse = await fetch( '/api/questionnaires/' + event.target.closest( 'tr' ).dataset.id, {
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
    remove_questionnaire();
};

const addQuestionnaireQuestion = ( event ) => {
    async function add_questionnaire_question() {
        try {
            const reponse = await fetch( '/api/questionnaires/' + event.target.closest( 'tbody' ).dataset.id, {
                method: "PATCH",
                body: JSON.stringify( {
                    "id": event.target.closest( 'tr' ).dataset.id,
                    "entite": "question",
                    "action": "add"
                } ),
                headers: {
                    "Content-Type": "application/json"
                }
            } );
            const retour = await reponse.json();
            if ( retour.code === 'success' ) {
                document.querySelector( '#questions-liees' ).appendChild( event.target.closest( 'tr' ) );
                event.target.classList.remove( 'btn-primary' );
                event.target.classList.add( 'btn-danger' );
                event.target.innerText = 'Supprimer';
                event.target.removeEventListener( 'click', addQuestionnaireQuestion );
                event.target.addEventListener( 'click', removeQuestionnaireQuestion );
                addFlash( retour.msg );
            }

        } catch ( error ) {
            console.log( error );
        }
    }
    add_questionnaire_question();
};


const removeQuestionnaireQuestion = ( event ) => {
    async function remove_questionnaire_question() {
        try {
            const reponse = await fetch( '/api/questionnaires/' + event.target.closest( 'tbody' ).dataset.id, {
                method: "PATCH",
                body: JSON.stringify( {
                    "id": event.target.closest( 'tr' ).dataset.id,
                    "entite": "question",
                    "action": "remove"
                } ),
                headers: {
                    "Content-Type": "application/json"
                }
            } );
            const retour = await reponse.json();
            if ( retour.code === 'success' ) {
                document.querySelector( '#questions-disponibles' ).appendChild( event.target.closest( 'tr' ) );
                event.target.classList.remove( 'btn-danger' );
                event.target.classList.add( 'btn-primary' );
                event.target.innerText = 'Ajouter';
                event.target.removeEventListener( 'click', removeQuestionnaireQuestion );
                event.target.addEventListener( 'click', addQuestionnaireQuestion );

                addFlash( retour.msg );
            }

        } catch ( error ) {
            console.log( error );
        }
    }
    remove_questionnaire_question();
};

window.addQuestionnaire = addQuestionnaire;
window.removeQuestionnaire = removeQuestionnaire;
window.addQuestionnaireQuestion = addQuestionnaireQuestion;
window.removeQuestionnaireQuestion = removeQuestionnaireQuestion;