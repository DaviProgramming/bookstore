

const listeners = () => {

    
    let inputsForm = document.querySelectorAll('.auth-pages-form-content-input-group input');

    if(inputsForm != null){

        inputsForm.forEach(input => {

            input.addEventListener('click', (e) => {

                inputsActions.clickInput(e.target);

            })

            input.addEventListener('blur', (e) => {

                inputsActions.blurInput(e.target);

            })

        })


    }

    let eyesPassword = document.querySelectorAll('.auth-pages-form-content-input-group-eyes i');
        
    if(eyesPassword != null){

        eyesPassword.forEach(eyeButton => {

            eyeButton.addEventListener('click', (e) => {

                eyesActions.clicked(e.target);

            })

        })

    }

    let labels = document.querySelectorAll('label');

    if(labels != null){

        labels.forEach(label => {

            label.addEventListener('click', (e) => {

                labelActions.clickLabel(e.target);

            })

        })

    }



    let buttonCadastrar = document.querySelector('button[name="button-cadastro"]');


    buttonCadastrar.addEventListener('click', (e) => {


    })

}

const inputsActions = {

    blurInput(input){

        let divContainer = input.parentNode;
        let label = divContainer.querySelector('label');

        if(input.value.length <= 0){

            labelActions.ativaLabel(label);

        }else{

            labelActions.desativaLabel(label);

        }

    },


    clickInput(input){

        let divContainer = input.parentNode;

        let label = divContainer.querySelector('label');

        labelActions.desativaLabel(label);

    }


}


const labelActions = {

    clickLabel(label){

        let divContainer = label.parentNode;
        let input = divContainer.querySelector('input');
        input.focus();

        this.desativaLabel(label);

    },

    desativaLabel(label){

        if(!label.classList.contains('disabled')){

            label.classList.add('disabled');

        }

    },

    ativaLabel(label){

        if(label.classList.contains('disabled')){

            label.classList.remove('disabled');

        }
    }


}


const formActions = {

    

    

}


const eyesActions = {

    clicked(eye){

        this.removeActived();
        this.addActive(eye);

    },

    removeActived(){

        let eyeAtivado = document.querySelectorAll('.auth-pages-form-content-input-group-eyes i.active');

        eyeAtivado.forEach(eye => {

            if(eye != null){

                eye.classList.remove('active');
    
            }

        })

        

    },

    addActive(eye){


        let eyeAtivar = null;

        if(eye.classList.contains('fa-eye')){

            eyeAtivar = document.querySelector('.auth-pages-form-content-input-group-eyes i.fa-eye-slash');


        }else if(eye.classList.contains('fa-eye-slash')){

            eyeAtivar = document.querySelector('.auth-pages-form-content-input-group-eyes i.fa-eye');

        }

        eyeAtivar.classList.add('active');


    }



}

listeners();