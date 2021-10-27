let width = window.innerWidth,
	height = window.innerHeight,
	ratio = window.devicePixelRatio;

let x = width / 2,
    r = 40;
    step = 0,
    vx = r * 0.2;
    
let canvas = document.getElementById("canvas"),
    context = canvas.getContext("2d");

let bubblesRight = new Image();
bubblesRight.onload = animate;
bubblesRight.src = "../assets/img/bubbles/right.png";

canvas.width = width * ratio;
canvas.height = height * ratio;
canvas.style.width = width + "px";
canvas.style.height = height + "px";
context.scale(ratio, ratio);
context.imageSmoothingEnabled = false;
context.fillStyle = "rgba(255, 255, 255, 0.25)";

function animate() {
	draw();
	update();
	requestAnimationFrame(animate);
}

function draw() {
	context.fillRect(0, 0, width, height);
	drawBubbles(x, height, r, Math.floor(step));
}

function drawBubbles(x, y, r, step) {
    let s = r/4;
	context.drawImage(bubblesRight, 22*step, 0, 22, 22, x-11*s, y-22*s, 22*s, 22*s);
}

function update() {
    x += vx;
    if (x > width - r ) {
        vx *= -1;
        // bubblesRight.src = "../assets/img/bubbles/left.png";
        console.log(vx);
    } else if (x < r) {
        vx *= -1;
        // bubblesRight.src = "../assets/img/bubbles/right.png";
        console.log(vx);
    }
    
    step += 0.07;
    if (step >= 4) {
        step -= 4 ;
    }
}
