var oImage ="";
function moveDrawligne(oEvent){ 
    var oCanvas = oEvent.currentTarget,
        oCtx = null, oPos = null;
    if(oCanvas.bDraw ==false){
    return false;
    }
    oPos = getPosition(oEvent, oCanvas);
    oCtx = oCanvas.getContext('2d');
    
    //dessine
    oCtx.strokeStyle = '#000000';
    oCtx.lineWidth = 3;
    oCtx.beginPath(); 
    oCtx.moveTo((oCanvas.posX), oCanvas.posY);
    oCtx.lineTo(oPos.posX, oPos.posY);
    oCtx.stroke();
    
    oCanvas.posX = oPos.posX;
    oCanvas.posY = oPos.posY; 


}

function getPosition(oEvent, oCanvas){
    var oRect = oCanvas.getBoundingClientRect(),
        oEventEle = oEvent.changedTouches? oEvent.changedTouches[0]:oEvent;
    return {
    posX : (oEventEle.clientX - oRect.left) / (oRect.right - oRect.left) * oCanvas.width,
    posY : (oEventEle.clientY - oRect.top) / (oRect.bottom - oRect.top) * oCanvas.height
    };
}

function downDrawligne(oEvent){ 
    oEvent.preventDefault(); 
    var  oCanvas = oEvent.currentTarget,
        oPos = getPosition(oEvent, oCanvas);
    oCanvas.posX = oPos.posX;
    oCanvas.posY = oPos.posY;
    oCanvas.bDraw = true;
    capturer(false);


}

function upDrawligne(oEvent){
    var oCanvas = oEvent.currentTarget;
    oCanvas.bDraw = false; 
    capturer(true);

}

function initCanvas(){

    var oCanvas = document.getElementById("canvas");
    oCanvas.bDraw = false;
    oCanvas.width = 200 ;
    oCanvas.height = 150;
    oCtx = oCanvas.getContext('2d'); 
    oCanvas.addEventListener("mousedown", downDrawligne);
    oCanvas.addEventListener("mouseup", upDrawligne);
    oCanvas.addEventListener("mousemove", moveDrawligne);
    oCanvas.addEventListener("touchstart", downDrawligne);
    oCanvas.addEventListener("touchend", upDrawligne);
    oCanvas.addEventListener("touchmove", moveDrawligne); 
}

/**
    * Récupère le canva sous forme d'image 
    * oCanvas.width = 200 ;
    * oCanvas.height = 150;
    */
function capturer(bAction){
    
    var oCapture = document.getElementById("capture");
    oCapture.innerHTML = '';
    if(bAction == true){ 
    var oImage = document.createElement('img'),
        oCanvas = document.getElementById("canvas");
    oImage.src = oCanvas.toDataURL("image/png");
    oCapture.appendChild(oImage);



    }
}

//récupération des données


    // Accéde à l'élément form …
    var form = document.getElementById("myForm");
    // … et prend en charge l'événement submit.
    form.addEventListener("submit", function (event) {



    var XHR = new XMLHttpRequest();
    
    
    // Lie l'objet FormData et l'élément form
    var FD = new FormData(form);

    //récupère les données de l'enfant de 'capture' et ote l'excédant pour ne garder que la string en base64
    var temp = document.getElementById('capture').firstChild.getAttribute('src');
    var imgB64 = temp.split("data:image/png;base64,").pop()
    
    
    
    //ajoute imgB64 à FD
    FD.append('data',imgB64);

    
    XHR.addEventListener("error", function(event) {
        alert('Oups! Quelque chose s\'est mal passé.');
    });

    // Configure la requête
    XHR.open("POST", "traitement.php");

    // Les données envoyées sont ce que l'utilisateur a mis dans le formulaire
    XHR.send(FD);
    
    XHR.onload = function() {
        //récupère la réponse provenant de php, si "OK" redirige vers index.html
        const response = JSON.parse(this.responseText);
        if(response == "OK"){
        document.location.href="index.php";
        }
    };

    event.preventDefault();

    });

    //Vide les dessin du canvas
function nettoyer(oEvent){
    alert("nettoyer");
    var  oCanvas = document.getElementById("canvas"),
        oCtx = oCanvas.getContext('2d');
    oCtx.clearRect(0,0,oCanvas.width,oCanvas.height); 
    capturer(false);
}

document.addEventListener('DOMContentLoaded',function(){
    initCanvas();
    document.getElementById("bt-clear").addEventListener("click", nettoyer); 
});