const http = require("http");
const fs = require("fs");
const path = require("path");

ext = {
  "css":"text/css",
  "html":"text/html",
  "ico":"image/ico",
  "jpg":"image/jpeg",
  "js":"text/javascript",
  "json":"application/json",
  "png":"image/png",
  "gif":"image/gif"
};


/*_____________________________GUARDA A PÁGINA DE ERRO EM erro404html______________
Aqui é declarada uma variável que conterá o html da página de erro404 que será     *
devolvida caso seja feita a requisição de um recurso html indísponivel no servidor */

var erro404html;

fs.readFile(path.join(__dirname,"erro.html"),function(nemFerrando, erroRes){
  if(nemFerrando){
    console.log(`Erro ao carregar pagina de erro404 ${nemFerrando}`)
  }else{

    erro404html = erroRes;
  }
});
//__________________________________________________________________________________

var server = http.createServer(function(req,res){

/*_________________TRATAMENTO DA URL_____________________
  Neste bloco são feitos todos os tratamentos para a URL *
  da requisição ser transformada em uma localização      *
  válida no sistema de arquivos.                         */

  if(path.extname(req.url)==""){
    req.url = path.join(req.url,"index.html");
  }else if(req.url == "/favicon.ico"){
    req.url = "/assets/favicon.ico";
  }

  req.url = req.url.replace(/%20/g," ");
  console.log("\n"+req.url);
//________________________________________________________

  fs.readFile(path.join(__dirname,req.url),function(err,file){
    if(err){

//_________CASO SEJA O PEDIDO DE UMA PAGINA HTML DEVOLVE UM HTML COM MSG DE ERRO_________________
      if(path.extname(req.url)==".html"){
        res.writeHead(200, {"Content-Type":"text/html"});
        res.write(erro404html);
        console.log("_________________\nerror 404 for .html\n" + err +"\n_________________\n");
      }else{
        res.writeHead(404);
        console.log("error 404 for" + req.url)
      }
//_______________________________________________________________________________________________

    }else{
      res.writeHead(200, {"Content-Type":ext[path.extname(req.url).split(".")[1]]});
      res.write(file);
      console.log(`sent ${req.url}`)
    }
    res.end();
  });

});

server.listen("8000");
console.log("running");
