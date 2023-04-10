//to prevent right click pop up
document.addEventListener('contextmenu', event => event.preventDefault());


let rightClick = false;
let leftClick = false;
let brushSize = 3;
const cells = document.querySelectorAll('.cell');
const resultContainer = document.getElementById("results");
let session = null;

async function loadModel(){
    session = await ort.InferenceSession.create('../models/SimpleCNNDigitModel2.onnx');
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


function softmax(arr) {
    const max = Math.max(...arr);
    const exps = arr.map(x => Math.exp(x - max));
    const sumExps = exps.reduce((acc, val) => acc + val, 0);
    return exps.map(x => x/sumExps);
}

function getGridValues(){
    const cells = document.getElementsByClassName('cell');
    const pixelValues = new Float32Array(28*28);
    for (let i = 0; i < cells.length; i++) {
        const cellColor = cells[i].style.backgroundColor;
        pixelValues[i] = cellColor === 'white' ? 0.0039 : 0;
    }

    return pixelValues;
}
alert("1")



async function refreshProbs() {
        const input = getGridValues();
        const tensor = new ort.Tensor('float32', input, [1, 1, 28, 28]);

        const feeds = { "input.1": tensor};
        const results = await session.run(feeds);


        const dataOutput = results.outputName.data;
        const dataArray = Array.from(dataOutput)
        const probs = softmax(dataArray);
        const  maxProb = Math.max(...probs)

        for (let i = 0; i < probs.length; i++) {
            const element = document.getElementById(`prediction-${i}`);
            element.children[0].children[0].style.height = `${probs[i] * 100}%`;
            element.className =
                probs[i] === maxProb
                    ? "prediction-col top-prediction"
                    : "prediction-col";
        }

}