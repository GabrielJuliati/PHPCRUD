const express = require("express");
const app = express();
const bodyParser = require('body-parser');
const cors = require('cors');
const PacienteDao = require('./pacienteDao');
const AgendamentoDao = require("./agendamentoDao");
const RelatorioDao = require("./relatorioDao"); // Adicionado o DAO de relatório

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

const agendamentoDao = new AgendamentoDao;

// GET /api/agendamentos - Listar todos os agendamentos
app.get('/api/agendamentos', async (req, res) => {
    try {
        const agendamentos = await agendamentoDao.read();
        res.json({
            success: true,
            data: agendamentos
        });
    } catch (error) {
        console.error('Erro ao listar agendamentos:', error);
        res.status(500).json({
            success: false,
            message: 'Erro interno do servidor',
            error: error.message
        });
    }
});

// GET /api/agendamentos/:id - Buscar agendamento por ID
app.get('/api/agendamentos/:id', async (req, res) => {
    try {
        const { id } = req.params;
        const agendamento = await agendamentoDao.buscarPorId(id);
        
        if (!agendamento) {
            return res.status(404).json({
                success: false,
                message: 'Agendamento não encontrado'
            });
        }
        
        res.json({
            success: true,
            data: agendamento
        });
    } catch (error) {
        console.error('Erro ao buscar agendamento por ID:', error);
        res.status(500).json({
            success: false,
            message: 'Erro interno do servidor',
            error: error.message
        });
    }
});

// GET /api/agendamentos/cpf/:cpf - Buscar agendamentos por CPF
app.get('/api/agendamentos/cpf/:cpf', async (req, res) => {
    try {
        const { cpf } = req.params;
        const agendamentos = await agendamentoDao.buscarPorCpf(cpf);
        
        res.json({
            success: true,
            data: agendamentos
        });
    } catch (error) {
        console.error('Erro ao buscar agendamentos por CPF:', error);
        res.status(500).json({
            success: false,
            message: 'Erro interno do servidor',
            error: error.message
        });
    }
});

// POST /api/agendamentos - Criar novo agendamento
app.post('/api/agendamentos', async (req, res) => {
    try {
        const { paciente_id, data_consulta, tipo_exame } = req.body;
        
        // Validação básica
        if (!paciente_id || !data_consulta || !tipo_exame) {
            return res.status(400).json({
                success: false,
                message: 'Campos obrigatórios: paciente_id, data_consulta, tipo_exame'
            });
        }
        
        const result = await agendamentoDao.inserir(paciente_id, data_consulta, tipo_exame);
        
        res.status(201).json({
            success: true,
            message: 'Agendamento criado com sucesso',
            data: {
                id: result.insertId,
                paciente_id,
                data_consulta,
                tipo_exame
            }
        });
    } catch (error) {
        console.error('Erro ao criar agendamento:', error);
        res.status(500).json({
            success: false,
            message: 'Erro interno do servidor',
            error: error.message
        });
    }
});

// PUT /api/agendamentos/:id - Atualizar agendamento
app.put('/api/agendamentos/:id', async (req, res) => {
    try {
        const { id } = req.params;
        const { paciente_id, data_consulta, tipo_exame } = req.body;
        
        // Validação básica
        if (!paciente_id || !data_consulta || !tipo_exame) {
            return res.status(400).json({
                success: false,
                message: 'Campos obrigatórios: paciente_id, data_consulta, tipo_exame'
            });
        }
        
        // Verificar se o agendamento existe
        const agendamentoExistente = await agendamentoDao.buscarPorId(id);
        if (!agendamentoExistente) {
            return res.status(404).json({
                success: false,
                message: 'Agendamento não encontrado'
            });
        }
        
        const result = await agendamentoDao.atualizar(id, paciente_id, data_consulta, tipo_exame);
        
        res.json({
            success: true,
            message: 'Agendamento atualizado com sucesso',
            data: {
                id,
                paciente_id,
                data_consulta,
                tipo_exame
            }
        });
    } catch (error) {
        console.error('Erro ao atualizar agendamento:', error);
        res.status(500).json({
            success: false,
            message: 'Erro interno do servidor',
            error: error.message
        });
    }
});

