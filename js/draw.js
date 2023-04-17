//to prevent right click pop up
document.addEventListener('contextmenu', event => event.preventDefault());


let rightClick = false;
let leftClick = false;
let brushSize = 3;
const cells = document.querySelectorAll('.cell');
const resultContainer = document.getElementById("results");
let session = null;
let modelNames = ["SimpleCNNDigitModel2.onnx", "muchBetterDigitClassificator.onnx"];
let inputNames = ["input.1", "Input3"]
let outputNames = ["outputName", "Plus214_Output_0"]
let modelChosenIndex = 0;


function changeModel(index){
    modelChosenIndex = index;
    loadModel();
    clearCells();
}

loadModel()

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

        refreshProbs();
    });
});

document.addEventListener('DOMContentLoaded', function() {
    let btns = document.querySelectorAll('.btn-group .btn');

    btns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            btns.forEach(function(btn) {
                btn.classList.remove('active'); // Remove active class from other buttons
            });
            this.classList.add('active'); // Add active class to clicked button
        });
    });
});

async function loadModel(){
    let modelName = modelNames[modelChosenIndex];
    session = await ort.InferenceSession.create('../models/' + modelName);
    alert('../models/' + modelName + " 4")
}

function clearCells(){
    const cells = document.querySelectorAll('.cell');

    cells.forEach((cell) => {
        cell.style.backgroundColor = "white";
    });
    clearProbs();
}

function clearProbs(){
    for (let i = 0; i < 10; i++) {
        const element = document.getElementById(`prediction-${i}`);
        element.children[0].children[0].style.height = `0%`;
        element.className = "prediction-col";
    }
}

function changeBrushSize() {
    // Get the value of the slider
    const slider = document.getElementById("brush-size-slider");
    brushSize = slider.value;
    const label = document.getElementById("brush-size-label");
    label.innerHTML = brushSize;
}

function softmax(arr) {
    const max = Math.max(...arr);
    const exps = arr.map(x => Math.exp(x - max));
    const sumExps = exps.reduce((acc, val) => acc + val, 0);
    return exps.map(x => x/sumExps);
}

function getGridValues(mine){
    let bgValue = mine ? 0.0039 : 0;
    let digitValue = mine ? 0 : 255;
    const cells = document.getElementsByClassName('cell');
    const pixelValues = new Float32Array(28*28);
    for (let i = 0; i < cells.length; i++) {
        const cellColor = cells[i].style.backgroundColor;
        pixelValues[i] = cellColor === 'white' ? bgValue : digitValue;
    }
    return pixelValues;
}



async function refreshProbs() {
    const input = getGridValues(modelChosenIndex === 0);
    const tensor = new ort.Tensor('float32', input, [1, 1, 28, 28]);

    let inputName = inputNames[modelChosenIndex];
    let outputName = outputNames[modelChosenIndex];

    // ask data
    const feeds = {[inputName]: tensor};
    const results = await session.run(feeds);

    // get data
    const dataOutput = results[outputName].data;
    const dataArray = Array.from(dataOutput)

    // process data
    const probs = softmax(dataArray);
    const  maxProb = Math.max(...probs)

    // change bar heights
    for (let i = 0; i < probs.length; i++) {
        const element = document.getElementById(`prediction-${i}`);
        element.children[0].children[0].style.height = `${probs[i] * 100}%`;
        element.className =
            probs[i] === maxProb
                ? "prediction-col top-prediction"
                : "prediction-col";
    }

}