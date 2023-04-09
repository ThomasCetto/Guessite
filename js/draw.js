document.addEventListener('contextmenu', event => event.preventDefault());

let rightClick = false;
let leftClick = false;
let brushSize = 1;




const cells = document.querySelectorAll('.cell');

cells.forEach((cell) => {
    cell.addEventListener('mousedown', (event) => {
        if (event.which === 1) {
            leftClick = true;
        } else if (event.which === 3) {
            rightClick = true;
        }
    });

    cell.addEventListener('mouseup', (event) => {
        if (event.which === 1) {
            leftClick = false;
        } else if (event.which === 3) {
            rightClick = false;
        }
    });

    cell.addEventListener('mouseenter', () => {
        if(leftClick){
            cell.style.backgroundColor = "black";
        }else if(rightClick){
            cell.style.backgroundColor = "white";
        }
    });
});

function clearCells(){
    const cells = document.querySelectorAll('.cell');

    cells.forEach((cell) => {
        cell.style.backgroundColor = "white";
    });
}

function changeBrushSize() {
    // Get the value of the slider
    const slider = document.getElementById("brush-size-slider");
    brushSize = slider.value;
    const label = document.getElementById("brush-size-label");
    label.innerHTML = brushSize;
}