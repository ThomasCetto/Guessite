//to prevent right click pop up
document.addEventListener('contextmenu', event => event.preventDefault());
import * as onnx from '../node_modules/onnxjs/dist/onnx.min.js';



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

alert("4")

function softmax(arr) {
    const max = Math.max(...arr);
    const exps = arr.map(x => Math.exp(x - max));
    const sumExps = exps.reduce((acc, val) => acc + val, 0);
    return exps.map(x => x/sumExps);
}

async function main() {
    try {
        const session = await ort.InferenceSession.create('../models/SimpleCNNDigitModel2.onnx');
        const data = new Float32Array(28*28);
        for (let i = 0; i < 28*28; i++) {
            data[i] = 0;
        }

        for(let i=0; i<20; i++){
            data[14 + 14*i] = 0.0039;
        }

        const tensor = new ort.Tensor('float32', data, [1, 1, 28, 28]);
        const feeds = { "input.1": tensor};
        const results = await session.run(feeds);
        const dataOutput = results.outputName.data;
        console.log(dataOutput)
        const dataArray = Array.from(dataOutput)
        console.log(dataArray)
        const softmaxed = softmax(dataArray);

        document.write(`data of result tensor 'c': ${softmaxed}`);

    } catch (e) {
        document.write(`failed to inference ONNX model: ${e}.`);
    }
}
main()