var carregarRecHtml = (rec,selector) =>{
  let source = new XMLHttpRequest();
  let target = document.querySelector(selector);

  source.onload = function() {
    if(this.status == 200){
      target.innerHTML = source.responseText;
    }else{
      console.log("algo de errado no carregamento de um recurso html remoto");
    }
  }

  source.open('get',rec);
  source.send();
}
