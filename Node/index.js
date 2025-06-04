const express = require('express');
const app = express();
const bodyParser = require('body-parser');

//Converte os dados recebidos em json
app.use(bodyParser.json());

//Converte os parêmetros e url em json
app.use(bodyParser.urlencoded({ extended: true }));

//Configurando o ejs
app.set("view engine", "ejs");



//------------------------------------------------------------------------------------------



app.get("/public/acesso/login", (req, res) => {
});

app.get("/public/acesso/forgotPassword", (req, res) => {
});

app.get("/public/acesso/controller/usuarioController", (req, res) => {
});

app.get("/public/acesso/dao/usuarioDao", (req, res) => {
});

app.get("/public/home/home", (req, res) => {
});

app.get("/public/pacientes/escolhaPaciente", (req, res) => {
});

app.get("/public/pacientes/cadastroPaciente", (req, res) => {
});

app.get("/public/pacientes/gestaoPaciente", (req, res) => {
});

app.get("/public/pacientes/controller/pacienteController", (req, res) => {
});

app.get("/public/pacientes/dao/pacienteDao", (req, res) => {
});

app.get("/public/cadastro/cadastro", (req, res) => {
});

app.get("/public/logout/logout", (req, res) => {
});


//------------------------------------------------------------------------------------------

app.get("/public/agendamento/gestãoAgendamento", (req, res) => {
});

app.get("/public/agendamento/cadastro", (req, res) => {
});

app.get("/public/agendamento/agendamentos", (req, res) => {
});

app.get("/public/agendamento/editar", (req, res) => {
});

app.get("/public/agendamento/controller/agendamentoController", (req, res) => {
});

app.get("/public/agendamento/dao/agendamentoDao", (req, res) => {
});

app.get("/public/agendamento/processamento/processamento", (req, res) => {
});

app.get("/public/exames/exames", (req, res) => {
});

app.get("/public/exames/cadastro", (req, res) => {
});

app.get("/public/exames/editar", (req, res) => {
});

app.get("/public/exames/gestaoExames", (req, res) => {
});

app.get("/public/exames/dao/examesDao", (req, res) => {
});

app.get("/public/exames/controller/examesController", (req, res) => {
});

app.get("/public/exames/processamento/processamento", (req, res) => {
});


//------------------------------------------------------------------------------------------

app.get("/public/relatorio/relatatorio", (req, res) => {
});

app.get("/public/relatorio/controller/RelatorioController", (req, res) => {
});

app.get("/public/relatorio/dao/RelatorioDAO", (req, res) => {
});


//------------------------------------------------------------------------------------------

/*
app.post("/cliente", (req, res) => {
    const {nome, cnpj, dataFundacao} = req.body;
    
    console.log("Nome: " + nome + "\nCNPJ: " + cnpj + "\nData de fundação: " + dataFundacao);
    res.send("Cliente cadastrado com sucesso.");
})

app.get("/editarClientes/:idCliente", (req, res) => {
    const codigoCliente = req.params.idCliente;
    console.log("Editando o cliente: ", codigoCliente);
    res.send("Editando o cliente: " + codigoCliente);
});

app.put("/cliente", (req, res) => {
    const {nome, cnpj, dataFundacao} = req.body;
    
    console.log("Nome: " + nome + "\nCNPJ: " + cnpj + "\nData de fundação: " + dataFundacao);
    res.send("Cliente atualizado com sucesso.");
})

app.delete("/cliente", (req, res) => {
    const {nome, cnpj, dataFundacao} = req.body;
    
    console.log("Nome: " + nome + "\nCNPJ: " + cnpj + "\nData de fundação: " + dataFundacao);
    res.send("Cliente excluído com sucesso.");
})

app.get("/fornecedores", (req, res) => {
    res.end("<html><head><title>Minha primeira página</title></head><body><h1>Minha primeira pagina</h1></body></html>");
});

app.listen(3000, () => {
    console.log('Servidor rodando na porta 3000');
});
*/