// DELETE /api/agendamentos/:id - Excluir agendamento
app.delete('/api/agendamentos/:id', async (req, res) => {
    try {
        const { id } = req.params;
        
        // Verificar se o agendamento existe
        const agendamentoExistente = await agendamentoDao.buscarPorId(id);
        if (!agendamentoExistente) {
            return res.status(404).json({
                success: false,
                message: 'Agendamento não encontrado'
            });
        }
        
        await agendamentoDao.delete(id);
        
        res.json({
            success: true,
            message: 'Agendamento excluído com sucesso'
        });
    } catch (error) {
        console.error('Erro ao excluir agendamento:', error);
        res.status(500).json({
            success: false,
            message: 'Erro interno do servidor',
            error: error.message
        });
    }
});

//------------------------------------------------------------------------------------------
// INÍCIO DO MÓDULO DE RELATÓRIO

const relatorioDao = new RelatorioDao();

// IMPORTANTE: Rotas específicas devem vir antes das rotas genéricas
// GET /api/relatorios/consolidado/:cpf - Buscar dados consolidados por CPF
app.get('/api/relatorios/consolidado/:cpf', async (req, res) => {
    try {
        const { cpf } = req.params;
        const dadosConsolidados = await relatorioDao.buscarDadosConsolidadosPorCpf(cpf);
        
        if (!dadosConsolidados.paciente) {
            return res.status(404).json({
                success: false,
                message: 'Paciente não encontrado com o CPF informado'
            });
        }
        
        res.json({
            success: true,
            data: dadosConsolidados
        });
    } catch (error) {
        console.error('Erro ao buscar dados consolidados por CPF:', error);
        res.status(500).json({
            success: false,
            message: 'Erro interno do servidor',
            error: error.message
        });
    }
});

// GET /api/relatorios/cpf/:cpf - Buscar relatórios por CPF
app.get('/api/relatorios/cpf/:cpf', async (req, res) => {
    try {
        const { cpf } = req.params;
        const relatorios = await relatorioDao.buscarPorCpf(cpf);
        
        res.json({
            success: true,
            data: relatorios
        });
    } catch (error) {
        console.error('Erro ao buscar relatórios por CPF:', error);
        res.status(500).json({
            success: false,
            message: 'Erro interno do servidor',
            error: error.message
        });
    }
});

// GET /api/relatorios - Listar todos os relatórios
app.get('/api/relatorios', async (req, res) => {
    try {
        const relatorios = await relatorioDao.listarTodos();
        res.json({
            success: true,
            data: relatorios
        });
    } catch (error) {
        console.error('Erro ao listar relatórios:', error);
        res.status(500).json({
            success: false,
            message: 'Erro interno do servidor',
            error: error.message
        });
    }
});

// GET /api/relatorios/:id - Buscar relatório por ID
app.get('/api/relatorios/:id', async (req, res) => {
    try {
        const { id } = req.params;
        const relatorio = await relatorioDao.buscarPorId(id);
        
        if (!relatorio) {
            return res.status(404).json({
                success: false,
                message: 'Relatório não encontrado'
            });
        }
        
        res.json({
            success: true,
            data: relatorio
        });
    } catch (error) {
        console.error('Erro ao buscar relatório por ID:', error);
        res.status(500).json({
            success: false,
            message: 'Erro interno do servidor',
            error: error.message
        });
    }
});

// POST /api/relatorios - Criar novo relatório
app.post('/api/relatorios', async (req, res) => {
    try {
        const { nome_paciente, cpf, tipo_exame, data_exame, resultado, observacao } = req.body;
        
        // Validação básica
        if (!nome_paciente || !cpf || !tipo_exame || !data_exame || !resultado) {
            return res.status(400).json({
                success: false,
                message: 'Campos obrigatórios: nome_paciente, cpf, tipo_exame, data_exame, resultado'
            });
        }
        
        const result = await relatorioDao.inserir(nome_paciente, cpf, tipo_exame, data_exame, resultado, observacao || null);
        
        res.status(201).json({
            success: true,
            message: 'Relatório criado com sucesso',
            data: {
                id: result.insertId,
                nome_paciente,
                cpf,
                tipo_exame,
                data_exame,
                resultado,
                observacao: observacao || null
            }
        });
    } catch (error) {
        console.error('Erro ao criar relatório:', error);
        res.status(500).json({
            success: false,
            message: 'Erro interno do servidor',
            error: error.message
        });
    }
});

