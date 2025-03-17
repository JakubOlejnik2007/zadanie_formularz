const formSubmitButton = document.querySelector('.form__submit');
const form = document.querySelector('.form');
const allInputs = document.querySelectorAll('.form__control');

const regexPassword = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{12,}$/;

const validate = () => {
    let isEveryInputValid = true;
    console.log(allInputs)
    allInputs.forEach(input => {
        const targetId = input.id;
        const targetValue = input.value;
        const targetParent = input.parentNode;
        let errorMessage = "";

        if (targetId === "login") {
            if (targetValue.length < 8) {
                isEveryInputValid = false;
                errorMessage = "Twój login jest za krótki";
            }
        }

        if (targetId === "password") {
            if (!regexPassword.test(targetValue)) {
                isEveryInputValid = false;
                errorMessage = "Hasło: 12 znaków; wielkie i małe litery; cyfra";
            }
        }

        if (targetId === "description") {
            if (targetValue.length === 0) {
                isEveryInputValid = false;
                errorMessage = "Opis nie może być pusty";
            }
        }

        targetParent.children[3].innerHTML = errorMessage;
    });

    formSubmitButton.disabled = !isEveryInputValid;
};

form.addEventListener("input", validate);