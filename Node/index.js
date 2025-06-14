const express = require("express");
const app = express();
const bodyParser = require('body-parser');
const cors = require('cors');
const PacienteDao = require('./pacienteDao');

//Perguntar o motivo de usar o cors
app.use(cors());

//Converte os dados recebidos em json
app.use(bodyParser.json());

//Converte os parêmetros e url em json
app.use(bodyParser.urlencoded({ extended: true }));

//Configurando o ejs
app.set("view engine", "ejs");


//------------------------------------------------------------------------------------------
const pacienteDao = new PacienteDao();

// GET - Listar todos os pacientes
app.get("/api/pacientes", async (req, res) => {
    try {
        const pacientes = await pacienteDao.listarTodos();
        res.status(200).json({
            success: true,
            data: pacientes,
            message: "Pacientes listados com sucesso"
        });
    } catch (error) {
        res.status(500).json({
            success: false,
            message: "Erro ao listar pacientes",
            error: error.message
        });
    }
});

// GET - Buscar paciente por ID
app.get("/api/pacientes/:id", async (req, res) => {
    try {
        const id = req.params.id;
        const paciente = await pacienteDao.buscarPorId(id);
        
        if (!paciente) {
            return res.status(404).json({
                success: false,
                message: "Paciente não encontrado"
            });
        }
        
        res.status(200).json({
            success: true,
            data: paciente,
            message: "Paciente encontrado com sucesso"
        });
    } catch (error) {
        res.status(500).json({
            success: false,
            message: "Erro ao buscar paciente",
            error: error.message
        });
    }
});

// GET - Buscar pacientes por CPF
app.get("/api/pacientes/cpf/:cpf", async (req, res) => {
    try {
        const cpf = req.params.cpf;
        const pacientes = await pacienteDao.buscarPorCpf(cpf);
        
        res.status(200).json({
            success: true,
            data: pacientes,
            message: "Busca por CPF realizada com sucesso"
        });
    } catch (error) {
        res.status(500).json({
            success: false,
            message: "Erro ao buscar paciente por CPF",
            error: error.message
        });
    }
});

// POST - Criar novo paciente
app.post("/api/pacientes", async (req, res) => {
    try {
        const { nome, cpf, telefone, endereco, observacoes, dataNascimento } = req.body;
        
        // Validação básica
        if (!nome || !cpf) {
            return res.status(400).json({
                success: false,
                message: "Nome e CPF são obrigatórios"
            });
        }
        
        const result = await pacienteDao.inserir(nome, cpf, telefone, endereco, observacoes, dataNascimento);
        
        res.status(201).json({
            success: true,
            data: { id: result.insertId },
            message: "Paciente cadastrado com sucesso"
        });
    } catch (error) {
        res.status(500).json({
            success: false,
            message: "Erro ao cadastrar paciente",
            error: error.message
        });
    }
});

// PUT - Atualizar paciente
app.put("/api/pacientes/:id", async (req, res) => {
    try {
        const id = req.params.id;
        const { nome, cpf, telefone, endereco, observacoes, dataNascimento } = req.body;
        
        // Validação básica
        if (!nome || !cpf) {
            return res.status(400).json({
                success: false,
                message: "Nome e CPF são obrigatórios"
            });
        }
        
        const result = await pacienteDao.atualizar(id, nome, cpf, telefone, endereco, observacoes, dataNascimento);
        
        if (result.affectedRows === 0) {
            return res.status(404).json({
                success: false,
                message: "Paciente não encontrado"
            });
        }
        
        res.status(200).json({
            success: true,
            message: "Paciente atualizado com sucesso"
        });
    } catch (error) {
        res.status(500).json({
            success: false,
            message: "Erro ao atualizar paciente",
            error: error.message
        });
    }
});

// DELETE - Excluir paciente
app.delete("/api/pacientes/:id", async (req, res) => {
    try {
        const id = req.params.id;
        const result = await pacienteDao.delete(id);
        
        if (result.affectedRows === 0) {
            return res.status(404).json({
                success: false,
                message: "Paciente não encontrado"
            });
        }
        
        res.status(200).json({
            success: true,
            message: "Paciente excluído com sucesso"
        });
    } catch (error) {
        res.status(500).json({
            success: false,
            message: "Erro ao excluir paciente",
            error: error.message
        });
    }
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
*/
app.listen(3000, () => {
    console.log("Servidor rodando na porta 3000");
    console.log("API disponível em: http://localhost:3000");
});
