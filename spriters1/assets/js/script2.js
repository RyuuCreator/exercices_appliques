/* DECLARATION DE LA TAIL DU CANVAS*/

let canWidth = window.innerWidth;
let canHeight = window.innerHeight;
let ratio = window.devicePixelRatio;

/* PREPARATION DE LA SOURCES COLONNES ET LIGNES (DECLARER 169) */

let srcX;
let srcY;

/* PREPARATION ET DECLARATION DE L'IMAGE DE DEPART */

let startSprite;
startSprite = srcX = 0 , srcY = 0;

/* TAILLE DE LA SPRITE (SHEET) ET LE NOMBRE DE COLONNE / LIGNES */

let sheetWidth = 450;
let sheetHeight = 240;
let cols = 9;
let rows = 4;

/* DECLARATION DE LA HAUTEUR ET LARGEUR D'UNE FRAME SUR LE SHEET */

let width = sheetWidth / cols;
let height = sheetHeight / rows;

/* DECLARATION VARIABLE GRANDEUR IMAGE */

let imgWidth = width * 2;
let imgHeight = height * 2;

/* POSITION DE DEPART DU PERSONNAGE / RAYON */

let x = (canWidth / 2) - (width / 2);
let y = (canHeight / 2) - (height / 2);

/* DECLARATION DES DIRECTION */

let up = false;
let right = false;
let left = false;
let down = false;
let stop = false;

/* DECLARATION DES LIGNES DU SPRITE */

let trackTop = 3;
let trackRight = 2;
let trackLeft = 1;
let trackDown = 0;

/* DECLARATION DE LA PREMIERE FRAME */

let currentFrame = 0;

/* CREATION ET DECLARATION DE L'IMAGE SOURCE ET LE CANVAS */

let caracter = new Image();
caracter.src = "./assets/img/drwho/ten/ten.png";

let canvas = document.getElementById("canvas");
let context = canvas.getContext("2d");

/* DECLARATION DES RATIO TAILLE/CONTEXT */

canvas.width = canWidth * ratio;
canvas.height = canHeight * ratio;
context.scale(ratio, ratio);
context.imageSmoothingEnabled = false;
context.fillStyle = "rgba(255, 255, 255, 1)";

/* FONCTION ONCLICK DIRECTION */

// function moveTop() {
// 	up = true;
//     right = false;
// 	left = false;
// 	down = false;
// }

// function moveRight() {
// 	startSprite = false;
// 	up = false;
//     right = true;
// 	left = false;
// 	down = false;
// }

// function moveLeft() {
// 	startSprite = false;
// 	up = false;
//     right = false;
// 	left = true;
// 	down = false;
// }

// function moveDown() {
// 	startSprite = false;
// 	up = false;
//     right = false;
// 	left = false;
// 	down = true;
// }

// function moveStop() {
// 	startSprite = false;
// 	up = false;
//     right = false;
// 	left = false;
// 	down = false;
// }

/* FONCTION KEYBOARD DIRECTION */

window.onkeydown = function(e) {
    let kc = e.keyCode;
    e.preventDefault();

    if      (kc === 37 || kc === 81 || kc === 100) left = true;  //only one key per event
    else if (kc === 38 || kc === 90 || kc === 104) up = true;    //so check exclusively
    else if (kc === 39 || kc === 68 || kc === 102) right = true;
    else if (kc === 40 || kc === 83 || kc === 98) down = true;
};

window.onkeyup = function(e) {
    let kc = e.keyCode;
    e.preventDefault();

    if      (kc === 37 || kc === 81 || kc === 100) left = false;
    else if (kc === 38 || kc === 90 || kc === 104) up = false;
    else if (kc === 39 || kc === 68 || kc === 102) right = false;
    else if (kc === 40 || kc === 83 || kc === 98) down = false;
};

/* DETAILLE POUR LES MOUVEMENT UP/RIGHT/LEFT/DOWN */

function updateFrame() {
	currentFrame += 1;
	if(currentFrame >= 9) {
		currentFrame -= 9;
	}

    if(up) {
		y -= 12;
		srcY = trackTop * height;
        srcX = currentFrame * width;
    } else if(right) {
		x += 12;
		srcY = trackRight * height;
        srcX = currentFrame * width;
	} else if(left) {
		x -= 12;
		srcY = trackLeft * height;
        srcX = currentFrame * width;
	} else if(down) {
		y += 12;
		srcY = trackDown * height;
        srcX = currentFrame * width;
    } 
}

/* FONCTION POUR "DESSINER" MON PERSONNAGE */

function drawImage() {
	context.fillRect(0, 0, canWidth, canHeight);
	updateFrame();
	context.drawImage(caracter, srcX, srcY, width, height, x, y, imgWidth, imgHeight);
}

/* FONCTION POUR L'INTERVAL D'IMAGE (FPS) */

setInterval(function () {
	drawImage();
}, 100);