const headerSrc = new XMLHttpRequest();
const header = document.getElementById('headnav');

headerSrc.onload = function() {
  if(this.status == 200){
    header.innerHTML = xhr.responseText;
  }else{
    console.log("algo de errado no carregamento do cabeçalho");
  }
}

headerSrc.open('get','html/header.html');
headerSrc.send();
