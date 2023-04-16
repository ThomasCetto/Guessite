let difficulty = 0;
// These are for the test dataset, and are the ones that my model can't find
let hardestImageIndexes =  [321, 445, 449, 495, 582, 591, 659, 684, 717, 839, 844, 846, 882, 947, 1014, 1039, 1062, 1068, 1112, 1156, 1182, 1202, 1226, 1232, 1242, 1247, 1260, 1263, 1299, 1319, 1326, 1337, 1364, 1393, 1500, 1527, 1530, 1621, 1678, 1681, 1709, 1754, 1790, 1878, 1901, 2023, 2043, 2053, 2070, 2098, 2109, 2118, 2130, 2135, 2168, 2182, 2185, 2189, 2266, 2280, 2293, 2387, 2414, 2425, 2454, 2462, 2488, 2597, 2607, 2654, 2780, 2896, 2921, 2927, 2952, 2953, 2995, 3023, 3060, 3073, 3206, 3225, 3289, 3384, 3422, 3503, 3511, 3520, 3559, 3597, 3718, 3767, 3796, 3806, 3808, 3853, 3906, 4075, 4078, 4176, 4205, 4238, 4248, 4256, 4265, 4306, 4344, 4497, 4536, 4571, 4575, 4578, 4615, 4639, 4731, 4740, 4761, 4783, 4807, 4814, 4874, 4956, 4978, 5278, 5634, 5734, 5842, 5888, 5955, 5973, 6011, 6059, 6091, 6157, 6172, 6505, 6532, 6555, 6558, 6571, 6576, 6578, 6597, 6625, 6651, 6740, 6755, 6783, 6847, 7121, 7434, 7619, 7902, 8059, 8081, 8091, 8094, 8095, 8246, 8408, 8520, 8527, 9009, 9015, 9019, 9642, 9664, 9692, 9729, 9770, 9839, 9905, 9982]

let session = null;

loadModel()

function setDifficulty(value){
    difficulty = value;
}

function guess(number){
    alert(number)
    const guessInput = document.getElementById("guessInput")
    const modelInput = document.getElementById("modelInput")
    const difficultyInput = document.getElementById("difficulty")
    difficultyInput.value = difficulty;
    guessInput.value = number
    modelInput.value = getModelGuess()
}

async function loadModel(){
    session = await ort.InferenceSession.create('../models/muchBetterDigitClassificator.onnx');
    alert("loaded")
}

async function getModelGuess() {
    let input = imageToArray();

    const tensor = new ort.Tensor('float32', input, [1, 1, 28, 28]);

    // ask data
    const feeds = {"Input3": tensor};
    const results = await session.run(feeds);

    // get data
    const dataOutput = results.Plus214_Output_0.data;
    const dataArray = Array.from(dataOutput);

    // process data
    const probs = softmax(dataArray);
    const  maxProb = Math.max(...probs);

    const modelGuess = probs.indexOf(BigInt(maxProb));
    alert(modelGuess);
    return modelGuess
}

function softmax(arr) {
    const max = Math.max(...arr);
    const exps = arr.map(x => Math.exp(x - max));
    const sumExps = exps.reduce((acc, val) => acc + val, 0);
    return exps.map(x => x/sumExps);
}

function imageToArray(){
    let img = document.getElementById("imageToGuess");

    let canvas = document.createElement("canvas");
    canvas.width = img.width;
    canvas.height = img.height;

    let ctx = canvas.getContext("2d");
    ctx.drawImage(img, 0, 0);

    let imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
    let data = imageData.data;

    let floatArray= new Float32Array(data.length);

    for (let i = 0; i < data.length; i++) {
        floatArray[i] = data[i];
    }
    return floatArray;
}