// PUT /api/relatorios/:id - Atualizar relatório
app.put('/api/relatorios/:id', async (req, res) => {
    try {
        const { id } = req.params;
        const { nome_paciente, cpf, tipo_exame, data_exame, resultado, observacao } = req.body;
        
        // Validação básica
        if (!nome_paciente || !cpf || !tipo_exame || !data_exame || !resultado) {
            return res.status(400).json({
                success: false,
                message: 'Campos obrigatórios: nome_paciente, cpf, tipo_exame, data_exame, resultado'
            });
        }
        
        // Verificar se o relatório existe
        const relatorioExistente = await relatorioDao.buscarPorId(id);
        if (!relatorioExistente) {
            return res.status(404).json({
                success: false,
                message: 'Relatório não encontrado'
            });
        }
        
        const result = await relatorioDao.atualizar(id, nome_paciente, cpf, tipo_exame, data_exame, resultado, observacao || null);
        
        res.json({
            success: true,
            message: 'Relatório atualizado com sucesso',
            data: {
                id,
                nome_paciente,
                cpf,
                tipo_exame,
                data_exame,
                resultado,
                observacao: observacao || null
            }
        });
    } catch (error) {
        console.error('Erro ao atualizar relatório:', error);
        res.status(500).json({
            success: false,
            message: 'Erro interno do servidor',
            error: error.message
        });
    }
});

// DELETE /api/relatorios/:id - Excluir relatório
app.delete('/api/relatorios/:id', async (req, res) => {
    try {
        const { id } = req.params;
        
        // Verificar se o relatório existe
        const relatorioExistente = await relatorioDao.buscarPorId(id);
        if (!relatorioExistente) {
            return res.status(404).json({
                success: false,
                message: 'Relatório não encontrado'
            });
        }
        
        await relatorioDao.excluir(id);
        
        res.json({
            success: true,
            message: 'Relatório excluído com sucesso'
        });
    } catch (error) {
        console.error('Erro ao excluir relatório:', error);
        res.status(500).json({
            success: false,
            message: 'Erro interno do servidor',
            error: error.message
        });
    }
});

// Rota para a página de relatório por CPF
app.get("/public/relatorio/relatorioPorCpf", (req, res) => {
    res.render("relatorio/relatorioPorCpf");
});

// FIM DO MÓDULO DE RELATÓRIO
//------------------------------------------------------------------------------------------

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
    
    console.log("Nome: " + nome + "\nCNPJ: " + cnpj + "\nData de fundação: " + dataFundacao);
    res.send("Cliente cadastrado com sucesso.");
})

app.get("/editarClientes/:idCliente", (req, res) => {
    const codigoCliente = req.params.idCliente;
    console.log("Editando o cliente: ", codigoCliente);
    res.send("Editando o cliente: " + codigoCliente);
});

app.put("/cliente", (req, res) => {
    const {nome, cnpj, dataFundacao} = req.body;
    
    console.log("Nome: " + nome + "\nCNPJ: " + cnpj + "\nData de fundação: " + dataFundacao);
    res.send("Cliente atualizado com sucesso.");
})

app.delete("/cliente", (req, res) => {
    const {nome, cnpj, dataFundacao} = req.body;
    
    console.log("Nome: " + nome + "\nCNPJ: " + cnpj + "\nData de fundação: " + dataFundacao);
    res.send("Cliente excluído com sucesso.");
})

app.get("/fornecedores", (req, res) => {
    res.end("<html><head><title>Minha primeira página</title></head><body><h1>Minha primeira pagina</h1></body></html>");
});
*/
app.listen(3000, () => {
    console.log("Servidor rodando na porta 3000");
    console.log("API disponível em: http://localhost:3000");
});

