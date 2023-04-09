const cells = document.querySelectorAll('.cell');

let isMouseDown = false;
cells.forEach((cell) => {
    console.log("ciao");
    cell.addEventListener('mousedown', () => {
        isMouseDown = true;
    });
    cell.addEventListener('mouseup', () => {
        isMouseDown = false;
    });
    cell.addEventListener('mouseenter', () => {
        if (isMouseDown) {
            //let bgc = cell.style.backgroundColor;
            //cell.style.backgroundColor = (bgc === "white") ? "black" : "white";
            cell.style.backgroundColor = "black";
        }
    });
});

function clearCells(){
    const cells = document.querySelectorAll('.cell');

    cells.forEach((cell) => {
        cell.style.backgroundColor = "white";
    });
}