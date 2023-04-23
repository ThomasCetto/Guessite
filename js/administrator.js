
function toggleDelete(button, rowIndex, username){
    if (button.value === "Elimina") {
        button.value = "Confermi?";
        button.style.backgroundColor = "orange";
    } else {
        const deleteField = document.getElementById("usernameToDeleteField");
        deleteField.value = username;

        button.type = "submit";
    }
}

function toggleModify(button, rowIndex, username){
    //row index starts from 1, not 0
    // first click
    if (button.value === "Modifica") {
        // removes every input field from the table before creating new ones
        removeInputs();

        spawnInputs(rowIndex);

        makeButtonsGreen();

        // asks confirmation
        button.value = "Confermi?";
        button.style.backgroundColor = "orange";
    } else { // second click
        const modifyField = document.getElementById("usernameToModifyField");
        modifyField.value = username;

        button.type = "submit";
    }
}

function removeInputs(){
    const everycell = document.querySelectorAll('[class^="row"]');
    for(let i = 0; i < everycell.length; i++){
        const cell = everycell[i];

        //if there is an input inside, remove it
        let inputInside = cell.querySelector("input");
        let content = cell.innerText;

        if(inputInside){
            content = inputInside.value; // there is max 1 input inside
            cell.removeChild(inputInside);
        }
        cell.innerText = content;
    }
}

function spawnInputs(rowIndex){
    const rowCells = document.getElementsByClassName("row" + rowIndex);
    const fields = ["newUsername", "newScore", "newTries", "newGuessed"];

    for (let i = 0; i < rowCells.length; i++) {
        const cell = rowCells[i];
        const input = document.createElement("input");
        input.type = "text";
        input.value = cell.innerText;
        input.name = fields[i];
        cell.innerText = "";
        cell.appendChild(input);
    }
}

function makeButtonsGreen(){
    const buttons = document.getElementsByClassName("modifyButton");
    for (let i = 0; i < buttons.length; i++) {
        buttons[i].style.backgroundColor = "green";
        buttons[i].value = "Modifica";
    }
}