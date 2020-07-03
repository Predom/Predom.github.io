var programCode = function(processingInstance){
  with (processingInstance){
  size(500,500);
  frameRate(60);


    var ellipseX = width/2;
    var ellipseY = height/2;
    var ellipseY_var =0;
    var ellipseX_var =0;
    var velTot=0;
    var mouseIsPressed = false;
    var bolinhaIsDragged = false;

    draw = function (){

      background(255,255,255);
      fill(255, 247, 0);
      ellipse(ellipseX,ellipseY,20,20);

      //atualiza as velocidades da bolinha
      ellipseY += ellipseY_var;
      ellipseX += ellipseX_var;

      //basicamente a gravidade e a normal do chão
      ellipseY_var +=0.5;
      if(ellipseY>height-10)ellipseY_var -=0.5;

      //chão e paredes
      if(ellipseY>height-10 && ellipseY_var>0){
        ellipseY_var = -ellipseY_var*0.8;
        ellipseY=height-10;
      }
      if(ellipseY>height-10){
        ellipseY=height-10;
      }
      if(ellipseX>width-10 && ellipseX_var>0) ellipseX_var = -ellipseX_var*0.8;
      if(ellipseX<10 && ellipseX_var<0) ellipseX_var = -ellipseX_var*0.8;

      mousePressed = function(){
        mouseIsPressed = true;
      }
      if(mouseIsPressed){
        if((mouseY<ellipseY+10 && mouseY>ellipseY-10 && mouseX<ellipseX+10 && mouseX>ellipseX-10)||bolinhaIsDragged){
        ellipseY_var =0;
        ellipseX_var =0;
        ellipseY = mouseY;
        ellipseX = mouseX;
        bolinhaIsDragged=true;
        }
      }

      mouseReleased = function(){
        ellipseY_var = (mouseY-mouseMemY);
        ellipseX_var = (mouseX-mouseMemX);
        mouseIsPressed=false;
        bolinhaIsDragged=false;
      }
      mouseMemY=mouseY;
      mouseMemX=mouseX;


    };




}};


var canvas = document.getElementById("muhCanvas");

var processingInstance = new Processing(canvas, programCode);
