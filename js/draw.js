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

    cell.addEventListener('mouseenter', (event) => {
        if (!rightClick && !leftClick) return;

        let strokeSize = Math.max(0, brushSize-2);
        let cellID = cell.id;
        let split = cellID.split("-");
        let cellRow = parseInt(split[1]);
        let cellCol = parseInt(split[2]);
        let cellToModify = document.getElementById("cell-" + cellRow + "-" + cellCol);
        let color = cellToModify.style.backgroundColor;
        if(leftClick) color = "black";
        else if(rightClick) color = "white";
        cellToModify.style.backgroundColor = color;

        let ids = "";
        for(let r = cellRow-strokeSize; r<cellRow+strokeSize+1; r++){
            if(r < 0 || r > 27) continue;

            for(let c= cellCol-strokeSize; c<cellCol+strokeSize+1; c++){
                if(c < 0 || c > 27) continue;

                let cellToModify = document.getElementById("cell-" + r + "-" + c);
                cellToModify.style.backgroundColor = color;
            }
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

alert("3")
import {Tensor, InferenceSession} from "onnxjs";
const session = new InferenceSession();
const url = "../models/SimpleCNNDigitModel.onnx"
await session.loadModel(url)
const input = [new Tensor(new Float32Array([1.0, 2.0, 3.0, 4.0]), "float32", [2,2])];
const outputMap = await session.run(input)
const outputTensor = outputMap.values().next().value


